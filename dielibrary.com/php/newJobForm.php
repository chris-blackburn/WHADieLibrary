<div class="entry-info">
	<span>Die ID:</span> <output name="dieID"></output><br>
</div>

<form action="../php/submitForm.php">

	<input type="hidden" name="?dieID">
	<input type="hidden" name="dieID">
	<input type="hidden" name="jobFunction" value="add">
	<input type="hidden" name="dieFunction" value="edit">

	<div class="field center">
		<input type="number" name="?jobNumber" placeholder="Job number"  min="0" required>
		<input type="text" name="?customerName" placeholder="Customer Name">
	</div>

	<div class="field">
		<label for="input[name=jobDate]">Job Date:
		<div class="field-input">
			<input type="date" name="?jobDate" value="<?php echo date("Y-m-d"); ?>">
		</div>
		</label>
	</div>

	<div class="field">
		<label for="input[name=location]">Location:
		<div class="field-input">
			<select name="!location">
				<option value="Awaiting Arrival">Awaiting Arrival</option>
				<option value="Green Inventory">Green Inventory</option>
				<option value="Sanwa">Sanwa</option>
				<option value="Heidelberg">Heidelberg</option>
				<option value="Kluge">Kluge</option>
				<option value="Trashed">Trashed</option>
			</select>
		</div>
		</label>
	</div>

	<input type="submit" value="Pull">
</form>