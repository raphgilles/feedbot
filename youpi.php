<?php
	define('WEBSITE_NAME', 'Feedbot');
	include('./assets/lang/lang.php');
	include('./config.php');
?>
<div align="center">
	<img class="scale-up-center" src="./assets/icons/logomail.png" style="display:block; max-width:60vw; filter:invert(1) drop-shadow(0 0 1px white); margin:auto;width: 100%;">
	<div class="textcontainer">
		<span class="particletext confetti"><h1 style="font-size: xx-large;filter: drop-shadow(0 0 1px white);">🥳 <?=I_WELCOME;?></h1></span>
	</div>
</div>
<style type="text/css">
.scale-up-center {
	-webkit-animation: scale-up-center 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
			animation: scale-up-center 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
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
  background-color: rgba(76, 175, 80, 0.5);
}
body .particletext.confetti > .particle.c2 {
  background-color: rgba(156, 39, 176, 0.5);
}
</style>
<script src="./assets/jquery-3.6.3.min.js"></script>
<script type="text/javascript">
function confetti() {
   $.each($(".particletext.confetti"), function(){
      var confetticount = ($(this).width()/50)*10;
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
		window.location.href = "<?=WEBSITE_URL;?>";
	}, 4000);
</script>