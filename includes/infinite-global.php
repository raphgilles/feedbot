<?php
session_start();
$user = $_SESSION['uid'];
include('./functions.php');
include('../config.php');
$lastid = cq("".$_GET['last_id']."");

$sql = "SELECT * FROM articles WHERE date < '$lastid' ORDER BY date DESC LIMIT 20";
$result = mysqli_query($conn, $sql);

include("../template-parts/global-timeline.php");
?>