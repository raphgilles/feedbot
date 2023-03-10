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
	<div class="title">
		<i class="fa fa-globe-w" aria-hidden="true"></i> <?= GLOBAL_FEED ?>
	</div>
	<div class="story_contenair">
<?php include('./template-parts/widget-stories.php'); ?>
	</div>
	<div style="clear:both;">
		<div class="widget-home">
<?php include('./template-parts/widget-suggestions.php'); ?>
<?php include('./template-parts/widget-shares.php'); ?>
<?php include('./template-parts/widget-funding.php'); ?>
<?php include('./template-parts/footer.php'); ?>
		</div>
		<div>

<?php
$actualtime = time();
$sql = "SELECT * FROM articles WHERE date > '$lastid' AND date < $actualtime ORDER BY date DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
include('./template-parts/global-timeline.php');
if($isconnected !== NULL){
	include('./template-parts/autopromo.php');
}
?>

<?php
if($isconnected == ""){
	include('./template-parts/not-connected.php');
}
else{
?>
			<div id="post-data" class="appear"></div>
		</div>
		<script>
			var isActive = false;
			$(window).scroll(function(){
				if(!isActive && $(window).scrollTop() + $(window).height() >= $(document).height() - 550){
					isActive = true;
					var last_id = $(".content-home:last").attr("id");
					loadMore(last_id);
				}
			});

			function loadMore(last_id){
				var website = window.location.origin;
				$.ajax({
					url: website + '/includes/infinite-global.php?last_id=' + last_id,
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
<?php } ?>
<?php // Manque potentiellement deux fermetures de div // ?>