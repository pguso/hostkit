<?php
	session_start();
    error_reporting(0);
	require("config/config.php");
	
	// show current step
	$nextStep = "introduction";
	if (isset($_POST['nextStep']))
		$nextStep = $_POST['nextStep'];
	
	
	// define vars
	$step = $nextStep;
	$header = $config['header'];
	$product = $introduction["product"];
	
	include("templates/header.php");
	include($nextStep.".php");
	include("templates/footer.php");
	