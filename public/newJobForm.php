<form action="../php/submitDie.php">
	<label for="output[name=dieID]">Die ID:</label> <output name="dieID"></output><br>

	<input type="hidden" name="?type" value="job">
	<input type="hidden" name="dieID">
	<input type="hidden" name="?function" value="add">

	<input type="text" name="jobNumber" placeholder="Job number" required>
	<input type="text" name="customerName" placeholder="Customer Name">

	<div>
		<label for="input[name=jobDate]">Job Date:</label>
			<input type="date" name="jobDate" value="<?php echo date("Y-m-d"); ?>">
	</div>

	<input type="submit" value="Pull">
</form>