<?php
	
	session_start();

	include "connect.php";

	$username = $_POST["username"];
	$password = $_POST["password"];

	//var_dump($_POST);

	$query = mysql_query("SELECT * FROM users WHERE username='$username'") or die("Incorrect credentials.");
	$info = mysql_fetch_array($query) or die("Incorrect credentials.");

	$correct_password = $info["password"];
	$id = $info["id"];

	if ($password == $correct_password)
	{
		$_SESSION["logged_in"] = true;
		header("location: /admin.php");
	}
	else
	{
		$_SESSION["logged_in"] = false;
		header("location: ?authenticated=false");
	}

?>