<?php

// On vérifie si le média existe dans la base de donnée
$media_query = mysqli_fetch_array(mysqli_query($conn, "SELECT url FROM sites WHERE url = '$media_url'"));
$media_db_url = $media_query['url'];

// Si le média n'existe pas, on l'ajoute 
if($media_db_url == "") {
	// if ($media_thumbnail !== WEBSITE_URL."/assets/nopreview.png") {
	// $media_thumb = "/var/www/my_webapp/www/storage/icons/".sha1(time()).".jpg";
	// file_put_contents($media_thumb, file_get_contents($media_thumbnail));
	// $media_thumbnail = $media_thumb;
	// }

	$sql = "INSERT INTO sites (thumbnail, url) values ('$media_thumbnail', '$media_url')";
	mysqli_query($conn, $sql);
	$id_site_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM sites WHERE url = '$media_url'"));
	$id_site = $id_site_query['id'];
	echo "<br />Le média a été ajouté. Son id est ".$id_site;
}

// Si le média existe, on récupère son id
else {
	$id_site_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM sites WHERE url = '$media_url'"));
	$id_site = $id_site_query['id'];
   echo "<br />Le média existe déjà, son id est ".$id_site;
}


// On vérifie si le feed existe dans la base de donnée
$feed_url = $feed;
$feed_query = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM feeds WHERE feed_url = '$feed_url'"));
$feed_db_url = $feed_query['feed_url'];
$id_feed = $feed_query['id'];


// Si le feed n'existe pas, on l'ajoute 
if($feed_db_url == "") {
	// if ($media_thumbnail !== WEBSITE_URL."/assets/nopreview.png") {
	// $media_thumb = "/var/www/my_webapp/www/storage/icons/".sha1(time()).".jpg";
	// file_put_contents($media_thumb, file_get_contents($media_thumbnail));
	// $media_thumbnail = $media_thumb;
	// }

	$sql = "INSERT INTO feeds (site_id, feed_title, feed_url, thumbnail, language) values ('$id_site', '$media_name', '$feed_url', '$media_thumbnail', '$language')";
	mysqli_query($conn, $sql);
	$id_feed_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM feeds WHERE feed_url = '$feed_url'"));
	$id_feed = $id_feed_query['id'];	
	$language = $id_feed_query['language'];

	$sql = "INSERT INTO feeds_published (feed_id, uid) values ('$id_feed', '$user')";
	mysqli_query($conn, $sql);
	$id_feed_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM feeds_published WHERE uid = '$user' AND feed_id = '$id_feed'"));
	$is_active_feed = $id_feed_query['is_active'];
	$share_title = $id_feed_query['share_title'];
	$share_description = $id_feed_query['share_description'];
	$share_image = $id_feed_query['share_image'];
	$visibility = $id_feed_query['visibility'];
	$is_sensitive = $id_feed_query['is_sensitive'];
	$spoiler_text = $id_feed_query['spoiler_text'];
	echo "<br />Le feed a été ajouté. Son id est ".$id_feed." - Automatisé : ".$is_active_feed;
}


// Si le feed existe, on récupère son id
else {
	$id_feed_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM feeds_published WHERE uid = '$user' AND feed_id = '$id_feed'"));
	$feed_exists = $id_feed_query['id'];
	$query_language =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM feeds WHERE id = '$feed_exists'"));
	$language = $query_language['language'];

	if ($feed_exists == "") {
	$sql = "INSERT INTO feeds_published (feed_id, uid) values ('$id_feed', '$user')";
	mysqli_query($conn, $sql);
	$id_feed_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM feeds_published WHERE uid = '$user' AND feed_id = '$id_feed'"));
	$is_active_feed = $id_feed_query['is_active'];
	$share_title = $id_feed_query['share_title'];
	$share_description = $id_feed_query['share_description'];
	$share_image = $id_feed_query['share_image'];
	$is_sensitive = $id_feed_query['is_sensitive'];
	$spoiler_text = $id_feed_query['spoiler_text'];
	echo "<br />Le feed a été ajouté. Son id est ".$id_feed." - Automatisé : ".$is_active_feed;
	$sql = "UPDATE feeds SET subscribers = subscribers + 1 WHERE id = '$id_feed'";
	mysqli_query($conn, $sql);
	}

	else {
	$is_active_feed = $id_feed_query['is_active'];
	$share_title = $id_feed_query['share_title'];
	$share_description = $id_feed_query['share_description'];
	$share_image = $id_feed_query['share_image'];
	$visibility = $id_feed_query['visibility'];
	$is_sensitive = $id_feed_query['is_sensitive'];
	$spoiler_text = $id_feed_query['spoiler_text'];
	$feedexists = 1;
	echo "<br />Le feed existe et son id est ".$id_feed." - Automatisé : ".$is_active_feed."<br />CW : ".$is_sensitive." - Spoiler text : ".$spoiler_text;
	}
}



?>