<?php
	include "connect.php";

	session_start();

	$page = urldecode(mysql_real_escape_string($_POST["page"]));

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
			// Media assets updated content
			$first_title = mysql_real_escape_string($_POST["firstTitle"]);
			$first_content = mysql_real_escape_string($_POST["firstContent"]);

			// Update db content
			mysql_query("UPDATE `media_page` SET `content`='$first_title' WHERE `name`='title_one'");
			mysql_query("UPDATE `media_page` SET `content`='$first_content' WHERE `name`='content_one'");

			echo "true";
			break;
		case "new":
			// New page content
			$new_title = mysql_real_escape_string($_POST["newTitle"]);
			$new_content = mysql_real_escape_string($_POST["newContent"]);

			// Update db content
			mysql_query("INSERT INTO `shoutout_cms`.`pages` (`Title`, `Content`) VALUES ('$new_title', '$new_content');");

			echo "true";

			break;
		case "delete":
			// Page name to delete
			$page_title = urldecode(mysql_real_escape_string($_POST["pageTitle"]));

			// Delete page in db
			mysql_query("DELETE FROM `pages` WHERE `Title` = '$page_title'");

			echo "true";

			break;
		default:
			// Updated content
			$updated_content = mysql_real_escape_string($_POST["updatedContent"]);

			// Update db content
			mysql_query("UPDATE `pages` SET `Content`='$updated_content' WHERE `Title` = '$page'");

			echo "true";

			break;
	}


?>