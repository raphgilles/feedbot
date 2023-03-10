<?php
session_start();
$user = $_SESSION['uid'];
include('./functions.php');
include('../config.php');
$lastid = cq("".$_GET['last_id']."");
$search = cq("".$_GET['search']."");
$search = html_entity_decode($search);
$search = str_replace( "-", ' ', $search);

$keywordaray = explode(' ', $search);
$b = 0;
$fullsearch = NULL;
foreach($keywordaray as $keyword) {
$keys = trim($keyword);
if ($b > 0) {
$other .=" OR title REGEXP '[[:<:]]".$keys."[[:>:]]'";
$other2 .=" OR excerpt REGEXP '[[:<:]]".$keys."[[:>:]]'";
$other3 .=" OR title LIKE '%$keys%'";
$other4 .=" OR excerpt LIKE '%$keys%'";
}
$fullsearch .= "$keys%";
$b++;
}
$firstword = $keywordaray['0'];
$other = str_replace("OR title REGEXP '[[:<:]][[:>:]]'", '', $other);
$other2 = str_replace("OR excerpt REGEXP '[[:<:]][[:>:]]'", '', $other);
$other3 = str_replace("OR title LIKE '%%'", '', $other3);
$other4 = str_replace("OR excerpt LIKE '%%'", '', $other4);

$sql = "SELECT * FROM articles WHERE (title LIKE '%$fullsearch' OR excerpt LIKE '%$fullsearch') AND id < '$lastid' ORDER BY id DESC LIMIT 20";
$result = mysqli_query($conn, $sql);

include("../template-parts/single-feed-timeline.php");
?>