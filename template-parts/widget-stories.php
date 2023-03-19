<?php
$time = time() - (60 * 60 * 24);
$actualtime = time();
$sql = "SELECT DISTINCT feed_id, MAX(date) FROM articles WHERE date > '$time' AND date < '$actualtime' GROUP BY feed_id ORDER BY MAX(date) DESC, feed_id";
$result = mysqli_query($conn, $sql);
?>

<div class="story_content">

<?php
$i = 0;
foreach($result as $row){
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
		$is_sensitive = $row2['is_sensitive'];
	}
	if($is_sensitive !== '1'){
?>
	<div style="position: relative; display: inline-block;">
		<div style="float:left; width:90px; text-align: center; overflow: hidden; text-overflow: ellipsis;">
			<div class="story-background" onclick="story(<?=$current_feed_id;?>);" title="Story de <?php echo $feed_title; ?>">
				<div class="story-avatar" style="background-image: url(<?php echo $feed_avatar; ?>);">
				</div>
			</div>
			<span style="width: 80px; font-size: 11px; white-space:nowrap; overflow: hidden; display:inline-block; text-overflow: ellipsis;"><?php echo $feed_title; ?></span>      
		</div>
	</div>
<?php
	$i++;
	}
}
?>

</div>
