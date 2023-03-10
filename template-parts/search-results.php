<?php
session_start();
$isconnected = $_SESSION['uid'];

    foreach ($result as $row) {
    $article_id = $row['id'];
    $feed_id = $row['feed_id'];
    $thumbnail = $row['thumbnail'];
    $thumbnail = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", WEBSITE_URL."/storage/thumbnails/", $thumbnail);
    $title = $row['title'];
    $url = $row['url'];
    $description = html_entity_decode($row['excerpt'], ENT_SUBSTITUTE);
    if ($feed_id == "168") { $description = preg_replace( "/\r|\n/", "", $description, 2); }
    if ($feed_id == "126") { $description = preg_replace( "/\r|\n/", "", $description, 2); }
    $youtubeid = $row['youtubeid'];
    $peertubeid = $row['peertubeid'];
    $caracters_counter = strlen($description);

    $description_link = "";
    if ($description !== "") {
    $caracters_counter = strlen($description);
    $description_link = truncate($description,400);
    $description_link = str_replace( "\n", '', $description_link);
    $description_link = str_replace( "« ", '“', $description_link);
    $description_link = str_replace( " »", '”', $description_link);
    $description_link = str_replace( "«", '“', $description_link);
    $description_link = str_replace( "»", '”', $description_link);
    $description_link = str_replace( '"', '&#34;', $description_link);
    $description_link = "« ".$description_link." »";
    }

    $date = $row['date'];
    $sql = "SELECT * FROM feeds WHERE id = '$feed_id'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
        $feed_name = $row['feed_title'];
        $feed_avatar = $row['thumbnail'];
        $feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", WEBSITE_URL."/storage/icons/", $feed_avatar);
        $feed_url = $row['feed_url'];
        $media_url = parse_url($feed_url, PHP_URL_HOST);
        $media_url = str_replace("api.", "", $media_url);
        $media_url = str_replace("feeds.", "", $media_url);
        $media_url = str_replace("rss.", "", $media_url);
        $media_url = str_replace("backend.", "", $media_url);
        $site_id = $row['site_id'];
        $is_sensitive = $row['is_sensitive'];
    }

    if ($is_sensitive !== "1") {

    $sql = "SELECT * FROM feeds_published WHERE uid = '$user' AND feed_id = '$feed_id'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
    $is_subscribed = $row['id'];
    $sub_id = $row['id'];
    }

    $sql = "SELECT * FROM articles_published WHERE article_id = '$article_id' AND uid = '$user'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
        $is_shared = $row['is_shared'];
        $share_date = $row['date'];
        $bookmarked = $row['bookmarked'];
    }

    if ($is_shared == "1") {
    $sql = "SELECT * FROM statuses WHERE uid = '$user' AND article_id = '$article_id'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
        $status_id = $row['post_id'];
    }

    }
?>
<div class="content-home" style="padding-top: 15px; padding-bottom: 0px;" id="<?=$article_id;?>">
    <?php if ($article_id == NULL) { echo "Coucou"; } ?> 
    <div style="height:75px;">

         <?php if ($lastid == "") { include('./template-parts/subscribe-button.php'); } else { include('subscribe-button.php'); } ?>

        <div style="width: 60px; aspect-ratio: 1 / 1; background-image: url(<?=$feed_avatar;?>); background-size: cover; background-position: center; border-radius: 50%; float:left; overflow: hidden;"><a href="<?= WEBSITE_URL."/feed/".$feed_id;?>" style="display:block; width:100%; height:100%;"></a></div>

        <div style="margin-left: 74px; padding-top: 13px; line-height: 16px;"><a href="<?= WEBSITE_URL."/feed/".$feed_id;?>" style="color:var(--feedbot-title); font-weight: bold; text-decoration: none;"><?=truncate($feed_name,30);?></a> <?php if ($youtubeid !== "") { ?><img src="<?=WEBSITE_URL;?>/assets/youtube.png" alt="YouTube channel" style="width:20px; margin-left: 4px; margin-bottom: 1px; vertical-align: middle;" /><?php } ?><?php if ($peertubeid !== NULL && $peertubeid !== "") { ?><img src="<?=WEBSITE_URL;?>/assets/peertube.png" alt="PeerTube channel" style="width:14px; margin-left: 5px; vertical-align: middle;" /><?php } ?><br />
        <span style="font-size: 12px;"><?=relativedate($date);?></span>
        </div>
    </div>

 	<?php if ($description !== "") { ?>   
    <div <?php if ($caracters_counter > "400") { ?>class="description-short"<?php } ?> id="description-<?=$article_id;?>">
    <span style="word-break: break-word; white-space: pre-line;"><?=$description;?></span> 
    </div>
    <?php if ($caracters_counter > "400") { ?><div id="read-more-<?=$article_id;?>" style="width:100%; font-weight: bold; text-align: center; margin-top: 10px; cursor: pointer;"><?= READ_MORE ?></div><?php } ?>
    <div style="height:20px;"></div>
    <?php } ?>

    <div class="timeline-thumbnail" title="<?=$title;?>">
    <div class="timeline-thumbnail-content" style="background-image: url(<?=$thumbnail;?>);"><a href="<?php if ($youtubeid == "" && $peertubeid == "") { echo $url; } else { echo WEBSITE_URL ?>/watch/<?=$youtubeid.$peertubeid; } ?>" <?php if ($youtubeid == "" && $peertubeid == "") { ?> target="_blank" <?php } ?> style="display:block; width:100%; height:100%;"></a></div>
    <div class="timeline-title"><a href="<?php if ($youtubeid == "" && $peertubeid == "") { echo $url; } else { echo WEBSITE_URL ?>/watch/<?=$youtubeid.$peertubeid; } ?>" <?php if ($youtubeid == "" && $peertubeid == "") { ?> target="_blank" <?php } ?> style="text-decoration: none;"><span style="color:var(--feedbot-gray); font-size: 12px; text-transform: uppercase;"><?=$media_url;?></span><br /><span style="color:var(--feedbot-title); font-weight:bold;"><?=$title;?></span></a></div>
    </div>

    <?php if ($lastid == "") {
        include('./template-parts/buttons.php');
        } else {
        include('../template-parts/buttons.php');
        } ?>
</div>

<?php if ($caracters_counter > "400") { ?>
<script type="text/javascript">
    function expand<?=$article_id;?>() {
    document.getElementById('description-<?=$article_id;?>').classList.remove('description-short');
    document.getElementById('read-more-<?=$article_id;?>').style.display = 'none';
    }
    document.getElementById('read-more-<?=$article_id;?>').addEventListener('click', expand<?=$article_id;?>);
</script>
<?php
}
$is_subscribed = NULL;
$id++;
}
}
?>
</div>