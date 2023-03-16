<?php
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');

$caracters_counter = strlen($description);

$description_link = truncate($description,400);
$description_link_search   = array("\n", "« ", " »", "«", "»", '"');
$description_link_replace  = array("", '“', '”', '“', '”', '&#34;');

$description_link = str_replace($description_link_search, $description_link_replace, $description_link);

$description_link = "« ".$description_link." »";

$sql = "SELECT * FROM articles_published WHERE uid = '$user' AND article_id = '$article_id'";
$result = mysqli_query($conn, $sql);

foreach ($result as $row){
	$is_shared = $row['is_shared'];
	$bookmarked = $row['bookmarked'];
	$share_date = $row['date'];
}

$sql = "SELECT * FROM statuses WHERE uid = '$user' AND article_id = '$article_id'";
$result = mysqli_query($conn, $sql);

foreach ($result as $row){
	$status_id = $row['post_id'];
}

$sql = "SELECT * FROM feeds_published WHERE uid = '$user' AND feed_id = '$feed_id'";
$result = mysqli_query($conn, $sql);

foreach ($result as $row){
	$is_subscribed = $row['uid'];
	$sub_id = $row['id'];
}

$sql = "SELECT * FROM feeds WHERE id = '$feed_id'";
$result = mysqli_query($conn, $sql);

foreach ($result as $row){
	$feed_name = $row['feed_title'];
	$site_id = $row['site_id'];
	$feed_thumbnail = $row['thumbnail'];
	$feed_thumbnail = str_replace(WEBSITE_URI, WEBSITE_URL."/", $feed_thumbnail);
	$feed_url = $row['feed_url'];
}

$thumbnail_cinema = $thumbnail;
?>

<div class="contenair-videos">
	<div class="content-videos">

<?php if ($youtubeid !== NULL) { ?>
		<div style="background-image: url(<?=$thumbnail;?>)" class="videos-thumbnail" style="padding-top: 0; margin-top: 0;">
			<div class="videos-youtube-iframe">
				<iframe src="https://www.youtube-nocookie.com/embed/<?=$youtubeid;?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			</div>
		</div>
<?php } ?>

<?php if ($platform == "PeerTube") { ?>
		<div style="background-image: url(<?=$thumbnail;?>)" class="videos-thumbnail" style="padding-top: 0; margin-top: 0;">
			<div class="videos-youtube-iframe" style="z-index:1;">
				<iframe src="<?=$embed;?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			</div>
		</div>
<?php } ?>

<div class="video_item">
	<div style="height:80px;">
		<a href="<?=WEBSITE_URL."/index.php?feed=".$feed_id;?>">
			<img src="<?=$feed_thumbnail;?>"  style="border-radius:50%; aspect-ratio: 1/1; width:60px; float:left; margin-right:20px;" title="<?=$feed_name;?>" />
		</a>
		<div title="<?=$feed_name;?>" style="line-height:18px;">
			<a href="<?=WEBSITE_URL."/index.php?feed=".$feed_id;?>" style="color:var(--feedbot-title); font-weight: bold; text-decoration: none;">
				<?=$feed_name;?>
			</a>
<?php if ($youtubeid !== NULL && $youtubeid !== "") { ?>
			<img src="<?=WEBSITE_URL;?>/assets/youtube.png" alt="YouTube channel" style="width:20px; margin-left: 4px; margin-bottom: 4px; vertical-align: middle;" />
<?php } ?>
<?php if ($peertubeid !== NULL && $peertubeid !== "") { ?>
			<img src="<?=WEBSITE_URL;?>/assets/peertube.png" alt="PeerTube channel" style="width:16px; margin-left: 5px; vertical-align: bottom; margin-top: 4px;" />
<?php } ?>
			<br>
			<span style="font-size: 12px;">
				<?=$website;?><br><?=$date;?>
			</span>
		</div>
		<div>
