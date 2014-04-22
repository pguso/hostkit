<?php 
/*
 * Copyright (c) 2013 Patric Gutersohn
 * http://www.ladensia.com
 *
 */
session_start();

include_once 'ServiceClass.php'; 
 
$service = new ServiceClass($_SESSION['ip'], $_SESSION['user'], $_SESSION['password']); 

$package = array($_REQUEST['plans'], $_REQUEST['planm'], $_REQUEST['planl'], $_REQUEST['planxl'], $_REQUEST['planxxl']);

$i = 0;
$response = array();

$packages = $service->listPackages(); 

if($_REQUEST['plans'] == 0) {
	$response[] = array( 's' => $packages->package[0]);
} else if($_REQUEST['plans'] == 1) {
	$response[] = array( 's' => $packages->package[1]);
} else if($_REQUEST['plans'] == 2) {
	$response[] = array( 's' => $packages->package[2]);
} else if($_REQUEST['plans'] == 3) {
	$response[] = array( 's' => $packages->package[3]);
} else if($_REQUEST['plans'] == 4) {
	$response[] = array( 's' => $packages->package[4]);
} else if($_REQUEST['plans'] == 5) {
	$response[] = array( 's' => $packages->package[5]);
} else if($_REQUEST['plans'] == 6) {
	$response[] = array( 's' => $packages->package[6]);
} else if($_REQUEST['plans'] == 7) {
	$response[] = array( 's' => $packages->package[7]);
} else if($_REQUEST['plans'] == 8) {
	$response[] = array( 's' => $packages->package[8]);
} else if($_REQUEST['plans'] == 9) {
	$response[] = array( 's' => $packages->package[9]);
}

if($_REQUEST['planm'] == 0) {
	$response[] = array( 'm' => $packages->package[0]);
} else if($_REQUEST['planm'] == 1) {
	$response[] = array( 'm' => $packages->package[1]);
} else if($_REQUEST['planm'] == 2) {
	$response[] = array( 'm' => $packages->package[2]);
} else if($_REQUEST['planm'] == 3) {
	$response[] = array( 'm' => $packages->package[3]);
} else if($_REQUEST['planm'] == 4) {
	$response[] = array( 'm' => $packages->package[4]);
} else if($_REQUEST['planm'] == 5) {
	$response[] = array( 'm' => $packages->package[5]);
} else if($_REQUEST['planm'] == 6) {
	$response[] = array( 'm' => $packages->package[6]);
} else if($_REQUEST['planm'] == 7) {
	$response[] = array( 'm' => $packages->package[7]);
} else if($_REQUEST['planm'] == 8) {
	$response[] = array( 'm' => $packages->package[8]);
} else if($_REQUEST['planm'] == 9) {
	$response[] = array( 'm' => $packages->package[9]);
}

if($_REQUEST['planl'] == 0) {
	$response[] = array( 'l' => $packages->package[0]);
} else if($_REQUEST['planl'] == 1) {
	$response[] = array( 'l' => $packages->package[1]);
} else if($_REQUEST['planl'] == 2) {
	$response[] = array( 'l' => $packages->package[2]);
} else if($_REQUEST['planl'] == 3) {
	$response[] = array( 'l' => $packages->package[3]);
} else if($_REQUEST['planl'] == 4) {
	$response[] = array( 'l' => $packages->package[4]);
} else if($_REQUEST['planl'] == 5) {
	$response[] = array( 'l' => $packages->package[5]);
} else if($_REQUEST['planl'] == 6) {
	$response[] = array( 'l' => $packages->package[6]);
} else if($_REQUEST['planl'] == 7) {
	$response[] = array( 'l' => $packages->package[7]);
} else if($_REQUEST['planl'] == 8) {
	$response[] = array( 'l' => $packages->package[8]);
} else if($_REQUEST['planl'] == 9) {
	$response[] = array( 'l' => $packages->package[9]);
}

if($_REQUEST['planxl'] == 0) {
	$response[] = array( 'xl' => $packages->package[0]);
} else if($_REQUEST['planxl'] == 1) {
	$response[] = array( 'xl' => $packages->package[1]);
} else if($_REQUEST['planxl'] == 2) {
	$response[] = array( 'xl' => $packages->package[2]);
} else if($_REQUEST['planxl'] == 3) {
	$response[] = array( 'xl' => $packages->package[3]);
} else if($_REQUEST['planxl'] == 4) {
	$response[] = array( 'xl' => $packages->package[4]);
} else if($_REQUEST['planxl'] == 5) {
	$response[] = array( 'xl' => $packages->package[5]);
} else if($_REQUEST['planxl'] == 6) {
	$response[] = array( 'xl' => $packages->package[6]);
} else if($_REQUEST['planxl'] == 7) {
	$response[] = array( 'xl' => $packages->package[7]);
} else if($_REQUEST['planxl'] == 8) {
	$response[] = array( 'xl' => $packages->package[8]);
} else if($_REQUEST['planxl'] == 9) {
	$response[] = array( 'xl' => $packages->package[9]);
}

if($_REQUEST['planxxl'] == 0) {
	$response[] = array( 'xxl' => $packages->package[0]);
} else if($_REQUEST['planxxl'] == 1) {
	$response[] = array( 'xxl' => $packages->package[1]);
} else if($_REQUEST['planxxl'] == 2) {
	$response[] = array( 'xxl' => $packages->package[2]);
} else if($_REQUEST['planxxl'] == 3) {
	$response[] = array( 'xxl' => $packages->package[3]);
} else if($_REQUEST['planxxl'] == 4) {
	$response[] = array( 'xxl' => $packages->package[4]);
} else if($_REQUEST['planxxl'] == 5) {
	$response[] = array( 'xxl' => $packages->package[5]);
} else if($_REQUEST['planxxl'] == 6) {
	$response[] = array( 'xxl' => $packages->package[6]);
} else if($_REQUEST['planxxl'] == 7) {
	$response[] = array( 'xxl' => $packages->package[7]);
} else if($_REQUEST['planxxl'] == 8) {
	$response[] = array( 'xxl' => $packages->package[8]);
} else if($_REQUEST['planxxl'] == 9) {
	$response[] = array( 'xxl' => $packages->package[9]);
}


$fp = fopen('results.json', 'w');  
fwrite($fp, json_encode($response)); 
fclose($fp);

?>