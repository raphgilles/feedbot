<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Feedbot Installation</title>
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0,user-scalable=no, shrink-to-fit=yes" />
	<link rel="stylesheet" href="./assets/colors-dark.css">
	<link rel="stylesheet" href="./assets/style.css">
	<script src="./assets/jquery-3.6.3.min.js"></script>
</head>
<body>

<div style="width:90%; max-width:1200px; margin:auto; margin-top:40px; padding:40px; border-radius:12px; background-color: var(--feedbot-content-background);">
	<img src="./assets/icons/logomail.png" style="display:block; width:200px; filter:invert(1); margin:auto;" />
	<h3 style="text-align:center; color:var(--feedbot-title); margin-bottom: 60px;">Installation</h3>

<?php
include('./includes/functions.php');

$page = cq($_GET['page']);

if($page == ""){
	$salt = md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true));
	$pepper = md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true));
}

if($page == 2){
	$dir  = __DIR__;
	$perm = substr(sprintf('%o', fileperms(''.$dir.'')), -4);

	if($perm != "0777"){
		echo "<div align=\"center\"><h3 style=\"color:red;\">Veuillez donner les droits d'accès (777) au dossier principal (<i>".__DIR__."</i>) pour continuer l'installation !</h3></div></div></body></html>";
		exit();
	}

	$dbhost = cq($_POST['dbhost']);
	$dbuser = cq($_POST['dbuser']);
	$dbname = cq($_POST['dbname']);
	$dbpassword = cq($_POST['dbpassword']);
	$salt = cq($_POST['salt']);
	$pepper = cq($_POST['pepper']);
	$website_name = cq($_POST['website_name']);
	$website_url = cq($_POST['website_url']);

	// On vérifie la connexion à la base de donnée
	$cnx = new mysqli(''.$dbhost.'', ''.$dbuser.'', ''.$dbpassword.'');

	if($cnx->connect_error){
		// S'il y a une erreur à cette étape, c'est que le HOST ou le PASSWORD sont erronés
		echo "<div align=\"center\"><h3 style=\"color:red;\">Connexion à la base de donnée impossible, vérifiez votre mot de passe ou votre host.</h3></div></div></body></html>";
		exit();
	}

	// Si la table n'a pas été créer par l'admin, alors on la créer
	if(!$cnx->query("CREATE DATABASE IF NOT EXISTS ".$dbname."")){
		// Si la base ne veut pas se créer :
		echo "<div align=\"center\"><h3 style=\"color:red;\">Création de la base de donnée \"<i>".$dbname."</i>\" a échouée, veuillez la créer manuellement.</h3></div></div></body></html>";
		exit();
	}
	mysqli_close($cnx);

	$config = "<?php\n";
	$config .= "// Basics\ndefine('WEBSITE_NAME', '".$website_name."');\n";
	$config .= "define('WEBSITE_URL', '".$website_url."');\ndefine('WEBSITE_URI', '".$dir."/');\n\n";
	$config .= "// Links\ndefine('HOME_PAGE', WEBSITE_URL.'/');\n";
	$config .= "define('GLOBAL_PAGE', WEBSITE_URL.'/?p=global');\ndefine('BOOKMARKS_PAGE', WEBSITE_URL.'/?p=bookmarks');\ndefine('ADD_FEED_PAGE', WEBSITE_URL.'/?p=add');\ndefine('YOUR_FEEDS_PAGE', WEBSITE_URL.'/?p=feeds');\ndefine('STATUSES_PAGE', WEBSITE_URL.'/?p=shares');\ndefine('PUBLISH_PAGE', WEBSITE_URL.'/?p=publish');\ndefine('SETTINGS_PAGE', WEBSITE_URL.'/?p=settings');\n\ninclude_once(WEBSITE_URI.'assets/lang/lang.php');\n\n";
	$config .= "//DB Params\n\$servername = '".$dbhost."';\n";
	$config .= "\$username = '".$dbuser."';\n";
	$config .= "\$password = '".$dbpassword."';\n";
	$config .= "\$dbname = '".$dbname."';\n";
	$config .= "\$conn = new mysqli(\$servername, \$username, \$password, \$dbname);\n\n";
	$config .= "//Users security\n";
	$config .= "\$salt = '".$salt."';\n";
	$config .= "\$pepper = '".$pepper."';\n\n";
	$config .= "\$telegram_bot = '';\n";
	$config .= "?>";

	file_put_contents(__DIR__.'/config.php', $config);

	include(__DIR__.'/config.php');
}

if($page == 3){
	include('./config.php');
	$dbfile = cq($_POST['dbfile']);
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

$theme = $_COOKIE['theme'];

if($theme == ""){
	$theme = "dark";
}
?>

<?php if($page == ""){ ?>
	<form action="install.php?page=2" method="POST" style="max-width:400px; text-align:left; align-items:initial; margin:auto;">
		<input type="text" name="website_name" placeholder="Website Name" required>
		<input type="text" name="dbhost" placeholder="Database host" required>
		<input type="text" name="dbuser" placeholder="Database user" required>
		<input type="text" name="dbname" placeholder="Database name" required>
		<input type="password" name="dbpassword" placeholder="Database password" required>
		<input type="hidden" name="salt" value="<?=$salt;?>">
		<input type="hidden" name="pepper" value="<?=$pepper;?>">
		<input type="hidden" name="website_url" value="<?=$website_url;?>">
		<button type="submit">Save</button>
	</form>

	<p style="margin-top:20px; font-style: italic; text-align:center;">The url of your website will be the current URL : <?=$website_url;?></p>

<?php
}
elseif($page == 2){
	if($conn->connect_error){
		die("Database connection failed: " . $conn->connect_error);
	}
	else{
?>
	<p style="text-align:center;">Database connection successful.</p>
	<form action="install.php?page=3" method="POST" style="margin:auto;">
		<input type="hidden" name="dbfile" value="feedbot.sql">
		<button type="submit">Importer les données</button>
	</form>
<?php
	}
} 
elseif($page == 3){
	$sql = file_get_contents($dbfile);
	$conn->multi_query($sql);

	chmod('./includes/mastophp/', 0775);
	unlink('install.php');
	unlink('feedbot.sql');

	echo "<p style=\"text-align:center;\">The database has been successfully created. Installation is complete!</p>";
?>
	<script type="text/javascript">
		setTimeout(function(){
			window.location.href = "<?=WEBSITE_URL;?>";
		}, 4000);
	</script>
<?php
}
?>
</div>

</body>
</html>