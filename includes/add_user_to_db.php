<?php
include('../config.php');


// On vérifie si l'utilisateur existe dans la base de donnée
$user_query = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM users WHERE username = '$akainstance'"));
$user_db_username = $user_query['username'];

// Si l'utilisateur n'existe pas, on l'ajoute 
if($user_db_username == "") {
$sql = "INSERT INTO users (username) values ('$akainstance')";
	mysqli_query($conn, $sql);
	$id_user_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM users ORDER BY id DESC LIMIT 1"));
	$id_user = $id_user_query['id'];
}

// Si l'utilisateur existe, on récupère son id
else {
	$id_user_query =  mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM users WHERE username = '$akainstance'"));
	$id_user = $id_user_query['id'];
}
?>