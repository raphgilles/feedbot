<?php
// Pagination
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentpage = (int) strip_tags($_GET['page']);
}else{
    $currentpage = 1;
}
$linksmax = 10;
$premier = ($currentpage * $linksmax) - $linksmax;
$sqlpagination = "SELECT * FROM statuses WHERE uid = '$user'";
$resultpagination = mysqli_query($conn, $sqlpagination);
$total_links = mysqli_num_rows($resultpagination);
$display_total = $total_links;
if ($total_links == '0') { $total_links = '1'; }
$nb_pages = ceil($total_links / $linksmax);

// MastoPHP
require './includes/mastophp/autoload.php';
$mastoPHP = new MastoPHP\MastoPHP(''.$aka.'');
$app = $mastoPHP->registerApp(WEBSITE_NAME, WEBSITE_URL);

$sql = "SELECT * FROM statuses WHERE uid = '$user' ORDER BY id DESC LIMIT ".$premier.", ".$linksmax."";
$result = mysqli_query($conn, $sql);
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');

$bannername = basename($banner); 
if ($bannername == "missing.png") {
$banner = WEBSITE_URL."/assets/defaut_banner.png";
}

?>

<div class="contenair-links">

<div class="title" style="margin:15px; margin-bottom: 50px;"><i class="fa fa-history" aria-hidden="true"></i> <?=SHARES_HISTORY;?></div>
<div class="content-posts">

<div style="background-image: url(<?=$banner;?>);" class="banner">
    <div class="post-displayname"><img src="<?=$useravatar;?>" class="post-avatar" /></div> <div class="post-displayname"><p class="profile-counter"><?=$displayname;?><br />
    <?=$display_total;?> <?=SHARES;?><br /><?=$following;?> <?=FOLLOWS;?><br /><?=$followers;?> <?=FOLLOWERS;?></p></div>
</div>
<?php 

foreach ($result as $row) {
    $thisone = $row['id'];
	$statuses_id = $row['post_id'];
    $status_origin = $row['url'];
    $getpub = $mastoPHP->getPub($statuses_id);
    $status = emojis($getpub);
    $status_favs = $getpub['favourites_count'];
    $status_shares = $getpub['reblogs_count'];
    $status_comments = $getpub['replies_count'];
    $status_visibility = $row['post_visibility'];
    $status_date = minirelativedate(strtotime($getpub['created_at']));
    $status_full_date = relativedate(strtotime($getpub['created_at']));
    $article_id = $row['article_id'];
    $status_userlink = $getpub['account']['url'];

    if ($status_visibility == "public") { $visibility_icon = '<i class="fa fa-globe-w" aria-hidden="true"></i>'; }
    if ($status_visibility == "unlisted") { $visibility_icon = '<i class="fa fa-unlock" aria-hidden="true"></i>'; }
    if ($status_visibility == "private") { $visibility_icon = '<i class="fa fa-lock" aria-hidden="true"></i>'; }
    if ($status_visibility == "direct") { $visibility_icon = '<i class="fa fa-at" aria-hidden="true"></i>'; }

?>

<div class="post-mastodon feed_<?=$thisone;?>">

    <div style="height:50px; width: 100%;">
            <div style="float:right; margin-top: -2px;">
            <span style="color:var(--feedbot-gray); vertical-align: top;" title="<?=$status_visibility;?>"><?=$visibility_icon;?></span> <a href="<?=$status_origin;?>" style="color:var(--feedbot-gray); font-size:12px; text-decoration:none;" title="<?=$status_full_date;?>" target="_blank"><?=$status_date;?></a>
            </div>

            <div style="width:40px; aspect-ratio: 1 / 1; background-image: url('<?=$useravatar;?>'); background-size: cover; background-position: center; border-radius: 6px; float:left;"><a href="<?=$status_userlink;?>" style="display:block; width:100%; height:100%;" target="_blank"></a></div>
                <div style="margin-left: 50px; line-height: 16px; word-break: break-word;">
                <a href="<?=$status_userlink;?>" style="color:var(--feedbot-title); font-weight:bold; text-decoration:none;" target="_blank"><?=$displayname;?></a><br />
                <span style="color:var(--feedbot-gray); font-size:12px;"><?=$aka;?></span>
                </div>
    </div>

    <p><?=$status;?></p>

    <p style="margin-top:15px;"><a href="<?=$statuses_url ?>" target="_blank" title="<?=VIEW_ON_MASTODON;?>" style="color:var(--feedbot-gray); text-decoration:none;"><i class="fa fa-reply" aria-hidden="true"></i> <span style="margin-right:5px;"><?=$status_comments ?></span> <i class="fa fa-retweet" aria-hidden="true"></i> <span style="margin-right:5px;"><?=$status_shares;?></span> <i class="fa fa-star" aria-hidden="true"></i> <span style="margin-right:6px;"><?=$status_favs;?></span> <span style="margin-right:6px;"><i class="fa fa-external-link" aria-hidden="true"></i><span> </a>
    </p>

    <div class="delete-share">
        <form class="unshare_<?=$thisone;?>">
            <input type="hidden" name="action" value="delete_status">
            <input type="hidden" name="status_id" value="<?=$statuses_id;?>">
            <input type="hidden" name="article_id" value="<?=$article_id;?>">
            <button onclick="if(!confirm('<?=DELETE_SHARE_CONFIRM;?>')){return false;}; unshare(<?=$thisone;?>); hideelement(<?=$thisone;?>);" class="switch" title="<?=DELETE_SHARE;?>" style="color:var(--feedbot-text);" /><i class="fa fa-times" aria-hidden="true"></i></button>
        </form>
    </div>

</div>

<?php } ?>

<nav>
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item-before<?= ($currentpage == 1) ? " disabled" : "" ?>">
            <a href="<?=STATUSES_PAGE;?>&page=<?= $currentpage - 1 ?>" class="page-link"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> <?=PAGINATION_PREVIOUS;?></a>
        </li>
        <?php for($page = 1; $page <= $pages; $page++): ?>
        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
        <li class="page-item<?= ($currentpage == $page) ? " active" : "" ?>">
        <a href="<?=STATUSES_PAGE;?>&page=<?= $page ?>" class="page-link"><?= $page ?></a>
        </li>
        <?php endfor ?>
        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
        <li class="page-item-next<?= ($currentpage == $nb_pages) ? " disabled" : "" ?>">
        <a href="<?=STATUSES_PAGE;?>&page=<?= $currentpage + 1 ?>" class="page-link"><?=PAGINATION_NEXT;?> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
        </li>
    </ul>
</nav>

<?php if ($display_total == 0) { ?>
<div style="text-align: center; width: 100%; display: inline-block; margin-top: 20px; margin-bottom: 40px;"><?=NO_SHARES;?>"<a href="<?=YOUR_FEEDS_PAGE;?>" title="<?=YOUR_FEEDS;?>"><?=YOUR_FEEDS;?></a>".</div>
<?php } ?>

</div>