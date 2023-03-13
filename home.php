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
		<i class="fa fa-home" aria-hidden="true"></i> <?= HOME ?>
	</div>

<?php if ($totalfeeds > "0") { ?>
	<div class="story_contenair">	
<?php include('./template-parts/widget-stories-subscriptions.php'); ?>
	</div>
<?php } ?>


		<div class="widget-home" style="display: unset;">
<?php include('./template-parts/widget-welcome.php'); ?>
<?php include('./template-parts/widget-suggestions.php'); ?>
<?php include('./template-parts/widget-shares.php'); ?>
<?php include('./template-parts/widget-funding.php'); ?>
<?php include('./template-parts/footer.php'); ?>
		</div>

		<div>

<?php if ($totalfeeds == "0") { ?>
<?php include('./template-parts/new-users.php'); ?>
<?php } ?>

<?php
$actualtime = time();
$sql = "SELECT * FROM articles_published WHERE uid = '$user' AND is_published = '1' AND published_date < $actualtime ORDER BY published_date DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
include('./template-parts/home-timeline.php');
include('./template-parts/autopromo.php');
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
				$.ajax({
					url: '<?=WEBSITE_URL;?>/includes/infinite-home.php?last_id=' + last_id,
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