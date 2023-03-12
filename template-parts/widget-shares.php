<div class="widget-home-content shares-widget widget_shares" style="margin-bottom:20px;">

<h4><i class="fa fa-mastodon" aria-hidden="true" style="color:var(--feedbot-title); font-size: 24px; margin-right: 5px; vertical-align: middle;"></i> <?=PUBLIC_SHARES;?></h4>

<?php

$i = 0;
$feed_id = $row['id'];
$sql2 = "SELECT * FROM statuses WHERE post_visibility = 'public' ORDER BY id DESC";
$result2 = mysqli_query($conn, $sql2);
	foreach ($result2 as $row2) {
		if ($i < 5) {
		$uid = $row2['uid'];
		$status_id = $row2['post_id'];
		$status_url = $row2['url'];
		$article_id = $row2['article_id'];
		$status_visibility = $row2['post_visibility'];
		$status_instance = parse_url($status_url, PHP_URL_HOST);
		$status = GetMastoStatus($status_url);
		$status_displayname = emoji($status['account']);
		$status_username = $status['account']['username'];
		$status_userlink = $status['account']['url'];
		$status_aka = "@".$status_username."@".$status_instance;
		$status_avatar = $status['account']['avatar'];
		$status_date = $status['created_at'];
		$status_origin = $status['url'];
		$status_content = emojis($status);
		$status_replies = $status['replies_count'];
		$status_favs = $status['favourites_count'];
		$status_shares = $status['reblogs_count'];

		$sql = "SELECT * FROM articles WHERE id = '$article_id'";
		$result = mysqli_query($conn, $sql);
		foreach ($result as $row) {
			$article_id = $row['id'];
			$feed_id = $row['feed_id'];
			$article_url = $row['url'];
		}

		$sql = "SELECT * FROM feeds WHERE id = '$feed_id'";
		$result = mysqli_query($conn, $sql);
		foreach ($result as $row) {
			$is_sensitive = $row['is_sensitive'];
		}

		if ($is_sensitive !== "1") {
?>
	<div style="margin-top: 20px; padding-top: 20px; <?php if ($i !== 0) { ?> border-top:1px solid var(--feedbot-thumbnails-borders);<?php } ?>">

	    <div style="height:50px; width: 100%;">
	        <div style="float:right; margin-top: -2px;">
	        <span style="color:var(--feedbot-gray); vertical-align:top;" title="<?=$status_visibility;?>"> <i class="fa fa-globe-w" aria-hidden="true"></i></span> 
	        <a href="<?=$status_origin;?>" style="color:var(--feedbot-gray); font-size:12px; text-decoration:none;" target="_blank"><?=minirelativedate($status_date);?></a>
	        </div>

	        <div style="width:40px; aspect-ratio: 1 / 1; background-image: url('<?=$status_avatar;?>'); background-size: cover; background-position: center; border-radius: 6px; float:left;"><a href="<?=$status_userlink;?>" style="display:block; width:100%; height:100%;" target="_blank"></a></div>
	            <div style="padding-top: 2px; margin-left: 50px; line-height: 16px; word-break: break-word;">
	            <a href="<?=$status_userlink;?>" style="color:var(--feedbot-title); font-weight:bold; text-decoration:none;" target="_blank"><?=$status_displayname;?></a><br />
	            <span style="color:var(--feedbot-gray); font-size:12px;"><?=$status_aka;?></span>
	            </div>
	    </div>

	    <div style="margin-top: 5px;">
	    <?=$status_content;?>
	    </div>

	    <div style="margin-top:15px;"><a href="<?=$status_url;?>" target="_blank" title="<?= VIEW_ON_MASTODON ?>" style="color:var(--feedbot-gray); text-decoration:none;"><i class="fa fa-reply" aria-hidden="true"></i> <span style="margin-right:5px;"><?=$status_replies;?></span> <i class="fa fa-retweet" aria-hidden="true"></i> <span style="margin-right:5px;"><?=$status_shares;?></span> <i class="fa fa-star" aria-hidden="true"></i> <span style="margin-right:6px;"><?=$status_favs;?></span> <i class="fa fa-external-link" aria-hidden="true"></i><span></a>
    </div>

	</div>


<?php
		$i++;
		}
	}
}
?>
</div>

<?php if ($i == 0) { ?> <script type="text/javascript">
    $(".widget_shares").hide();
</script> <?php } ?>