<?php
if(!empty($_GET['lang']) && $_GET['lang'] != ""){
	$lang = htmlentities(addslashes($_GET['lang']));
	setcookie("lang", $lang);
}
elseif(!empty($_COOKIE["lang"]) && $_COOKIE["lang"] != ""){
	$lang = htmlentities(addslashes($_COOKIE["lang"]));
}
else{
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	setcookie("lang", $lang);
}

switch ($lang) {
	case 'fr':
		// En Français
		require_once('fr.php');
		break;

	case 'uk':
		// En Français
		require_once('uk.php');
		break;
	
	default:
		// Par défaut
		require_once('en.php');
		break;
}
?>