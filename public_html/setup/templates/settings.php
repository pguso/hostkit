<h3>Settings</h3>

<p>
	We need some information to configure the site for you.
</p>
<hr>

<?php if ($error) { ?>
	<div class="error">
		<b>Error: <?php echo $error; ?></b><br><br>
	</div>
<?php } ?>

<form method="post">
	<p>
		<label>Website Url </label><br>
		<input class="title" type="text" name="url" value="<?php echo $url; ?>" placeholder="http://domain.com">
	</p>
	<p>
		<label>Paypal E-Mail Address</label><br>
		<input class="title" type="text" name="email" value="<?php echo $email; ?>">
	</p>
	<p>
		<label>VAT</label> (set to 0 if you don't use VAT)<br>
		<input class="title" type="text" name="vat" value="<?php echo $vat; ?>">
	</p>
	
	<hr>
	
	<?php if ($goToNextStep) { ?>
		<div class="success">Everything is ok! Go to next step...</div>

		<a href="index.php" class="button negative">
			<img src="css/blueprint/plugins/buttons/icons/cross.png" alt=""/> Cancel
		</a>		
		
		<input type="hidden" name="nextStep" value="done">
		<button type="submit" class="button positive">
			<img src="css/blueprint/plugins/buttons/icons/tick.png" alt=""/> Next
		</button>
	<?php } else { ?>
		<a href="index.php" class="button negative">
			<img src="css/blueprint/plugins/buttons/icons/cross.png" alt=""/> Cancel
		</a>
		
		<input type="hidden" name="nextStep" value="settings">
		<button type="submit" class="button positive">
			<img src="css/blueprint/plugins/buttons/icons/tick.png" alt=""/> Update Settings
		</button>
	<?php } ?>
</form>