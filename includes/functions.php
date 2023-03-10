<?php


// Sécuriser une entrée
function cq($v){
        return htmlentities(addslashes($v));
}



// Get displaynames with custom emojis

function emoji($u){
    $nb_arr = count($u['emojis']);
    if($nb_arr != 0){
        $i = 0;
        $text = $u['display_name'];
        while($i <= $nb_arr){
            $pseud = $u['emojis'][$i]['shortcode'];
            $emoj = $u['emojis'][$i]['url'];
            $text = str_replace(':'.$pseud.':', '<img class="x_shortcode" src="'.$emoj.'">', $text);
            $i++;
        }
    }
    else{
        $text = $u['display_name'];
    }
    return $text;
}



// Get statuses with custom emojis

function emojis($u){
    $nb_arr = count($u['emojis']);
    if($nb_arr != 0){
        $i = 0;
        $text = $u['content'];
        while($i <= $nb_arr){
            $pseud = $u['emojis'][$i]['shortcode'];
            $emoj = $u['emojis'][$i]['url'];
            $text = str_replace(':'.$pseud.':', '<img class="x_shortcode" src="'.$emoj.'">', $text);
            $i++;
        }
    }
    else{
        $text = $u['content'];
    }
    return $text;
}



// Get header
function getHEADERS($url){
    $type = get_headers($url, 1)["Content-Type"];
    return $type;
}

// Récupérer le flux RSS à partir du lien
function getRSS($v2){
    $url2 = $v2;

    $page_content = file_get_contents($url2);

    $dom_obj = new DOMDocument();
    $dom_obj->loadHTML($page_content);
    $link_val = null;

    foreach($dom_obj->getElementsByTagName('link') as $link) {

        if($link->getAttribute('type')=='application/rss+xml'){ 
        $link_val = $link->getAttribute('href');
        return $link->getAttribute('href');
        }

    }

    if (is_null ($link_val)) {
        return $url2;
    }
}


// Récupérer l'image Open Graph
function getmetaimage($v2){
    $url2 = $v2;

    $page_content = file_get_contents($url2);

    $dom_obj = new DOMDocument();
    $dom_obj->loadHTML($page_content);
    $meta_val = null;

    foreach($dom_obj->getElementsByTagName('meta') as $meta) {

        if($meta->getAttribute('property')=='og:image'){ 
        $meta_val = $meta->getAttribute('content');
        return $meta->getAttribute('content');
        }

    }

    if (is_null ($meta_val)) {
        return WEBSITE_URL."/assets/nopreview.png";
    }
}


// Récupérer l'embed d'une publication
function getmetaembed($url){
    $url2 = $url;

    $page_content = file_get_contents($url2);

    $dom_obj = new DOMDocument();
    $dom_obj->loadHTML($page_content);
    $meta_val = null;

    foreach($dom_obj->getElementsByTagName('meta') as $meta) {

        if($meta->getAttribute('property')=='og:video:url'){ 
        $meta_val = $meta->getAttribute('content');
        return $meta->getAttribute('content');
        }

    }

    if (is_null ($meta_val)) {
        return NULL;
    }
}



// Récupérer la plateforme d'une publication
function getmetaplatform($url){
    $url2 = $url;

    $page_content = file_get_contents($url2);

    $dom_obj = new DOMDocument();
    $dom_obj->loadHTML($page_content);
    $meta_val = null;

    foreach($dom_obj->getElementsByTagName('meta') as $meta) {

        if($meta->getAttribute('property')=='og:platform'){ 
        $meta_val = $meta->getAttribute('content');
        return $meta->getAttribute('content');
        }

    }

    if (is_null ($meta_val)) {
        return NULL;
    }
}



// Récupérer l'icone Apple-Touch
function getFavicon($v3){
    $url2 = $v3;

    $page_content = file_get_contents($url2);

    $dom_obj = new DOMDocument();
    $dom_obj->loadHTML($page_content);
    $meta_val = null;

    foreach($dom_obj->getElementsByTagName('link') as $link) {

        if($link->getAttribute('rel')=='apple-touch-icon'){ 
        $meta_val = $link->getAttribute('href');
        return $link->getAttribute('href');
        }

        else {
        $meta_val = null;
        }

    }

    if (is_null($meta_val)) {
        return WEBSITE_URL."/assets/nopreview.png";
    }
}


