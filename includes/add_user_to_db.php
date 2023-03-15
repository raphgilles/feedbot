<?php
include('../config.php');
$current_date = time();

// On vérifie si l'utilisateur existe dans la base de donnée
$user_query = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM users WHERE username = '$akainstance'"));
$user_db_username = $user_query['username'];

// Si l'utilisateur n'existe pas, on l'ajoute 
if($user_db_username == "") {
	$sql = "INSERT INTO users (username) values ('$akainstance')";
	mysqli_query($conn, $sql);
	$id_user_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM users ORDER BY id DESC LIMIT 1"));
	$id_user = $id_user_query['id'];
	$username = $id_user_query['username'];
	if ($username == $admin) {
		$sql = "UPDATE users SET admin = ('1') WHERE id = '$id_user'";
		mysqli_query($conn, $sql);
	}

	$sql = "UPDATE users SET joined_date = '$current_date' WHERE id = '$id_user'";
	mysqli_query($conn, $sql);

	$sql = "UPDATE users SET last_activity = '$current_date' WHERE id = '$id_user'";
	mysqli_query($conn, $sql);
}

// Si l'utilisateur existe, on récupère son id
else {
	$sql = "SELECT * FROM users WHERE username = '$akainstance'";
	$result = mysqli_query($conn, $sql);
	foreach($result as $row) {
		$id_user = $row['id'];
	}
	$sql = "UPDATE users SET last_activity = '$current_date' WHERE username = '$akainstance'";
	mysqli_query($conn, $sql);
}
?>
