<?php
	
	session_start();

	if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
	{
		header("location: /admin.php");
	}
	else
	{
		echo file_get_contents("login.html");
	}
	
?>