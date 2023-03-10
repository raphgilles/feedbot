<?php

function emoji($u){
	$nb_arr = count($u['emojis']);
	if($nb_arr != 0){
		$i = 0;
		$text = $u['display_name'];
		while($i <= $nb_arr){
			$pseud = $u['emojis'][$i]['shortcode'];
			$emoj = $u['emojis'][$i]['url'];
			$text = str_replace(':'.$pseud.':', '<img class="x_shortcode" src="'.$emoj.'">', $text);
			$i++;
		}
	}
	else{
		$text = $u['display_name'];
	}
	return $text;
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
$url = "https://";
}
else {
$url = "http://";
}
$url.= $_SERVER['HTTP_HOST'];
$url .= "/";

// Exemple d'utilisation :
// Vous devez aussi configurer MastoPHP.php
// en remplaçant "urn:ietf:wg:oauth:2.0:oob" par "https://votre_site.tld/index_cnx.php" ici, index_cnx.php fait référence à ce présent fichier
//
// Votre formulaire initial où vous allez demander le @aka@instance.tld doit renvoyer cette valeur à index_cnx.php?i=@aka@instance.tld

session_start();

$redirect = $_SESSION['redirect'];
if ($redirect == $url."?p=signin") { $redirect = $url; }

if((htmlspecialchars($_GET['i']) != "") || (!empty($_COOKIE['akainstance']) && $_COOKIE['akainstance'] != "")){
	$akainstance = htmlspecialchars($_GET['i']);
	if($_COOKIE['akainstance'] != ""){
		$akainstance = htmlspecialchars($_COOKIE['akainstance']);
	}

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
	$akainstance = preg_replace('/\s+/', '', $akainstance);

	$_SESSION['fullaka'] = "@".$aka."@".$theDomain."";
	$_SESSION['aka'] = $aka;
	$_SESSION['theDomain'] = $theDomain;

	if($aka != "" && $theDomain != ""){

		$xurl = 'https://'.$theDomain.'/@'.$aka.'';
		$xch = curl_init($xurl);
		curl_setopt($xch, CURLOPT_HEADER, true);    // we want headers
		curl_setopt($xch, CURLOPT_NOBODY, true);    // we don't need body
		curl_setopt($xch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($xch, CURLOPT_TIMEOUT,10);
		$xoutput = curl_exec($xch);
		$xhttpcode = curl_getinfo($xch, CURLINFO_HTTP_CODE);
		curl_close($xch);

		$cookieaccept = htmlspecialchars($_GET['cookieaccept']);

		if($xhttpcode != 200){
			$akavalue = "@".$aka."@".$theDomain."";
			session_unset();
			session_destroy();
			setcookie("akainstance", null, time()-3600, "/");
			unset($_COOKIE['akainstance']);
			$error = "Le compte @".$aka."@".$theDomain." n’existe pas.";
			header('location: ../index.php?p=signin&error='.$error.'&stop=on');
		}
		else{
			header('location: ./validate.php?i='.$akainstance.'&cookieaccept='.$cookieaccept.'&redirect='.$redirect.'');
		}
	}
	else{
		$error = "Vérifiez l’écriture de votre @pseudo@serveur.";
		header('location: ../index.php?p=signin&error='.$error.'');
	}
}

if(!empty($_GET['code'])){
  header('location: ./validate.php?code='.htmlspecialchars($_GET['code']).'&redirect='.$redirect.'');
}