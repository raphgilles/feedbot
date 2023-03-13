<?php
include('../config.php');
include('./functions.php');

session_start();

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	$url = "https://";
}
else {
	$url  = "http://";
}
	$url .= $_SERVER['HTTP_HOST'];
	$url .= "/";

$redirect = $_SESSION['redirect'];

if($redirect == $url."?p=signin"){
	$redirect = $url;
}
if($redirect == ""){
	$redirect = $url;
}

if(htmlspecialchars($_GET['error']) == "access_denied"){
	session_unset();
	session_destroy();
	header('location: ../index.php');
}

if((($_SESSION['akainstance'] == "") || (empty($_SESSION['akainstance']))) && (htmlspecialchars($_GET['i']) != "")){
	$akainstance = htmlspecialchars($_GET['i']);
	$akainstance = preg_replace('/\s+/', '', $akainstance);
	$_SESSION['akainstance'] = $akainstance;
}

if($_GET['cookieaccept'] == "on"){
	setcookie("akainstance", "".$_SESSION['akainstance']."", time()+60*60*24*365, "/");
}

$akainstance = $_SESSION['akainstance'];

require './mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP(''.$akainstance.'');

$app = $mastoPHP->registerApp(WEBSITE_NAME, WEBSITE_URL);

if(!empty($_GET['i'])){
	echo "<strong>— Veuillez vous assurer d'avoir donné les droit d'accès en écriture au dossier \"/includes/mastophp\" puis rafraîchissez cette page.<br>— Please make sure you have given write access to the \"/includes/mastophp\" folder then refresh this page.</strong>";

	if($app === false) {
		throw new Exception('Problem during register app');
	}

	// Redirection automatique vers l'instance pour validation
	if($app->getAuthUrl() == ""){
		session_unset();
		session_destroy();
		setcookie("akainstance", null, time()-3600, "/");
		unset($_COOKIE['akainstance']);
		header('location: ../index.php?p=signin&stop=on&aka='.$akainstance);
	}
	else{
		header('location:'.$app->getAuthUrl().'');
	}
}

if(!empty($_GET['code'])){
	// L'instance renvoie à index_cnx.php le code par la méthode get : https://votre_site.tld/index_cnx.php?code=XXXXXXX
	$app->registerAccessToken(''.htmlspecialchars($_GET['code']).'');

	$user = $app->getUser();
	$display_name = emoji($user);

	$myaka = $_SESSION['aka'];
	$thisaka = strtolower($user['username']);

	if($myaka == $thisaka){

		include('add_user_to_db.php');

		$bearer = $app->gheader();
		$bearer = $bearer['Authorization'];
		$_SESSION['aka'] = $user['username'];
		$_SESSION['Authorization'] = $bearer;
		$_SESSION['username'] = $user['username'];
		$_SESSION['display_name'] = $display_name;
		$_SESSION['avatar'] = $user['avatar'];
		$_SESSION['banner'] = $user['header'];
		$_SESSION['uid'] = $id_user;
		$_SESSION['statuses_count'] = $user['statuses_count'];
		$_SESSION['followers_count'] = $user['followers_count'];
		$_SESSION['following_count'] = $user['following_count'];
		$_SESSION['note'] = $user['note'];
		$_SESSION['user'] = $user;
		$_SESSION['fullakainstance'] = "@".$user['username']."@".$_SESSION['theDomain']."";

		if ($redirect == $url."?p=signin") { $redirect = ""; }
		header('location: '.$redirect.'');
	}
	else{
		$exploder = explode('@', $akainstance);

		if($exploder[0] == ""){
			$aka = $exploder[1];
			$theDomain = $exploder[2];
		}
		else{
			$aka = $exploder[0];
			$theDomain = $exploder[1];
		}

		$aka = strtolower($aka);
		$theDomain = strtolower($theDomain);
		$akainstance = "@".$aka."@".$theDomain."";

		$key1 = sha1($akainstance);
		$key2 = sha1($aka);
		$key3 = sha1($theDomain);
		$key4 = sha1($salt.$key1.$key2.$key3.$pepper);

		$jfil = __DIR__.DIRECTORY_SEPARATOR.'/mastophp/MastoPHP_'.$theDomain.'_'.$key4.'.json';
		unlink($jfil);

		$erraccount = "Il y a un problème avec votre compte. Veuillez vérifier les informations.";

		header('location: ../index.php?p=signin&error='.$erraccount.'&aka1='.htmlspecialchars($myaka).'&aka2='.htmlspecialchars($thisaka).'&theDomain='.htmlspecialchars($theDomain).'');
	}
}