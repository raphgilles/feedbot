<?php
	define('WEBSITE_NAME', 'Feedbot');
	include('./assets/lang/lang.php');
	include('./config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=I_TITLE;?></title>
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0,user-scalable=no, shrink-to-fit=yes" />
	<link rel="stylesheet" href="./assets/colors-dark.css">
	<link rel="stylesheet" href="./assets/style.css">
	<script src="./assets/jquery-3.6.3.min.js"></script>
</head>
<body style="position: relative; width: 100vw; height: 100vh; overflow: hidden;">

<div class="textcontainer" style="width: 100%; height: 100%; position: absolute;">
	<span class="particletext confetti" style="width: 100vw; height: 100vh; position: absolute; top: -60px;"></span>
</div>
<div class="textcontainer" style="width: 100%; height: 100%; position: absolute;">
	<span class="particletext confetti" style="width: 100vw; height: 100vh; position: absolute; top: -60px; translate: 0 50%;"></span>
</div>

<div align="center">
	<div style="position:absolute; top:50%; transform: translateY(-50%); margin: 0; width: 100%;">
		<img class="logo scale-up-center" src="./assets/icons/logomail.png">
<!--
		<h1 style="font-size: 100%;filter: drop-shadow(0 0 1px white);">🥳 <?=I_WELCOME;?></h1>
-->
	</div>
</div>

<style type="text/css">
.logo {
	display:block;
	max-width:50%;
	filter:invert(1) drop-shadow(0 0 1px white);
	margin:auto;
	width: 100%;
}
.scale-up-center {
	-webkit-animation: scale-up-center 0.8s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
			animation: scale-up-center 0.8s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
}
@-webkit-keyframes scale-up-center {
	0% {
		-webkit-transform: scale(0.5);
			transform: scale(0.5);
	}
	100% {
		-webkit-transform: scale(1);
			transform: scale(1);
	}
}
@keyframes scale-up-center {
	0% {
		-webkit-transform: scale(0.5);
			transform: scale(0.5);
	}
	100% {
		-webkit-transform: scale(1);
			transform: scale(1);
	}
}

@-webkit-keyframes confetti {
	0% {
		opacity: 0;
		transform: translateY(0%) rotate(0deg);
	}
	10% {
		opacity: 1;
	}
	35% {
		transform: translateY(-800%) rotate(270deg);
	}
	80% {
		opacity: 1;
	}
	100% {
		opacity: 0;
		transform: translateY(2000%) rotate(1440deg);
	}
}
@keyframes confetti {
	0% {
		opacity: 0;
		transform: translateY(0%) rotate(0deg);
	}
	10% {
		opacity: 1;
	}
	35% {
		transform: translateY(-800%) rotate(270deg);
	}
	80% {
		opacity: 1;
	}
	100% {
		opacity: 0;
		transform: translateY(2000%) rotate(1440deg);
	}
}
body .particletext.confetti > .particle {
	opacity: 0;
	position: absolute;
	-webkit-animation: confetti 3s ease-in infinite;
			animation: confetti 3s ease-in infinite;
}
body .particletext.confetti > .particle.c1 {
	background-color: #8384ff;
}
body .particletext.confetti > .particle.c2 {
	background-color: #563acc;
}
@media screen and (min-width:1080px){
	.logo {
		max-width: 30%;
	}
}
</style>
<script src="./assets/jquery-3.6.3.min.js"></script>
<script type="text/javascript">
function confetti() {
	 $.each($(".particletext.confetti"), function(){
			var confetticount = ($(this).width()/50)*5;
			for(var i = 0; i <= confetticount; i++) {
				 $(this).append('<span class="particle c' + $.rnd(1,2) + '" style="top:' + $.rnd(10,50) + '%; left:' + $.rnd(0,100) + '%;width:' + $.rnd(6,8) + 'px; height:' + $.rnd(3,4) + 'px;animation-delay: ' + ($.rnd(0,30)/10) + 's;"></span>');
			}
	 });
}
jQuery.rnd = function(m,n) {
	m = parseInt(m);
	n = parseInt(n);
	return Math.floor( Math.random() * (n - m + 1) ) + m;
}
confetti();
</script>
<script type="text/javascript">
	setTimeout(function(){
		installexit();
	}, 4000);

	function installexit(){
		$('body').fadeOut(400, 'linear', installredir());
	}

	function installredir(){
		setTimeout(function(){
			window.location.href = "<?=WEBSITE_URL;?>";
		}, 400);
	}
</script>