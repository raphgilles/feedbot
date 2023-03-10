<div class="contenair">
<?php if ($_GET['m'] == 'success') { ?>
	<div class="alert-green">
		<span><i class="fa fa-check" aria-hidden="true"></i></span> <span style="margin-left: 14px;"> <?=SUCCESS_FEED;?></span>
	</div>
<?php } ?>
<?php if ($_GET['m'] == 'failed') { ?>
	<div class="alert-orange">
		<span><i class="fa fa-exclamation" aria-hidden="true"></i></span> <span style="margin-left: 14px;"> <?=FAILED_FEED;?></span>
	</div>
<?php } ?>
<?php if ($_GET['m'] == 'incompatible') { ?>
	<div class="alert-orange">
		<span><i class="fa fa-exclamation" aria-hidden="true"></i></span> <span style="margin-left: 14px;"> Ce flux n'est pas pris en charge par <?=WEBSITE_NAME;?>.</span>
	</div>
<?php } ?>

	<div class="title"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?=ADD_RSS_FEED;?></div>
	<div class="content">
        <form action="includes/addrss.php" method="post">
    	    <label for="flux"><?=FEED_URL;?></label>
        	<input type="url" id="flux" name="flux" placeholder="" required>
	        <input type="hidden" id="uid" name="uid" value="<?=$user;?>" required>
    	    <input type="hidden" id="feed_id" name="feed_id" value="<?=$row['id'];?>">
	        <button type="submit"><?=ADD;?></button>
        </form>
	</div>
</div>