<?php
include('../../config.php');
include('../functions.php');
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');
$date_format = "%A %d %B %Y à %Hh%M";
$current_time = time();
$limit = strtotime('-1 day', $current_time);

// Mail config
$from = 'veille@feedbot.net'; 
$fromName = WEBSITE_NAME; 
$subject = "Votre veille journallière";
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";
$mailheader = '<!doctype html><html lang="fr" style="height: 100%;">
<head>
<title>Votre veille journallière - '.WEBSITE_NAME.'</title>
<style>
body {
  background-color: #E4E9F7;
  min-height: 100%;
}

.logo {
  width: 100%;
  text-align: center;
  margin-bottom: 8px;
}

.logo img {
    width: 50%;
}

.contenair {
    max-width: 1000px;
    margin:auto;
    padding: 5px;
    background-color: #E4E9F7;
}

.feed_item {
    background-color: #FFF;
    border-radius: 12px;
    padding: 10px;
    padding-top: 15px;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.feed_item:hover, .feed_item:active {
  background-color:  #f6f6f6;
  -webkit-tap-highlight-color: #f6f6f6;
}

.feed_item img {
    width: 100%;
    aspect-ratio: 16 / 9;
    border-radius: 12px;
    margin: auto;
}

.feed_item a {
    color: #563ACC;
}

.feed_item a:hover {
    text-decoration:none;
}
</style>
</head>
<body style="background-color: #E4E9F7; min-height: 100%;">
<div class="contenair">
<div class="logo"><a href="'.WEBSITE_URL.'" target="_blank" title='.WEBSITE_NAME.'"><img src="'.WEBSITE_URL.'/assets/icons/logomail.png" /></a></div>';

$sql4 = "SELECT * FROM users";
$result4 = mysqli_query($conn, $sql4);

while($row4 = $result4->fetch_array()) {
$user = $row4['id'];
$aka = $row4['username'];
$mail = $row4['mail'];
$daily_mail = $row4['daily_mail'];
$mailfooter = '<p style="text-align:center; font-size: 12px; font-style:italic;">Ceci est un mail automatique. Vous pouvez le désactiver sur votre compte '.WEBSITE_NAME.'.<br />
Identifiant Mastodon : '.$aka.'</p></div></body></html>';
echo $user." - ".$aka."<br />";

    if ($mail !== NULL && $daily_mail == "1") {

    $to = $mail;

    $sql = "SELECT * FROM articles_published WHERE uid = '$user' ORDER BY id DESC LIMIT 0, 6";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $row) {
        $article_id = $row['article_id'];
        $published_date = $row['published_date'];

        if ($published_date >= $limit) { 
        $sql2 = "SELECT * FROM articles WHERE id = '$article_id'";
        $result2 = mysqli_query($conn, $sql2);

            foreach ($result2 as $row2) {
            $youtubeid = $row2['youtubeid'];
            $peertubeid = $row2['peertubeid'];
            $article_thumbnail = $row2['thumbnail'];
            $article_thumbnail = str_replace($_SERVER['DOCUMENT_ROOT'], WEBSITE_URL."/", $article_thumbnail);
            $article_title = $row2['title'];
            $article_excerpt = html_entity_decode($row2['excerpt'], ENT_SUBSTITUTE);
            $article_url = $row2['url'];
            if ($youtubeid !== "") { $article_url = WEBSITE_URL."/watch/".$youtubeid; }
            if ($peertubeid !== "") { $article_url = WEBSITE_URL."/watch/".$peertubeid; }
            $article_date = strftime($date_format, $row2['published_date']);
            $htmlContent .= ' 
            <div class="feed_item" title="'.$article_title.'">
            <a href="'.$article_url.'"><div style="background-image:url(\''.$article_thumbnail.'\'); background-position:center; background-size:cover; width:100%; aspect-ratio:16/9; border-radius:12px;" alt="'.$article_title.'"></div></a>
            <div style="margin-top:6px;"><strong>'.$article_title.'</strong><br />
            '.truncate($article_excerpt,270).'<br />
            <a href="'.$article_url.'">'.substr($article_url,0,50).'…</a></div></div>
            '; 
        }
    }
}
        if ($article_title !== "") {
        // Send email 
        if (mail($to, $subject, $mailheader.$htmlContent.$mailfooter, $headers)){ 
        echo 'L’email a été envoyé.<br />'; 
        } else { 
        echo 'Email sending failed.'; 
        }
    }

echo $mailheader.$htmlContent.$mailfooter;
}
}

?>