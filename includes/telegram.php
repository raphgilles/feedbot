<?php
session_start();
$feed_id = $_POST['feed_id'];
$uid = $_SESSION['uid'];

include('db.php');

$chat_id = $_GET['id'];
echo "Utilisateur : ".$uid."<br />";
echo "chat_id : ".$chat_id."<br />";

$sql = "UPDATE users SET telegram = ('$chat_id') WHERE id = '$uid'";
mysqli_query($conn, $sql);

if ($chat_id !== "") {
header('Location: '.WEBSITE_URL.'/?p=settings&telegram=success');
}
else {
header('Location: '.WEBSITE_URL.'/?p=settings&telegram=failed');
}
?>