<?php
	define('WEBSITE_NAME', 'Feedbot');
	include('./assets/lang/lang.php');
	include('./includes/functions.php');
	$page = cq($_GET['page']);

	if($page == ""){
		$npage = "1";
	}
	else{
		$npage = $page;
	}
?>

<?php
if($page != "4"){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=I_TITLE;?></title>
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0,user-scalable=no, shrink-to-fit=yes" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
	<link rel="stylesheet" href="./assets/colors-dark.css">
	<link rel="stylesheet" href="./assets/style.css">
	<script src="./assets/jquery-3.6.3.min.js"></script>
	<style type="text/css">
		/* Style de l'installateur */
		html {
			position: relative;
			height: auto;
			width: auto;
			padding: 0;
			margin: 0;
		}

		body {
			position: absolute;
			width: 100vw;
			height: 100vh;
			overflow-y: scroll;
			overflow-x: hidden;
			margin: 0;
			padding: 0;
			top: 0;
		}

		.first-box {
			position: relative;
			top: 50%;
			transform: translateY(-50%);
			padding:40px;
			border-radius:12px;
			background-color: var(--feedbot-content-background);
		}

		.first-box img {
			display: block;
			width: 200px;
			filter: invert(1);
			margin: auto;
		}

		.first-box h3 {
			text-align: center;
			color: var(--feedbot-title);
			margin-top: 15px;
			margin-bottom: 35px; 
		}

		@media screen and (max-width: 1080px) {
			.first-box {
				margin: auto 1%;
			}
		}
		@media screen and (min-width: 1081px) {
			.first-box {
				margin: auto 10%;
			}
		}
	</style>
</head>
<body>

<div class="first-box">
	<img src="./assets/icons/logomail.png">
	<h3><?=I_H3_TITLE;?><br><?=$npage;?>/3</h3>

<?php
}
else{
	include('./youpi.php');
}

if($page == "" || $page == 1){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
		$website_url = "https://";
	}
	else{
		$website_url = "http://";   
	}

	$subfolder = $_SERVER['PHP_SELF'];
	$subfolder = str_replace("/install.php", "", $subfolder);

	if($subfolder == "/"){
		$subfolder = "";
	}

	$website_url .= $_SERVER['HTTP_HOST'].$subfolder;
}

if($page == 2){
	$dir  = __DIR__;
	$perm = substr(sprintf('%o', fileperms(''.$dir.'')), -4);

	if($perm != "0777"){
		echo "<div align=\"center\"><h3 style=\"color: white;\">".I_ADMIN_RIGHTS." (<i>".__DIR__."</i>)</h3></div></div></body></html>";
		exit();
	}

	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
		$website_url = "https://";
	}
	else{
		$website_url = "http://";   
	}

	$subfolder = $_SERVER['PHP_SELF'];
	$subfolder = str_replace("/install.php", "", $subfolder);

	if($subfolder == "/"){
		$subfolder = "";
	}

	$website_url .= $_SERVER['HTTP_HOST'].$subfolder;

	$akaadmin = cq($_POST['akaadmin']);
	$dbhost = cq($_POST['dbhost']);
	$dbuser = cq($_POST['dbuser']);
	$dbname = cq($_POST['dbname']);
	$dbpassword = cq($_POST['dbpassword']);
	$salt = md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true));
	$pepper = md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true));
	$website_name = "Feedbot";

	// On vérifie l'aka de l'admin

	$akaadmin = trim($akaadmin);
	$exploder = explode('@', $akaadmin);

	if($exploder[0] == ""){
		$aka = $exploder[1];
		$theDomain = $exploder[2];
	}
	else{
		$aka = $exploder[0];
		$theDomain = $exploder[1];
	}

	$aka = strtolower($aka); // À vérifier si ça ne pose pas de problème
	$theDomain = strtolower($theDomain);
	$akaadmin = "@".$aka."@".$theDomain."";
	$akalink = "https://".$theDomain."/@".$aka."";
	$xch = curl_init($akalink);
	curl_setopt($xch, CURLOPT_HEADER, true);    // we want headers
	curl_setopt($xch, CURLOPT_NOBODY, true);    // we don't need body
	curl_setopt($xch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($xch, CURLOPT_TIMEOUT,10);
	$xoutput = curl_exec($xch);
	$xhttpcode = curl_getinfo($xch, CURLINFO_HTTP_CODE);
	curl_close($xch);

	if($xhttpcode != 200){
		header('location: ./install.php?page=1&erraka=yes&');
		exit();
	}

	// On vérifie la connexion à la base de donnée
	$cnx = new mysqli(''.$dbhost.'', ''.$dbuser.'', ''.$dbpassword.'');

	if($cnx->connect_error){
		// S'il y a une erreur à cette étape, c'est que le HOST ou le PASSWORD sont erronés
		echo "<div align=\"center\"><h3 style=\"color:red;\">".I_DB_ACCESS_DEN."</h3></div></div></body></html>";
		exit();
	}

	// Si la table n'a pas été créer par l'admin, alors on la créer
	if(!$cnx->query("CREATE DATABASE IF NOT EXISTS ".$dbname."")){
		// Si la base ne veut pas se créer :
		echo "<div align=\"center\"><h3 style=\"color:white;\">".I_CREATE_DB_FAILED." (<i>".$dbname."</i>)</h3></div></div></body></html>";
		exit();
	}
	mysqli_close($cnx);

	$config = "<?php\n";
	$config .= "// Basics\ndefine('WEBSITE_NAME', '".$website_name."');\n";
	$config .= "define('WEBSITE_URL', '".$website_url."');\ndefine('WEBSITE_URI', '".$dir."/');\n\n";
	$config .= "// Links\ndefine('HOME_PAGE', WEBSITE_URL.'/');\n";
	$config .= "define('GLOBAL_PAGE', WEBSITE_URL.'/?p=global');\ndefine('BOOKMARKS_PAGE', WEBSITE_URL.'/?p=bookmarks');\ndefine('ADD_FEED_PAGE', WEBSITE_URL.'/?p=add');\ndefine('YOUR_FEEDS_PAGE', WEBSITE_URL.'/?p=feeds');\ndefine('STATUSES_PAGE', WEBSITE_URL.'/?p=shares');\ndefine('PUBLISH_PAGE', WEBSITE_URL.'/?p=publish');\ndefine('SETTINGS_PAGE', WEBSITE_URL.'/?p=settings');\n\ninclude_once(WEBSITE_URI.'assets/lang/lang.php');\n\n";
	$config .= "\$admin = '".$akaadmin."';\n";
	$config .= "//DB Params\n\$servername = '".$dbhost."';\n";
	$config .= "\$username = '".$dbuser."';\n";
	$config .= "\$password = '".$dbpassword."';\n";
	$config .= "\$dbname = '".$dbname."';\n";
	$config .= "\$conn = new mysqli(\$servername, \$username, \$password, \$dbname);\n\n";
	$config .= "//Users security\n";
	$config .= "\$salt = '".$salt."';\n";
	$config .= "\$pepper = '".$pepper."';\n";
	$config .= "?>";

	file_put_contents(__DIR__.'/config.php', $config);

	include(__DIR__.'/config.php');
}

