<div class="widget-home-content" style="margin-bottom: 20px;">

<p><?=WELCOME;?> <?=$displayname;?>.</p>

<?php if ($totalfeeds == "0") { ?>
<div style="margin-bottom: 16px;">
<p><?= GET_STARTED ?> <a href="<?=ADD_FEED_PAGE;?>" title="<?=ADD_RSS_FEED;?>"><?=GET_STARTED_LINK;?></a> ?</p>
</div>

<?php } ?>

	<p><?=WHAT_HAVE_YOU_TO_SAY;?> ?</p>
	<form class="publish" style="padding: 0px;">
	<input type="hidden" name="action" value="publish">
	<textarea onkeyup="counter(this)" class="publish_area" name="message" rows="3" maxlength="500" style="border-radius: 8px; resize: none;" required></textarea>
	<div style="width:100%;">
	<div class="counter" style="width: 100%; height: 22px; text-align:right; margin-top:-29px; padding-right: 10px;">500</div>

	<div style="margin-top: 20px;">
	<button onclick="publish();" class="widget-button-right publish_button" style="height:38px; margin-top: 4px; padding: 0px 30px; float:right;"><span><i class="fa fa-mastodon fa-2x" aria-hidden="true" style="vertical-align: middle;"></i></span> <span style="vertical-align: middle; margin-left: 10px;"><?=PUBLISH;?></span></button>

	<button class="shared publish_button_sent" style="height:38px; margin-top: 4px; padding: 0px 30px; float:right; display: none;"><span><i class="fa fa-check fa-2x" aria-hidden="true" style="vertical-align: middle;"></i></span> <span style="vertical-align: middle; margin-left: 10px;"><?=SENT;?></span></button>

	<select name="visibility" class="widget-button-left" style="height:38px;" required>
    <option value="public" selected><?=VISIBILITY_PUBLIC;?></option>
    <option value="unlisted"><?=UNLISTED;?></option>
    <option value="private"><?=VISIBILITY_PRIVATE;?></option>
    <option value="direct"><?=DIRECT;?></option>
	</select>
	</div>

	</div>
	</form>

</div>