<?php
include('../config.php');
include('../includes/functions.php');

$id = cq($_GET['id']);

$sql = "SELECT * FROM articles WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row){
    $title = $row['title'];
    $thumbnail = $row['thumbnail'];
    $thumbnail = str_replace($_SERVER['DOCUMENT_ROOT'], WEBSITE_URL."/", $thumbnail);
    $embed = $row['embed'];
    $feed_id = $row['feed_id'];

    $sql = "SELECT * FROM feeds WHERE id ='$feed_id'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row){
        $feed_name = $row['feed_title'];
    }
}
?>
<head>
<title><?=$title;?> | <?=WEBSITE_NAME;?> Podcast</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0,user-scalable=no, shrink-to-fit=yes" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@v5.3.2/dist/amplitude.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo WEBSITE_URL ?>/assets/colors-dark.css" id="theme">
<link rel="stylesheet" href="<?php echo WEBSITE_URL ?>/assets/style.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@v5.3.2/dist/amplitude.js"></script>
<script src="<?php echo WEBSITE_URL."/assets/jquery-3.6.3.min.js"; ?>"></script>

<style type="text/css">
    /*
  1. Base
*/
/*
  2. Components
*/
div.control-container {
  margin-top: 10px;
  padding-bottom: 10px; }
  div.control-container div.amplitude-play-pause {
    width: 74px;
    height: 74px;
    cursor: pointer;
    float: left;
    margin-left: 10px; }
  div.control-container div.amplitude-play-pause.amplitude-paused {
    background: url("https://521dimensions.com/img/open-source/amplitudejs/examples/single-song/play.svg");
    background-size: cover; }
  div.control-container div.amplitude-play-pause.amplitude-playing {
    background: url("https://521dimensions.com/img/open-source/amplitudejs/examples/single-song/pause.svg");
    background-size: cover; }
  div.control-container div.meta-container {
    float: left;
    width: calc(100% - 84px);
    text-align: center;
    color: white;
    margin-top: 10px; }
    div.control-container div.meta-container span[data-amplitude-song-info="name"] {
      font-family: "Open Sans", sans-serif;
      font-size: 18px;
      color: #fff;
      display: block; }
    div.control-container div.meta-container span[data-amplitude-song-info="artist"] {
      font-family: "Open Sans", sans-serif;
      font-weight: 100;
      font-size: 14px;
      color: #fff;
      display: block; }
  div.control-container:after {
    content: "";
    display: table;
    clear: both; }

/*
  Small only
*/
@media screen and (max-width: 39.9375em) {
  div.control-container div.amplitude-play-pause {
    background-size: cover;
    width: 64px;
    height: 64px; }
  div.control-container div.meta-container {
    width: calc(100% - 74px); } }
/*
  Medium only
*/
/*
  Large Only
*/
div.time-container {
  opacity: 0.5;
  font-family: 'Open Sans';
  font-weight: 100;
  font-size: 12px;
  color: #fff;
  height: 15px; }
  div.time-container span.current-time {
    float: left;
    margin-left: 5px; }
  div.time-container span.duration {
    float: right;
    margin-right: 5px; }

/*
  Small only
*/
/*
  Medium only
*/
/*
  Large Only
*/
progress.amplitude-song-played-progress {
  background-color: #313252;
  -webkit-appearance: none;
  appearance: none;
  width: 100%;
  height: 5px;
  display: block;
  cursor: pointer;
  border: none; }
  progress.amplitude-song-played-progress:not([value]) {
    background-color: #313252; }

progress[value]::-webkit-progress-bar {
  background-color: #313252; }

progress[value]::-moz-progress-bar {
  background-color: var(--feedbot-purple); }

progress[value]::-webkit-progress-value {
  background-color: var(--feedbot-purple); }

/*
  Small only
*/
/*
  Medium only
*/
/*
  Large Only
*/
/*
  3. Layout
*/
div.bottom-container {
  background-color: #202136; }

/*
  Small only
*/
/*
  Medium only
*/
/*
  Large Only
*/
div#single-song-player {
  margin: auto;
  width: 100%;
  -webkit-font-smoothing: antialiased; }
  div#single-song-player img[data-amplitude-song-info="cover_art_url"] {
    width: 100%; }

a.learn-more{
  display: block;
  width: 300px;
  margin: auto;
  margin-top: 30px;
  text-align: center;
  color: white;
  text-decoration: none;
  background-color: #202136;
  font-family: "Lato", sans-serif;
  padding: 20px;
  font-weight: 100;
}
/*
  Small only
*/
/*
  Medium only
*/
/*
  Large Only
*/
/*
  4. Pages
*/
/*
  5. Themes
*/
/*
  6. Utils
*/
/*
  7. Vendors
*/

/*# sourceMappingURL=app.css.map */


</style>
</head>

<body style="background-color:#202136; height:100%;">

<div  style="position:absolute; background-color:#313252; z-index:2; height:calc(100% - 115px); width:100%;">
  <div id="single-song-player">
      <div style="position:relative; background-image:url(<?=$thumbnail;?>); background-size:cover; background-position:center; width:100%;"><a href="<?=WEBSITE_URL."/podcast/".$id;?>" target="_blank" style="display:block; width:100%; height:100%;"></a></div>
        <div class="bottom-container">
          <progress class="amplitude-song-played-progress" id="song-played-progress"></progress>

          <div class="time-container">
              <span class="current-time">
                  <span class="amplitude-current-minutes"></span>:<span class="amplitude-current-seconds"></span>
              </span>
              <span class="duration">
                  <span class="amplitude-duration-time"></span>
              </span>
          </div>

          <div class="control-container">
            <div class="amplitude-play-pause amplitude-playing" id="play-pause"></div>
            <div class="meta-container">
              <span data-amplitude-song-info="name" class="song-name"></span>
              <span data-amplitude-song-info="artist"></span>
            </div>
          </div>
        </div>
  </div>
</div>

<script id="rendered-js">
    Amplitude.init({
    "bindings": {
      37: 'prev',
      39: 'next',
      32: 'play_pause'
    },
    "songs": [
      {
        "name": "<?=$title;?>",
        "artist": "<?=$feed_name;?>",
        "album": "",
        "url": "<?=$embed;?>",
        "cover_art_url": "<?=$thumbnail;?>",
        "duration": "60"
      },
    ],
    "autoplay": true
  });

    Amplitude.play();

  window.onkeydown = function(e) {
      return !(e.keyCode == 32);
  };

  /*
    Handles a click on the song played progress bar.
  */
  document.getElementById('song-played-progress').addEventListener('click', function( e ){
    var offset = this.getBoundingClientRect();
    var x = e.pageX - offset.left;

    Amplitude.setSongPlayedPercentage( ( parseFloat( x ) / parseFloat( this.offsetWidth) ) * 100 );
  });
</script>

<script type="text/javascript">
  $("#play-pause").addClass("amplitude-playing");
</script>

<div style="width:100%; position:absolute; margin:auto; bottom:15px; font-size:12px; text-align:center;">Propulsé par <a href="https://521dimensions.com/open-source/amplitudejs" style="color:#FFF;" target="_blank">AmplitudeJS</a></div>

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