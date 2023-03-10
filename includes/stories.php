<?php
include('../config.php');
include('./functions.php');

$media_id = cq($_GET['media']);
$back_url = $_SERVER['HTTP_REFERER'];
$time = time() - (60 * 60 * 24);
$sql = "SELECT * FROM articles WHERE feed_id = '$media_id' AND date > '$time' ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
?>
<div class="closer" onclick="hide_publish('<?=$back_url;?>')"><i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
 <div data-slide="slide_<?php echo $media_id; ?>" class="slide">
    <div class="slide-items">

<?php
$i = 0;
foreach ($result as $row) {
    if ($i < 6) {
    $feed_id = $row['feed_id'];
    $sql2 = "SELECT * FROM feeds WHERE id = '$feed_id'";
    $result2 = mysqli_query($conn, $sql2);
    foreach ($result2 as $row2) {
        $current_feed_id = $row2['id'];
        $feed_avatar = $row2['thumbnail'];
        $feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", WEBSITE_URL."/storage/icons/", $feed_avatar);
        $feed_title = $row2['feed_title'];
        $feed_url = $row2['feed_url'];
        $media_url = parse_url($feed_url, PHP_URL_HOST);
        $media_url = parse_url($feed_url, PHP_URL_HOST);
        $media_url = str_replace("api.", "", $media_url);
        $media_url = str_replace("feeds.", "", $media_url);
        $media_url = str_replace("rss.", "", $media_url);
        $media_url = str_replace("backend.", "", $media_url);
    }

    $title = $row['title'];
    $description = $row['excerpt'];
    $youtubeid = $row['youtubeid'];
    $peertubeid = $row['peertubeid'];
    $embed = $row['embed'];
    $url = $row['url'];
    if ($youtubeid !== "") { $url = WEBSITE_URL."/index.php?watch=".$youtubeid; }
    if ($peertubeid !== "") { $url = WEBSITE_URL."/index.php?watch=".$peertubeid; }
    $thumbnail = $row['thumbnail'];
    $thumbnail = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", WEBSITE_URL."/storage/thumbnails/", $thumbnail);
    $date = minirelativedate($row['date']);
 
?>
    <div class="story_element" style="background-image: url(<?php echo $thumbnail; ?>) ; background-position: center; background-size: cover;">

        <!-- <?php // if ($embed !== "") { ?>
            <div style="position:absolute; height:100%; aspect-ratio: 9/16;">
            <embed src="<?=$embed;?>?autoplay=1" style="height:100%; aspect-ratio: 9/16;">
            </div>
        <?php // } ?> -->

        <div style="top:0; width: 100%; height: 200px; background: linear-gradient(0deg, rgba(255,255,255,0) 0%, rgba(0,0,0,0.8) 100%);">  
            <div style="position:absolute; padding: 20px; z-index:5;">
            <a href="<?=WEBSITE_URL."/index.php?feed=".$feed_id; ?>" title="<?php echo $feed_title; ?>"><img src="<?php echo $feed_avatar; ?>" style="height: 60px; aspect-ratio: 1 / 1; border-radius: 50%; float: left;" /></a>
                <div style="color:#FFF; padding-left: 70px; padding-top: 12px; text-shadow: 0px 0px 2px rgba(0,0,0,1);"><a href="<?=WEBSITE_URL."/index.php?feed=".$feed_id; ?>" style="color:#FFF; font-weight:bold; text-decoration:none;" title="<?php echo $feed_title; ?>"><?php echo $feed_title; ?></a> <span style="margin-left:8px; color:#D8D8D8;"><?=$date;?></span><br />
                <span style="font-size: 14px; padding-top: -8px;"><?php echo $media_url; ?></span>
                </div>
            </div>
        </div>

        <div class="excerpt">
        <?php if ($title !==""){ ?><a href="<?php echo $url; ?>" style="color: #000; font-weight:bold; margin-bottom: 4px; text-decoration: none;" <?php if ($youtubeid == "" && $peertubeid == "") { ?>target="_blank"<?php } ?>><?php echo $title ?></a><br /><?php } ?>
        <?php if ($description !== "") { ?><p style="color: #000;<?php if ($title !==""){ ?> padding-top:8px;<?php } ?>"><?php echo truncate($description,120); ?></p><?php } ?>    
        </div>
        <div class="link" style="color: #000;" <?php if ($youtubeid == "" && $peertubeid == "") { ?>onclick="window.open('<?php echo $url; ?>');" <?php } else { ?> onclick="window.open('<?php echo $url; ?>','_self')"<?php } ?>><i class="fa fa-link" aria-hidden="true"></i> <span style="margin-left: 5px;"><?=OPEN;?></span></div>

    </div>

<?php
    $i++;
    }
}
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