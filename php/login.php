<?php
	session_start();

	include "connect.php";

	$username = mysql_real_escape_string($_POST["username"]);
	$password = mysql_real_escape_string($_POST["password"]);

	$salt = "d0be2dc421be4fcd0172e5afceea3970e2f3d940";

	try
	{
		$query = mysql_query("SELECT * FROM users WHERE username='$username'");
		$info = mysql_fetch_array($query);

		$correct_password = $info["password"];
		$id = $info["id"];

		if (sha1($salt.$password) == $correct_password)
		{
			$_SESSION["logged_in"] = true;
			header("location: /admin.php");
		}
		else
		{
			$_SESSION["logged_in"] = false;
			header("location: /index.php?authenticated=false");
		}
	}
	catch (Exception $e)
	{
		$_SESSION["logged_in"] = false;
		header("location: /index.php?authenticated=false");
	}
?>