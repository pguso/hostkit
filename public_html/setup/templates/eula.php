<h3>EULA</h3>

<div class="info">You must accept the EULA to continue!</div>

<textarea style="height: 300px; width: 98%;"><?php echo $eula; ?></textarea>
<hr>

<a href="index.php" class="button negative">
	<img src="css/blueprint/plugins/buttons/icons/cross.png" alt=""/> Cancel
</a>

<form method="post">
	<input type="hidden" name="nextStep" value="requirements">
	<button type="submit" class="button positive">
		<img src="css/blueprint/plugins/buttons/icons/tick.png" alt=""/> I accept the "EULA"
	</button>
</form>