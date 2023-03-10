<?php
include('../config.php');
session_start();
unset($_SESSION['akainstance']);
unset($_SESSION['username']);
unset($_SESSION['display_name']);
unset($_SESSION['avatar']);
unset($_SESSION['uid']);
unset($_SESSION['aka']);
unset($_SESSION['token']);
session_destroy();
setcookie("akainstance", null, time()-3600, "/");
unset($_COOKIE['akainstance']);
header('location: '.WEBSITE_URL.'');
?>