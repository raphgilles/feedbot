<?php
session_start();

include('../config.php');
include('./functions.php');

$aka = $_SESSION['akainstance'];
$user = $_SESSION['uid'];

$feed = cq("".$_POST['flux']."");
$is_rss = getHEADERS($feed);

if ($is_rss !== "application/xml" && $is_rss !== "application/atom+xml") {
$feed = getRSS($feed);
}

$extension = pathinfo($feed, PATHINFO_EXTENSION);
$slash = substr($feed, strlen($feed)-1);
if ($extension == "" && $slash !== "/") {
    $feed = str_replace($feed, $feed.'/', $feed);
}

$rss = simplexml_load_file($feed, "SimpleXMLElement", LIBXML_NOCDATA);

$media_name = str_replace( "'", '’', $rss->channel->title);
if($media_name == ""){
	$media_name = $rss->title;
}
$media_url = parse_url($feed, PHP_URL_HOST);
$media_url = "https://".$media_url;
$media_url = str_replace("https://api.", "https://", $media_url);
$media_url = str_replace("https://feeds.", "https://", $media_url);
$media_url = str_replace("https://rss.", "https://", $media_url);
$media_url = str_replace("https://backend.", "https://", $media_url);


$sql = "SELECT * FROM feeds WHERE feed_url = '$feed'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
	$feed_id = $row['id'];
	$id_feed = $feed_id;
}

$sql = "SELECT * FROM feeds_published WHERE feed_id = '$feed_id' AND uid = '$user'";
$result = mysqli_query($conn, $sql);
foreach($result as $row) {
	$sub_id = $row['id'];
	if ($sub_id !== "") { $feedexists = 1; }
}

if ($feed_id !== NULL && $sub_id == "") {
	$sql = "INSERT INTO feeds_published (feed_id, uid) values ('$feed_id', '$user')";
	mysqli_query($conn, $sql);

	$sql = "SELECT * FROM articles WHERE feed_id = '$feed_id' ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	foreach ($result as $row) {
		$article_id = $row['id'];
		$site_id = $row['id_site'];
		$title = $row['title'];
		$date = $row['date'];
	}

	$sql = "SELECT * FROM articles_published WHERE uid = '$user' AND feed_id = '$feed_id'";
	$result = mysqli_query($conn, $sql);
	foreach ($result as $row) {
	    $share_id = $row['id'];
	}

	if ($share_id == "") {
	$sql = "INSERT INTO articles_published (uid, article_id, site_id, feed_id, is_published, published_date) VALUES ('$user', '$article_id', '$site_id', '$feed_id', '1', '$date')";
	mysqli_query($conn, $sql);
	}

	else {
	$sql = "UPDATE articles_published SET is_published = ('1') WHERE uid = '$user' AND feed_id = '$feed_id'";
	mysqli_query($conn, $sql);
	}

	$sql = "UPDATE feeds SET subscribers = subscribers + 1 WHERE id = '$feed_id'";
	mysqli_query($conn, $sql);
 }

