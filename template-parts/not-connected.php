<div class="content-home" style="padding-top: 15px; padding-bottom: 25px;" id="<?php echo $article_published_id; ?>">
    <div style="height:75px;">

        <div style="width: 60px; aspect-ratio: 1 / 1; background-image: url(./assets/icons/icon.png); background-size: cover; background-position: center; border-radius: 50%; float:left; overflow: hidden;"><a href="<?=WEBSITE_URL;?>" style="display:block; width:100%; height:100%;"></a></div>
        <div style="margin-left: 74px; padding-top: 13px; line-height: 16px;"><a href="<?=WEBSITE_URL;?>" style="color:#000; font-weight: bold; text-decoration: none;"><?=WEBSITE_NAME;?></a><br />
        <span style="font-size: 12px;"><?php echo relativedate(time()); ?></span>
        </div>
    </div>

    <div style="margin-top:20px; margin-bottom: 20px;">
    <h3 style="margin-bottom: 5px;"><?=ENJOY_TIMELINE;?></h3>
    <p style="word-break: break-word; white-space: break-spaces;"><?=MUST_BE_CONNECTED;?></p>

    <div style="text-align: center; margin-top: 20px;">
        <form action="<?=WEBSITE_URL;?>" method="post">
            <button type="submit" title="<?=SHARE;?>"><i class="fa fa-mastodon fa-2x" aria-hidden="true" style="vertical-align: middle; margin-right: 5px;"></i> <?= IM_LOGGING;?></button>
        </form>
    </div>

    </div>
</div>