<?php

$title = htmlspecialchars_decode($title, ENT_QUOTES);
$title = $title."\n \n";
$description = htmlspecialchars_decode($description, ENT_QUOTES);
$description = preg_replace('!\s+!', ' ', $description);
$description = preg_replace('/\t+/','',$description);
$description = preg_replace('/\n{3}/','/\n/',$description);
$description = $description."\n \n";
$mention = " via @feedbot@tooter.social";

if ($visibility == "direct") {
  $mention = "";
}

if ($share_title == '0') {
  $title = "";
}

if ($share_description == '0') {
  $description = "";
}

$publication = $title.$description;
$publication = truncate($publication,400)." \n \n";
if ($youtube_id !== "") { $url = WEBSITE_URL."/watch/".$youtube_id; }
if ($peertubeid !== "") { $url = WEBSITE_URL."/watch/".$peertubeid; }
$url = "› ".$url;
$publication = $publication.$url.$mention;
$publication = str_replace( "\n \n \n \n", "\n \n", $publication);

$fp = $_SERVER['DOCUMENT_ROOT']."/temp/thumbnail.jpg";
$thumbnail = str_replace($_SERVER['DOCUMENT_ROOT'], WEBSITE_URL."/", $thumbnail);
$data = file_get_contents_curl($thumbnail);
file_put_contents( $fp, $data );
$image = "thumbnail.jpg";

require 'mastophp/autoload.php';

$mastoPHP = new MastoPHP\MastoPHP(''.$aka.'');

$app = $mastoPHP->registerApp(WEBSITE_NAME, WEBSITE_URL);

$bearer = $app->gheader();
$image = "thumbnail.jpg";
$alt_text = $title;
$domaine = thedomain($aka);
$bearer = $bearer['Authorization'];

if ($share_image == '0') {
  $image = "";
}



$media_sleep = false;

// the main status update array, this will have media IDs added to it further down
// and will be used when you send the main status update using steps in the first article
$status_data = array(
  "status" => $publication,
  "language" => $language,
  "visibility" => $visibility,
  "sensitive" => $is_sensitive,
  "spoiler_text" => $spoiler_text
);

// if we are posting an image, send it to Mastodon
// using a single image here for demo purposes
if ($image !== "") {
  // enter the alternate text for the image, this helps with accessibility
  $fields = array(
    "description" => $alt_text
  );

  // get location of image on the filesystem
  $imglocation = $_SERVER['DOCUMENT_ROOT']."/temp/thumbnail.jpg";

  // add images to files array, this is a single image for demo
  $files = array();
  $files[$image] = file_get_contents($imglocation);

  // make a multipart-form-data delimiter
  $boundary = uniqid();
  $delimiter = '-------------' . $boundary;

  $post_data = '';
  $eol = "\r\n";

  foreach ($fields as $name => $content) {
    $post_data .= "--" . $delimiter . $eol . 'Content-Disposition: form-data; name="' . $name . "\"" . $eol . $eol . $content . $eol;
  }

  foreach ($files as $name => $content) {
    $post_data .= "--" . $delimiter . $eol . 'Content-Disposition: form-data; name="file"; filename="' . $name . '"' . $eol . 'Content-Transfer-Encoding: binary' . $eol;
    $post_data .= $eol;
    $post_data .= $content . $eol;
  }

  $post_data .= "--" . $delimiter . "--".$eol;

  $media_headers = [
    'Authorization: '.$bearer,
    "Content-Type: multipart/form-data; boundary=$delimiter",
    "Content-Length: " . strlen($post_data)
  ];

  // send the image using a cURL POST
  $ch_media_status = curl_init();
  curl_setopt($ch_media_status, CURLOPT_URL, "https://".$domaine."//api/v2/media");
  curl_setopt($ch_media_status, CURLOPT_POST, 1);
  curl_setopt($ch_media_status, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_media_status, CURLOPT_HTTPHEADER, $media_headers);
  curl_setopt($ch_media_status, CURLOPT_POSTFIELDS, $post_data);
  $media_response = curl_exec($ch_media_status);
  $media_output_status = json_decode($media_response);
  $media_info = curl_getinfo($ch_media_status);
  curl_close ($ch_media_status);

  // check the return status of the POST request
  if (($media_info['http_code'] == 200) || ($media_info['http_code'] == 202)) {
    $status_data['media_ids'] = array($media_output_status->id); // id is a string!
    $post_to_mastodon = true;

    if ($media_info['http_code'] == 200) {
      // 200: MediaAttachment was created successfully, and the full-size file was processed synchronously (image)        
      $media_sleep = false;
    }
    else if ($media_info['http_code'] == 202) {
      // 202: MediaAttachment was created successfully, but the full-size file is still processing (video, gifv, audio)
      // Note that the MediaAttachment’s url will still be null, as the media is still being processed in the background
      // However, the preview_url should be available
      $media_sleep = true;
    }
    else {
      $post_error_message = "Error posting media file";
    }
  }
  else {
    $post_error_message = "Error posting media file, error code: " . $media_info['http_code'];
  }
}

// wait for the complex media to finish processing on server
// this is only so when the status is posted the video can be watched right away
if ($media_sleep) {
  sleep(5);
}


// add a JSON content type to the headers
$headers = [
  'Authorization: '.$bearer,
  'Content-Type: application/json'
];

// JSON-encode the status_data array
$post_data = json_encode($status_data);

// Initialize cURL with headers and post data
$ch_status = curl_init();
curl_setopt($ch_status, CURLOPT_URL, "https://".$domaine."/api/v1/statuses");
curl_setopt($ch_status, CURLOPT_POST, 1);
curl_setopt($ch_status, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_status, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch_status, CURLOPT_POSTFIELDS, $post_data); // send the JSON data

// Send the JSON data via cURL and receive the response
$output_status = json_decode(curl_exec($ch_status));

// Close the cURL connection
curl_close ($ch_status);

include('fediverse_add_post.php');


exec("find ".$_SERVER['DOCUMENT_ROOT']."/temp/ \( -name '*.jpeg' -o -name '*.jpg' -o -name '*.png'  \) -delete");

echo "<br />L'article a été publié sur le Fediverse.";

?>