<?php if ($isconnected == "") { ?>
			<form action="<?=WEBSITE_URL;?>/?p=signin" method="post">
				<button type="submit" title="<?=SUBSCRIBE_TO;?> <?=$feed_name;?>">
					<span>
						<i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?=SUBSCRIBE;?>
					</span>
				</button>
			</form>
<?php } elseif ($is_subscribed == "") { ?>
			<form class="subscribe_<?=$feed_id;?>">
				<input type="hidden" name="action" value="subscribe">
				<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
				<button onclick="subscribe(<?=$feed_id;?>)" type="submit" title="<?=SUBSCRIBE_TO;?> <?=$feed_name;?>">
					<span>
						<i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?=SUBSCRIBE;?>
					</span>
				</button>
			</form>

			<form class="unsubscribe_<?=$feed_id;?>" style="display: none;">
				<input type="hidden" name="action" value="delete_feed">
				<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
				<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
				<button onclick="unsubscribe(<?=$feed_id;?>);" type="submit" class="unsuscribe" title="<?=UNSUBSCRIBE_TO;?> <?=$feed_name;?>">
					<span>
						<i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?=UNSUBSCRIBE;?>
					</span>
				</button>
			</form>
<?php } else { ?>
			<form class="unsubscribe_<?=$feed_id;?>">
				<input type="hidden" name="action" value="delete_feed">
				<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
				<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
				<button onclick="unsubscribe(<?=$feed_id;?>)" type="submit" class="unsuscribe" title="<?=UNSUBSCRIBE_TO;?> <?=$feed_name;?>">
					<span>
						<i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?=UNSUBSCRIBE;?>
					</span>
				</button>
			</form>

			<form class="subscribe_<?=$feed_id;?>" style="display: none;">
				<input type="hidden" name="action" value="from_video">
				<input type="hidden" name="flux" value="<?=$feed_url;?>">
				<button onclick="subscribe(<?=$feed_id;?>);" type="submit" title="<?=SUBSCRIBE_TO;?> <?=$feed_name;?>">
					<span>
						<i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?=SUBSCRIBE;?>
					</span>
				</button>
			</form>
<?php } ?>
		 </div>
	</div>

	<p style="white-space:pre-line;">
		<a href="<?=$theurl;?>" target="_blank" class="feed_item_title" title="<?=$title;?>"><?=$title;?></a>
	</p>

	<div <?php if ($caracters_counter > "600") { ?>class="description-youtube-short"<?php } ?>  id="description">
<?php if ($description !== "") { ?>
		<p style="margin-top:10px; word-break: break-word; white-space: pre-line;"><?=$description;?></p>
<?php } ?>
		<p style="margin-top:18px; word-break: break-all; white-space:pre-line;">
			<a href="<?=$theurl;?>" target="_blank" title="<?=$title;?>"><?=$theurl ?></a>
		</p>
	</div>
<?php if ($caracters_counter > "600") { ?>
	<div id="read-more" style="width:100%; font-weight: bold; text-align: center; margin-top: 10px; cursor: pointer;">
		<?=READ_MORE;?>
	</div>
<?php } ?>
	<div style="height:20px;"></div>
		<div style="position:relative; display:block; height:28px;">
			<div class="youtube-buttons-left">
