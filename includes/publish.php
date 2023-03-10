<?php
session_start();
$publication = $_POST['message'];
$visibility = $_POST['visibility'];
$akainstance = $_SESSION['akainstance'];

if ($visibility == "direct") {
	$publication = str_replace( "via @feedbot@tooter.social", '', $publication);
}
require 'mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP(''.$akainstance.'');

$app = $mastoPHP->registerApp('Feedbot', 'https://feedbot.net/');
$app->postStatus($publication, $visibility);

header('location: https://feedbot.net/index.php?p=publish&m=success')
?>