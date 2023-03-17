<?php
include('../../config.php');
include('../functions.php');

// UPDATE THUMBNAILS ARTICLES
$sql4= "SELECT * FROM articles";
$result2 = mysqli_query($conn, $sql4);

while($row2 = $result2->fetch_array()){
	$id = $row2['id'];
	$id = $row2['title'];
	$url = $row2['url'];
	$thumbnail = getmetaimage($url);

	if($thumbnail !== WEBSITE_URL."/assets/nopreview.png"){
		$media_thumb = WEBSITE_URI."storage/thumbnails/".sha1(time()).".jpg";
		file_put_contents($media_thumb, file_get_contents($thumbnail));
		$thumbnail = $media_thumb;
		imagejpeg($thumbnail, $thumbnail, 90);
	}

	$sql5 = "UPDATE articles SET thumbnail = ('$thumbnail') WHERE id = '$id'";
	mysqli_query($conn, $sql5);

	echo $title." - ".$url."<br />";
	$thumbpath = str_replace(WEBSITE_URI."storage/thumbnails/", WEBSITE_URL."/storage/thumbnails/", $thumbnail);
	echo "<img src='".$thumbpath."' /><br /><br />";
}

?>