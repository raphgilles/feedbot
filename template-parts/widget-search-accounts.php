<div class="widget-home-content">

<h4>Flux associés à votre recherche</h4>

<?php
$search = cq($_POST['search']);
$search_title = $search;
$search = html_entity_decode($search);

$search = remove_accents($search);
$search = strtolower($search);
$search = preg_replace('~\b[a-z]{1,3}\b\s*~', '', $search);
$search = str_replace( "-", ' ', $search);
$search = str_replace( ":", ' ', $search);
$search = str_replace( "_", ' ', $search);
$search = str_replace( "+", ' ', $search);
$search = str_replace( ",", ' ', $search);
$search = str_replace( "’", '', $search);
$search = str_replace( "|", ' ', $search);
$search = str_replace( "!", '', $search);
$search = str_replace( "(", '', $search);
$search = str_replace( ")", '', $search);
$search = str_replace( "&", '', $search);
$search = str_replace( ".", '', $search);
$search = str_replace( "?", '', $search);
$search = str_replace( "/", '', $search);
$search = str_replace( "\\", '', $search);
$search = str_replace( "Λ", '', $search);
$search = str_replace( "%", '', $search);
$search = preg_replace('/\s+/', ' ',$search);

$infinite_search = str_replace( " ", '-', $search);

$keywordaray = explode(' ', $search);
$b = 0;
foreach($keywordaray as $keyword) {
$keys = trim($keyword);
if ($b > 0) {
$other .=" OR title REGEXP '[[:<:]]".$keys."[[:>:]]'";
$other2 .=" OR excerpt REGEXP '[[:<:]]".$keys."[[:>:]]'";
$other3 .=" OR title LIKE '%$keys%'";
$other4 .=" OR excerpt LIKE '%$keys%'";
}
$fullsearch .= "$keys%";
$b++;
}

$firstword = $keywordaray['0'];
$other = str_replace("OR title REGEXP '[[:<:]][[:>:]]'", '', $other);
$other2 = str_replace("OR excerpt REGEXP '[[:<:]][[:>:]]'", '', $other2);

$sql = "SELECT * FROM feeds WHERE feed_title LIKE '%".$fullsearch."%'";
$result = mysqli_query($conn, $sql);
$b = 0;

foreach ($result as $row) {
	if ($b == 0) { $firstid = $row['id']; }
	if ($b > 0) { $theid .= " OR feed_id = '".$row['id']."'"; }
	$b++;
}

$sql = "SELECT DISTINCT feed_id, MAX(id) FROM articles WHERE (feed_id = '$firstid' $theid) OR (title REGEXP '[[:<:]]".$firstword."[[:>:]]' $other OR excerpt REGEXP '[[:<:]]".$firstword."[[:>:]]' $other2) OR (title LIKE '%$fullsearch' OR excerpt LIKE '%$fullsearch') GROUP BY feed_id ORDER BY MAX(id) DESC, feed_id";
$result = mysqli_query($conn, $sql);

$i = 0;
foreach ($result as $row) {
	$feed_id = $row['feed_id'];
	$sql2 = "SELECT * FROM feeds_published WHERE feed_id = '$feed_id' AND uid = '$user'";
	$result2 = mysqli_query($conn, $sql2);
	foreach ($result2 as $row2) {
		$is_followed = $row2['id'];
	}

	if ($i < 10) {
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
		<div style="width:60px; aspect-ratio: 1 / 1; background-image: url(<?=$feed_avatar;?>); background-size: cover; background-position: center; border-radius: 50%; float:left;"><a href="<?= WEBSITE_URL."/index.php?feed=".$feed_id;?>" style="display:block; width:100%; height:100%;"></a></div>

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
			<a href="<?= WEBSITE_URL."/index.php?feed=".$feed_id;?>" style="color:color:var(--feedbot-title); font-weight: bold; text-decoration: none;"><?=truncate($feed_name,30);?></a> <?php if ($youtubeid !== "") { ?><img src="<?=WEBSITE_URL;?>/assets/youtube.png" alt="YouTube channel" style="width:20px; margin-left: 4px; margin-top: 1px; vertical-align: top;" /><?php } ?><?php if ($peertubeid !== NULL && $peertubeid !== "") { ?><img src="<?=WEBSITE_URL;?>/assets/peertube.png" alt="PeerTube channel" style="width:14px; margin-left: 5px; vertical-align: middle;" /><?php } ?><br />
			<span style="font-size: 12px;"><?=$media_url;?></span>
		</div>
	</div>


<?php
	$i++;
	}
	}
}
$is_followed = NULL;
}
$fullsearch = NULL;
?>

</div>