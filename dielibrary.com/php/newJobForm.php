<form action="../php/submitForm.php">
	<label for="output[name=dieID]">Die ID:</label> <output name="dieID"></output><br>

	<input type="hidden" name="?dieID">
	<input type="hidden" name="dieID">
	<input type="hidden" name="jobFunction" value="add">
	<input type="hidden" name="dieFunction" value="edit">

	<input type="number" name="?jobNumber" placeholder="Job number"  min="0" required>
	<input type="text" name="?customerName" placeholder="Customer Name">

	<div>
		<label for="input[name=jobDate]">Job Date:</label>
			<input type="date" name="?jobDate" value="<?php echo date("Y-m-d"); ?>">
	</div>

	<div class="field">
		<label for="input[name=location]">Location:</label>
		<div class="field-input">
			<select name="!location">
				<option value="Awaiting Arrival">Awaiting Arrival</option>
				<option value="Green Inventory">Green Inventory</option>
				<option value="Gold Inventory">Gold Inventory</option>
				<option value="Sanwa">Sanwa</option>
				<option value="Heidelberg">Heidelberg</option>
				<option value="Kluge">Kluge</option>
			</select>
		</div>	
	</div>

	<input type="submit" value="Pull">
</form>