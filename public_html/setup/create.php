<?php 
/*
 * Copyright (c) 2013 Patric Gutersohn
 * http://www.ladensia.com
 *
 */
session_start();
include_once 'ServiceClass.php'; 

if($_POST['ip'] != '') {
	$_SESSION['ip']= $_POST['ip'];
	$_SESSION['user'] = $_POST['user'];
	$_SESSION['password'] = $_POST['password'];
	
	$service = new ServiceClass($_SESSION['ip'], $_SESSION['user'], $_SESSION['password']); 
	
}
 
$packages = $service->listPackages();

$i = 0;
$k = 0;
$y = 0;
$x = 0;
$z = 0;
$max = count($packages);

?>

<!DOCTYPE html>
<html>
<head>
    <title>cPanel Account Creator</title>

    <link href="../css/jquery-ui.custom.min.css" rel="stylesheet" type="text/css"/>
    <link href="../css/jquery-ui-slider-pips.css" rel="stylesheet" type="text/css"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet"/>

    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/jquery-ui-slider-pips.js"></script>
    <script src="../js/chooser.js"></script>

</head>
<body>


<section class="container">
    <div class="login">
        <h1>Create cPanel Account - Paket Chooser</h1>

        <div id="msg" style="display: none"></div>
        <!-- If you wanna integrate the plugin into your site just copy the form bellow and integrate the js and css files into your site -->
		
		<!-- form choose plan start -->
        <form method="post" action="" onsubmit="return false;" class="config">
		</form>
		<!-- form choose plan end -->

        <!-- form choose plan start -->
        <form method="post" action="" onsubmit="return false;" class="chooser">
            <p><label>Plan S </label>
				<select class="plans">
				<?php while($i != $max) { ?>
					<?php foreach($packages->package[$i]->name as $value) { ?>
					<option value="<?php echo $i; ?>"><?php echo $value; ?></option>
					<?php $i++; ?>
					<?php } ?>
				<?php } ?>
				</select>
			</p>
			
			<p><label>Plan M </label>
				<select class="planm">
				<?php while($y != $max) { ?>
					<?php foreach($packages->package[$y]->name as $value) { ?>
					<option value="<?php echo $y; ?>"><?php echo $value; $y++; ?></option>
					<?php } ?>
				<?php } ?>
				</select>
			</p>

            <p><label>Plan L </label>
				<select class="planl">
				<?php while($x != $max) { ?>
					<?php foreach($packages->package[$x]->name as $value) { ?>
					<option value="<?php echo $x; ?>"><?php echo $value; $x++; ?></option>
					<?php } ?>
				<?php } ?>
				</select>
			</p>

            <p><label>Plan XL </label>
				<select class="planxl">
				<?php while($z != $max) { ?>
					<?php foreach($packages->package[$z]->name as $value) { ?>
					<option value="<?php echo $z; ?>"><?php echo $value; $z++; ?></option>
					<?php } ?>
				<?php } ?>
				</select>
			</p>
			
			<p><label>Plan XXL </label>
				<select class="planxxl">
				<?php while($k != $max) { ?>
					<?php foreach($packages->package[$k]->name as $value) { ?>
					<option value="<?php echo $k; ?>"><?php echo $value; $k++; ?></option>
					<?php } ?>
				<?php } ?>
				</select>
			</p>
			
			<div style="clear: both"></div>
			
            <p class="create">
                <input type="submit" name="create" value="create">
            </p>
			
        </form>
        <!-- form end -->

    </div>

</section>

</body>
</html>