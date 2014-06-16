<?php
	
	session_start();

	if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
	{
		echo file_get_contents("admin.html");
	}
	else
	{
		header("location: /index.php");
	}
	
?>