<?php if ($isconnected == "") { ?>
				<form class="timeline-buttons" action="<?=WEBSITE_URL;?>" method="post">
					<button type="submit" class="timeline-buttons" title="<?=SHARE;?>">
						<i class="fa fa-retweet" aria-hidden="true" style="margin-right:5px;"></i> <?=SHARE;?>
					</button>
				</form>
<?php } elseif ($is_shared !== "1") { ?>
				<form class="timeline-buttons share_<?=$article_id;?>">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
					<input type="hidden" name="site_id" value="<?=$site_id;?>">
					<input type="hidden" name="messagetitle" value="<?=$title;?>">
					<input type="hidden" name="message" value="<?=$description_link;?>">
					<input type="hidden" name="url" value="<?=$url;?>">
					<input type="hidden" name="peertubeid" value="<?=$peertubeid;?>">
					<input type="hidden" name="youtubeid" value="<?=$youtubeid;?>">
					<input type="hidden" name="thumbnail" value="<?=$thumbnail;?>">
					<button onclick="share(<?=$article_id;?>);"class="timeline-buttons" title="<?=SHARE;?>">
						<i class="fa fa-retweet" aria-hidden="true" style="margin-right:5px;"></i> <?=SHARE;?>
					</button>
				</form>

				<form class="timeline-buttons unshare_<?=$article_id;?>" style="display: none;">
					<input type="hidden" name="action" value="delete_status">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<input type="hidden" name="status_id" value="<?=$status_id;?>">
					<button onclick="unshare(<?=$article_id;?>);" type="submit" class="timeline-buttons" title="<?=SHARED;?> : <?=relativedate($date);?>" style="color:#563ACC;">
						<i class="fa fa-retweet" aria-hidden="true" style="margin-right:5px;"></i> <?=SHARED;?>
					</button>
				</form>
<?php } else { ?>
				<form class="timeline-buttons share_<?=$article_id;?>" style="display: none;">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
					<input type="hidden" name="site_id" value="<?=$site_id;?>">
					<input type="hidden" name="messagetitle" value="<?=$title;?>">
					<input type="hidden" name="message" value="<?=$description_link;?>">
					<input type="hidden" name="url" value="<?=$url;?>">
					<input type="hidden" name="peertubeid" value="<?=$peertubeid;?>">
					<input type="hidden" name="youtubeid" value="<?=$youtubeid;?>">
					<input type="hidden" name="thumbnail" value="<?=$thumbnail;?>">
					<button onclick="share(<?=$article_id;?>);"class="timeline-buttons" title="<?=SHARE;?>">
						<i class="fa fa-retweet" aria-hidden="true" style="margin-right:5px;"></i> <?=SHARE;?>
					</button>
				</form>

				<form class="timeline-buttons unshare_<?=$article_id;?>">
					<input type="hidden" name="action" value="delete_status">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<input type="hidden" name="status_id" value="<?=$status_id;?>">
					<button onclick="unshare(<?=$article_id;?>);" type="submit" class="timeline-buttons" title="<?=SHARED;?> : <?=relativedate($date);?>" style="color:#563ACC;">
						<i class="fa fa-retweet" aria-hidden="true" style="margin-right:5px;"></i> <?=SHARED;?>
					</button>
				</form>
<?php } ?>
			</div>

			<div class="youtube-buttons-right">
