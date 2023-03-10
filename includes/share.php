<?php
include("./functions.php");
include("../config.php");

$messatitle = cq($_POST['messagetitle']);
$thumbnail = cq($_POST['thumbnail']);
$peertubeid = cq($_POST['peertubeid']);
$youtubeid = cq($_POST['youtubeid']);
$url = cq($_POST['url']);
$message = cq($_POST['message']);
$caracters = 460 - strlen(utf8_decode(html_entity_decode($message, ENT_SUBSTITUTE)));
$message = str_replace( '\&quot;', '&quot;', $message);
$message = str_replace( '  ', '', $message);
$message = str_replace('\\\'','’', $message);
$article_id = cq($_POST['article_id']);
$site_id = cq($_POST['site_id']);
$feed_id = cq($_POST['feed_id']);
?>
<div class="closer" onclick="hide_publish()"><i class="fa fa-times fa-2x" aria-hidden="true"></i></div>

<div style="position:relative; max-width: 1200px; margin: auto; top:50%; transform: translateY(-50%);">
<div class="title" style="font-size:20px; margin-bottom: 15px; color:#FFF;"><i class="fa fa-paper-plane" aria-hidden="true" style="margin-right: 5px;"></i> <?=SHARE;?> <?=ON_MASTODON;?></div>
<div class="content_popup" style="padding-top: 15px; padding-bottom: 15px;">
        <form class="share_content_<?=$article_id;?>">
        <input type="hidden" name="action" value="share">
        <input type="hidden" name="article_id" value="<?=$article_id;?>">
        <input type="hidden" name="url" value="<?=$url;?>">
        <input type="hidden" name="site_id" value="<?=$site_id;?>">
        <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
        <input type="hidden" name="peertubeid" value="<?=$peertubeid;?>">
        <input type="hidden" name="youtubeid" value="<?=$youtubeid;?>">
        <textarea onkeyup="counter_share(this)" class="publish_area" style="resize: none;" name="message" rows="5" maxlength="460" required><?=$message;?></textarea>
        <div class="counter" style="width: 100%; height: 20px; margin-bottom: 5px; margin-top: -5px; text-align:right; padding-right: 10px;"><?=$caracters;?></div>

        <div class="timeline-thumbnail" style="width: 100%; margin-left: 0px; margin-bottom: 10px; border-radius: 12px; border: 1px solid var(--feedbot-thumbnails-borders); cursor: initial; overflow: hidden; text-overflow: ellipsis;">
                <div style="width:100%; aspect-ratio: 16 / 9; background-image: url(<?=$thumbnail;?>); background-size: cover; background-position: center; border-top-left-radius: 12px; border-top-right-radius: 12px;"></div>
                <div class="timeline-title" style="width: 100%; margin-left: 15px; margin-right: 15px; padding-bottom: 4px; text-align: left;"><span style="font-weight:bold;"><?=$messatitle;?></span></div>
                <?php if ($message !== "") { ?>
                <div style="width:100%; margin-bottom: 15px; text-align: left; margin-left: 15px; padding-right: 27px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;"><span><?=truncate($message, 200);?></span></div>
                <?php } ?>
        </div>

        <div style="width:100%;">
                <select class="widget-button-left" style="height:38px; margin-bottom: 5px;" name="visibility" required>
                <option value="public" selected><?=VISIBILITY_PUBLIC;?></option>
                <option value="unlisted"><?=UNLISTED;?></option>
                <option value="private"><?=VISIBILITY_PRIVATE;?></option>
                <option value="direct"><?=DIRECT;?></option>
                </select>

                
                <button onclick="share2(<?=$article_id;?>)" class="widget-button-right share_button" style="height:38px; margin-top: 3px; padding: 0px 10px; float:right;"><span><i class="fa fa-mastodon fa-2x" aria-hidden="true" style="vertical-align: middle;"></i></span> <span style="vertical-align: middle; margin-left: 10px;"><?=SHARE;?></span></button>

                <button class="shared shared_button" style="height:38px; margin-top: 3px; padding: 0px 30px; float:right; display: none;"><span><i class="fa fa-check fa-2x zoomin" aria-hidden="true" style="vertical-align: middle; cursor:initial;"></i></span> <span style="vertical-align: middle; margin-left: 10px;"><?=SHARED;?></span></button>
                </form>
        </div>
</div>