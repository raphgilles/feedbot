<?php
include('../../config.php');
include('../functions.php');


// UPDATE THUMBNAILS SITES
$sql4= "SELECT * FROM sites";
$result2 = mysqli_query($conn, $sql4);

echo "<h1>Sites</h1>";

while($row2 = $result2->fetch_array()){
    $id = $row2['id'];
    $url = "https://".$row2['url'];
    $url = str_replace("https://https://", "https://", $url);
    $url = str_replace("https://api.", "https://", $url);
    $url = str_replace("https://feeds.", "https://www.", $url);
    $thumbnail = getFavicon($url);
    if ($thumbnail !== WEBSITE_URL."/assets/nopreview.png") {
    $thumbnail = $url.$thumbnail;
    $thumbnail = str_replace("".$url.$url."", "".$url."", $thumbnail);
}

    if ($url == "https://lemediatv.fr") {
        $thumbnail = "https://www.lemediatv.fr/favicon.ico";
    }
    if ($url == "https://www.frustrationmagazine.fr") {
        $thumbnail = "https://feedbot.net/assets/favicons/frustration.png";
    }

    if ($thumbnail !== "https://feedbot.net/assets/nopreview.png") {
    $media_thumb = "/var/www/my_webapp/www/storage/icons/".sha1(time()).".jpg";
    file_put_contents($media_thumb, file_get_contents($thumbnail));
    $thumbnail = $media_thumb;
    }

    $sql5 = "UPDATE sites SET thumbnail = ('$thumbnail') WHERE id = '$id'";
    mysqli_query($conn, $sql5);

    echo $url."<br />";
    $thumbpath = str_replace("/var/www/my_webapp/www/storage/icons/", WEBSITE_URL."/storage/icons/", $thumbnail);
    echo "<img src='".$thumbpath."' /><br /><br />";

    sleep(3);
}


// UPDATE THUMBNAILS FEEDS
$sql2= "SELECT * FROM feeds";
$result = mysqli_query($conn, $sql2);

echo "<h1>Feeds</h1>";

while($row = $result->fetch_array()){
	$id = $row['id'];
	$title = $row['feed_title'];
    $feed = $row['feed_url'];
    $url = parse_url($row['feed_url'], PHP_URL_HOST);
	$url = "https://".$url;
	$url = str_replace("https://https://", "https://", $url);
    $url = str_replace("https://api.", "https://", $url);
    $url = str_replace("https://feeds.", "https://www.", $url);
    $thumbnail = getFavicon($url);
    if ($thumbnail !== WEBSITE_URL."/assets/nopreview.png") {
    $thumbnail = $url.$thumbnail;
    $thumbnail = str_replace("".$url.$url."", "".$url."", $thumbnail);
}

    if ($url == "https://lemediatv.fr") {
        $thumbnail = "https://www.lemediatv.fr/favicon.ico";
    }
    if ($url == "https://www.frustrationmagazine.fr") {
        $thumbnail = "https://feedbot.net/assets/favicons/frustration.png";
    }

    if ($thumbnail !== WEBSITE_URL."/assets/nopreview.png") {
    $media_thumb = "/var/www/my_webapp/www/storage/icons/".sha1(time()).".jpg";
    file_put_contents($media_thumb, file_get_contents($thumbnail));
    $thumbnail = $media_thumb;
    }

  $sql3 = "UPDATE feeds SET thumbnail = ('$thumbnail') WHERE id = '$id'";
  mysqli_query($conn, $sql3);

    echo $url."<br />";
    $thumbpath = str_replace("/var/www/my_webapp/www/storage/icons/", WEBSITE_URL."/storage/icons/", $thumbnail);
    echo "<img src='".$thumbpath."' /><br /><br />";

  sleep(3);
}

?>