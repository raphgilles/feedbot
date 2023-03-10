<?php 
$sql = "SELECT * FROM feeds_published WHERE uid = '$user'";
$result = mysqli_query($conn, $sql);
$totalfeeds = mysqli_num_rows($result);

$sql = "SELECT * FROM articles_published WHERE uid = '$user' AND is_published = '1'";
$result = mysqli_query($conn, $sql);
$totalshares = mysqli_num_rows($result);

$sql = "SELECT * FROM statuses WHERE uid = '$user'";
$result = mysqli_query($conn, $sql);
$totalposts = mysqli_num_rows($result);
?>

<div class="contenair-home">
	
<div class="title"><i class="fa fa-home" aria-hidden="true"></i> <?= HOME ?></div>

<div style="position:relative; display: block; width: calc(100% - 36px); max-width: 900px; clear:right; height: 110px; overflow:hidden; overflow-x:scroll; margin: auto;">	
<?php include('./template-parts/widget-stories-subscriptions.php'); ?>
</div>

<div style="display:table-row; clear:both;">

<div class="widget-home">
<?php include('./template-parts/widget-welcome.php'); ?>
<?php include('./template-parts/widget-suggestions.php'); ?>
</div>


<div>
<?php
$sql = "SELECT * FROM articles_published WHERE uid = '$user' AND is_published = '1' ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
include('./template-parts/home-timeline.php');
?>

<div id="post-data"></div>
</div>
<script>
$(window).on("scroll", function() {
 var scrollHeight = $(document).height();
 var scrollPos = $(window).height() + $(window).scrollTop();
 if(((scrollHeight - 300) >= scrollPos) / scrollHeight == 0){
   var last_id = $(".content-home:last").attr("id");
        loadMore(last_id).delay(1000);
  }
});

function loadMore(last_id){
  $.ajax({
      url: 'widget-timeline-home.php?last_id=' + last_id,
      type: "GET",
      beforeSend: function(){
          $('.ajax-load').show();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      $("#post-data").append(data);
  }).fail(function(jqXHR, ajaxOptions, thrownError){
      alert('server not responding...');
  });
}
</script> 