<?php if ($isconnected == "") { ?>
				<form action="<?=WEBSITE_URL;?>" method="post" class="timeline-buttons bookmark_<?=$article_id;?>">
					<button type="submit" class="timeline-buttons" title="<?=READ_LATER;?>" style="margin-right:5px;">
						<i class="fa fa-bookmark" aria-hidden="true"></i> <?=READ_LATER;?>
					</button>
				</form>
<?php } elseif ($bookmarked !== "1") { ?>
				<form class="timeline-buttons bookmark_<?=$article_id;?>">
					<input type="hidden" name="action" value="bookmark">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
					<input type="hidden" name="site_id" value="<?=$site_id;?>">
					<button onclick="bookmark(<?=$article_id;?>);" class="timeline-buttons" title="<?=READ_LATER;?>">
						<i class="fa fa-bookmark" aria-hidden="true" style="margin-right:5px;"></i> <?=READ_LATER;?>
					</button>
				</form>

				<form class="timeline-buttons unbookmark_<?=$article_id;?>" style="display:none;">
					<input type="hidden" name="action" value="delete_bookmark">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<button onclick="unbookmark(<?=$article_id;?>);" class="timeline-buttons" title="<?=UNBOOKMARKS;?>" style="color:red;">
						<i class="fa fa-bookmark" aria-hidden="true" style="margin-right:5px;"></i> <?=READ_LATER;?>
					</button>
				</form>
<?php } else { ?>
				<form class="timeline-buttons bookmark_<?=$article_id;?>" style="display:none;" class="timeline-buttons-div">
					<input type="hidden" name="action" value="bookmark">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
					<input type="hidden" name="site_id" value="<?=$site_id;?>">
					<button onclick="bookmark(<?=$article_id;?>);" class="timeline-buttons" title="<?=READ_LATER;?>">
						<i class="fa fa-bookmark" aria-hidden="true" style="margin-right:5px;"></i> <?=READ_LATER;?>
					</button>
				</form>

				<form class="timeline-buttons unbookmark_<?=$article_id;?>" method="post" class="timeline-buttons-div">
					<input type="hidden" name="action" value="delete_bookmark">
					<input type="hidden" name="article_id" value="<?=$article_id;?>">
					<button onclick="unbookmark(<?=$article_id;?>);" class="timeline-buttons" title="<?=UNBOOKMARKS;?>" style="color:red;">
						<i class="fa fa-bookmark" aria-hidden="true" style="margin-right:5px;"></i> <?=READ_LATER;?>
					</button>
				</form>
<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php if ($theme == "dark") { ?>

<div class="video_cinema" style="background-image: url(<?=$thumbnail_cinema;?>); display:none;"></div>

<?php } ?>

<div class="suggested-videos-contenair">
	<h3 style="text-align:center; margin-bottom:14px;">
		<i class="fa fa-youtube-play" aria-hidden="true" style="margin-right:5px;"></i> <?=OTHER_VIDEOS;?>
	</h3>

<?php
	$i = 0;

	$title_suggestions = remove_accents($title);
	$title_suggestions = strtolower($title_suggestions);
	$title_suggestions = preg_replace('~\b[a-z]{1,3}\b\s*~', '', $title_suggestions);
	$char_replace = array("-", ":", "_", "+", ",", "|");
	$title_suggestions = str_replace($char_replace, ' ', $title_suggestions);
	$char_replace = array("’", "!", "(", ")", "&", ".", "?", "/", "[", "]", "#", "\\", "Λ", "%");
	$title_suggestions = str_replace($char_replace, '', $title_suggestions);
	$title_suggestions = preg_replace('/\s+/', ' ',$title_suggestions);

	$keywordaray = explode(' ', $title_suggestions );
	$b = 0;
	
	foreach($keywordaray as $keyword){
		$keys = trim($keyword);
		
		if($b > 0){
			$other .=" OR title REGEXP '[[:<:]]".$keys."[[:>:]]'";
			$other2 .=" OR excerpt REGEXP '[[:<:]]".$keys."[[:>:]]'";
		}
		$b++;
	}

	$firstword = $keywordaray['0'];
	$other = str_replace("OR title REGEXP '[[:<:]][[:>:]]'", '', $other);
	$other2 = str_replace("OR excerpt REGEXP '[[:<:]][[:>:]]'", '', $other2); 
	$sql = "SELECT * FROM articles WHERE (youtubeid IS NOT NULL OR peertubeid IS NOT NULL) AND (youtubeid != '' OR peertubeid != '') AND (feed_id LIKE '%$feed_id%' OR title REGEXP '[[:<:]]".$firstword."[[:>:]]' $other OR excerpt REGEXP '[[:<:]]".$firstword."[[:>:]]' $other2) ORDER BY id DESC";
	//echo $sql;

	// $sql = "SELECT * FROM articles WHERE feed_id = '$feed_id' ORDER BY rand()";
	$result = mysqli_query($conn, $sql);
	
	foreach($result as $row){
		if($i < 4){
			$youtube_id = $row['youtubeid'];
			$peertube_id = $row['peertubeid'];
			$title = $row['title'];
			$feed_id_suggestions = $row['feed_id'];
			$sql = "SELECT feed_title FROM feeds WHERE id = '$feed_id_suggestions'";
			$result = mysqli_query($conn, $sql);
			$thumbnail = $row['thumbnail'];
			$thumbnail = str_replace(WEBSITE_URI."storage/thumbnails/", WEBSITE_URL."/storage/thumbnails/", $thumbnail);

			foreach($result as $row){
				$feed_name = $row['feed_title'];
			}

			if($youtube_id !== $watch && $peertube_id !== $watch){
?>
	<div class="suggested-videos" title="<?=$title;?>">
		<div style="background-image: url(<?=$thumbnail;?>);" class="suggested-videos-thumbnail" onclick="window.location='<?=WEBSITE_URL ?>/index.php?watch=<?=$youtube_id.$peertube_id;?>';">
			<div class="playbutton">
				<i class="fa fa-youtube-play" aria-hidden="true"></i>
			</div>
		</div>
		<div style="overflow:hidden;">
			<p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
				<a href="<?=WEBSITE_URL ?>/index.php?watch=<?=$youtube_id.$peertube_id;?>" class="feed_item_title" style="color:color:var(--feedbot-title); font-size:14px;">
					<?=$title;?>
				</a>
			</p>
			<p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
				<a href="<?=WEBSITE_URL ?>/index.php?watch=<?=$youtube_id.$peertube_id;?>" style="color:var(--feedbot-text); text-decoration:none; font-size:14px;">
					@<?=$feed_name;?>
				</a>
			</p>
		</div>
	</div>

<?php 		$i++;
			}
		}
	}
?>

</div>

<?php

$sql = "SELECT * FROM statuses WHERE article_id = '$article_id' AND post_visibility = 'public'";
$result = mysqli_query($conn, $sql);

foreach($result as $row){
	$status_url = $row['url'];
}

if($status_url !== NULL){
?>

<div style="clear:both; height:40px;"></div>
	<div class="watch-shares">
		<h3 style="text-align:center; margin-bottom:14px;">
			<i class="fa fa-retweet" aria-hidden="true"></i> Partages
		</h3>
	</div>
<?php
	foreach($result as $row){
		$status_url = $row['url'];
		$status_instance = parse_url($status_url, PHP_URL_HOST);
		$status = GetMastoStatus($status_url);
		$status_displayname = $status['account']['display_name'];
		$status_username = $status['account']['username'];
		$status_userlink = $status['account']['url'];
		$status_aka = "@".$status_username."@".$status_instance;
		$status_avatar = $status['account']['avatar'];
		$status_date = $status['created_at'];
		$status_origin = $status['url'];
		$status_content = $status['content'];
		$website_without_https = str_replace( "https://", '', WEBSITE_URL);

		$status_content = str_replace( "› <a href=\"".WEBSITE_URL."/index.php?watch=".$youtubeid.$peertubeid."\" target=\"_blank\" rel=\"nofollow noopener noreferrer\"><span class=\"invisible\">https://</span><span class=\"\">".$website_without_https."/watch/".$youtubeid.$peertubeid."</span><span class=\"invisible\"></span></a> via <span class=\"h-card\"><a href=\"https://tooter.social/@feedbot\" class=\"u-url mention\">@<span>feedbot</span></a></span>", '', $status_content);
		$status_content = str_replace( "<br /> <br />", ' ', $status_content);
?>
	<div class="content-videos shares">
		<div style="height:50px; width: 100%;">
			<div style="float:right;">
				<a href="<?=$status_origin;?>" style="color:var(--feedbot-gray); font-size:12px; margin-left: 5px; text-decoration:none;" target="_blank">
					<?=relativedate($status_date);?>
				</a>
			</div>
			<div style="width:40px; aspect-ratio: 1 / 1; background-image: url('<?=$status_avatar;?>'); background-size: cover; background-position: center; border-radius: 6px; float:left;">
				<a href="<?=$status_userlink;?>" style="display:block; width:100%; height:100%;" target="_blank"></a>
			</div>
			<div style="margin-left: 50px; padding-top: 4px; line-height: 16px; word-break: break-word;">
				<a href="<?=$status_userlink;?>" style="color:var(--feedbot-title); font-weight:bold; text-decoration:none;" target="_blank">
					<?=$status_displayname;?>
				</a>
				<br>
				<span style="font-size:12px; color:var(--feedbot-gray);">
					<?=$status_aka;?>
				</span>
			</div>
		</div>
		<div style="margin-top: 5px;">
			<?=$status_content;?>
		</div>
	</div>

<?php
	}
}

if ($caracters_counter > "600") { ?>

<script type="text/javascript">
	function expand(){
		document.getElementById('description').classList.remove('description-youtube-short');
		document.getElementById('read-more').style.display = 'none';
	}
	document.getElementById('read-more').addEventListener('click', expand);
</script>

<?php } ?>

<script>
var monitor = setInterval(function(){
	var elem = document.activeElement;
	if(elem && elem.tagName == 'IFRAME'){
		$(".video_cinema").show();
	}
}, 1);
</script>