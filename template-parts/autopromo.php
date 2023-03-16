<div class="autopromo" style="padding-top: 15px; padding-bottom: 25px;">
	<div style="height:75px;">
		<div style="width: 60px; aspect-ratio: 1 / 1; background-image: url(<?=WEBSITE_URL;?>/assets/icons/icon.png); background-size: cover; background-position: center; border-radius: 50%; float:left; overflow: hidden;">
			<a href="<?=WEBSITE_URL;?>" style="display:block; width:100%; height:100%;"></a>
		</div>
		<div style="margin-left: 74px; padding-top: 13px; line-height: 16px;">
			<a href="<?=WEBSITE_URL;?>" style="color:var(--feedbot-title); font-weight: bold; text-decoration: none;"><?= WEBSITE_NAME; ?></a>
			<br>
			<span style="font-size: 12px; color:var(--feedbot-text);"><?php echo relativedate(time()); ?></span>
		</div>
	</div>

	<div style="margin-bottom: 20px; text-align: center;">
		<h3 style="margin-bottom: 5px; color:var(--feedbot-title);">
			<?=ENJOY;?> <?=WEBSITE_NAME;?> ?
		</h3>
		<p style="word-break: break-word; white-space: break-spaces;"><?=MAKE_IT_KNOWN;?>.</p>

		<div style="text-align: center; margin-top: 20px;">
			<form class="share_3382">
				<input type="hidden" name="article_id" value="3382">
				<input type="hidden" name="feed_id" value="289">
				<input type="hidden" name="site_id" value="100">
				<input type="hidden" name="messagetitle" value="<?=WEBSITE_NAME;?>">
				<input type="hidden" name="message" value="<?=TALK_ON_MASTODON_MESSAGE;?>">
				<input type="hidden" name="url" value="https://feedbot.net">
				<input type="hidden" name="peertubeid" value="">
				<input type="hidden" name="youtubeid" value="">
				<input type="hidden" name="thumbnail" value="https://feedbot.net/assets/icons/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png">
				<button onclick="share(3382)" title="<?= SHARE ?>">
					<i class="fa fa-paper-plane fa-2x" aria-hidden="true" style="margin-right: 10px; vertical-align: middle;"></i> <?=TALK_ON_MASTODON;?> !
				</button>
			</form>
		</div>
	</div>
</div>