if($page == 3){
	include('./config.php');
	$dbfile = cq($_POST['dbfile']);
	$instance_url = urlencode(WEBSITE_URL);
	$url = "https://manager.feedbot.net/instances_listing.php?url=".$instance_url;

	$xch = curl_init($url);
	curl_setopt($xch, CURLOPT_HEADER, true);    // we want headers
	curl_setopt($xch, CURLOPT_NOBODY, true);    // we don't need body
	curl_setopt($xch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($xch, CURLOPT_TIMEOUT,10);
	curl_exec($xch);
	curl_close($xch);
}

$theme = $_COOKIE['theme'];

if($theme == ""){
	$theme = "dark";
}

?>

<?php
if($page == "" || $page == 1){
	if(cq($_GET['erraka']) == "yes"){
		echo "<div align=\"center\"><p>".I_ERRAKA."</p><br></div>";
	}
?>
	<form action="install.php?page=2" method="POST" style="max-width:400px; text-align:left; align-items:initial; margin:auto;">
		<input type="text" name="akaadmin" placeholder="<?=I_ADMIN;?>" required>
		<div align="center"><i class="fa fa-minus" aria-hidden="true"></i></div>
		<input type="text" name="dbname" placeholder="<?=I_DB_NAME;?>" required>
		<input type="text" name="dbhost" placeholder="<?=I_DB_HOST;?>" required>
		<input type="text" name="dbuser" placeholder="<?=I_DB_USER;?>" required>
		<input type="password" name="dbpassword" placeholder="<?=I_DB_PWD;?>" required>
		<button type="submit"><?=NEXT;?> <i aria-hidden="true" class="fa fa-caret-right fa-fw"></i></button>
	</form>

	<p style="margin-top:20px; font-style: italic; text-align:center;"><?=I_WURL;?> <?=$website_url;?></p>

<?php
}
elseif($page == 2){
	if($conn->connect_error){
		die("".DB_FAILED."" . $conn->connect_error);
	}
	else{
?>
	<p style="text-align: center; font-size: large;"><?=I_DB_OK;?></p>
	<p style="text-align: center;">
		<i class="fa fa-caret-down fa-fw" aria-hidden="true"></i>
		<br>
		<i aria-hidden="true" class="fa fa-database fa-lg fa-fw"></i>
		<?=I_DB_OK_2;?>
		<br>
		<br>
	</p>
	<form action="install.php?page=3" method="POST" style="margin:auto;">
		<input type="hidden" name="dbfile" value="feedbot.sql">
		<button type="submit"><?=NEXT;?> <i aria-hidden="true" class="fa fa-caret-right fa-fw"></i></button>
	</form>
<?php
	}
} 
elseif($page == 3){
	$sql = file_get_contents($dbfile);
	$conn->multi_query($sql);

	echo "<p style=\"text-align:center;\">".I_FINISH."<br><br><span style=\"font-size: large;\"><i class=\"fa fa-spinner fa-pulse fa-fw\"></i> ".I_AUTO_REDIR."</span></p>";
?>
	<script type="text/javascript">
		setTimeout(function(){
			window.location.href = "install.php?page=4";
		}, 4000);
	</script>
<?php
}
elseif($page == 4){
	unlink('install.php');
	unlink('feedbot.sql');
	unlink('youpi.php');
}
?>
</div>

</body>
</html>