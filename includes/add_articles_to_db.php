<?php

// On vérifie si l'article existe dans la base de donnée
$article_date = strtotime($date);
$article_query = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM articles WHERE feed_id = '$id_feed' AND url = '$url'"));
$article_db_id = $article_query['id'];
$article_shared_query = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM articles_published WHERE uid = '$user' AND article_id = '$article_db_id'"));
$article_published_id = $article_shared_query['id'];

// Si l'article n'existe pas, on l'ajoute
if($article_db_id == "") {

    if ($thumbnail !== WEBSITE_URL."/assets/nopreview.png") {
	$folder = date('Y_m');
	if (!file_exists($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/".$folder)) {
    mkdir($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/".$folder, 0755, true);
	}
	$thumbnail = reconstruct_url($thumbnail);
    $extension = pathinfo($thumbnail, PATHINFO_EXTENSION);
    $article_thumb = $_SERVER['DOCUMENT_ROOT']."storage/thumbnails/".$folder."/".md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true)).".".$extension;
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
	if ($extension == "jpg") { $source = imagecreatefromjpeg($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 50); }
	if ($extension == "jpeg") { $source = imagecreatefromjpeg($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 50); }
	if ($extension == "png") { $source = imagecreatefrompng($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 50); }
	if ($extension == "webp") { $source = imagecreatefromwebp($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 50); }
	$thumbnail = str_replace("/includes/../", "/", $article_thumb);
    }

	$sql = "INSERT INTO articles (title, excerpt, url, thumbnail, feed_id, platform, youtubeid, peertubeid, embed, id_site, date) values ('$title', '$description', '$url', '$thumbnail', '$id_feed', '$platform', '$youtube_id', '$peertubeid', '$embed', '$id_site', '$article_date')";
	mysqli_query($conn, $sql);
	$id_article_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles WHERE date = '$article_date' AND id_site = '$id_site'"));
	$id_article = $id_article_query['id'];
	$sql = "INSERT INTO articles_published (uid, article_id, site_id, feed_id, is_published, published_date) values ('$user', '$id_article', '$id_site', '$id_feed', '1', '$article_date')";
	mysqli_query($conn, $sql);
	if ($is_active_feed == 1) { include('fediverse_add_flux.php'); }
	echo "<br />L'article a été ajouté et son id est ".$id_article;
	$source = NULL;
	$article_thumb = NULL;
	$thumb = NULL;
	
}

// Si l'article existe, on vérifie s'il a été partagé
else {
	$id_article_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles WHERE date = '$article_date' AND id_site = '$id_site'"));
	$id_article = $id_article_query['id'];

	$is_shared_article_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT is_published FROM articles_published WHERE uid = '$user' AND article_id ='$id_article' AND site_id = '$id_site'"));
	$article_is_shared = $is_shared_article_query['is_published'];

		if($article_is_shared == "0") {
		$sql = "UPDATE articles_published SET feed_id = ('$id_feed'), is_published = ('1') WHERE uid = '$user' AND article_id ='$id_article'";
		mysqli_query($conn, $sql);
		if ($is_active_feed == 1) { include('fediverse_add_flux.php'); }
		echo "<br />L'article a été mis à jour et son id est ".$id_article;
		}

		if($article_is_shared == "") {
		$sql = "INSERT INTO articles_published (uid, article_id, site_id, feed_id, is_published, published_date) values ('$user', '$id_article', '$id_site', '$id_feed', '1', '$article_date')";
	mysqli_query($conn, $sql);


		if ($is_active_feed == 1) { include('fediverse_add_flux.php'); }
	echo "<br />L'article a été ajouté et son id est ".$id_article;
		}

echo "<br />L'article existe et son id est ".$id_article;
}

?>