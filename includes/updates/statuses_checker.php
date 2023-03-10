<?php
include ('../../config.php');
require '../mastophp/autoload.php';

$sql4 = "SELECT id, username FROM users";
$result4 = mysqli_query($conn, $sql4);

while($row4 = $result4->fetch_array()) {
$user = $row4['id'];

$aka = $row4['username'];
echo $user." - ".$aka."<br />";

$mastoPHP = new MastoPHP\MastoPHP(''.$aka.'');
$app = $mastoPHP->registerApp(WEBSITE_NAME, WEBSITE_URL);

// DELETE STATUSES
$sql= "SELECT * FROM statuses WHERE uid = '$user'";
$result = mysqli_query($conn, $sql);
    while($row = $result->fetch_array()){
    $post_id = $row['post_id'];
    $id_article = $row['article_id'];
    $post_url = $row['url'];
    $delete = $mastoPHP->getPub($post_id);
    $deleted = $delete['url'];
        if ($deleted !== $post_url) {
        $sql2 = "DELETE FROM statuses WHERE url ='$post_url'";
        mysqli_query($conn, $sql2);
        echo $post_url." a été supprimé.<br />";

        $sql = "UPDATE articles SET shares_count = shares_count - 1 WHERE id = '$id_article'";
        mysqli_query($conn, $sql);
        }        
    }

}

?>