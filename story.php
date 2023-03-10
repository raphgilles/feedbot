<?php
include('./includes/functions.php');
include('./config.php');

$media_id = cq($_GET['media']);
$time = time() - (60 * 60 * 24);

$sql = "SELECT * FROM feeds WHERE id = '$media_id'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $media_name = $row['feed_title'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$media_name;?> - <?=WEBSITE_NAME;?> Stories</title>
  <!-- Source : https://github.com/origamid/slide-stories -->
  <link rel="stylesheet" href="<?=WEBSITE_URL;?>/assets/stories.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0,user-scalable=no, shrink-to-fit=yes" />

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

<script src="<?=WEBSITE_URL;?>/assets/jquery-3.6.3.min.js"></script>
</head>

<body>

 <div data-slide="slide_<?=$media_id;?>" class="slide">
    <div class="slide-items">

<?php
$sql = "SELECT * FROM articles WHERE feed_id = '$media_id' AND date > '$time' ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
//$i = 0;
foreach ($result as $row) {
    //if ($i < 5) {
    $sql2 = "SELECT * FROM feeds WHERE id = '$media_id'";
    $result2 = mysqli_query($conn, $sql2);
    foreach ($result2 as $row2) {
        $current_feed_id = $row2['id'];
        $feed_avatar = $row2['thumbnail'];
        $feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", "storage/icons/", $feed_avatar);
        $feed_title = $row2['feed_title'];
        $feed_url = $row2['feed_url'];
        $media_url = parse_url($feed_url, PHP_URL_HOST);
    }

    $title = $row['title'];
    $description = $row['excerpt'];
    $url = $row['url'];
    $thumbnail = $row['thumbnail'];
    $thumbnail = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", "storage/thumbnails/", $thumbnail);
    $date = minirelativedate($row['date']);
 
?>
    <div style="background-image: url(<?php echo $thumbnail; ?>) ; height:100%; aspect-ratio: 9/16; background-position: center; background-size: cover;">
        <div style="top:0; width: 100%; height: 200px; background: linear-gradient(0deg, rgba(255,255,255,0) 0%, rgba(0,0,0,0.8) 100%);">
            <div style="padding-left: 20px; padding-top: 20px;">
            <img src="<?php echo $feed_avatar; ?>" style="height: 60px; aspect-ratio: 1 / 1; border-radius: 50%; float: left;" />
                <div style="color:#FFF; padding-left: 70px; padding-top: 4px; text-shadow: 0px 0px 2px rgba(0,0,0,1);"><span style="font-weight: bold;"><?php echo $feed_title; ?></span> <span style="margin-left:8px; color:#D8D8D8;"><?=$date;?></span><br />
                <span style="font-size: 14px; padding-top: -8px;"><?php echo $media_url; ?></span>
                </div>
            </div>
        </div>

        <div class="excerpt">
        <a href="<?php echo $url; ?>" style="color: #000; font-weight:bold; margin-bottom: 4px; text-decoration: none;" target="_blank"><?php echo $title ?></a><br />
        <?php if ($description !== "") { ?><?php echo truncate($description,120); ?><br /><?php } ?>    
        </div>
        <div class="link" onclick="window.open('<?php echo $url; ?>');"><i class="fa fa-link" aria-hidden="true"></i> <span style="margin-left: 5px;">Ouvrir</span></div>

    </div>

<?php
    //$i++;
    }
//}
?>
  </div>
    <nav class="slide-nav">
      <div class="slide-thumb"></div>
      <button class="slide-prev">Anterior</button>
      <button class="slide-next">Próximo</button>
    </nav>
</div>

<script src="<?=WEBSITE_URL;?>/assets/slide-stories.js"></script>

<script type="text/javascript">
    new SlideStories('slide_<?=$media_id;?>');
</script>

</body>
</html>