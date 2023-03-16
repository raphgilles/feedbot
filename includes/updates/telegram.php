<?php
include('../functions.php');
include('../../config.php');
$current_time = time();
$website_name = WEBSITE_NAME;
$website_name = strtolower($website_name);
$limit = strtotime('-60 minutes', $current_time);
$mention = ' via <a href="'.WEBSITE_URL.'/">@'.$website_name.'</a>';

$sql4 = "SELECT * FROM users";
$result4 = mysqli_query($conn, $sql4);

    while($row4 = $result4->fetch_array()) {
    $user = $row4['id'];
    $aka = $row4['username'];
    $telegram = $row4['telegram'];

        if ($telegram !== NULL) {
        echo $user." - ".$aka." - ".$telegram."<br />";

        $sql5 = "SELECT * FROM feeds_published WHERE uid = '$user' AND telegram = '1'";
        $result5 = mysqli_query($conn, $sql5);
            foreach ($result5 as $raw5) {
            $feedid = $raw5['feed_id'];

            $sql = "SELECT * FROM articles_published WHERE uid = '$user' AND feed_id = '$feedid' ORDER BY id DESC LIMIT 0, 1";
            $result = mysqli_query($conn, $sql);
                foreach ($result as $row) {
                $article_id = $row['article_id'];
                $published_date = $row['published_date'];
                $telegramed = $row['telegramed'];

                    if ($published_date >= $limit) { 
                    $sql2 = "SELECT * FROM articles WHERE id = '$article_id'";
                    $result2 = mysqli_query($conn, $sql2);

                        foreach ($result2 as $row2) {
                        $article_id2 = $row2['id'];
                        $youtubeid = $row2['youtubeid'];
                        $peertubeid = $row2['peertubeid'];
                        $article_title = "<strong>".$row2['title']."</strong> \n \n";
                        $article_excerpt = str_replace( "\n", '', $row2['excerpt']);
                        $article_excerpt = truncate($article_excerpt, 400);
                        $article_excerpt = $article_excerpt."\n \n";
                        $article_url = $row2['url'];
                        if ($youtubeid !== "") { $article_url = WEBSITE_URL."/watch/".$youtubeid; }
                        if ($peertubeid !== "") { $article_url = WEBSITE_URL."/watch/".$peertubeid; }
                        $content = $article_title.$article_excerpt.$article_url.$mention; 

                        if ($article_id2 !== NULL && $telegramed == 0) {
                        // ENDROIT OU ENVOYER LES LIENS
                        $content = urlencode($content);
                        $link = "https://api.telegram.org/bot".$telegram_api."/sendMessage?chat_id=".$telegram."&parse_mode=html&text=".$content;
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $link);
                        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $return = curl_exec($curl);
                        curl_close($curl);

                        echo "Article ".$article_id2." partagé. Lien : ".$link."<br />";

                        $sql = "UPDATE articles_published SET telegramed = ('1') WHERE uid = '$user' AND article_id = '$article_id2'";
                        mysqli_query($conn, $sql);
                        }




                        }
                    }
                }
            }
        }
    }
echo "<br /><br />Finished";
?>
