<?php
require './includes/mastophp/autoload.php';
$mastoPHP = new MastoPHP\MastoPHP(''.$aka.'');
$app = $mastoPHP->registerApp(<?=WEBSITE_NAME;?>, <?=WEBSITE_URL;?>);

$sql = "SELECT * FROM statuses WHERE uid = '$user' ORDER BY id DESC LIMIT 0, 5";
$result = mysqli_query($conn, $sql);
?>

<div class="widget" style="float:right;">
<div style="background-image: url(<?=$banner;?>);" class="banner">
    <div class="displayname"><img src="<?=$useravatar;?>" class="widget-avatar" /> <?=$displayname;?></div>
</div>
<?php 

foreach ($result as $row) {
	$statuses_id = $row['post_id'];
    $statuses_url = $row['url'];
    $getpub = $mastoPHP->getPub($statuses_id);
    $status_content = $getpub['content'];
    $status_favs = $getpub['favourites_count'];
    $status_shares = $getpub['reblogs_count'];
    $status_comments = $getpub['replies_count'];
    $status_visibility = $row['post_visibility'];

    if ($status_visibility == "public") { $visibility_icon = '<i class="fa fa-globe-w" aria-hidden="true"></i>'; }
    if ($status_visibility == "unlisted") { $visibility_icon = '<i class="fa fa-unlock" aria-hidden="true"></i>'; }
    if ($status_visibility == "private") { $visibility_icon = '<i class="fa fa-lock" aria-hidden="true"></i>'; }
    if ($status_visibility == "direct") { $visibility_icon = '<i class="fa fa-at" aria-hidden="true"></i>'; }

echo '<div class="widget-mastodon">'.$status_content.'
<p style="margin-top:15px;"><a href="'.$statuses_url.'" target="_blank" title="Voir sur Mastodon" style="color:#000; text-decoration:none;"><i class="fa fa-reply" aria-hidden="true"></i> <span style="margin-right:5px;">'.$status_comments.'</span> <i class="fa fa-retweet" aria-hidden="true"></i> <span style="margin-right:5px;">'.$status_shares.'</span> <i class="fa fa-star" aria-hidden="true"></i> <span style="margin-right:5px;">'.$status_favs.'</span> <span style="margin-right:6px;" title="'.$status_visibility.'">'.$visibility_icon.'</span> <i class="fa fa-external-link" aria-hidden="true"></i><span></a>
</p></div>';
} ?>

</div>