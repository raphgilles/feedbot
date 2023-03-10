<?php

$messatitle = cq($_POST['messagetitle']);
$message = cq($_POST['message']);
$message = str_replace( '\&quot;', '&quot;', $message);
$message .= " via @feedbot@tooter.social";
$article_id = cq($_POST['article_id']);
$site_id = cq($_POST['site_id']);
$feed_id = cq($_POST['feed_id']);
$caracters = 500 - mb_strlen($message, 'UTF-8');

?>
<div class="contenair">
<?php
if ($_GET['m'] == 'success') { ?>
	<div class="alert-green">
		<span><i class="fa fa-check" aria-hidden="true"></i></span> <span style="margin-left: 14px;"> <?=SUCCESS_SEND;?>.</span>
	</div>
<?php } ?>

	<div class="title">
		<i class="fa fa-paper-plane" aria-hidden="true"></i> <?=PUBLISH_PAGE_TITLE;?>
	</div>
	<div class="content-publish">
<?php if ($article_id !== "") { ?>
		<form action="<?=WEBSITE_URL;?>/includes/action.php" method="post">
			<input type="hidden" name="action" value="share">
			<input type="hidden" name="article_id" value="<?=$article_id;?>">
			<input type="hidden" name="site_id" value="<?=$site_id;?>">
			<input type="hidden" name="feed_id" value="<?=$feed_id;?>">
<?php } else { ?>
		<form action="<?=WEBSITE_URL;?>/includes/publish.php" method="post">
<?php } ?>
			<label for="message" style="margin-bottom: 5px;"><?php if ($messatitle == '') { ?><?=WHAT_HAVE_YOU_TO_SAY;?> ?<?php } else { ?><?=SHARE;?> :<br /> <?=$messatitle; } ?></label>
			<textarea onkeyup="counter(this)" class="publish_area" type="text" name="message" placeholder="" rows="10" maxlength="500" required><?=$message;?></textarea>
			<div class="counter" style="width: 100%; height: 22px; text-align:right; margin-top:-29px; padding-right: 10px;"></div>
			<label for="visibility" style="margin-top: 5px;"><?=VISIBILITY;?></label>
			<select name="visibility" required>
				<option value="public"><?=VISIBILITY_PUBLIC;?></option>
				<option value="unlisted"><?=UNLISTED;?></option>
				<option value="private"><?=VISIBILITY_PRIVATE;?></option>
				<option value="direct"><?=DIRECT;?></option>
			</select>
			<button type="submit">
				<span>
					<i class="fa fa-mastodon fa-2x" aria-hidden="true" style="vertical-align: middle;"></i></span> <span style="vertical-align: middle; margin-left: 10px;"><?=SHARE;?>
				</span>
			</button>
		</form>

<?php if($article_id == ""){ ?>
		<p style="font-style: italic; font-size: 12px; margin-top: 22px; text-align: center;"><?=NO_DATA;?>.</p>
<?php } ?>
	</div>
</div>