<?php

$rss = simplexml_load_file($feed_url);

$media_url = parse_url($feed_url, PHP_URL_HOST);
$media_url = "https://".$media_url;
$media_url = str_replace("https://api.", "https://", $media_url);
$media_url = str_replace("https://feeds.", "https://", $media_url);
$media_url = str_replace("https://rss.", "https://", $media_url);
$media_url = str_replace("https://backend.", "https://", $media_url);

$i = 0;

if ($media_url == "https://www.youtube.com") {
    $youtubeok = parse_url($feed_url, PHP_URL_PATH);
    if ($youtubeok == "/feeds/videos.xml") {
    include ("./youtube-cron.php");
    }
}

elseif(isset($rss->channel) && $media_url !== "https://www.youtube.com"){
$language = $rss->channel->language;

foreach ($rss->channel->item as $item) {
    if ($i <= 3) {
    $url = $item->link;
    $article_query = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM articles WHERE url = '$url' AND feed_id = '$feed_id'"));
    $article_db_id = $article_query['id'];
    if($article_db_id == "") {

        $title = str_replace( "'", '’', $item->title);
        $title = html_entity_decode($title, ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
        $description = str_replace( "'", '’', $item->description);
        $description = html_entity_decode(strip_tags($description), ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
        $date = $item->pubDate;
        if ($date == "") {
            $dc = $item->children('http://purl.org/dc/elements/1.1/');
            $date = $dc->date;
        }
        if ($date == "") {
            $date = time();
        }
        $thumbnail = WEBSITE_URL."/assets/nopreview.png";
        
        $page_content = file_get_contents($url);
        $dom_obj = new DOMDocument();
        $dom_obj->loadHTML($page_content);
        $meta_val = NULL;

        foreach($dom_obj->getElementsByTagName('meta') as $meta) {

            if($meta->getAttribute('property')=='og:image'){ 
            $thumbnail = $meta->getAttribute('content');
            }
            if (is_null($thumbnail)) {
            $thumbnail = WEBSITE_URL."/assets/nopreview.png";
            }

            if($meta->getAttribute('property')=='og:video:secure_url'){ 
            $embed = $meta->getAttribute('content');
            }

            if($meta->getAttribute('property')=='og:platform'){ 
            $platform = $meta->getAttribute('content');
            }

        }

        $enclosure = $item->enclosure['url'];
        $enclosure = reconstruct_url($enclosure);
        $is_audio = pathinfo($enclosure, PATHINFO_EXTENSION);
        if ($is_audio == "mp3" OR $is_audio == "aac" OR $is_audio == "wav") {
            $embed = $enclosure;
            $thumbnail = $item->children('itunes', true)->image->attributes()->href;
        }
        
        if ($media_url == "https://www.ouest-france.fr") { $thumbnail = $item->enclosure['url']; }
        if ($media_url == "https://www.nasa.gov") { $thumbnail = $item->enclosure['url']; }
        if ($media_url == "https://www.humanite.fr") { $thumbnail = $item->enclosure['url']; }
        if ($media_url == "https://arretsurimages.net") { $thumbnail = $item->enclosure['url']; }
        if ($media_url == "https://www.liberation.fr") { $thumbnail = libe($thumbnail); }
        if ($media_url == "https://www.cowcotland.com" && $thumbnail !== "") { $thumbnail = $media_url.$thumbnail; }
        if ($thumbnail == "") { $thumbnail = "https://feedbot.net/assets/nopreview.png"; }
        $thumbnail = reconstruct_url($thumbnail);
        
        if ($platform == "PeerTube") {
        $peertubeid = generateID();
        $media_thumbnail = $rss->channel->image->url;
        }

        include('./add_articles.php');

        $dom_obj = NULL;
        $description = NULL;
        $platform = NULL;
        $embed = NULL;
        $peertubeid = NULL;

        }
        $i++;
    }
}

}

elseif(isset($rss->entry) && $media_url !== "https://www.youtube.com"){
    $media_name = str_replace( "'", '’', $rss->author->name);
        foreach($rss->entry as $entry){
            if ($i <= 3) {
            $urlAtt = $entry->link->attributes();
            $url    = $urlAtt['href'];
            $title  = $entry->title;
            $title = str_replace( "'", '’', $title);
            $title = html_entity_decode($title, ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
            $description = str_replace( "'", '’', $entry->content);
            $description = str_replace( "&nbsp;", '<br /><br />', $description);
            $description = strip_tags(html_entity_decode($description), ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
            $thumbnail = WEBSITE_URL."/assets/nopreview.png";  
            $page_content = file_get_contents($url);
            $dom_obj = new DOMDocument();
            $dom_obj->loadHTML($page_content);

            foreach($dom_obj->getElementsByTagName('meta') as $meta){
                if($meta->getAttribute('property')=='og:image'){
                    $thumbnail = $meta->getAttribute('content');
                }

                if(is_null ($thumbnail)){
                    $thumbnail = WEBSITE_URL."/assets/nopreview.png";
                }

                if($meta->getAttribute('property')=='og:video:secure_url'){
                    $embed = $meta->getAttribute('content');
                }

                if($meta->getAttribute('property')=='og:platform'){
                    $platform = $meta->getAttribute('content');
                }
            }

            $thumbnail = reconstruct_url($thumbnail);

            if($platform == "PeerTube"){
                $peertubeid = generateID();
                $media_thumbnail = $rss->channel->image->url;
            }

            $date = $entry->published;

            if($date == ""){
                $date = $entry->updated;
            }

            include('./add_articles.php');

            $i++;
        }
    }
}

?>