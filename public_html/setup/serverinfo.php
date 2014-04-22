<?php 

include_once 'ServiceClass.php';  

if($_POST['ip'] != '') {
	$ip = $_POST['ip'];
	$user = $_POST['user'];
	$password = $_POST['password'];
	
	$service = new ServiceClass($ip, $user, $password); 
	
	header("location: create.php");
}

?>