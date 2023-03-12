<?php
include ('../../config.php');

$sql = "SELECT 404_last_id FROM tasks";
$result = mysqli_query($conn, $sql);
foreach($result as $row){
    $last_id = $row['404_last_id'];
}

$sql = "SELECT * FROM articles WHERE id > '$last_id' LIMIT 250";
$result = mysqli_query($conn, $sql);
foreach($result as $row){
    $article_id = $row['id'];
    $title = $row['title'];
    $thumbnail = $row['thumbnail'];
    $url = $row['url'];
    echo "<br />".$article_id." - ".$title."<br />".$url."<br />";

    $xch = curl_init($url);
    curl_setopt($xch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($xch, CURLOPT_NOBODY, true);    // we don't need body
    curl_setopt($xch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($xch, CURLOPT_TIMEOUT,10);
    $xoutput = curl_exec($xch);
    $xhttpcode = curl_getinfo($xch, CURLINFO_HTTP_CODE);
    curl_close($xch);

    echo $xhttpcode."<br />";

    if ($xhttpcode == 404){
        $sql = "UPDATE articles SET 404_count = 404_count + 1 WHERE id = '$article_id'";
        mysqli_query($conn, $sql);
    }

    if ($xhttpcode !== 404){
        $sql = "UPDATE articles SET 404_count = ('0') WHERE id = '$article_id'";
        mysqli_query($conn, $sql);
    }

    $counter = $row['404_count'];

    if ($counter == 5) {
        $sql = "DELETE FROM articles WHERE id = '$article_id'";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM articles_published WHERE article_id = '$article_id'";
        mysqli_query($conn, $sql);
        unlink($thumbnail);
        echo "Supprimé<br />";
    }
}

if ($last_id >= $article_id) { $article_id = 0; }
$sql = "UPDATE tasks SET 404_last_id = '$article_id'";
mysqli_query($conn, $sql);
?>