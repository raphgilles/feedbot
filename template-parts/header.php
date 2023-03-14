<?php
include('./config.php');
include('./includes/functions.php');

if(!isset($admin)){
  $sql = "SELECT * FROM users WHERE admin = '1'";
  $result = mysqli_query($conn, $sql);
  foreach($result as $row){
    $admin = $row['username'];
  }
}

$sidebar = $_COOKIE['open'];
$lang = $_COOKIE['lang'];

$affichage = cq("".$_GET['p']."");
$watch = cq("".$_GET['watch']."");
$feed = cq("".$_GET['feed']."");
$article = cq("".$_GET['article']."");

session_start();

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
$redirect = "https://";
}
else {
$redirect = "http://";
}
$redirect.= $_SERVER['HTTP_HOST'];   
$redirect.= $_SERVER['REQUEST_URI'];    

if ($affichage !== "signin" && $affichage !== "publish") {
$_SESSION['redirect'] = $redirect;
}
$stopredir = cq($_GET['stop']);

$isconnected = $_SESSION['uid'];
if ($isconnected == "" && $stopredir !== "on") {
    if(cq($_COOKIE['akainstance']) != ""){
    header('location: '.WEBSITE_URL.'/includes/index_cnx.php?i='.cq($_COOKIE['akainstance']).'&cookieaccept=on&redirect='.$redirect.'');
    }
    else{
    }
}

else {
$user = $isconnected;
$useravatar = $_SESSION['avatar'];
$displayname = $_SESSION['display_name'];
$username = $_SESSION['username'];
$aka = $_SESSION['akainstance'];
$banner = $_SESSION['banner'];
$followers = $_SESSION['followers_count'];
$following = $_SESSION['following_count'];
}

if ($watch !== "") {
$sql = "SELECT * FROM articles WHERE youtubeid = '$watch'";
$result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
      $theurl = $row['url'];
      $website = parse_url($theurl, PHP_URL_HOST);
      $is_youtube = $website;
      $youid = $row['youtubeid'];
      if ($website == "www.youtube.com") {
      $article_id = $row['id'];
      $title = $row['title'];
      $feed_id = $row['feed_id'];

      parse_str(parse_url($theurl, PHP_URL_QUERY), $youtube_parser);
      $youtubeid = $youtube_parser['v'];

      $thumbnail = $row['thumbnail'];
      $thumbnail = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", "/storage/thumbnails/", $thumbnail);
      $thumbnail = $thumbnail;

      $description_link = html_entity_decode($row['excerpt'], ENT_SUBSTITUTE);
      $description_link = urlencode($description_link);
      $description_link = str_replace( "%C2%AB%C2%A0", '“', $description_link);
      $description_link = str_replace( "%C2%A0%C2%BB", '”', $description_link);
      $description_link = str_replace( "%C2%AB", '“', $description_link);
      $description_link = str_replace( "%C2%BB", '”', $description_link);
      $description_link = str_replace( "%0A", '', $description_link);

      $description = html_entity_decode($row['excerpt'], ENT_SUBSTITUTE);

      $date = relativedate($row['date']);
      }
    }

$sql = "SELECT * FROM articles WHERE peertubeid = '$watch'";
$result = mysqli_query($conn, $sql);
  foreach ($result as $row) {
    $platform = $row['platform'];
    if ($platform == "PeerTube") {
    $article_id = $row['id'];
    $peertubeid = $row['peertubeid'];
    $embed = $row['embed'];
    $feed_id = $row['feed_id'];
    $is_embeded = $article_id;
    $title = $row['title'];
    $theurl = $row['url'];
    $website = parse_url($theurl, PHP_URL_HOST);

    $thumbnail = $row['thumbnail'];
    $thumbnail = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", WEBSITE_URL."/storage/thumbnails/", $thumbnail);
    $thumbnail = $thumbnail;

    $description_link = html_entity_decode($row['excerpt'], ENT_SUBSTITUTE);
    $description_link = urlencode($description_link);
    $description_link = str_replace( "%C2%AB%C2%A0", '“', $description_link);
    $description_link = str_replace( "%C2%A0%C2%BB", '”', $description_link);
    $description_link = str_replace( "%C2%AB", '“', $description_link);
    $description_link = str_replace( "%C2%BB", '”', $description_link);
    $description_link = str_replace( "%0A", '', $description_link);

    $description = html_entity_decode($row['excerpt'], ENT_SUBSTITUTE);

    $date = relativedate($row['date']);
    }
  }
}

