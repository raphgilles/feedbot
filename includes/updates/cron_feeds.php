<?php
include (__DIR__ ."/../../config.php");
include('../functions.php');

$sql = "SELECT feeds_last_id FROM tasks";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
	$last_id = $row['feeds_last_id'];
}

$sql4 = "SELECT * FROM feeds WHERE id > '$last_id' AND subscribers != '0'";
$result4 = mysqli_query($conn, $sql4);

$limit = 0;
while($row4 = $result4->fetch_array()) {
	if ($limit < 10) {
		$feed_id = $row4['id'];
		$feed_name = $row4['feed_title'];
		$feed_url = $row4['feed_url'];
		$site_id = $row4['site_id'];
		echo "<strong>".$feed_name."</strong><br />".$feed_url."<br />";
		include('./cron_feeds_2.php');
		$limit++;
	}
}

if ($last_id >= $feed_id) { $feed_id = 0; }
$sql = "UPDATE tasks SET feeds_last_id = '$feed_id'";
mysqli_query($conn, $sql);

?>