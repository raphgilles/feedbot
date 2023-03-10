<div class="widget-home-content small_screens_hide">

<h4 style="color:var(--feedbot-title);">Suggestions</h4>

<?php
$sql = "SELECT * FROM feeds ORDER BY rand()";
$result = mysqli_query($conn, $sql);

$i = 0;
foreach ($result as $row) {
	$feed_id = $row['id'];
	$sql2 = "SELECT * FROM feeds_published WHERE feed_id = '$feed_id' AND uid = '$user'";
	$result2 = mysqli_query($conn, $sql2);
	foreach ($result2 as $row2) {
		$is_followed = $row2['id'];
	}
	if ($i < 5 && $is_followed == NULL) {
	$feed_name = $row['feed_title'];
	$feed_avatar = $row['thumbnail'];
	$feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", WEBSITE_URL."/storage/icons/", $feed_avatar);
	$feed_url = $row['feed_url'];
	$media_url = parse_url($feed_url, PHP_URL_HOST);
    $media_url = str_replace("api.", "", $media_url);
    $media_url = str_replace("feeds.", "", $media_url);
    $media_url = str_replace("rss.", "", $media_url);
    $media_url = str_replace("backend.", "", $media_url);
    $is_sensitive = $row['is_sensitive'];

    $sql3 = "SELECT * FROM articles WHERE feed_id = '$feed_id' LIMIT 1";
    $result3 = mysqli_query($conn, $sql3);
    foreach ($result3 as $row3) {
    	$youtubeid = $row3['youtubeid'];
    	$peertubeid = $row3['peertubeid'];
    }

    if ($is_sensitive !== "1") {
?>
	<div style="height: 60px; margin-top:20px;" class="suggestion_<?=$feed_id;?>">
		<div style="width:60px; aspect-ratio: 1 / 1; background-image: url(<?=$feed_avatar;?>); background-size: cover; background-position: center; border-radius: 50%; float:left;"><a href="<?= WEBSITE_URL."/feed/".$feed_id;?>" style="display:block; width:100%; height:100%;"></a></div>

		<div class="suggestion-button" title="<?= SUBSCRIBE_TO ?> <?=$feed_name;?>">
		<?php if ($isconnected == "") { ?>
		<form action="<?=WEBSITE_URL;?>">
        <button type="submit"><i class="fa fa-rss" aria-hidden="true"></i></button>
    	</form>
		<?php } else { ?>
        <form class="subscribe_<?=$feed_id;?>">
        <input type="hidden" name="action" value="subscribe">
        <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
        <button onclick="subscribe(<?=$feed_id;?>)"><i class="fa fa-rss" aria-hidden="true"></i></button>
        </form>
    	<?php } ?>
        </div>

		<div style="margin-left: 74px; margin-right: 30px; overflow: hidden; padding-top: 12px; line-height: 16px;">
			<a href="<?= WEBSITE_URL."/feed/".$feed_id;?>" style="color:var(--feedbot-title); font-weight: bold; text-decoration: none;"><?=truncate($feed_name,30);?></a> <?php if ($youtubeid !== "") { ?><img src="<?=WEBSITE_URL;?>/assets/youtube.png" alt="YouTube channel" style="width:20px; margin-left: 4px; margin-top: 1px; vertical-align: top;" /><?php } ?><?php if ($peertubeid !== NULL && $peertubeid !== "") { ?><img src="<?=WEBSITE_URL;?>/assets/peertube.png" alt="PeerTube channel" style="width:14px; margin-left: 5px; vertical-align: middle;" /><?php } ?><br />
			<span style="font-size: 12px;"><?=$media_url;?></span>
		</div>
	</div>


<?php
	$i++;
	}
	}
$is_followed = NULL;
}
?>

</div>