if ($feed !== "" && $article == "") {
  $sql = "SELECT * FROM feeds WHERE id = '$feed'";
  $result = mysqli_query($conn, $sql);
  foreach ($result as $row) {
    $feed_name = $row['feed_title'];
    $title = $row['feed_title'];
    $feed_avatar = $row['thumbnail'];
    $feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", WEBSITE_URL."/storage/icons/", $feed_avatar);
    $feed_avatar = $feed_avatar;
    $feed_url = $row['feed_url'];
    $media_url = parse_url($feed_url, PHP_URL_HOST);
    $media_url = str_replace("api.", "", $media_url);
    $media_url = str_replace("feeds.", "", $media_url);
    $media_url = str_replace("rss.", "", $media_url);
    $media_url = str_replace("backend.", "", $media_url);
    $wiki_slug = $row['wiki_slug'];
    $subscribers = $row['subscribers'];
  }

  $sql = "SELECT * FROM articles WHERE feed_id = '$feed' ORDER BY id DESC LIMIT 1";
  $result = mysqli_query($conn, $sql);
  foreach ($result as $row) {
    $feed_banner = $row['thumbnail'];
    $feed_banner = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", "/storage/thumbnails/", $feed_banner);
    $feed_banner = $feed_banner;
  }
}

if ($feed !== "" && $article !== "") {
  $sql = "SELECT * FROM feeds WHERE id = '$feed'";
  $result = mysqli_query($conn, $sql);
  foreach ($result as $row) {
    $feed_name = $row['feed_title'];
    $feed_avatar = $row['thumbnail'];
    $feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", WEBSITE_URL."/storage/icons/", $feed_avatar);
    $feed_avatar = $feed_avatar;
    $feed_url = $row['feed_url'];
    $media_url = parse_url($feed_url, PHP_URL_HOST);
    $media_url = str_replace("api.", "", $media_url);
    $media_url = str_replace("feeds.", "", $media_url);
    $media_url = str_replace("rss.", "", $media_url);
    $media_url = str_replace("backend.", "", $media_url);
    $wiki_slug = $row['wiki_slug'];
  }

  $sql = "SELECT * FROM articles WHERE feed_id = '$feed' AND id = '$article'";
  $result = mysqli_query($conn, $sql);
  foreach ($result as $row) {
    $title = $row['title'];
    $feed_banner = $row['thumbnail'];
    $feed_banner = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", "/storage/thumbnails/", $feed_banner);
    $feed_banner = $feed_banner;
  }
}

?>
<!DOCTYPE html>
<html lang="<?=$lang;?>" dir="ltr">

<head>
<title><?php if ($title !== NULL) { echo $title. " | "; } ?><?=WEBSITE_NAME;?></title>
<meta property="og:platform" content="Feedbot" />
<meta property="feedbot:version" content="0.9" />
<meta property="feedbot:admin" content="<?=$admin;?>" />

