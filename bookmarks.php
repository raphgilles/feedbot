<div class="contenair-home">
	<div class="title">
		<i class="fa fa-bookmark" aria-hidden="true" style="margin-right:5px;"></i> Vos marque-pages
	</div>

	<div class="widget-home" style="display:unset;">
		<?php include('./template-parts/widget-welcome.php'); ?>
		<?php include('./template-parts/widget-suggestions.php'); ?>
		<?php include('./template-parts/widget-shares.php'); ?>
		<?php include('./template-parts/widget-funding.php'); ?>
		<?php include('./template-parts/footer.php'); ?>
	</div>

<?php

$sql = "SELECT * FROM articles_published WHERE uid = '$user' AND bookmarked = '1' ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);

foreach($result as $row){
	$id = $lastid + 1;
	$article_id = $row['article_id'];
	$sql = "SELECT * FROM articles WHERE id ='$article_id'";
	$result = mysqli_query($conn, $sql);

	foreach($result as $row){
		$article_id = $row['id'];
		$feed_id = $row['feed_id'];
		$thumbnail = $row['thumbnail'];
		$thumbnail = str_replace($_SERVER['DOCUMENT_ROOT']."storage/thumbnails/", "storage/thumbnails/", $thumbnail);
		$title = $row['title'];
		$url = $row['url'];

		$media_url = parse_url($url, PHP_URL_HOST);
		$media_url = str_replace("api.", "", $media_url);
		$media_url = str_replace("feeds.", "", $media_url);
		$media_url = str_replace("rss.", "", $media_url);
		$media_url = str_replace("backend.", "", $media_url);
		
		$description = html_entity_decode($row['excerpt'], ENT_SUBSTITUTE);
		$description = preg_replace("/\s{4}/", "\t", $description);
		$description = preg_replace('/\t+/',' ',$description);
		$description = preg_replace('/\n{3}/','<br />',$description);
		$youtubeid = $row['youtubeid'];
		$peertubeid = $row['peertubeid'];
		$caracters_counter = strlen($description);

		$description_link = "";
		
		if($description !== ""){
			$description_link = truncate($description,400);
			$description_link_search   = array("\n", "« ", " »", "«", "»", '"');
			$description_link_replace  = array("", '“', '”', '“', '”', '&#34;');
			$description_link = str_replace($description_link_search, $description_link_replace, $description_link);
			$description_link = "« ".$description_link." »";
		}

		$date = $row['date'];
		$sql = "SELECT * FROM feeds WHERE id = '$feed_id'";
		$result = mysqli_query($conn, $sql);
		
		foreach($result as $row){
			$feed_name = $row['feed_title'];
			$feed_avatar = $row['thumbnail'];
			$feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", "storage/icons/", $feed_avatar);
			$feed_url = $row['feed_url'];
			$site_id = $row['site_id'];
		}

		$sql = "SELECT * FROM feeds_published WHERE uid = '$user' AND feed_id = '$feed_id'";
		$result = mysqli_query($conn, $sql);

		foreach($result as $row){
			$is_subscribed = $row['id'];
			$sub_id = $row['id'];
		}

		$sql = "SELECT * FROM articles_published WHERE article_id = '$article_id' AND uid = '$user'";
		$result = mysqli_query($conn, $sql);

		foreach($result as $row){
			$is_shared = $row['is_shared'];
			$share_date = $row['date'];
			$bookmarked = $row['bookmarked'];
		}

		if($is_shared == "1"){
			$sql = "SELECT * FROM statuses WHERE uid = '$user' AND article_id = '$article_id'";
			$result = mysqli_query($conn, $sql);
			foreach($result as $row){
				$status_id = $row['post_id'];
			}
		}
?>
	<div class="content-home" style="padding-top: 15px; padding-bottom: 0px;" id="<?=$article_id;?>">
		<div style="height:75px;">
<?php
	if($lastid == ""){
		include('./template-parts/subscribe-button.php');
	}
	else{
		include('subscribe-button.php');
	}
?>
			<div style="width: 60px; aspect-ratio: 1 / 1; background-image: url(<?=$feed_avatar;?>); background-size: cover; background-position: center; border-radius: 50%; float:left; overflow: hidden;">
				<a href="<?= WEBSITE_URL."/index.php?feed=".$feed_id;?>" style="display:block; width:100%; height:100%;"></a>
			</div>
			<div style="margin-left: 74px; padding-top: 13px; line-height: 16px;">
				<a href="<?= WEBSITE_URL."/index.php?feed=".$feed_id;?>" style="color:var(--feedbot-title); font-weight: bold; text-decoration: none;">
					<?=truncate($feed_name,30);?>
				</a>
	<?php if ($youtubeid !== "") { ?>
				<img src="<?=WEBSITE_URL;?>/assets/youtube.png" alt="YouTube channel" style="width:20px; margin-left: 6px; margin-top: 1px; vertical-align: top;" />
	<?php } ?>
	<?php if ($peertubeid !== NULL && $peertubeid !== "") { ?>
				<img src="<?=WEBSITE_URL;?>/assets/peertube.png" alt="PeerTube channel" style="width:14px; margin-left: 4px; vertical-align: middle;" />
	<?php } ?>
				<br>
				<span style="font-size: 12px;"><?=relativedate($date);?></span>
			</div>
		</div>

<?php if ($description !== "") { ?>
		<div <?php if ($caracters_counter > "400") { ?>class="description-short"<?php } ?>  id="description-<?=$article_id;?>">
			<span style="word-break: break-word; white-space: pre-line;"><?=$description;?></span> 
		</div>
<?php if ($caracters_counter > "400") { ?>
		<div id="read-more-<?=$article_id;?>" style="width:100%; font-weight: bold; text-align: center; margin-top: 10px; cursor: pointer;">Lire la suite</div>
<?php } ?>
		<div style="height:20px;"></div>
<?php } ?>

		<div class="timeline-thumbnail" title="<?=$title;?>">
			<div class="timeline-thumbnail-content" style="background-image: url(<?=$thumbnail;?>);">
				<a href="<?php if ($youtubeid == "" && $peertubeid == "") { echo $url; } else { echo WEBSITE_URL ?>/index.php?watch=<?=$youtubeid.$peertubeid; } ?>" <?php if ($youtubeid == "" && $peertubeid == "") { ?> target="_blank" <?php } ?> style="display:block; width:100%; height:100%;">
				</a>
			</div>
			<div class="timeline-title">
				<a href="<?php if ($youtubeid == "" && $peertubeid == "") { echo $url; } else { echo WEBSITE_URL ?>/index.php?watch=<?=$youtubeid.$peertubeid; } ?>" <?php if ($youtubeid == "" && $peertubeid == "") { ?> target="_blank" <?php } ?> style="text-decoration: none;">
					<span style="color:var(--feedbot-gray); font-size: 12px; text-transform: uppercase;"><?=$media_url;?></span>
					<br>
					<span style="color:var(--feedbot-title); font-weight:bold;"><?=truncate($title,120);?></span>
				</a>
			</div>
		</div>
<?php include('./template-parts/buttons.php'); ?>
	</div>

<?php if ($caracters_counter > "400") { ?>

	<script type="text/javascript">
		function expand<?=$article_id;?>(){
			document.getElementById('description-<?=$article_id;?>').classList.remove('description-short');
			document.getElementById('read-more-<?=$article_id;?>').style.display = 'none';
		}
		document.getElementById('read-more-<?=$article_id;?>').addEventListener('click', expand<?=$article_id;?>);
	</script>

<?php
		}
	$id++;
	}
}
?>


<?php if ($article_id == NULL) { ?>

		<div class="content-home">
			<div style="width: 100%; aspect-ratio: 16 / 9; background-image: url(./assets/images/andris-romanovskis-BIxOJaIJQi0-unsplash.jpg); background-size: cover; background-position: center; border-radius: 12px; margin-bottom: 20px;"></div>
			<div style="width: 100%; font-style: italic;">
				Il semblerait que vos marque-pages sont encore vides. Des articles apparaitront ici lorsque vous en aurez mis de côté en utilisant l'icône <i class="fa fa-bookmark" aria-hidden="true" style="margin-left: 5px;"></i>
			</div>
		</div>

<?php } ?>

		</div>
