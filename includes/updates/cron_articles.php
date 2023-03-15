<?php
include (__DIR__ ."/../../config.php");
include('../functions.php');

$sql = "SELECT articles_last_id FROM tasks";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
  $last_id = $row['articles_last_id'];
}

$sql4 = "SELECT * FROM feeds_published WHERE id > '$last_id'";
$result4 = mysqli_query($conn, $sql4);

$limit = 0;

foreach ($result4 as $row4) {
  if ($limit < 20) {
    $id = $row4['id'];
    $user = $row4['uid'];
    $feed_id = $row4['feed_id'];
    $share_title = $row4['share_title'];
    $share_description = $row4['share_description'];
    $share_image = $row4['share_image'];
    $visibility = $row4['visibility'];
    $is_sensitive = $row4['is_sensitive'];
    $spoiler_text = $row4['spoiler_text'];
    $is_active = $row4['is_active'];

    $sql = "SELECT * FROM feeds WHERE id = '$feed_id'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
      $feed_name = $row['feed_title'];
      $site_id = $row['site_id'];
      $language = $row['language'];
    }

    $sql = "SELECT * FROM users WHERE id = '$user'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
      $aka = $row['username'];
    }

    echo "<strong>".$feed_name."</strong><br />";

    $sql = "SELECT * FROM articles WHERE feed_id = '$feed_id' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
      $article_id = $row['id'];
      $title = $row['title'];
      $description = $row['excerpt'];
      $thumbnail = $row['thumbnail'];
      $url = $row['url'];
      $youtube_id = $row['youtubeid'];
      $peertubeid = $row['peertubeid'];
      $article_query = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles_published WHERE uid = '$user' AND article_id = '$article_id' AND feed_id = '$feed_id'"));
      $article_db_id = $article_query['id'];
      $date = $row['date'];

      if ($article_db_id == "") {
        $sql = "INSERT INTO articles_published (uid, article_id, site_id, feed_id, is_published, published_date) VALUES ('$user', '$article_id', '$site_id', '$feed_id', '1', '$date')";
        mysqli_query($conn, $sql);

        echo "User: ".$user." - Article: ".$article_id." - Site: ".$site_id." - Feed: ".$feed_id." - YouTube: ".$youtube_id."<br />";
        echo "Publié sur Feedbot<br />";

        if ($is_active == 1) {
        echo "User: ".$user." - Article: ".$article_id." - Site: ".$site_id." - Feed: ".$feed_id." - YouTube: ".$youtube_id."<br />";
        include('../fediverse_add_flux.php');
        }
      }
      else {
      }
    }
  $limit++;
  }
}

if ($last_id >= $id) { $id = 0; }
$sql = "UPDATE tasks SET articles_last_id = '$id'";
mysqli_query($conn, $sql);

?>