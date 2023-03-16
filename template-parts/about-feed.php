<?php

$wiki_feed_name = str_replace(" ", '_', $feed_name);
$wiki_feed_name = urlencode($wiki_feed_name);

if($wiki_slug == NULL){
	$about = getWIKI($lang, $wiki_feed_name);
}
else{
	$about = getWIKI($lang, $wiki_slug);
}

if($about !== NULL && $about !== ""){
	$caracters_counter = strlen($about);
?>

<div class="widget-home-content about" style="margin-bottom:20px;">
	<h4 style="color:var(--feedbot-title);">
		<i class="fa fa-info-circle" aria-hidden="true" style="margin-right:6px;"></i> <?=ABOUT;?>
	</h4>
	<div <?php if ($caracters_counter > "400") { ?>class="description-short"<?php } ?> style="margin-top:20px;" id="about">
		<span style="word-break: break-word; white-space: pre-line;"><?=$about;?></span>
	</div>
<?php if ($caracters_counter > "400") { ?>
	<div id="read-more-about" style="width:100%; font-weight:bold; text-align:center; margin-top:10px; cursor:pointer;">
		<?=READ_MORE;?>
	</div>
<?php } ?>
	<div style="margin-top:20px;">
		<p style="text-align:right;">Source : <a href="https://<?=$lang;?>.wikipedia.org/wiki/<?=$wiki_feed_name;?>" target="_blank">Wikipedia</a></p>
	</div>
</div>

<?php if ($caracters_counter > "400") { ?>
<script type="text/javascript">
	function expand_about(){
		document.getElementById('about').classList.remove('description-short');
		document.getElementById('read-more-about').style.display = 'none';
	}

	document.getElementById('read-more-about').addEventListener('click', expand_about);
	// Est-ce que le jQuery est appelé avant ? // Si oui, à écrire en jQuery
</script>
<?php
	}
}
?>