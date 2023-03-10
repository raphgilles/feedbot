<?php
$article_date = strtotime($date);
$article_query = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles WHERE url = '$url' AND feed_id = '$feed_id'"));
$article_db_id = $article_query['id'];

if($article_db_id == "") {

	if ($thumbnail !== WEBSITE_URL."/assets/nopreview.png") {
	$folder = date('Y_m');
	if (!file_exists(__DIR__."/../../storage/thumbnails/".$folder)) {
    mkdir(__DIR__."/../../storage/thumbnails/".$folder, 0755, true);
	}
	$thumbnail = reconstruct_url($thumbnail);
    $type = get_headers($thumbnail, 1)["Content-Type"];
    $article_thumb = __DIR__."/../../storage/thumbnails/".$folder."/".md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true)).".jpg";
    file_put_contents($article_thumb, file_get_contents($thumbnail));
    $maxwidth = "1280";
	list($width, $height) = getimagesize($article_thumb);
	if ($width > $maxwidth) {
	$percent = $maxwidth / $width;
	$newwidth = $width * $percent;
	$newheight = $height * $percent;
	}
	else {
	$newwidth = $width;
	$newheight = $height;
	}
	if ($type == "image/jpeg") { $source = imagecreatefromjpeg($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 75); }
    if ($type == "image/png") { $source = imagecreatefrompng($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 75); }
    if ($type == "image/webp") { $source = imagecreatefromwebp($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 75); }
	$thumbnail = str_replace("/includes/updates/../../", "/", $article_thumb);
    }

	$sql = "INSERT INTO articles (title, excerpt, url, thumbnail, feed_id, platform, youtubeid, peertubeid, embed, id_site, date) values ('$title', '$description', '$url', '$thumbnail', '$feed_id', '$platform', '$youtube_id', '$peertubeid', '$embed', '$site_id', '$article_date')";
	mysqli_query($conn, $sql);
	$id_article_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles WHERE url = '$url' AND feed_id = '$feed_id'"));
	$id_article = $id_article_query['id'];

echo "<br />L'article a été ajouté et son id est ".$id_article;
echo "<br />".$title;
echo "<br />".$url;
echo "<br />".$description;
echo "<br />".$article_date."<br /><br />";

$source = NULL;
$article_thumb = NULL;
$thumb = NULL;

}

?>