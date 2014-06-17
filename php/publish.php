<?php
	include "connect.php";

	session_start();

	$page = mysql_real_escape_string($_POST["page"]);

	switch($page)
	{
		case "home":
			// Homepage updated content
			$first_title = mysql_real_escape_string($_POST["firstTitle"]);
			$second_title = mysql_real_escape_string($_POST["secondTitle"]);
			$first_content = mysql_real_escape_string($_POST["firstContent"]);
			$second_content = mysql_real_escape_string($_POST["secondContent"]);

			// Update db content
			mysql_query("UPDATE `home_page` SET `content`='$first_title' WHERE `name`='title_one'");
			mysql_query("UPDATE `home_page` SET `content`='$second_title' WHERE `name`='title_two'");
			mysql_query("UPDATE `home_page` SET `content`='$first_content' WHERE `name`='content_one'");
			mysql_query("UPDATE `home_page` SET `content`='$second_content' WHERE `name`='content_two'");

			echo "true";

			break;
		case "media":
			break;
		default:
			break;
	}


?>