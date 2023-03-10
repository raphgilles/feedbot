<?php
if (!file_exists('config.php')) {
    header('location: install.php');
}
include("template-parts/header.php");
?>

<body ontouchstart="">

<?php include("template-parts/sidebar.php") ?>

<div class="publish_popup zoomin" style="display: none;"></div>

<section class="home-section">

<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
<?php

if ($watch !== "") {
    include('watch.php');
}

if ($feed !== "") {
    include('single-feed.php');
}

if ($affichage === "global") {
    include('global.php');
}

// On vérifie si l'utilisateur est connecté, si non on lui affiche le formulaire de connexion
if (!is_null($isconnected) && $watch == "" && $feed == "" && $affichage !== "global") {

if ($affichage === '') {
    include('home.php');
}

elseif ($affichage === 'bookmarks') {
    include('bookmarks.php');
}

elseif ($affichage === 'add') {
    include('add.php');
}

elseif ($affichage === 'feeds') {
    include('feeds.php');
}

elseif ($affichage === 'shares') {
    include('shares.php');
}

elseif ($affichage === 'signin') {
    include('signin.php');
}

elseif ($affichage === 'settings') {
    include('settings.php');
}

elseif ($affichage === 'signout') {
    header('location: '.WEBSITE_URL.'/includes/disconnect.php');
}

elseif ($affichage === 'publish') {
    include('publish.php');
}

elseif ($affichage === 'search') {
    include('search.php');
}

else { ?>
<div style="max-width: 700px; min-width: 290px; margin: auto; padding-top: 80px; text-align: center;">
    <h3 style="margin-bottom: 40px;">Oops. You find a dead Link.</h3>
<img src="./assets/404.png" alt="Error 404 - Dead Link" title="Error 404 - Dead Link" style="width: 100%;" />
</div>
<?php }


} elseif ($watch == "" && $feed == "" && $affichage !== "global") {
    include('signin.php');
}

?>

</div>
</section>

<script type="text/javascript">
// Mobile Safari in standalone mode
if(("standalone" in window.navigator) && window.navigator.standalone){

    // If you want to prevent remote links in standalone web apps opening Mobile Safari, change 'remotes' to true
    var noddy, remotes = false;
    
    document.addEventListener('click', function(event) {
        
        noddy = event.target;
        
        // Bubble up until we hit link or top HTML element. Warning: BODY element is not compulsory so better to stop on HTML
        while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
            noddy = noddy.parentNode;
        }
        
        if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes))
        {
            event.preventDefault();
            document.location.href = noddy.href;
        }
    
    },false);
}
</script>

<script type="text/javascript">
    // Get the button:
let mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 5000 || document.documentElement.scrollTop > 5000) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 
</script>

<!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.4prod.com/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '4']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->

</body>
</html>