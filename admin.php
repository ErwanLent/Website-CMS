<?php
	include "php/connect.php";

	session_start();

	$page = "";

	if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
	{
		// Get template html
		$template = file_get_contents("admin.html");
		$inner_content = "";

		if (isset($_GET["page"]))
		{
			$page = $_GET["page"];
		}
		else
		{
			$page = "home";
		}

		// Get all pages in side bar
        $sqlCommand = "SELECT `Title` FROM `pages`";
		$result = mysql_query($sqlCommand);
      	$all_pages = "";
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$all_pages .= "<li class=\"active\"><a href=\"?page=".urlencode($row[0])."\">".$row[0]."</a></li>";
		}

		$template = str_replace("<%PAGES%>", $all_pages, $template);

		switch ($page) 
		{
		    case "home":
		        $inner_template = file_get_contents("home.html");
		        $controls = file_get_contents("home_controls.html");

		        // Update template with controls
		        $template = str_replace("<%CONTROLS%>", $controls, $template);

		        // Pull first title
				$first_title_query = mysql_query("SELECT `content` FROM `home_page` WHERE `name` = 'title_one'");
				$first_title_array = mysql_fetch_array($first_title_query);

				$first_title = $first_title_array["content"];

				// Pull second title
				$second_title_query = mysql_query("SELECT `content` FROM `home_page` WHERE `name` = 'title_two'");
				$second_title_array = mysql_fetch_array($second_title_query);

				$second_title = $second_title_array["content"];

				// Pull first content
				$first_content_query = mysql_query("SELECT `content` FROM `home_page` WHERE `name` = 'content_one'");
				$first_content_array = mysql_fetch_array($first_content_query);

				$first_content = $first_content_array["content"];

				// Pull second content
				$second_content_query = mysql_query("SELECT `content` FROM `home_page` WHERE `name` = 'content_two'");
				$second_content_array = mysql_fetch_array($second_content_query);

				$second_content = $second_content_array["content"];

				// Update content
		        $inner_content = str_replace("<%FIRST_TITLE%>", $first_title, $inner_template);
		        $inner_content = str_replace("<%SECOND_TITLE%>", $second_title, $inner_content);
		        $inner_content = str_replace("<%FIRST_CONTENT%>", $first_content, $inner_content);
		        $inner_content = str_replace("<%SECOND_CONTENT%>", $second_content, $inner_content);

		        break;
		    case "media":
		        $inner_template = file_get_contents("media.html");
		       	$controls = file_get_contents("home_controls.html");

		        // Update template with controls
		        $template = str_replace("<%CONTROLS%>", $controls, $template);

		        // Pull first title
				$first_title_query = mysql_query("SELECT `content` FROM `media_page` WHERE `name` = 'title_one'");
				$first_title_array = mysql_fetch_array($first_title_query);

				$first_title = $first_title_array["content"];

				// Pull first content
				$first_content_query = mysql_query("SELECT `content` FROM `media_page` WHERE `name` = 'content_one'");
				$first_content_array = mysql_fetch_array($first_content_query);

				$first_content = $first_content_array["content"];

				// Update content
		        $inner_content = str_replace("<%FIRST_TITLE%>", $first_title, $inner_template);
		        $inner_content = str_replace("<%FIRST_CONTENT%>", $first_content, $inner_content);
	
		        break;
		    case "new":
		    	$inner_content = file_get_contents("new_page.html");
		       	$controls = file_get_contents("new_controls.html");

		        // Update template with controls
		        $template = str_replace("<%CONTROLS%>", $controls, $template);
		    	break;
		    default:
		    	$inner_template = file_get_contents("custom.html");
		    	$controls = file_get_contents("custom_controls.html");

		        // Update template with controls
		        $controls = str_replace("<%PAGE%>", urlencode($page), $controls);
		        $template = str_replace("<%CONTROLS%>", $controls, $template);

		    	// Get content of page
				$page_content_query = mysql_query("SELECT `Content` FROM `pages` WHERE `Title` = '$page'");
				$page_content_array = mysql_fetch_array($page_content_query);

				$content = $page_content_array["Content"];
				
				// Update content
				$inner_content = str_replace("<%NAME%>", $page, $inner_template);
		        $inner_content = str_replace("<%FIRST_CONTENT%>", $content, $inner_content);
		        
       			break;
		}

		$output = str_replace("<%CONTENT%>", $inner_content, $template);
		echo $output;
	}
	else
	{
		header("location: /index.php");
	}
?>