// Télécharger un fichier
function file_get_contents_curl($iurl) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $iurl);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


// Isoler le domaine d'un identifiant Fediverse
function thedomain($domain)
    {
        $exploder = explode('@', $domain);

        if($exploder[0] == ""){
            $theDomain = $exploder[2];
        }
        else{
            $theDomain = $exploder[1];
        }
        return $theDomain;
}


// Supprimer le superflux des urls pour les vignettes

function reconstruct_url($url) {
    if (substr($url,0,4) == "http") {
        $urlPartsArray = parse_url($url);
        $outputUrl = $urlPartsArray['scheme'] . '://' . $urlPartsArray['host'] . ( isset($urlPartsArray['path']) ? $urlPartsArray['path'] : '' );
    } else {
        $URLexploded = explode("?", $url, 2);
        $outputUrl = $URLexploded[0];
    }
    return $outputUrl;
}



// Récupèrer l'url d'origine de la thumbnail de Libération

function libe($url) {
    return "https://cloudfront-eu-central-1.images.arcpublishing.com/liberation/".basename($url);
}



// Date relative

function relativedate($ts)
{
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return NOW;
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return JUST_NOW;
            if($diff < 120) return ONE_MINUTE_AGO;
            if($diff < 3600) return THERE_IS.floor($diff / 60).MINUTES.AGO;
            if($diff < 7200) return ONE_HOUR_AGO;
            if($diff < 86400) return THERE_IS.floor($diff / 3600).HOURS.AGO;
        }
        if($day_diff == 1) return YESTERDAY;
        if($day_diff < 7) return THERE_IS.$day_diff.DAYS.AGO;
        if($day_diff < 31) return THERE_IS.ceil($day_diff / 7).WEEKS.AGO;
        if($day_diff < 60) return LAST_MONTH;
        return date('d/m/Y h:i', $ts);
    }
    else
    {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 120) return 'in a minute';
            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
            if($diff < 7200) return 'in an hour';
            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
        }
        if($day_diff == 1) return 'Tomorrow';
        if($day_diff < 4) return date('l', $ts);
        if($day_diff < 7 + (7 - date('w'))) return 'next week';
        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
        if(date('n', $ts) == date('n') + 1) return 'next month';
        return date('F Y', $ts);
    }
}



// Date relative courtes

function minirelativedate($ts)
{
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return NOW;
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return MINI_JUST_NOW;
            if($diff < 120) return MINI_ONE_MINUTE_AGO;
            if($diff < 3600) return floor($diff / 60).MINI_MINUTES;
            if($diff < 7200) return MINI_ONE_HOUR_AGO;
            if($diff < 86400) return floor($diff / 3600).MINI_HOURS;
        }
        if($day_diff == 1) return $day_diff.MINI_YESTERDAY;
        if($day_diff < 7) return $day_diff.MINI_DAYS;
        if($day_diff < 365) return date('d M.', $ts);
        return date('d M. Y', $ts);
    }
    else
    {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 120) return 'in a minute';
            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
            if($diff < 7200) return 'in an hour';
            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
        }
        if($day_diff == 1) return 'Tomorrow';
        if($day_diff < 4) return date('l', $ts);
        if($day_diff < 7 + (7 - date('w'))) return 'next week';
        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
        if(date('n', $ts) == date('n') + 1) return 'next month';
        return date('F Y', $ts);
    }
}



// Tronquer un texte proprement

function truncate($chaine, $nb_car, $delim='…') {
  $length = $nb_car;
  if($nb_car<strlen($chaine)){
  while (($chaine[$length] != " ") && ($length > 0)) {
   $length--;
  }
  if ($length == 0) return substr($chaine, 0, $nb_car) . $delim;
   else return substr($chaine, 0, $length) . $delim;
  }else return $chaine;
}



// Récupérer les informations d'un status Mastodon

function GetMastoStatus($url) {
    $server = "https://".parse_url($url, PHP_URL_HOST)."/";
    $status_id = basename($url);
    $status_json_url = $server."api/v1/statuses/".$status_id;
    $status_json = file_get_contents($status_json_url);
    $status_array = json_decode($status_json, true);
    return $status_array;
}




