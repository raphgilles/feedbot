<?php
$search = cq($_POST['search']);
$search_title = $search;
?>
<div class="contenair-home">
<div class="title" style="margin-bottom: 60px; color:color:var(--feedbot-title);"><i class="fa fa-search" aria-hidden="true"></i> Résultats pour : <?=$search_title;?></div>
<div style="clear:both;">

<div class="widget-home">
<?php include('./template-parts/widget-search-accounts.php'); ?>
<?php include('./template-parts/widget-funding.php'); ?>
</div>

<div>

<?php
$search = cq($_POST['search']);
$search = html_entity_decode($search);
$search = remove_accents($search);
$search = strtolower($search);
$search = preg_replace('~\b[a-z]{1,3}\b\s*~', '', $search);
$search = str_replace( "-", ' ', $search);
$search = str_replace( ":", ' ', $search);
$search = str_replace( "_", ' ', $search);
$search = str_replace( "+", ' ', $search);
$search = str_replace( ",", ' ', $search);
$search = str_replace( "’", '', $search);
$search = str_replace( "|", ' ', $search);
$search = str_replace( "!", '', $search);
$search = str_replace( "(", '', $search);
$search = str_replace( ")", '', $search);
$search = str_replace( "&", '', $search);
$search = str_replace( ".", '', $search);
$search = str_replace( "?", '', $search);
$search = str_replace( "/", '', $search);
$search = str_replace( "\\", '', $search);
$search = str_replace( "Λ", '', $search);
$search = str_replace( "%", '', $search);
$search = preg_replace('/\s+/', ' ',$search);

$infinite_search = str_replace( " ", '-', $search);

$keywordaray = explode(' ', $search);
$b = 0;
foreach($keywordaray as $keyword) {
$keys = trim($keyword);
if ($b > 0) {
$other .=" OR title REGEXP '[[:<:]]".$keys."[[:>:]]'";
$other2 .=" OR excerpt REGEXP '[[:<:]]".$keys."[[:>:]]'";
$other3 .=" OR title LIKE '%$keys%'";
$other4 .=" OR excerpt LIKE '%$keys%'";
}
$fullsearch .= "$keys%";
$b++;
}
$firstword = $keywordaray['0'];
$other = str_replace("OR title REGEXP '[[:<:]][[:>:]]'", '', $other);
$other2 = str_replace("OR excerpt REGEXP '[[:<:]][[:>:]]'", '', $other2);
$other3 = str_replace("OR title LIKE '%%'", '', $other3);
$other4 = str_replace("OR excerpt LIKE '%%'", '', $other4);

$sql = "SELECT * FROM articles WHERE (title REGEXP '[[:<:]]".$firstword."[[:>:]]' $other OR excerpt REGEXP '[[:<:]]".$firstword."[[:>:]]' $other2) OR (title LIKE '%$fullsearch' OR excerpt LIKE '%$fullsearch') ORDER BY shares_count DESC, id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
?>

<?php
include('./template-parts/search-results.php');
include('./template-parts/autopromo.php');
?>

<div id="post-data" class="appear"></div>

</div>
<script>
var isActive = false;
$(window).scroll(function() {
    if(!isActive && $(window).scrollTop() + $(window).height() >= $(document).height() - 550) {
        isActive = true;
        var last_id = $(".content-home:last").attr("id");
        loadMore(last_id);
    }
});

function loadMore(last_id){
  var search = "<?=$infinite_search;?>";
  var website = window.location.origin;
  $.ajax({
      url: website + '/includes/infinite-search.php?last_id=' + last_id + '&search=' + search,
      type: "GET",
      beforeSend: function(){
          $('.ajax-load').show();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      $("#post-data").append(data);
      isActive = false;
  }).fail(function(jqXHR, ajaxOptions, thrownError){

  });
}
</script>