<?php
	$sql = "SELECT * FROM feeds_published WHERE uid = '$user'";
	$result = mysqli_query($conn, $sql);
	$totalfeeds = mysqli_num_rows($result);
?>
<div class="contenair-links">

<?php if ($_GET['m'] == 'success') { ?>
	<div class="alert-green">
		<span><i class="fa fa-check" aria-hidden="true"></i></span> <span style="margin-left: 20px;"> <?=SUCCESS_FEED;?></span>
	</div>
<?php } ?>

	<div class="title" style="margin:15px; margin-bottom: 50px;">
		<i class="fa fa-rss" aria-hidden="true"></i> <?=RSS_FEEDS_MANAGER;?>
	</div>
	<div class="content-feeds">
		<p style="text-align: center; margin-bottom: 40px;">
			<?=YOU_SUBSCRIBED;?> <strong><?=$totalfeeds;?></strong> <?=FEEDS;?>.
		</p>
<?php

$sql = "SELECT * FROM users WHERE id = '$user'";
$result = mysqli_query($conn, $sql);

foreach($result as $row){
	$telegram_id = $row['telegram'];
}

$sql = "SELECT * FROM feeds_published WHERE uid = '$user' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

foreach($result as $row){
	$sub_id = $row['id'];
	$feed_id = $row['feed_id'];
	$sql_select = "SELECT * FROM feeds WHERE id = '$feed_id'";
	$sql_query = mysqli_query($conn, $sql_select);
	$feed_query =  mysqli_fetch_array($sql_query);
	$title = $feed_query['feed_title'];
	$thumbnail = $feed_query['thumbnail'];
	$thumbnail = str_replace(WEBSITE_URI."storage/icons/", WEBSITE_URL."/storage/icons/", $thumbnail);
	$url = $feed_query['feed_url'];
	$is_active = $row['is_active'];
	$share_title = $row['share_title'];
	$share_description = $row['share_description'];
	$share_image = $row['share_image'];
	$visibility = $row['visibility'];
	$is_sensitive = $row['is_sensitive'];
	$spoiler_text = $row['spoiler_text'];
	$telegram = $row['telegram'];
?>

		<div class="feed_item feed_<?=$sub_id;?>" title="<?=$title;?>">
			<div class="thumbnail_feed" style="background-image: url(<?=$thumbnail;?>);">
				<a href="<?=WEBSITE_URL."/index.php?feed=".$feed_id;?>" style="display: block; width: 100%; height: 100%"></a>
			</div>
			<p>
				<a href="<?=WEBSITE_URL."/index.php?feed=".$feed_id;?>" style="color:var(--feedbot-title); vertical-align: middle; font-weight: bold; padding-top: 4px; text-decoration: none;"> <?=$title;?></a>
			</p>
			<a href="<?=$url;?>" style="color:var(--feedbot-text);"><?=substr($url,0,50);?>...</a>
			<p style="margin-top: 10px;">
<?php if ($is_active == '1') { ?>
				<form class="switch autoshare_on_<?=$sub_id;?>" style="display: none;">
					<input type="hidden" name="action" value="activate_feed">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<button onclick="autoshare_on(<?=$sub_id;?>);" class="switch" title="<?=PUBLISH_ON_MASTODON;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
					</button>
				</form>

				<form class="switch autoshare_off_<?=$sub_id;?>">
					<input type="hidden" name="action" value="desactivate_feed">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<button onclick="autoshare_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_PUBLISH_ON_MASTODON;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
					</button>
				</form>
<?php } else { ?>
				<form class="switch autoshare_on_<?=$sub_id;?>">
					<input type="hidden" name="action" value="activate_feed">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<button onclick="autoshare_on(<?=$sub_id;?>);" class="switch" title="<?=PUBLISH_ON_MASTODON;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
					</button>
				</form>

				<form class="switch autoshare_off_<?=$sub_id;?>" style="display: none;">
					<input type="hidden" name="action" value="desactivate_feed">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<button onclick="autoshare_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_PUBLISH_ON_MASTODON;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
					</button>
				</form>
<?php } ?>
				<span style="vertical-align: middle; padding-top: 2px; margin-left: 10px;"><?=PUBLISH_ON_MASTODON;?></span>
			</p>

<!-- Activer le partage automatique sur Mastodon -->
<?php if ($is_active == '1') { ?>
			<div class="sharing_options_<?=$sub_id;?>">
<?php } else { ?>
			<div class="sharing_options_<?=$sub_id;?>" style="display:none;">
<?php } ?>

<!-- Activer le partage du titre -->
				<p style="margin:-2px;">
<?php if ($share_title == '1') { ?>
					<form class="switch sharetitle_off_<?=$sub_id;?>">
						<input type="hidden" name="action" value="share_title">
						<input type="hidden" name="share_title" value="0">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="sharetitle_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_PUBLISH_TITLE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch sharetitle_on_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="share_title">
						<input type="hidden" name="share_title" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="sharetitle_on(<?=$sub_id;?>);" class="switch" title="<?=PUBLISH_TITLE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>
<?php } else { ?>
					<form class="switch sharetitle_off_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="share_title">
						<input type="hidden" name="share_title" value="0">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="sharetitle_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_PUBLISH_TITLE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch sharetitle_on_<?=$sub_id;?>">
						<input type="hidden" name="action" value="share_title">
						<input type="hidden" name="share_title" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="sharetitle_on(<?=$sub_id;?>);" class="switch" title="<?=PUBLISH_TITLE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>
<?php } ?>
					<span style="vertical-align: middle; padding-top: 2px; margin-left: 10px;"><?=PUBLISH_TITLE;?></span>
				</p>

<!-- Activer le partage de la description -->
				<p style="margin:-2px;">
<?php if ($share_description == '1') { ?>
					<form class="switch sharedescription_off_<?=$sub_id;?>">
						<input type="hidden" name="action" value="share_description">
						<input type="hidden" name="share_description" value="0">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="sharedescription_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_PUBLISH_DESCRIPTION;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch sharedescription_on_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="share_description">
						<input type="hidden" name="share_description" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="sharedescription_on(<?=$sub_id;?>);" class="switch" title="<?=PUBLISH_DESCRIPTION;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>
<?php } else { ?>
					<form class="switch sharedescription_off_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="share_description">
						<input type="hidden" name="share_description" value="0">
						<input type="hidden" id="sub_id" name="feed_id" value="<?=$sub_id;?>">
						<button onclick="sharedescription_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_PUBLISH_DESCRIPTION;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch sharedescription_on_<?=$sub_id;?>">
						<input type="hidden" name="action" value="share_description">
						<input type="hidden" name="share_description" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="sharedescription_on(<?=$sub_id;?>);" class="switch" title="<?=PUBLISH_DESCRIPTION;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>
<?php } ?>
					<span style="vertical-align: middle; padding-top: 2px; margin-left: 10px;"><?=PUBLISH_DESCRIPTION;?></span>
				</p>

<!-- Activer le partage de l'image -->
				<p style="margin:-2px;">
<?php if ($share_image == '1') { ?>
					<form class="switch shareimage_off_<?=$sub_id;?>">
						<input type="hidden" name="action" value="share_image">
						<input type="hidden" name="share_image" value="0">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="shareimage_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_ATTACH_IMAGE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch shareimage_on_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="share_image">
						<input type="hidden" name="share_image" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="shareimage_on(<?=$sub_id;?>);" class="switch" title="<?=ATTACH_IMAGE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>
<?php } else { ?>
					<form class="switch shareimage_off_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="share_image">
						<input type="hidden" name="share_image" value="0">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="shareimage_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_ATTACH_IMAGE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch shareimage_on_<?=$sub_id;?>">
						<input type="hidden" name="action" value="share_image">
						<input type="hidden" name="share_image" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="shareimage_on(<?=$sub_id;?>);" class="switch" title="<?=ATTACH_IMAGE;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>
<?php } ?>
					<span style="vertical-align: middle; padding-top: 2px; margin-left: 10px;"><?=ATTACH_IMAGE;?></span>
				</p>

<!-- Contenu sensible -->
<?php if ($is_sensitive == '1') { ?>
				<p style="margin:-2px;">
					<form class="switch is_sensitive_off_<?=$sub_id;?>">
						<input type="hidden" name="action" value="is_sensitive">
						<input type="hidden" name="is_sensitive" value="0">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="is_sensitive_off(<?=$sub_id;?>);" class="switch" title="<?=DESACTIVATE_SENSITIVE_CONTENT;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch is_sensitive_on_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="is_sensitive">
						<input type="hidden" name="is_sensitive" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="is_sensitive_on(<?=$sub_id;?>);" class="switch" title="<?=ACTIVATE_SENSITIVE_CONTENT;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>

					<span style="vertical-align: middle; padding-top: 2px; margin-left: 10px;"><?=SENSITIVE_CONTENT;?></span>
				</p>

				<form class="switch is_sensitive_off_<?=$sub_id;?> sensitive_text_<?=$sub_id;?>">
					<label for="spoiler_text" style="padding-left:32px; margin-left:20px; border-left:5px solid #563ACC; line-height:30px;">Content Warning :</label><br />
					<input type="hidden" name="action" value="spoiler_text">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<button onclick="sensitive_text(<?=$sub_id;?>);" class="sensitive_button_on_<?=$sub_id;?>" style="padding-left:16px; padding-right:14px; margin-top: -37px; height:36px; line-height:10px; vertical-align:middle;">
						<span style="vertical-align: middle;">Ok</span>
					</button>
					<button class="sensitive_button_off_<?=$sub_id;?>" style="padding-left:16px; padding-right:14px; margin-top: -37px; height:36px; line-height:10px; vertical-align:middle; display: none;" disabled>
						<span style="vertical-align: middle;"><i class="fa fa-check" aria-hidden="true"></i></span>
					</button>
					<textarea name="spoiler_text" style="max-width: 300px; height:36px;" rows="1"><?=$spoiler_text;?></textarea>
				</form>
<?php } else { ?>
				<p style="margin:-2px;">
					<form class="switch is_sensitive_off_<?=$sub_id;?>" style="display: none;">
						<input type="hidden" name="action" value="is_sensitive">
						<input type="hidden" name="is_sensitive" value="0">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="is_sensitive_off(<?=$sub_id;?>);" class="switch" title="<?=DESACTIVATE_SENSITIVE_CONTENT;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
						</button>
					</form>

					<form class="switch is_sensitive_on_<?=$sub_id;?>">
						<input type="hidden" name="action" value="is_sensitive">
						<input type="hidden" name="is_sensitive" value="1">
						<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
						<button onclick="is_sensitive_on(<?=$sub_id;?>);" class="switch" title="<?=ACTIVATE_SENSITIVE_CONTENT;?>">
							<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
						</button>
					</form>

					<span style="vertical-align: middle; padding-top: 2px; margin-left: 10px;"><?=SENSITIVE_CONTENT;?></span>
				</p>

				<form class="switch is_sensitive_off_<?=$sub_id;?> sensitive_text_<?=$sub_id;?>" style="display: none;">
					<label for="spoiler_text" style="padding-left:32px; margin-left:20px; border-left:5px solid #563ACC; line-height:30px;">Content Warning :</label><br />
					<input type="hidden" name="action" value="spoiler_text">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<button onclick="sensitive_text(<?=$sub_id;?>);" class="sensitive_button_on_<?=$sub_id;?>" style="padding-left:16px; padding-right:14px; margin-top: -37px; height:36px; line-height:10px; vertical-align:middle;">
						<span style="vertical-align: middle;">Ok</span>
					</button>
					<button class="sensitive_button_off_<?=$sub_id;?>" style="padding-left:16px; padding-right:14px; margin-top: -37px; height:36px; line-height:10px; vertical-align:middle; display: none;" disabled>
						<span style="vertical-align: middle;"><i class="fa fa-check" aria-hidden="true"></i></span>
					</button>
					<textarea name="spoiler_text" style="max-width: 300px; height:36px; line-height:10px;" rows="1"><?=$spoiler_text;?></textarea>
				</form>
<?php } ?>

<!-- Visibilité -->
				<p style="font-size: 14px; margin-top: 10px;"><?=PUBLICATIONS_VISIBILITY;?> :</p>
				<form class="switch visibility_<?=$sub_id;?>">
					<select name="visibility" class="switch visibility_<?=$sub_id;?>" style="font-size:13px; margin-top: 8px; margin-bottom: 8px;" onchange="set_visibility(<?=$sub_id;?>)">
						<option value="" selected disabled hidden><?=EDIT_VISIBILITY;?></option>
						<option value="public" <?php if ($visibility == "public") { ?> selected="selected"<?php } ?>><?=VISIBILITY_PUBLIC;?></option>
						<option value="unlisted" <?php if ($visibility == "unlisted") { ?> selected="selected"<?php } ?>><?=UNLISTED;?></option>
						<option value="private" <?php if ($visibility == "private") { ?> selected="selected"<?php } ?>><?=VISIBILITY_PRIVATE;?></option>
						<option value="direct" <?php if ($visibility == "direct") { ?> selected="selected"<?php } ?>><?=DIRECT;?></option>
					</select>
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<input type="hidden" name="action" value="change_visibility_feed">
				</form>
			</div>

<!-- Recevoir sur Telegram -->
			<p style="margin:-2px; margin-top: 6px;">
<?php if ($telegram_id == "") { ?>
				<form action="<?=WEBSITE_URL;?>/?p=settings" method="POST" class="switch">
					<input type="hidden" name="telegram" value="notconnected">
					<button type="submit" class="switch">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
					</button>
				</form>
<?php } elseif ($telegram == '1') { ?>
				<form class="switch telegram_off_<?=$sub_id;?>">
					<input type="hidden" name="action" value="telegram">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<input type="hidden" name="telegram" value="0">
					<button onclick="telegram_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_TELEGRAM;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
					</button>
				</form>

				<form class="switch telegram_on_<?=$sub_id;?>" style="display: none;">
					<input type="hidden" name="action" value="telegram">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<input type="hidden" name="telegram" value="1">
					<button onclick="telegram_on(<?=$sub_id;?>);" class="switch" title="<?=TELEGRAM;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
					</button>
				</form>
<?php } else { ?>
				<form class="switch telegram_off_<?=$sub_id;?>" style="display: none;">
					<input type="hidden" name="action" value="telegram">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<input type="hidden" name="telegram" value="0">
					<button onclick="telegram_off(<?=$sub_id;?>);" class="switch" title="<?=STOP_TELEGRAM;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
					</button>
				</form>

				<form class="switch telegram_on_<?=$sub_id;?>">
					<input type="hidden" name="action" value="telegram">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<input type="hidden" name="telegram" value="1">
					<button onclick="telegram_on(<?=$sub_id;?>);" class="switch" title="<?=TELEGRAM;?>">
						<span class="fa-stack fa-lg"><i class="fa fa-toggle-off fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
					</button>
				</form>
<?php } ?>
				<span style="vertical-align: middle; padding-top: 2px; margin-left: 10px;"><?=TELEGRAM;?></span>
			</p>

<!-- Supprimer le feed -->
			<p style="margin-top: 10px;">
				<form class="switch unsubscribe_<?=$sub_id;?>">
					<input type="hidden" name="action" value="delete_feed">
					<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
					<input type="hidden" name="sub_id" value="<?=$sub_id;?>">
					<button onclick="if(!confirm('<?=DELETE_FEED_CONFIRM;?>')){return false;}; unsubscribe(<?=$sub_id;?>); hideelement(<?=$sub_id;?>);" class="switch" title="<?=DELETE_FEED;?>">
						<span class="fa-stack fa-lg" style="line-height: 34px; width: 34px; font-size: 16px;"><i class="fa fa-times-circle fa-2x" aria-hidden="true" style="color:var(--feedbot-text);"></i></span>
					</button>
				</form>
				<span class="unsubscribe_<?=$sub_id;?>" style="vertical-align: middle; margin-left: 16px; padding-top: 2px;"><?=DELETE_FEED;?></span>
			</p>
		</div>
<?php
}
if($url == ""){
?>
		<p>Vous n'avez pas encore ajouté de flux. Peut-être serait-il temps de <a href="?p=add">commencer</a> ?</p>
<?php } ?>
	</div>
</div>