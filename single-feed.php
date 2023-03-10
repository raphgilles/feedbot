<?php 
$sql = "SELECT * FROM feeds_published WHERE uid = '$user' AND feed_id = '$feed'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
$is_subscribed = $row['uid'];
$sub_id = $row['id'];

$sql3 = "SELECT * FROM articles WHERE feed_id = '$feed' ORDER BY id LIMIT 1";
$result3 = mysqli_query($conn, $sql3);
    foreach ($result3 as $row3) {
      $youtubeid = $row3['youtubeid'];
      $peertubeid = $row3['peertubeid'];

      $media_url = $row3['url'];
      $media_url = parse_url($media_url, PHP_URL_HOST);
      $media_url = str_replace("api.", "", $media_url);
      $media_url = str_replace("feeds.", "", $media_url);
      $media_url = str_replace("rss.", "", $media_url);
      $media_url = str_replace("backend.", "", $media_url);
    }
}
?>

<div class="contenair-single-feed">

<div style="clear:both;">

<div class="banner-contenair">
  <div class="single-feed-banner" style="background-image: url(<?= $feed_banner;?>);"></div>
  <div class="single-feed-avatar"style="background-image: url(<?= $feed_avatar;?>);"></div>
  <div class="single-feed-title">
    <span style="font-size: 20px; font-weight: bold;"><?= $feed_name;?></span> <?php if ($youtubeid !== "" && $youtubeid !== NULL) { ?><img src="<?=WEBSITE_URL;?>/assets/youtube.png" alt="YouTube channel" style="width:26px; margin-left: 6px; margin-top: 2px; vertical-align: top;" /><?php } ?><?php if ($peertubeid !== NULL && $peertubeid !== "") { ?><img src="<?=WEBSITE_URL;?>/assets/peertube.png" alt="PeerTube channel" style="width:18px; margin-left: 6px; vertical-align: top;" /><?php } ?><br />
    <span style="font-size: 16px;"><?= $media_url;?></span>
  </div>

        <div class="single-feed-subscribe">
        <?php if ($isconnected == "") { ?>
        <form action="./?p=signin" method="post">
        <button type="submit" title="<?= SUBSCRIBE_TO ?> <?=$feed_name;?>"/><span><i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?= SUBSCRIBE ?></span></button>
        </form>
        <?php } elseif ($is_subscribed == "") { ?>

        <form class="subscribe_<?=$feed;?>">
        <input type="hidden" name="action" value="subscribe">
        <input type="hidden" name="feed_id" value="<?=$feed;?>">
        <button onclick="subscribe(<?=$feed;?>)" type="submit" title="<?= SUBSCRIBE_TO ?> <?=$feed_name;?>"/><span><i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?= SUBSCRIBE ?></span></button>
        </form>

        <form style="display: none;" class="unsubscribe_<?=$feed;?>">
        <input type="hidden" name="action" value="delete_feed">
        <input type="hidden" name="feed_id" value="<?=$feed;?>">
        <input type="hidden" name="sub_id" value="<?=$sub_id;?>">
        <button onclick="unsubscribe(<?=$feed;?>)" class="unsuscribe" title="<?= UNSUBSCRIBE_TO ?> <?=$feed_name;?>"/><span><i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?= UNSUBSCRIBE ?></span></button>
        </form>

        <?php } else { ?>
        <form style="display:none;" class="subscribe_<?=$feed;?>">
        <input type="hidden" name="action" value="subscribe">
        <input type="hidden" name="feed_id" value="<?=$feed;?>">
        <button onclick="subscribe(<?=$feed;?>)" title="<?= SUBSCRIBE_TO ?> <?=$feed_name;?>"/><span><i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?= SUBSCRIBE ?></span></button>
        </form>

        <form method="post" class="unsubscribe_<?=$feed;?>">
        <input type="hidden" name="action" value="delete_feed">
        <input type="hidden" name="feed_id" value="<?=$feed;?>">
        <input type="hidden" name="sub_id" value="<?=$sub_id;?>">
        <button onclick="unsubscribe(<?=$feed;?>)" class="unsuscribe" title="<?= UNSUBSCRIBE_TO ?> <?=$feed_name;?>"/><span><i class="fa fa-rss" aria-hidden="true" style="margin-right: 5px;"></i> <?= UNSUBSCRIBE ?></span></button>
        </form>
        <?php } ?>
        </div>
 
</div>

<div style="width:100%; clear:both; margin-bottom:20px;"></div>

<div class="widget-home single-feed">
<?php include('./template-parts/about-feed.php');?>
<?php if ($subscribers == 0) { ?>
<div class="alert" style="width:100%; text-align:left; margin-bottom:20px;">
<span style="margin-left: 20px;"><i class="fa fa-info-circle" aria-hidden="true" style="margin-right: 5px;"></i> Ce flux n'a actuellement aucun abonné et n'est peut-être pas à jour.<br />Vous pouvez lui redonner vie en vous abonnant.</span>
</div>
<?php } ?>
<?php include('./template-parts/widget-suggestions.php');?>
<?php include('./template-parts/widget-funding.php'); ?>
<?php include('template-parts/footer.php'); ?>
</div>

<div>
<?php
if ($article == "") {
  $sql = "SELECT * FROM articles WHERE feed_id = '$feed' ORDER BY date DESC LIMIT 10";
  $result = mysqli_query($conn, $sql);
  include('./template-parts/single-feed-timeline.php');
}

if ($article !== "") {
  $sql = "SELECT * FROM articles WHERE feed_id = '$feed' AND id = '$article'";
  $result = mysqli_query($conn, $sql);
  include('./template-parts/single-feed-timeline.php');
}
?>

<?php if ($article == "") { ?>
<div id="post-data" class="appear"></div>
</div>

<script>
var isActive = false;
$(window).scroll(function() {
    if(!isActive && $(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
        isActive = true;
        var last_id = $(".content-home:last").attr("id");
        loadMore(last_id);
    }
});

function loadMore(last_id){
  var website = window.location.origin;
  $.ajax({
      url: website + '/includes/infinite-single-feed.php?last_id=' + last_id + '&feed=<?=$feed;?>',
      type: "GET",
      beforeSend: function(){
          $('.ajax-load').show();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      $("#post-data").append(data);
      isActive = false;
  }).fail(function(jqXHR, ajaxOptions, thrownError){
     
  });
}
</script>
<?php } ?>