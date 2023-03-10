<?php

$xml_str = file_get_contents($feed_url);
$xml = new SimpleXMLElement($xml_str);
$xml->registerXPathNamespace('prefix', 'http://www.w3.org/2005/Atom');
$result = $xml->xpath("//media:description");

$yt_data = array();
foreach($xml->entry as $entry){

    $videoid = (string)$entry->children('yt', true)->videoId;
    $yt_data[] = array(
        'id' => $videoid,
        'title' => (string)$entry->title,
        'description' => (string)$entry->children('media', true)->group->description,
        'img' => (string)'https://img.youtube.com/vi/'.$videoid.'/maxresdefault.jpg',
        'thumb' => (string)'https://img.youtube.com/vi/'.$videoid.'/mqdefault.jpg',
        'published' => (string)$entry->published,
        'updated' => (string)$entry->updated,
        'channel' => (string)$entry->children('yt', true)->channelId,
        'author' => (string)$entry->author->name,
        'uri' => (string)$entry->author->uri,
        'views' => (string)$entry->children('media', true)->group->community->statistics->attributes()['views'],
        'ratings_count' => (string)$entry->children('media', true)->group->community->starRating->attributes()['count'],
        'ratings_avg' => (string)$entry->children('media', true)->group->community->starRating->attributes()['average'],
    );
    
}

foreach($yt_data as $yt){
	if ($i < 2) {
	$channel_url = $yt['uri'];
	$media_thumbnail = getmetaimage($channel_url);
    $youtube_author = $yt['author'];
	$youtube_id = $yt['id'];
	$title = $yt['title'];
	$title = str_replace( "'", '’', $title);
	$title = html_entity_decode($title, ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
	$description = $yt['description'];
	$description = str_replace( "'", '’', $description);
	$description = html_entity_decode(strip_tags($description), ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
	$url = "https://www.youtube.com/watch?v=".$yt['id'];
	$thumbnail = $yt['img'];
	if ($thumbnail == "") { $thumbnail = $yt['thumb']; }
	$date = $yt['published'];

    include('./add_articles.php');

    $i++;
	}
}

$youtube_id = NULL;

?>