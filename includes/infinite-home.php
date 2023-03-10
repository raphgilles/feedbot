<?php
session_start();
$user = $_SESSION['uid'];
include('./functions.php');
include('../config.php');
$lastid = cq("".$_GET['last_id']."");

$sql = "SELECT * FROM articles_published WHERE published_date < '$lastid' AND uid = '$user' AND is_published = '1' ORDER BY published_date DESC LIMIT 20";
$result = mysqli_query($conn, $sql);

include("../template-parts/home-timeline.php");
?>