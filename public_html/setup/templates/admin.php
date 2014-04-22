<h3>Add Admin Account</h3>
<p>This will be the Login Details for your Admin Interface.</p>
<?php echo $output; ?>
<form method="post" action="">
	<p>
		<label>Username</label><br>
		<input class="title user" type="text" name="user" value="">
	</p>
	<p>
		<label>Password</label><br>
		<input class="title pass" type="password" name="pass" value="">
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
		
		<input type="hidden" name="nextStep" value="admin">
		<button type="submit" class="button positive">
			<img src="css/blueprint/plugins/buttons/icons/tick.png" alt=""/> Add User
		</button>
	<?php } ?>
</form>