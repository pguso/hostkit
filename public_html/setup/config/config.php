<?php
	$config['header'] = "Setup Wizard";
	$config['applicationPath'] = "/";
	$config['database_file'] = "config/database_template.php";
	
	// INTRODUCTION
	$introduction = array();
	$introduction["product"] = "Hostkit Management & Billing Solution";
	$introduction["productVersion"] = "v1.0";
	$introduction["company"] = "Patric Gutersohn";

	// SERVER REQUIREMENTS
	$requirements = array();
	$requirements["phpVersion"] = "5";
	$requirements["extensions"] = array("mysqli", "pdo_mysql", "pdo", "intl", "ctype");

	// FILE PERMISSIONS
	// r = readable, w = writable, x = executable
	$filePermissions = array();
	//$filePermissions["config/import.sql"] = "rw";
	$filePermissions["../../app/cache"] = "rwx";
    $filePermissions["../../app/cache/prod"] = "rwx";
	$filePermissions["../../app/logs"] = "rw";
	//$filePermissions["../../vendor"] = "rw";

	if(is_dir("../../vendor") == false) {
		mkdir("../../vendor", 0755);
	}