<?php if ($watch !== "") { ?>
<meta property="og:title" content="<?php echo $title; ?>" />
<?php if ($description !== "") { ?><meta property="og:description" content="<?php echo htmlentities($description); ?>" /><?php } ?>
<meta property="og:image" content="<?php echo $thumbnail; ?>" />
<meta property="og:type" content="video.other">
<?php if ($youid !== NULL) { ?>
<meta property="og:video:url" content="https://www.youtube-nocookie.com/embed/<?php echo $watch; ?>">
<meta property="og:video:secure_url" content="https://www.youtube-nocookie.com/embed/<?php echo $watch; ?>">
<?php }
if ($peertubeid !== NULL) { ?>
<meta property="og:video:url" content="<?php echo $embed; ?>">
<meta property="og:video:secure_url" content="<?php echo $embed; ?>">
<?php } ?>
<meta property="og:video:type" content="text/html">
<meta property="og:video:width" content="1280">
<meta property="og:video:height" content="720">
<meta name="twitter:card" content="player">
<meta name="twitter:site" content="@feedbotnet">
<meta name="twitter:url" content="<?=WEBSITE_URL;?>/watch/<?php echo $watch; ?>">
<meta name="twitter:title" content="<?php echo $title; ?>">
<?php if ($description !== "") { ?><meta name="twitter:description" content="<?php echo htmlentities($description); ?>"><?php } ?>
<meta name="twitter:image" content="<?php echo $thumbnail; ?>">
<?php if ($youid !== NULL) { ?>
<meta name="twitter:player" content="https://www.youtube-nocookie.com/embed/<?php echo $watch; ?>">
<?php }
if ($peertubeid !== NULL) { ?>
<meta name="twitter:player" content="<?php echo $embed; ?>">
<?php } ?>
<meta name="twitter:player:width" content="1280">
<meta name="twitter:player:height" content="720">
<?php } ?>

<?php if ($feed !== "") { ?>
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:image" content="<?php echo $banner; ?>" />
<meta name="twitter:site" content="@feedbotnet">
<meta name="twitter:title" content="<?php echo $title; ?>">
<meta name="twitter:image" content="<?php echo $banner; ?>">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@v5.3.2/dist/amplitude.js"></script>
<?php } ?>

<?php if ($affichage == "" && $watch == "" && $feed == "") { ?>
<meta property="og:title" content="<?=WEBSITE_NAME;?> - Veille des médias et partage sur Mastodon" />
<meta property="og:image" content="<?=WEBSITE_URL;?>/assets/icons/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png" />
<meta name="twitter:site" content="@feedbotnet">
<meta name="twitter:title" content="<?=WEBSITE_NAME;?> - Veille des médias et partage sur Mastodon">
<meta name="twitter:image" content="<?=WEBSITE_URL;?>/assets/icons/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png">
<?php } ?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$theme = $_COOKIE['theme'];
if ($theme == "") {$theme = "dark"; }
?>
<link rel="stylesheet" href="<?php echo WEBSITE_URL ?>/assets/colors-<?=$theme;?>.css" id="theme">
<link rel="stylesheet" href="<?php echo WEBSITE_URL ?>/assets/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0,user-scalable=no, shrink-to-fit=yes" />
<meta name="apple-mobile-web-app-title" content="<?=WEBSITE_NAME;?>" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="theme-color" content="#11101D" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="assets/icons/iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/iPhone_11__iPhone_XR_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="assets/icons/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="assets/icons/iPhone_14_Pro_Max_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/10.5__iPad_Air_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/11__iPad_Pro__10.5__iPad_Pro_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="assets/icons/iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/12.9__iPad_Pro_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="assets/icons/iPhone_11_Pro_Max__iPhone_XS_Max_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="assets/icons/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/11__iPad_Pro__10.5__iPad_Pro_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="assets/icons/iPhone_14_Pro_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/10.9__iPad_Air_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/10.2__iPad_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/10.5__iPad_Air_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/12.9__iPad_Pro_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/10.9__iPad_Air_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="assets/icons/iPhone_14_Pro_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="assets/icons/iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/8.3__iPad_Mini_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="assets/icons/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="assets/icons/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="assets/icons/iPhone_11_Pro_Max__iPhone_XS_Max_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="assets/icons/iPhone_14_Pro_Max_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="assets/icons/iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/10.2__iPad_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="assets/icons/8.3__iPad_Mini_landscape.png">
<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="assets/icons/iPhone_11__iPhone_XR_portrait.png">

<link rel="manifest" href="./manifest.json">
<link rel="icon" type="image/png" href="<?=WEBSITE_URL;?>/assets/icons/icon.png" />
<link rel="apple-touch-icon" href="<?=WEBSITE_URL;?>/assets/icons/icon.png" />

<?php if($article !== "") {?><script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@{{version-number}}/dist/amplitude.js"></script><?php } ?>
<script src="<?php echo WEBSITE_URL."/assets/jquery-3.6.3.min.js"; ?>"></script>
<?php include(WEBSITE_URI.'/assets/functions.js.php'); ?>

</head>
