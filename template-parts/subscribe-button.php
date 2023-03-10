<?php
        if ($isconnected == "") { ?>
        <form action="<?=WEBSITE_URL;?>" class="follow-button subscribe_<?=$feed_id;?>" method="post" title="<?= SUBSCRIBE_TO ?> <?=$feed_name;?>">
        <button type="submit"><i class="fa fa-rss" aria-hidden="true"></i></button>
        </form>
        <?php } elseif ($is_subscribed == "") { ?>
        <form class="follow-button subscribe_<?=$feed_id;?>" title="<?= SUBSCRIBE_TO ?> <?=$feed_name;?>">
        <input type="hidden" name="action" value="subscribe">
        <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
        <button onclick="subscribe(<?=$feed_id;?>)"><i class="fa fa-rss" aria-hidden="true"></i></button>
        </form>

        <form class="follow-button-subscribed unsubscribe_<?=$feed_id;?>" style="display:none;" title="<?= UNSUBSCRIBE_TO ?> <?=$feed_name;?>">
        <input type="hidden" name="action" value="delete_feed">
        <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
        <input type="hidden" name="sub_id" value="<?=$sub_id;?>">
        <button onclick="unsubscribe(<?=$feed_id;?>)"><i class="fa fa-rss" aria-hidden="true"></i></button>
        </form>
        <?php } else { ?>
        <form class="follow-button subscribe_<?=$feed_id;?>" style="display:none;" title="<?= SUBSCRIBE_TO ?> <?=$feed_name;?>" title="S'abonner à <?=$feed_name;?>">
        <input type="hidden" name="action" value="subscribe">
        <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
        <button onclick="subscribe(<?=$feed_id;?>)"><i class="fa fa-rss" aria-hidden="true"></i></button>
        </form>

        <form class="follow-button-subscribed unsubscribe_<?=$feed_id;?>" title="<?= UNSUBSCRIBE_TO ?> <?=$feed_name;?>">
        <input type="hidden" name="action" value="delete_feed">
        <input type="hidden" name="feed_id" value="<?=$feed_id;?>">
        <input type="hidden" name="sub_id" value="<?=$sub_id;?>">
        <button onclick="unsubscribe(<?=$feed_id;?>)"><i class="fa fa-rss" aria-hidden="true"></i></button>
        </form>
<?php } ?>