// Générer un ID identique à YouTube pour les vidéos
function generateID() {
    // Copyright: http://snippets.dzone.com/posts/show/3123
    $len = 11;
    $base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz-_0123456789';
    $max=strlen($base)-1;
    $activatecode='';
    mt_srand((double)microtime()*1000000);
    while (strlen($activatecode)<$len+1)
    $activatecode.=$base[mt_rand(0,$max)];
    return $activatecode;
}




// Retirer les accents pour la recherche
function remove_accents($text) {
  $from = explode(" ",""
    ." À Á Â Ã Ä Å Ç È É Ê Ë Ì Í Î Ï Ñ Ò Ó Ô Õ Ö Ø Ù Ú Û Ü Ý à á â"
    ." ã ä å ç è é ê ë ì í î ï ñ ò ó ô õ ö ø ù ú û ü ý ÿ Ā ā Ă ă Ą"
    ." ą Ć ć Ĉ ĉ Ċ ċ Č č Ď ď Đ đ Ē ē Ĕ ĕ Ė ė Ę ę Ě ě Ĝ ĝ Ğ ğ Ġ ġ Ģ"
    ." ģ Ĥ ĥ Ħ ħ Ĩ ĩ Ī ī Ĭ ĭ Į į İ ı Ĵ ĵ Ķ ķ Ĺ ĺ Ļ ļ Ľ ľ Ŀ ŀ Ł ł Ń"
    ." ń Ņ ņ Ň ň ŉ Ō ō Ŏ ŏ Ő ő Ŕ ŕ Ŗ ŗ Ř ř Ś ś Ŝ ŝ Ş ş Š š Ţ ţ Ť ť"
    ." Ŧ ŧ Ũ ũ Ū ū Ŭ ŭ Ů ů Ű ű Ų ų Ŵ ŵ Ŷ ŷ Ÿ Ź ź Ż ż Ž ž ƀ Ɓ Ƃ ƃ Ƈ"
    ." ƈ Ɗ Ƌ ƌ Ƒ ƒ Ɠ Ɨ Ƙ ƙ ƚ Ɲ ƞ Ɵ Ơ ơ Ƥ ƥ ƫ Ƭ ƭ Ʈ Ư ư Ʋ Ƴ ƴ Ƶ ƶ ǅ"
    ." ǈ ǋ Ǎ ǎ Ǐ ǐ Ǒ ǒ Ǔ ǔ Ǖ ǖ Ǘ ǘ Ǚ ǚ Ǜ ǜ Ǟ ǟ Ǡ ǡ Ǥ ǥ Ǧ ǧ Ǩ ǩ Ǫ ǫ"
    ." Ǭ ǭ ǰ ǲ Ǵ ǵ Ǹ ǹ Ǻ ǻ Ǿ ǿ Ȁ ȁ Ȃ ȃ Ȅ ȅ Ȇ ȇ Ȉ ȉ Ȋ ȋ Ȍ ȍ Ȏ ȏ Ȑ ȑ"
    ." Ȓ ȓ Ȕ ȕ Ȗ ȗ Ș ș Ț ț Ȟ ȟ Ƞ ȡ Ȥ ȥ Ȧ ȧ Ȩ ȩ Ȫ ȫ Ȭ ȭ Ȯ ȯ Ȱ ȱ Ȳ ȳ"
    ." ȴ ȵ ȶ ȷ Ⱥ Ȼ ȼ Ƚ Ⱦ ȿ ɀ Ƀ Ʉ Ɇ ɇ Ɉ ɉ ɋ Ɍ ɍ Ɏ ɏ ɓ ɕ ɖ ɗ ɟ ɠ ɦ ɨ"
    ." ɫ ɬ ɭ ɱ ɲ ɳ ɵ ɼ ɽ ɾ ʂ ʄ ʈ ʉ ʋ ʐ ʑ ʝ ʠ ͣ ͤ ͥ ͦ ͧ ͨ ͩ ͪ ͫ ͬ ͭ"
    ." ͮ ͯ ᵢ ᵣ ᵤ ᵥ ᵬ ᵭ ᵮ ᵯ ᵰ ᵱ ᵲ ᵳ ᵴ ᵵ ᵶ ᵻ ᵽ ᵾ ᶀ ᶁ ᶂ ᶃ ᶄ ᶅ ᶆ ᶇ ᶈ ᶉ"
    ." ᶊ ᶌ ᶍ ᶎ ᶏ ᶑ ᶒ ᶖ ᶙ ᷊ ᷗ ᷚ ᷜ ᷝ ᷠ ᷣ ᷤ ᷦ Ḁ ḁ Ḃ ḃ Ḅ ḅ Ḇ ḇ Ḉ ḉ Ḋ ḋ"
    ." Ḍ ḍ Ḏ ḏ Ḑ ḑ Ḓ ḓ Ḕ ḕ Ḗ ḗ Ḙ ḙ Ḛ ḛ Ḝ ḝ Ḟ ḟ Ḡ ḡ Ḣ ḣ Ḥ ḥ Ḧ ḧ Ḩ ḩ"
    ." Ḫ ḫ Ḭ ḭ Ḯ ḯ Ḱ ḱ Ḳ ḳ Ḵ ḵ Ḷ ḷ Ḹ ḹ Ḻ ḻ Ḽ ḽ Ḿ ḿ Ṁ ṁ Ṃ ṃ Ṅ ṅ Ṇ ṇ"
    ." Ṉ ṉ Ṋ ṋ Ṍ ṍ Ṏ ṏ Ṑ ṑ Ṓ ṓ Ṕ ṕ Ṗ ṗ Ṙ ṙ Ṛ ṛ Ṝ ṝ Ṟ ṟ Ṡ ṡ Ṣ ṣ Ṥ ṥ"
    ." Ṧ ṧ Ṩ ṩ Ṫ ṫ Ṭ ṭ Ṯ ṯ Ṱ ṱ Ṳ ṳ Ṵ ṵ Ṷ ṷ Ṹ ṹ Ṻ ṻ Ṽ ṽ Ṿ ṿ Ẁ ẁ Ẃ ẃ"
    ." Ẅ ẅ Ẇ ẇ Ẉ ẉ Ẋ ẋ Ẍ ẍ Ẏ ẏ Ẑ ẑ Ẓ ẓ Ẕ ẕ ẖ ẗ ẘ ẙ ẚ Ạ ạ Ả ả Ấ ấ Ầ"
    ." ầ Ẩ ẩ Ẫ ẫ Ậ ậ Ắ ắ Ằ ằ Ẳ ẳ Ẵ ẵ Ặ ặ Ẹ ẹ Ẻ ẻ Ẽ ẽ Ế ế Ề ề Ể ể Ễ"
    ." ễ Ệ ệ Ỉ ỉ Ị ị Ọ ọ Ỏ ỏ Ố ố Ồ ồ Ổ ổ Ỗ ỗ Ộ ộ Ớ ớ Ờ ờ Ở ở Ỡ ỡ Ợ"
    ." ợ Ụ ụ Ủ ủ Ứ ứ Ừ ừ Ử ử Ữ ữ Ự ự Ỳ ỳ Ỵ ỵ Ỷ ỷ Ỹ ỹ Ỿ ỿ ⁱ ⁿ ₐ ₑ ₒ"
    ." ₓ ⒜ ⒝ ⒞ ⒟ ⒠ ⒡ ⒢ ⒣ ⒤ ⒥ ⒦ ⒧ ⒨ ⒩ ⒪ ⒫ ⒬ ⒭ ⒮ ⒯ ⒰ ⒱ ⒲ ⒳ ⒴ ⒵ Ⓐ Ⓑ Ⓒ"
    ." Ⓓ Ⓔ Ⓕ Ⓖ Ⓗ Ⓘ Ⓙ Ⓚ Ⓛ Ⓜ Ⓝ Ⓞ Ⓟ Ⓠ Ⓡ Ⓢ Ⓣ Ⓤ Ⓥ Ⓦ Ⓧ Ⓨ Ⓩ ⓐ ⓑ ⓒ ⓓ ⓔ ⓕ ⓖ"
    ." ⓗ ⓘ ⓙ ⓚ ⓛ ⓜ ⓝ ⓞ ⓟ ⓠ ⓡ ⓢ ⓣ ⓤ ⓥ ⓦ ⓧ ⓨ ⓩ Ⱡ ⱡ Ɫ Ᵽ Ɽ ⱥ ⱦ Ⱨ ⱨ Ⱪ ⱪ"
    ." Ⱬ ⱬ Ɱ ⱱ Ⱳ ⱳ ⱴ ⱸ ⱺ ⱼ Ꝁ ꝁ Ꝃ ꝃ Ꝅ ꝅ Ꝉ ꝉ Ꝋ ꝋ Ꝍ ꝍ Ꝑ ꝑ Ꝓ ꝓ Ꝕ ꝕ Ꝗ ꝗ"
    ." Ꝙ ꝙ Ꝛ ꝛ Ꝟ ꝟ Ａ Ｂ Ｃ Ｄ Ｅ Ｆ Ｇ Ｈ Ｉ Ｊ Ｋ Ｌ Ｍ Ｎ Ｏ Ｐ Ｑ Ｒ Ｓ Ｔ Ｕ Ｖ Ｗ Ｘ"
    ." Ｙ Ｚ ａ ｂ ｃ ｄ ｅ ｆ ｇ ｈ ｉ ｊ ｋ ｌ ｍ ｎ ｏ ｐ ｑ ｒ ｓ ｔ ｕ ｖ ｗ ｘ ｙ ｚ"
    );
  $to = explode(" ",""
    ." A A A A A A C E E E E I I I I N O O O O O O U U U U Y a a a"
    ." a a a c e e e e i i i i n o o o o o o u u u u y y A a A a A"
    ." a C c C c C c C c D d D d E e E e E e E e E e G g G g G g G"
    ." g H h H h I i I i I i I i I i J j K k L l L l L l L l L l N"
    ." n N n N n n O o O o O o R r R r R r S s S s S s S s T t T t"
    ." T t U u U u U u U u U u U u W w Y y Y Z z Z z Z z b B B b C"
    ." c D D d F f G I K k l N n O O o P p t T t T U u V Y y Z z D"
    ." L N A a I i O o U u U u U u U u U u A a A a G g G g K k O o"
    ." O o j D G g N n A a O o A a A a E e E e I i I i O o O o R r"
    ." R r U u U u S s T t H h N d Z z A a E e O o O o O o O o Y y"
    ." l n t j A C c L T s z B U E e J j q R r Y y b c d d j g h i"
    ." l l l m n n o r r r s j t u v z z j q a e i o u c d h m r t"
    ." v x i r u v b d f m n p r r s t z i p u b d f g k l m n p r"
    ." s v x z a d e i u r c g k l n r s z A a B b B b B b C c D d"
    ." D d D d D d D d E e E e E e E e E e F f G g H h H h H h H h"
    ." H h I i I i K k K k K k L l L l L l L l M m M m M m N n N n"
    ." N n N n O o O o O o O o P p P p R r R r R r R r S s S s S s"
    ." S s S s T t T t T t T t U u U u U u U u U u V v V v W w W w"
    ." W w W w W w X x X x Y y Z z Z z Z z h t w y a A a A a A a A"
    ." a A a A a A a A a A a A a A a A a E e E e E e E e E e E e E"
    ." e E e I i I i O o O o O o O o O o O o O o O o O o O o O o O"
    ." o U u U u U u U u U u U u U u Y y Y y Y y Y y Y y i n a e o"
    ." x a b c d e f g h i j k l m n o p q r s t u v w x y z A B C"
    ." D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g"
    ." h i j k l m n o p q r s t u v w x y z L l L P R a t H h K k"
    ." Z z M v W w v e o j K k K k K k L l O o O o P p P p P p Q q"
    ." Q q R r V v A B C D E F G H I J K L M N O P Q R S T U V W X"
    ." Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z"
    );
  return str_replace( $from, $to, $text);
}



// Récupérer les infos depuis Wikipédia
function getWIKI($lang, $media) {
$url = "https://".$lang.".wikipedia.org/w/api.php?action=query&prop=extracts|info&exintro&titles=".$media."&format=json&explaintext&redirects&inprop=url&indexpageids";
$xml = simplexml_load_file($url);

$json = file_get_contents($url);
$data = json_decode($json);

$pageid = $data->query->pageids[0];
return $data->query->pages->$pageid->extract;
}
?>