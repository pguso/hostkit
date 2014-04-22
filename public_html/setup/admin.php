<?php

	include("helper.php");
	$errors = array();
	$goToNextStep = false;
	
	if (isset($_POST['user'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		/*$db = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']) or die("Database error");;
		mysql_select_db($_SESSION['db_name'], $db);
		
		$salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

		$query = mysql_query("UPDATE user SET username='" . $user . "', salt='" . $salt . "', username_canonical='" . $user . "', password='" . $pass . "' WHERE id=1");
		*/
		$output = shell_exec('php app/console fos:user:create ' . $user . ' test@example.com ' . $pass);
		if (mysql_error($db)) {
			$error = mysql_error($db);
		} else {
			$goToNextStep = true;
		}
	}

	// show error
	include("templates/admin.php");