    <div style="position:relative; display: block; height: 28px;">

        <div class="timeline-buttons-left">
        <?php if ($is_shared !== "1") { ?>
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
            <button onclick="share(<?=$article_id;?>)"class="timeline-buttons" title="<?=SHARE;?>"><i class="fa fa-retweet" aria-hidden="true" style="margin-right: 5px;"></i> <?=SHARE;?></span></button>
            </form>

            <form class="timeline-buttons unshare_<?=$article_id;?>" style="display: none;">
            <input type="hidden" name="action" value="delete_status">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <input type="hidden" name="status_id" value="<?=$status_id;?>">
            <button onclick="unshare(<?=$article_id;?>)" type="submit" class="timeline-buttons" title="<?=SHARED;?> : <?=relativedate($date);?>" style="color:var(--feedbot-purple);"><i class="fa fa-retweet" aria-hidden="true" style="margin-right: 5px;"></i> <?=SHARED;?></span></button>
            </form>

        <?php } else { ?>
            <form class="timeline-buttons share_<?=$article_id;?>" style="display: none;" action="<?=WEBSITE_URL?>/?p=publish" method="post">
            <input type="hidden" name="p" value="publish">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
            <input type="hidden" name="site_id" value="<?=$site_id;?>">
            <input type="hidden" name="messagetitle" value="<?=$title;?>">
            <input type="hidden" name="message" value="<?=$description_link;?>">
            <input type="hidden" name="url" value="<?=$url;?>">
            <button type="submit" class="timeline-buttons" title="<?=SHARE;?>"><i class="fa fa-retweet" aria-hidden="true" style="margin-right: 5px;"></i> <?=SHARE;?></span></button>
            </form>

            <form class="timeline-buttons unshare_<?=$article_id;?>">
            <input type="hidden" name="action" value="delete_status">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <input type="hidden" name="status_id" value="<?=$status_id;?>">
            <button onclick="unshare(<?=$article_id;?>)" type="submit" class="timeline-buttons" title="<?=SHARED;?> : <?=relativedate($date);?>" style="color:var(--feedbot-purple);"><i class="fa fa-retweet" aria-hidden="true" style="margin-right: 5px;"></i> <?=SHARED;?></span></button>
            </form>
        <?php } ?>
        </div>

        <div class="timeline-buttons-right">
        <?php if ($bookmarked !== "1") { ?>
            <form class="timeline-buttons bookmark_<?=$article_id;?>" class="timeline-buttons-div">
            <input type="hidden" name="action" value="bookmark">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
            <input type="hidden" name="site_id" value="<?=$site_id;?>">
            <button onclick="bookmark(<?=$article_id;?>)" class="timeline-buttons" title="<?=READ_LATER;?>"><i class="fa fa-bookmark" aria-hidden="true" style="margin-right: 5px;"></i> <?=READ_LATER;?></button>
            </form>

            <form class="timeline-buttons unbookmark_<?=$article_id;?>" style="display:none;" class="timeline-buttons-div">
            <input type="hidden" name="action" value="delete_bookmark">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <button onclick="unbookmark(<?=$article_id;?>)" class="timeline-buttons" title="<?=READ_LATER;?>" style="color:red;"><i class="fa fa-bookmark" aria-hidden="true" style="margin-right: 5px;"></i> <?=READ_LATER;?></button>
            </form>

        <?php } else { ?>
            <form class="timeline-buttons bookmark_<?=$article_id;?>" style="display:none;" class="timeline-buttons-div">
            <input type="hidden" name="action" value="bookmark">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
            <input type="hidden" name="site_id" value="<?=$site_id;?>">
            <button onclick="bookmark(<?=$article_id;?>)" class="timeline-buttons" title="<?=READ_LATER;?>"><i class="fa fa-bookmark" aria-hidden="true" style="margin-right: 5px;"></i> <?=READ_LATER;?></button>
            </form>

            <form class="timeline-buttons unbookmark_<?=$article_id;?>" method="post" class="timeline-buttons-div">
            <input type="hidden" name="action" value="delete_bookmark">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <button onclick="unbookmark(<?=$article_id;?>)" class="timeline-buttons" title="<?=UNBOOKMARKS;?>" style="color:red;"><i class="fa fa-bookmark" aria-hidden="true" style="margin-right: 5px;"></i> <?=READ_LATER;?></button>
            </form>
        <?php } ?>
        </div>
    </div>