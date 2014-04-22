<?php

	include("helper.php");
	$errors = array();
	$goToNextStep = false;
	
	if (isset($_POST['url'])) {
		$url = $_POST['url'];
		$email = $_POST['email'];
		$vat = $_POST['vat'];
		
		$_SESSION['url'] = $url;
		
		$db = mysql_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass']) or die("Database error");;
		mysql_select_db($_SESSION['db_name'], $db);
		
		

		$query = mysql_query("UPDATE payment SET notifyUrl='" . $url . "/notify', url='" . $url . "', email='" . $email . "', vat='" . $vat . "' WHERE id=1");
		
		if (mysql_error($db)) {
			$error = mysql_error($db);
		} else {
			$goToNextStep = true;
		}
	}

	// show error
	include("templates/settings.php");