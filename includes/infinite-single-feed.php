<?php
session_start();
$user = $_SESSION['uid'];
include('./functions.php');
include('../config.php');
$lastid = cq("".$_GET['last_id']."");
$feed = cq("".$_GET['feed']."");

$sql = "SELECT * FROM articles WHERE date < '$lastid' AND feed_id = '$feed' ORDER BY date DESC LIMIT 20";
$result = mysqli_query($conn, $sql);

include("../template-parts/single-feed-timeline.php");
?>