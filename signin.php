<?php
session_start();
if(htmlspecialchars($_SESSION['uid']) == ""){
  if(htmlspecialchars($_COOKIE['akainstance']) != ""){
    header('location: ./includes/index_cnx.php?i='.htmlspecialchars($_COOKIE['akainstance']).'&cookieaccept=on');
  }
  else{
    header('location: '.WEBSITE_URL.'/index.php?p=signin');
  }
}

if(isset($_GET['error'])){
  $error = cq($_GET['error']);
}
else{
  $error = YOU_MUST_SIGNIN.".";
}
?>


<div class="contenair">

<?php if($isconnected == ""){ ?>
	<div class="alert<?php if(isset($_GET['error'])){?>-orange<?php } ?>">
		<span><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i></span>
		<span style="margin-left: 14px;"><?=$error;?></span>
	</div>
<?php } ?>

	<div class="title">
		<i class="fa fa-sign-in" aria-hidden="true"></i> <?=SIGNIN;?>
	</div>
	<div class="content">
        <form action="includes/index_cnx.php" method="GET">
    	    <label for="i"><i class="fa fa-user" aria-hidden="true"></i> <?=YOUR_MASTODON_ACCOUNT;?></label>
        	<input type="text" id="i" name="i" placeholder="<?= EXAMPLE ?> : @johnmastodon@mastoot.fr" required>
		
        	<button type="submit">
        		<span><i class="fa fa-mastodon fa-2x" aria-hidden="true" style="vertical-align: middle;"></i></span>
        		<span style="vertical-align: middle; margin-left: 10px;"><?=SIGNIN;?></span>
        	</button>

                <div style="margin-top:25px;">
                <!-- Ajout du checkbox pour les cookies -->
                <label for="cookieaccept" class="cookies">
                <input type="checkbox" role="switch" id="cookieaccept" name="cookieaccept" style="margin-right: 20px;" checked>
                <span class="cookiestext"><?=COOKIETEXT;?></span>
                </label>
                </div>
        </form>
	</div>

  <div class="content" style="padding-left: 5px; padding-right: 5px; margin-top: 20px; text-align: center;">
        <?=NEED_MASTODON_ACCOUNT;?> <?=WEBSITE_NAME;?>.<br />
        <?=DONT_HAVE_MASTODON;?> <a href="https://joinmastodon.org/" target="_blank"><?=CREATE_MASTODON_ACCOUNT;?></a>.
  </div>

  <?php include('./template-parts/footer.php'); ?>

</div>