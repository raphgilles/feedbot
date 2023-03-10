<?php
include('./functions.php');
include('../config.php');
$action = cq("".$_POST['action']."");


// Activer la synchronisation d'un flux
if ($action == 'activate_feed') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET is_active = ('1') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);
}



// Désactiver la synchronisation d'un flux
if ($action == 'desactivate_feed') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET is_active = ('0') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);
}



// S'abonner à un feed
if ($action == 'subscribe') {

session_start();
$feed_id = cq("".$_POST['feed_id']."");
$uid = $_SESSION['uid'];

$sql = "INSERT INTO feeds_published (feed_id, uid) values ('$feed_id', '$uid')";
mysqli_query($conn, $sql);

$sql = "SELECT * FROM articles WHERE feed_id = '$feed_id' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
	$article_id = $row['id'];
	$site_id = $row['id_site'];
	$date = $row['date'];
}

$sql2 = "SELECT * FROM articles_published WHERE uid = '$uid' AND feed_id = '$feed_id'";
$result2 = mysqli_query($conn, $sql2);
foreach ($result2 as $row2) {
    $share_id = $row2['id'];
}

if ($share_id == "") {
$sql = "INSERT INTO articles_published (uid, article_id, site_id, feed_id, is_published, published_date) VALUES ('$uid', '$article_id', '$site_id', '$feed_id', '1', '$date')";
mysqli_query($conn, $sql);
}

else {
$sql = "UPDATE articles_published SET is_published = ('1') WHERE uid = '$uid' AND feed_id = '$feed_id'";
mysqli_query($conn, $sql);
}

$sql = "UPDATE feeds SET subscribers = subscribers + 1 WHERE id = '$feed_id'";
mysqli_query($conn, $sql);

$sql = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM feeds_published WHERE feed_id = '$feed_id' AND  uid = '$uid'"));
$id = $sql['id'];

echo $id;

}



// Supprimer un feed
if ($action == 'delete_feed') {

session_start();
$feed_id = cq("".$_POST['feed_id']."");
$sub_id = cq("".$_POST['sub_id']."");
$uid = $_SESSION['uid'];

$sql2 = "SELECT * FROM articles_published WHERE uid = '$uid' AND feed_id = '$feed_id'";
$result = mysqli_query($conn, $sql2);
foreach ($result as $row){
	$sql3 = "UPDATE articles_published SET is_published = ('0') WHERE uid = '$uid' AND feed_id = '$feed_id'";
	mysqli_query($conn, $sql3);
	}

$sql = "DELETE FROM feeds_published WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);

$sql = "UPDATE feeds SET subscribers = subscribers - 1 WHERE id = '$feed_id'";
mysqli_query($conn, $sql);
}



// Modifier la confidentialité d'un flux
if ($action == 'change_visibility_feed') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$visibility = cq("".$_POST['visibility']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET visibility = ('$visibility') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);
}



// Partager le titre sur Mastodon ON-OFF
if ($action == 'share_title') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$share_title = cq("".$_POST['share_title']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET share_title = ('$share_title') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);
}



// Partager la description sur Mastodon ON-OFF
if ($action == 'share_description') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$share_description = cq("".$_POST['share_description']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET share_description = ('$share_description') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);
}



// Partager une image sur Mastodon ON-OFF
if ($action == 'share_image') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$share_image = cq("".$_POST['share_image']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET share_image = ('$share_image') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);
}



// Contenu sensible
if ($action == 'is_sensitive') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$is_sensitive = cq("".$_POST['is_sensitive']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET is_sensitive = ('$is_sensitive') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);

	if ($is_sensitive == "0") {
	$sql = "UPDATE feeds_published SET spoiler_text = ('') WHERE uid = '$uid' AND id ='$sub_id'";
	mysqli_query($conn, $sql);
	}
}



// Content Warning
if ($action == 'spoiler_text') {

session_start();
$sub_id = cq("".$_POST['sub_id']."");
$spoiler_text = cq("".$_POST['spoiler_text']."");
$uid = $_SESSION['uid'];

$sql = "UPDATE feeds_published SET spoiler_text = ('$spoiler_text') WHERE uid = '$uid' AND id ='$sub_id'";
mysqli_query($conn, $sql);
}