elseif ($feed_id === NULL) {

	$media_thumbnail = getFavicon($media_url);

	if($media_thumbnail !== WEBSITE_URL."/assets/nopreview.png"){
		$media_thumbnail = $media_url.$media_thumbnail;
		$media_thumbnail = str_replace("".$media_url.$media_url."", "".$media_url."", $media_thumbnail);
	}

	echo $media_thumbnail;

	$i = 0;

	if($media_url == "https://www.youtube.com"){
		$youtubeok = parse_url($feed, PHP_URL_PATH);
		if($youtubeok == "/feeds/videos.xml"){
			include("youtube.php");
		}
		else{
			header('location: '.WEBSITE_URL.'/index.php?p=add&m=incompatible'); 
		}
	}
	elseif(isset($rss->channel) && $media_url !== "https://www.youtube.com"){
		$language = $rss->channel->language;

		foreach($rss->channel->item as $item){
			if($i == 0){
				$title = str_replace( "'", '’', $item->title);
				$title = html_entity_decode($title, ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
				$url = $item->link;
				$description = str_replace( "'", '’', $item->description);
				$description = str_replace( "<small class=\"fine d-inline\"> </small>", '', $description);
				$description = str_replace( "&nbsp;", '<br /><br />', $description);
				$description = html_entity_decode(strip_tags($description), ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
				$date = $item->pubDate;

				$enclosure = $item->enclosure['url'];
		        $is_audio = pathinfo($enclosure, PATHINFO_EXTENSION);
		        if ($is_audio == "mp3" OR $is_audio == "aac" OR $is_audio == "wav") { $embed = $enclosure; }
				
				if($date == ""){
					$dc = $item->children('http:purl.org/dc/elements/1.1/');
					$date = $dc->date;
				}

				$thumbnail = WEBSITE_URL."/assets/nopreview.png";  

				$enclosure = $item->enclosure['url'];
		        $enclosure = reconstruct_url($enclosure);
		        $is_audio = pathinfo($enclosure, PATHINFO_EXTENSION);
		        if ($is_audio == "mp3" OR $is_audio == "aac" OR $is_audio == "wav") {
		            $embed = $enclosure;
		            $thumbnail = $item->children('itunes', true)->image->attributes()->href;
		        }

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
				
				if ($media_url == "https://www.ouest-france.fr") { $thumbnail = $item->enclosure['url']; }
		        if ($media_url == "https://www.nasa.gov") { $thumbnail = $item->enclosure['url']; }
		        if ($media_url == "https://www.humanite.fr") { $thumbnail = $item->enclosure['url']; }
		        if ($media_url == "https://arretsurimages.net") { $thumbnail = $item->enclosure['url']; }
		        if ($media_url == "https://www.liberation.fr") { $thumbnail = libe($thumbnail); }
		        if ($media_url == "https://www.cowcotland.com" && $thumbnail !== "") { $thumbnail = $media_url.$thumbnail; }
		        if ($thumbnail == "") { $thumbnail = "https://feedbot.net/assets/nopreview.png"; }
		        $thumbnail = reconstruct_url($thumbnail);

				if($platform == "PeerTube"){
					$peertubeid = generateID();
					$media_thumbnail = $rss->channel->image->url;
				}
		
				include('add_site_to_db.php');
				include('add_articles_to_db.php');

				echo "<br />".$title;
				echo "<br />".$url;
				echo "<br />".$description;
				echo "<br />".$date."<br />";

				$i++;
			}
		}
	}
	elseif(isset($rss->entry) && $media_url !== "https://www.youtube.com"){
		$media_name = str_replace( "'", '’', $rss->author->name);
			foreach($rss->entry as $entry){
				if ($i == 0) {
				$urlAtt = $entry->link->attributes();
				$url    = $urlAtt['href'];
				$title  = $entry->title;
				$title = html_entity_decode($title, ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
				$description = str_replace( "'", '’', $entry->content);
				$description = str_replace( "&nbsp;", '<br /><br />', $description);
				$description = html_entity_decode(strip_tags($description), ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
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

				include('add_site_to_db.php');
				include('add_articles_to_db.php');
		 
				echo "<br />".$title;
				echo "<br />".$url;
				echo "<br />".$description;
				echo "<br />".$date."<br />";

				$i++;
			}
		}
	}
}

if($feedexists == 1){
	header('location: '.WEBSITE_URL.'/index.php?p=add&m=failed');
}
elseif($title == ""){
	header('location: '.WEBSITE_URL.'/index.php?p=add&m=incompatible');
}
elseif($id_feed == ""){
	header('location: '.WEBSITE_URL.'/index.php?p=add&m=incompatible');
}
else{
	header('location: '.WEBSITE_URL.'/index.php?p=feeds&m=success');
}

?>