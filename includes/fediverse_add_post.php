<?php
include (__DIR__ ."/../config.php");
require 'mastophp/autoload.php';

$getuser = $app->getUser();
$userid = $getuser['id'];

$getstatus = $app->getStatuses($userid);
$post_url = $getstatus['0']['url'];
$post_id = $getstatus['0']['id'];
$post_visibiliy = $getstatus['0']['visibility'];
$appurl = $getstatus['0']['application']['website'];
echo $post_url."<br />";
 
if ($appurl == WEBSITE_URL OR $appurl == WEBSITE_URL."/") {
  
  $sql = "INSERT INTO statuses (uid, article_id, post_id, post_visibility, url) VALUES ('$user', '$article_id', '$post_id', '$post_visibiliy', '$post_url')";
  mysqli_query($conn, $sql);

  $sql = "UPDATE articles SET shares_count = shares_count + 1 WHERE id = '$article_id'";
  mysqli_query($conn, $sql);

  $sql = "UPDATE articles_published SET is_shared = 1 WHERE uid = '$user' AND article_id = '$article_id'";
  mysqli_query($conn, $sql);

}

else {

}

?>