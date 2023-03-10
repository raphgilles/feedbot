<div>

<?php
$lastid = $_GET['lastId'];
if ($lastid == "") {
$lastid = 0;
}
else {
include('./config.php');
}
$limit = $lastid + 10;
$sql = "SELECT * FROM articles WHERE id > '$lastid' ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);

$id = $lastid + 1;

foreach ($result as $row) {
    $article_id = $row['id'];
    $feed_id = $row['feed_id'];
    $thumbnail = $row['thumbnail'];
    $thumbnail = str_replace("/var/www/my_webapp/www/storage/thumbnails/", "storage/thumbnails/", $thumbnail);
    $title = $row['title'];
    $url = $row['url'];
    $description = html_entity_decode($row['excerpt'], ENT_SUBSTITUTE);
    $description = preg_replace('/\\n/m','',$description,1);
    $youtubeid = $row['youtubeid'];
    $caracters_counter = strlen($description);

    $description_link = truncate($description,450);
    $description_link = str_replace( "\n", '', $description_link);
    $description_link = str_replace( "« ", '“', $description_link);
    $description_link = str_replace( " »", '”', $description_link);
    $description_link = str_replace( "«", '“', $description_link);
    $description_link = str_replace( "»", '”', $description_link);
    $description_link = "« ".$description_link." »";
    $description_link .= "\n \n".$url;

    $date = $row['date'];
    $sql = "SELECT * FROM feeds WHERE id = '$feed_id'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
        $feed_name = $row['feed_title'];
        $feed_avatar = $row['thumbnail'];
        $feed_avatar = str_replace("/var/www/my_webapp/www/storage/icons/", "storage/icons/", $feed_avatar);
        $feed_url = $row['feed_url'];
        $media_url = parse_url($feed_url, PHP_URL_HOST);
        $media_url = str_replace("api.", "", $media_url);
        $media_url = str_replace("feeds.", "", $media_url);
        $media_url = str_replace("rss.", "", $media_url);
        $site_id = $row['site_id'];
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
<div class="content-home" style="padding-top: 15px; padding-bottom: 0px;" id="<?php echo $article_id; ?>">
    <div style="height:75px;">
        <div style="width: 60px; aspect-ratio: 1 / 1; background-image: url(<?php echo $feed_avatar; ?>); background-size: cover; background-position: center; border-radius: 50%; float:left; overflow: hidden;"></div>
        <div style="margin-left: 80px; padding-top: 13px; line-height: 16px;"><p style="font-weight: bold;"><?php echo truncate($feed_name,30); ?></p>
        <span style="font-size: 12px;"><?php echo relativedate($date); ?></span>
        </div>
    </div>

    <div <?php if ($caracters_counter > "400") { ?>class="description-short"<?php } ?> id="description-<?php echo $article_id; ?>">
    <span style="word-break: break-word; white-space: pre-line;"><?php echo $description; ?></span> 
    </div>
    <?php if ($caracters_counter > "400") { ?><div id="read-more-<?php echo $article_id; ?>" style="width:100%; font-weight: bold; text-align: center; margin-top: 10px; cursor: pointer;">Lire la suite</div><?php } ?>

    <div class="timeline-thumbnail" <?php if ($media_url !== "www.youtube.com") { ?> onclick="window.open('<?php echo $url; ?>');" <?php } else { ?> onclick="window.location='<?= HOME_PAGE."watch.php?v=".$youtubeid; } ?>'" title="<?php echo $title; ?>">
    <div style="width: 100%; background-image: url(<?php echo $thumbnail; ?>); aspect-ratio: 16 / 9; background-size: cover; background-position: center;"></div>
    <div class="timeline-title"><span style="color:#585858; font-size: 12px; text-transform: uppercase;"><?php echo $media_url; ?></span><br /><span style="font-weight:bold;"><?php echo $title; ?></span></div>
    </div>

    <div style="position:relative; display: block; height: 28px;">

        <?php if ($is_shared !== "1") { ?>
        <div class="timeline-buttons-left">
            <form class="timeline-buttons" action="./?p=publish" method="post">
            <input type="hidden" id="p" name="p" value="publish">
            <input type="hidden" id="article_id" name="article_id" value="<?php echo $article_id; ?>">
            <input type="hidden" id="feed_id" name="feed_id" value="<?php echo $feed_id; ?>">
            <input type="hidden" id="site_id" name="site_id" value="<?php echo $site_id; ?>">
            <input type="hidden" id="messagetitle" name="messagetitle" value="<?php echo $title; ?>">
            <input type="hidden" id="message" name="message" value="<?php echo $description_link; ?>">
            <input type="hidden" id="url" name="url" value="<?php echo $url; ?>">
            <button type="submit" class="timeline-buttons" title="Partager"><i class="fa fa-retweet" aria-hidden="true"></i> Partager</span></button>
            </form>
        </div>

    <?php } else { ?>
        <div class="timeline-buttons-left">
            <form class="timeline-buttons" action="./includes/action.php" method="post">
            <input type="hidden" id="action" name="action" value="delete_status">
            <input type="hidden" id="article_id" name="article_id" value="<?php echo $article_id; ?>">
            <input type="hidden" id="status_id" name="status_id" value="<?php echo $status_id; ?>">
            <button type="submit" class="timeline-buttons" title="Partagé : <?php echo relativedate($date); ?>" style="color:#563ACC;"><i class="fa fa-retweet" aria-hidden="true"></i> Partagé</span></button>
            </form>
        </div>

    <?php }
    if ($bookmarked !== "1") { ?>
        <div class="timeline-buttons-right">
            <form class="timeline-buttons" action="./includes/action.php" method="post" class="timeline-buttons-div">
            <input type="hidden" id="action" name="action" value="bookmark">
            <input type="hidden" id="article_id" name="article_id" value="<?php echo $article_id; ?>">
            <input type="hidden" id="feed_id" name="feed_id" value="<?php echo $feed_id; ?>">
            <input type="hidden" id="site_id" name="site_id" value="<?php echo $site_id; ?>">
            <button type="submit" class="timeline-buttons" title="Ajouter aux signets"><i class="fa fa-bookmark" aria-hidden="true"></i> Marque-pages</button>
            </form>
        </div>

    <?php } else { ?>
        <div class="timeline-buttons-right">
            <form class="timeline-buttons" action="./includes/action.php" method="post" class="timeline-buttons-div">
            <input type="hidden" id="action" name="action" value="delete_bookmark">
            <input type="hidden" id="article_id" name="article_id" value="<?php echo $article_id; ?>">
            <button type="submit" class="timeline-buttons" title="Retirer des signets" style="color:red;"><i class="fa fa-bookmark" aria-hidden="true"></i> Marque-pages</button>
            </form>
        </div>
    <?php } ?>
    </div>
</div>

<?php if ($caracters_counter > "400") { ?>
<script type="text/javascript">
    function expand<?php echo $article_id; ?>() {
    document.getElementById('description-<?php echo $article_id; ?>').classList.remove('description-short');
    document.getElementById('read-more-<?php echo $article_id; ?>').style.display = 'none';
    }
    document.getElementById('read-more-<?php echo $article_id; ?>').addEventListener('click', expand<?php echo $article_id; ?>);
</script>
<?php
}
$id++;
}
?>
</div>