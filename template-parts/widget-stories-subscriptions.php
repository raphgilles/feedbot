<div class="story_content">

<?php
$time = time() - (60 * 60 * 24);
// foreach ($result as $row) {
//    $feed_id = $row['feed_id'];
    $sql = "SELECT DISTINCT feed_id, MAX(published_date) FROM articles_published WHERE uid = '$user' AND is_published = '1' AND published_date > '$time' GROUP BY feed_id ORDER BY MAX(published_date) DESC, feed_id";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    foreach ($result as $row) {
        $feed_id = $row['feed_id'];
        $lessthan24h = "";
        $sql2 = "SELECT * FROM feeds WHERE id = '$feed_id'";
        $result2 = mysqli_query($conn, $sql2);
            foreach ($result2 as $row2) {
            $current_feed_id = $row2['id'];
            $feed_avatar = $row2['thumbnail'];
            $feed_avatar = str_replace($_SERVER['DOCUMENT_ROOT']."storage/icons/", WEBSITE_URL."/storage/icons/", $feed_avatar);
            $feed_title = $row2['feed_title'];
            $feed_url = $row2['feed_url'];
            $media_url = parse_url($feed_url, PHP_URL_HOST);
            }

            $sql = "SELECT * FROM articles WHERE feed_id = '$feed_id' AND date > '$time' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            foreach ($result as $row) {
            $lessthan24h = $row['id'];
            }

            if ($lessthan24h !== "") {
 
?>
<div style="position: relative; display: inline-block;">
    <div style="float:left; width:90px; text-align: center; overflow: hidden; text-overflow: ellipsis;">
        <div class="story-background" onclick="story(<?=$current_feed_id;?>);" title="Story <?= OF ?> <?=$feed_title;?>">
        <div class="story-avatar" style="background-image: url(<?=$feed_avatar;?>);"></div>
        </div>
        <span style="width: 80px; font-size: 11px; white-space:nowrap; overflow: hidden; display:inline-block; text-overflow: ellipsis;"><?=$feed_title;?></span>      
    </div>   
</div>
<?php $i++; }
else { } ?>
<?php 
    
}
?>
</div>


<?php if ($i == 0) { ?> <script type="text/javascript">
    $(".story_contenair").hide();
</script> <?php } ?>