<?php
include('../../config.php');
include('../functions.php');
include('../db.php');
$url = cq($_GET['lien']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Refresh a link</title>
	<link rel="stylesheet" href="<?php echo WEBSITE_URL ?>/assets/colors-dark.css">
	<link rel="stylesheet" href="<?php echo WEBSITE_URL ?>/assets/style.css">
</head>

<body>
<div style="width:100%; max-width: 900px; padding:40px; margin:auto; margin-top: 50px; margin-bottom: 50px; background-color: var(--feedbot-content-background); border-radius: 12px;">
<h3 style="text-align: center; margin-bottom:20px;">Mettre à jour un article</h3>
<form action="refresh.php" method="GET" style="display:block; max-width:500px; height:100px; margin: auto; border-radius: 12px;">
	<input type="text" name="lien">
	<button type="submit">Envoyer</button>
</form>

<?php if($url !== "") { ?>
	<div style="width: 100%; height:80px;"></div>

<?php
$sql = "SELECT * FROM articles WHERE url = '$url'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
	$article_id = $row['id'];
	$old_title = $row['title'];
	$old_description = $row['excerpt'];
	$old_thumbnail = $row['thumbnail'];
	$old_embed = $row['embed'];
	$old_platform = $row['platform'];
	$media_url = parse_url($url, PHP_URL_HOST);
	if($article_id !== ""){
		$page_content = file_get_contents($url);
		$dom_obj = new DOMDocument();
		$dom_obj->loadHTML($page_content);
		foreach($dom_obj->getElementsByTagName('meta') as $meta){
			if($meta->getAttribute('property')=='og:title'){
				$title = $meta->getAttribute('content');
				$title = iconv(mb_detect_encoding($title, mb_detect_order(), true), "UTF-8", $title);
				$title = str_replace( "'", '’', $title);
			}
			if($meta->getAttribute('property')=='og:description'){
				$description = $meta->getAttribute('content');
				$description = iconv(mb_detect_encoding($description, mb_detect_order(), true), "UTF-8", $description);
				$description = str_replace( "'", '’', $description);
			}
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
		if($thumbnail !== WEBSITE_URL."/assets/nopreview.png" && $media_url !== "www.guettapen.com"){
			$folder = date('Y_m');
			if (!file_exists(WEBSITE_URI."storage/thumbnails/".$folder)) {
				mkdir(WEBSITE_URI."storage/thumbnails/".$folder, 0755, true);
			}

			$thumbnail = reconstruct_url($thumbnail);
			$type = get_headers($thumbnail, 1)["Content-Type"];
			$article_thumb = WEBSITE_URI."storage/thumbnails/".$folder."/".md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true)).".jpg";
			file_put_contents($article_thumb, file_get_contents($thumbnail));
			$maxwidth = "1280";
			list($width, $height) = getimagesize($article_thumb);
			if($width > $maxwidth){
			$percent = $maxwidth / $width;
			$newwidth = $width * $percent;
			$newheight = $height * $percent;
			}
			else{
			$newwidth = $width;
			$newheight = $height;
			}
			if($type == "image/jpeg"){ $source = imagecreatefromjpeg($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 75); }
			if($type == "image/png"){ $source = imagecreatefrompng($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 75); }
			if($type == "image/webp"){ $source = imagecreatefromwebp($article_thumb); $thumb = imagecreatetruecolor($newwidth, $newheight); imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); imagejpeg($thumb, $article_thumb, 75); }
			$thumbnail = $article_thumb;
		}

		if($title !== $old_title && $title !== "" && $title !== NULL){
			$sql = "UPDATE articles SET title = ('$title') WHERE url = '$url'";
			mysqli_query($conn, $sql);
		}

		if($description !== $old_description && $description !== "" && $description !== NULL){
			$sql = "UPDATE articles SET excerpt = ('$description') WHERE url = '$url'";
			mysqli_query($conn, $sql);
		}

		if($thumbnail !== "" && $thumbnail !== NULL){
			$sql = "UPDATE articles SET thumbnail = ('$thumbnail') WHERE url = '$url'";
			mysqli_query($conn, $sql);
			unlink($old_thumbnail);
		}

		if($embed !== $old_embed && $embed !== "" && $embed !== NULL){
			$sql = "UPDATE articles SET embed = ('$embed') WHERE url = '$url'";
			mysqli_query($conn, $sql);
		}

		if($platform !== $old_platform && $platform !== "" && $platform !== NULL){
			$sql = "UPDATE articles SET platform = ('$platform') WHERE url = '$url'";
			mysqli_query($conn, $sql);
		}

		echo "<div style='text-align:center; margin-bottom:40px;'>L'article ".$title." a été mis à jour.</div>";

	}
}

$thumbnail = str_replace(WEBSITE_URI, WEBSITE_URL."/", $thumbnail);
?>
	<div class="timeline-thumbnail" style="width: 600px; margin:auto; margin-bottom: 10px; border-radius: 12px; border: 1px solid var(--feedbot-thumbnails-borders); cursor: initial; overflow: hidden; text-overflow: ellipsis;">
		<div style="width:100%; aspect-ratio: 16 / 9; background-image: url(<?=$thumbnail;?>); background-size: cover; background-position: center; border-top-left-radius: 12px; border-top-right-radius: 12px;">
		</div>
		<div class="timeline-title" style="width: 100%; margin-left: 15px; margin-right: 15px; padding-bottom: 4px; text-align: left;">
			<span style="font-weight:bold;"><?=$title;?></span>
		</div>
		<?php if ($description !== "") { ?>
		<div style="width:100%; margin-bottom: 15px; text-align: left; margin-left: 15px; padding-right: 27px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
			<span><?=truncate($description,200);?></span>
		</div>
		<?php } ?>
	</div>
<?php } ?>
</div>

</body>
</html>