<?php
include('./includes/functions.php');


$page = cq($_GET['page']);

if ($page == "") {
$salt = md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true));
$pepper = md5(uniqid(rand(), true))."-".md5(uniqid(rand(), true));
}

if ($page == 2) {
$dbhost = cq($_POST['dbhost']);
$dbuser = cq($_POST['dbuser']);
$dbname = cq($_POST['dbname']);
$dbpassword = cq($_POST['dbpassword']);
$salt = cq($_POST['salt']);
$pepper = cq($_POST['pepper']);
$website_name = cq($_POST['website_name']);
$website_url = cq($_POST['website_url']);

$config_file = fopen('config.php', 'c+b');
$config = "<?php\n";
$config .= "// Basics\ndefine('WEBSITE_NAME', '".$website_name."');\n";
$config .= "define('WEBSITE_URL', '".$website_url."');\n\n";
$config .= "// Links\ndefine('HOME_PAGE', WEBSITE_URL.'/');\n";
$config .= "define('GLOBAL_PAGE', WEBSITE_URL.'/?p=global');\ndefine('BOOKMARKS_PAGE', WEBSITE_URL.'/?p=bookmarks');\ndefine('ADD_FEED_PAGE', WEBSITE_URL.'/?p=add');\ndefine('YOUR_FEEDS_PAGE', WEBSITE_URL.'/?p=feeds');\ndefine('STATUSES_PAGE', WEBSITE_URL.'/?p=shares');\ndefine('PUBLISH_PAGE', WEBSITE_URL.'/?p=publish');\ndefine('SETTINGS_PAGE', WEBSITE_URL.'/?p=settings');\n\n// Visitor language retrieval\n// Récupération de la langue du visiteur\nrequire_once(\$_SERVER['DOCUMENT_ROOT'].'assets/lang/lang.php');\n\n";
$config .= "//DB Params\n\$servername = '".$dbhost."';\n";
$config .= "\$username = '".$dbuser."';\n";
$config .= "\$password = '".$dbpassword."';\n";
$config .= "\$dbname = '".$dbname."';\n";
$config .= "\$conn = new mysqli(\$servername, \$username, \$password, \$dbname);\n\n";
$config .= "//Users security\n";
$config .= "\$salt = '".$salt."';\n";
$config .= "\$pepper = '".$pepper."';\n";
$config .= "?>";

fwrite($config_file, $config);

include('./config.php');
}

if ($page == 3) {
include('./config.php');
$dbfile = cq($_POST['dbfile']);
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
$website_url = "https://";
}
else {
$website_url = "http://";   
}
$website_url .= $_SERVER['HTTP_HOST'];

$theme = $_COOKIE['theme'];
if ($theme == "") {$theme = "dark"; }
?>

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

<?php if ($page == "") { ?>
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

<?php }

elseif ($page == 2) { 

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
else {
echo "<p style=\"text-align:center;\">Database connection successful.</p>"; ?>
<form action="install.php?page=3" method="POST" style="margin:auto;">
	<input type="hidden" name="dbfile" value="feedbot.sql">
	<button type="submit">Importer les données</button>
</form>
<?php
}
} 

elseif ($page == 3) {
$sql = file_get_contents($dbfile);
$conn->multi_query($sql);
echo "<p style=\"text-align:center;\">The database has been successfully created. Installation is complete!</p>";
unlink('install.php');
unlink('feedbot.sql'); ?>
<script type="text/javascript">
	setTimeout(
  function() 
  {
    window.location.href = "<?=WEBSITE_URL;?>";
  }, 4000);
</script>
<?php
}
?>
</div>

</body>
</html>