// Partager sur Mastodon
if ($action == 'share') {

session_start();
$publication = cq("".$_POST['message']."");
$url = "› ".cq("".$_POST['url']."");
$peertubeid = cq("".$_POST['peertubeid']."");
$youtubeid = cq("".$_POST['youtubeid']."");
$publication = html_entity_decode($publication);
$publication = str_replace( "\'", '’', $publication);
$publication = str_replace( '\\"', '"', $publication);
if ($youtubeid == "" && $peertubeid == "") {
$publication .= "\n \n".$url;
}
else {
$publication .= "\n \n".WEBSITE_URL."/watch/".$youtubeid.$peertubeid;
}
$publication .= " via @feedbot@tooter.social";
$article_id = cq("".$_POST['article_id']."");
$site_id = cq("".$_POST['site_id']."");
$feed_id = cq("".$_POST['feed_id']."");
$visibility = cq("".$_POST['visibility']."");
$uid = $_SESSION['uid'];
$aka = $_SESSION['akainstance'];
$redirect = $_SESSION['redirect'];
$date = date();

$sql = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles_published WHERE uid = '$uid' AND article_id = '$article_id'"));
$exists = $sql['id'];

if ($exists == "") {
	$sql = "INSERT INTO articles_published (uid, article_id, site_id, is_shared, published_date) VALUES ('$uid', '$article_id', '$site_id', '1', '$date')";
	mysqli_query($conn, $sql);

	$sql = "UPDATE articles SET shares_count = shares_count + 1 WHERE id = '$article_id'";
	mysqli_query($conn, $sql);
}

else {
	$sql = "UPDATE articles_published SET is_shared = '1' WHERE uid = '$uid' AND article_id = '$article_id'";
	mysqli_query($conn, $sql);

	$sql = "UPDATE articles SET shares_count = shares_count + 1 WHERE id = '$article_id'";
	mysqli_query($conn, $sql);
}

if ($visibility == "direct") {
	$publication = str_replace( " via @feedbot@tooter.social", '', $publication);
}
require 'mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP(''.$aka.'');

$app = $mastoPHP->registerApp(WEBSITE_NAME, WEBSITE_URL);
$app->postStatus($publication, $visibility);

$getuser = $app->getUser();
$userid = $getuser['id'];

$getstatus = $app->getStatuses($userid);
$post_url = $getstatus['0']['url'];
$post_id = $getstatus['0']['id'];
$post_visibiliy = $getstatus['0']['visibility'];
$appurl = $getstatus['0']['application']['website'];
if ($appurl == WEBSITE_URL OR $appurl == WEBSITE_URL."/") {
  $sql = "INSERT INTO statuses (uid, article_id, post_id, post_visibility, url) values ('$uid', '$article_id', '$post_id', '$post_visibiliy', '$post_url')";
  mysqli_query($conn, $sql);
}

echo $post_id;
}


// Supprimer une publication Mastodon
if ($action == 'delete_status') {

session_start();
$status_id = cq("".$_POST['status_id']."");
$article_id = cq("".$_POST['article_id']."");
$uid = $_SESSION['uid'];
$aka = $_SESSION['akainstance'];

$sql = "UPDATE articles_published SET is_shared = '0' WHERE uid = '$uid' AND article_id = '$article_id'";
mysqli_query($conn, $sql);

$sql = "UPDATE articles SET shares_count = shares_count - 1 WHERE id = '$article_id'";
	mysqli_query($conn, $sql);

require './mastophp/autoload.php';
$mastoPHP = new MastoPHP\MastoPHP(''.$aka.'');
$app = $mastoPHP->registerApp(WEBSITE_NALE, WEBSITE_URL);
$bearer = $app->gheader();
$bearer = $bearer['Authorization'];
$domaine = thedomain($aka);
$url = "https://".$domaine."/api/v1/statuses/".$status_id;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Authorization: '.$bearer)
);
$result = curl_exec($ch);
curl_close ($ch);

$sql = "DELETE FROM statuses WHERE uid = '$uid' AND post_id ='$status_id'";
mysqli_query($conn, $sql);

}



// Ajouter aux bookmarks
if ($action == 'bookmark') {

session_start();
$article_id = cq("".$_POST['article_id']."");
$site_id = cq("".$_POST['site_id']."");
$feed_id = cq("".$_POST['feed_id']."");
$uid = $_SESSION['uid'];
$date = time();

$sql = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles_published WHERE uid = '$uid' AND article_id = '$article_id'"));
$exists = $sql['id'];

if ($exists == "") {
	$sql = "INSERT INTO articles_published (uid, article_id, site_id, feed_id, bookmarked, published_date) VALUES ('$uid', '$article_id', '$site_id', '$feed_id', '1', '$date')";
	mysqli_query($conn, $sql);
}
else {
	$sql = "UPDATE articles_published SET bookmarked = '1' WHERE uid = '$uid' AND article_id = '$article_id'";
	mysqli_query($conn, $sql);
}

}



// Retirer des bookmarks
if ($action == 'delete_bookmark') {

session_start();
$article_id = cq("".$_POST['article_id']."");
$uid = $_SESSION['uid'];
$redirect = $_SESSION['redirect'];
$date = date();

$sql = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles_published WHERE uid = '$uid' AND article_id = '$article_id'"));
$exists = $sql['id'];

$sql = "UPDATE articles_published SET bookmarked = '0' WHERE uid = '$uid' AND article_id = '$article_id'";
	mysqli_query($conn, $sql);

if ($article_id !== "") { $article_redirect = "#".$article_id; }
header('location: '.$redirect.$article_redirect.'');

}



// Recevoir sur Telegram
if ($action == 'telegram') {

session_start();
$uid = $_SESSION['uid'];
$sub_id = cq("".$_POST['sub_id']."");
$telegram = cq("".$_POST['telegram']."");

$sql = "UPDATE feeds_published SET telegram = ('$telegram') WHERE id = '$sub_id' AND uid = '$uid'";
mysqli_query($conn, $sql);
}



// Paramètres de l'utilisateur
if ($action == 'settings') {

session_start();
$uid = $_SESSION['uid'];
$mail = cq("".$_POST['mail']."");
$dailymail = cq("".$_POST['dailymail']."");
if ($dailymail == "") { $dailymail = "0"; }

$sql = "UPDATE users SET mail = ('$mail'), daily_mail = ('$dailymail') WHERE id = '$uid'";
mysqli_query($conn, $sql);
header('location: '.WEBSITE_URL.'/index.php?p=settings&m=success');
}



// Publier sur Mastodon
if ($action == 'publish') {

session_start();
$publication = $_POST['message'];
$visibility = $_POST['visibility'];
$akainstance = $_SESSION['akainstance'];

if ($visibility == "direct") {
	$publication = str_replace( "via @feedbot@tooter.social", '', $publication);
}
require 'mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP(''.$akainstance.'');

$app = $mastoPHP->registerApp(WEBSITE_NAME, WEBSITE_URL);
$app->postStatus($publication, $visibility);

}


else {
}

?>