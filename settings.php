<?php
$sqlpagination = "SELECT * FROM statuses WHERE uid = '$user'";
$resultpagination = mysqli_query($conn, $sqlpagination);
$display_total = mysqli_num_rows($resultpagination);

$sql = "SELECT * FROM users WHERE id = '$user'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
$mail = $row['mail'];
$dailymail = $row['daily_mail'];
$telegram = $row['telegram'];
}

// MastoPHP
require './includes/mastophp/autoload.php';
$mastoPHP = new MastoPHP\MastoPHP(''.$aka.'');
$app = $mastoPHP->registerApp(WEBSITE_NAME, WEBSITE_URL);

$bannername = basename($banner); 
if ($bannername == "missing.png") {
$banner = WEBSITE_URL."/assets/defaut_banner.png";
}

?>

<div class="contenair-links">

    <?php
    if ($_GET['telegram'] == 'success') { ?>
    <div class="alert-green">
    <span><i class="fa fa-check" aria-hidden="true"></i></span> <span style="margin-left: 20px;"> Connexion avec Telegram réussie.</span>
    </div>
    <?php } ?>

    <?php
    if ($_POST['telegram'] == 'notconnected') { ?>
    <div class="alert-orange">
    <span><i class="fa fa-check" aria-hidden="true"></i></span> <span style="margin-left: 20px;"> <?=NEED_TO_CONNECT_TELEGRAM;?>.</span>
    </div>
    <?php } ?>

    <?php
    if ($_GET['m'] == 'success') { ?>
    <div class="alert-green">
    <span><i class="fa fa-check" aria-hidden="true"></i></span> <span style="margin-left: 20px;"> Les paramètres de votre compte ont été enregistrés.</span>
    </div>
    <?php } ?>

    <div class="title"><i class="fa fa-history" aria-hidden="true"></i> Paramètres de votre compte</div>

        <div class="content-posts">
            <div style="background-image: url(<?=$banner;?>);" class="banner">
                <div class="post-displayname"><img src="<?=$useravatar;?>" class="post-avatar" /></div>
                <div class="post-displayname"><p class="profile-counter"><?=$displayname;?><br />
                <?=$display_total;?> <?= SHARES ?><br /><?=$following;?> <?= FOLLOWS ?><br /><?=$followers;?> <?= FOLLOWERS ?></p></div>
            </div>

            <div class="post-mastodon" style="margin-bottom:5px;">

                <form action="includes/action.php" method="post" class="switch">
                    <label for="mail"><strong>Votre adresse mail</strong></label><br />
                    <input type="mail" id="mail" name="mail" style="margin-bottom: 20px; max-width: 300px;" value="<?=$mail;?>"><br />
                    <label for="dailymail"><strong>Recevoir une veille journalière par mail ?</strong></label>

                    <?php if ($dailymail == "1") { ?>
                    <input type="checkbox" name="dailymail" value="1" style="margin-top: 8px;" checked>
                    <?php } else { ?>
                    <input type="checkbox" name="dailymail" value="1" style="margin-top: 8px;">
                    <?php } ?>

                    <input type="hidden" id="action" name="action" value="settings">
                    <input type="hidden" id="uid" name="uid" value="<?= $user; ?>">

                    <button type="submit"><span style="vertical-align: middle;">Modifier</span></button>
                </form>

            <?php if ($telegram_bot !== ""){ ?>
                <p style="margin-top:42px; margin-bottom:8px;"><strong>Connecter votre compte Telegram</strong></p>
                <?=$telegram_bot;?>
                <p style="font-style: italic; margin-top:8px; font-size: 14px;">Vous pourrez ensuite configurer la veille sur Telegram en temps réel dans la gestion de <a href="<?=YOUR_FEEDS_PAGE;?>" title="Vos flux RSS">vos flux RSS</a>.</p>
            <?php } ?>

            </div>

        </div>