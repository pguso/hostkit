<?php

	$error = false;
	$goToNextStep = false;
	
	if (isset($_POST['database']))
	{
		$database = $_POST['database'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$host = $_POST['host'];
		
		// check connection
		$connection = @mysql_connect($host, $username, $password);
		if ($connection)
		{
			$error = !mysql_select_db($database, $connection);
			@mysql_close($connestion);
			
			if (!$error)
			{
				// save settings in database config file
				// load template
				$template = file_get_contents("config/database_template.php");
				$template = str_replace("%%host%%", $host, $template);
				$template = str_replace("%%username%%", $username, $template);
				$template = str_replace("%%password%%", $password, $template);
				$template = str_replace("%%database%%", $database, $template);
				
				// write config file
				$dbFile = dirname(getenv('SCRIPT_FILENAME')).$config['applicationPath'].$config['database_file'];
				file_put_contents($dbFile, $template);

				$parameter = file_get_contents(realpath("../../app/config/parameters.yml"));
				$parameter = str_replace("%%host%%", $host, $parameter);
				$parameter = str_replace("%%username%%", $username, $parameter);
				$parameter = str_replace("%%password%%", $password, $parameter);
				$parameter = str_replace("%%database%%", $database, $parameter);
				
				// write config file
				$file = '../../app/config/parameters.yml';
				file_put_contents($file, $parameter);
				
				// save login in session for further use
				$_SESSION['db_host'] = $host;
				$_SESSION['db_user'] = $username;
				$_SESSION['db_pass'] = $password;
				$_SESSION['db_name'] = $database;
				
				// allow user to proceed
				$goToNextStep = true;
			}
			else $error = mysql_error();
		}
		else
			$error = mysql_error();
	}
	else
	{
		if (isset($_SESSION['db_host']))
		{
			$host = $_SESSION['db_host'];
			$username = $_SESSION['db_user'];
			$password = $_SESSION['db_pass'];
			$database = $_SESSION['db_name'];
		}
		else
		{
			$database = "";
			$username = "";
			$password = "";
			$host = "localhost";
		}
	}
		
	include("templates/database.php");