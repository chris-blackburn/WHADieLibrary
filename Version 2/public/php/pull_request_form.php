<div id="pull-form-container" class="die-form tab-content">
	<form>
		<input type="hidden" name="function" value="add">
		<input type="hidden" name="table" value="dieBase2">

		<div hidden id="entry-data">
			<!-- This is where i will store the data for entries when accessed -->
		</div>

		<label for="output[name=dieID]">Die ID:</label> <output name="dieID"></output>
		<br>
		<input type="date" name="dateLastUsed">
		<br>
		<input type="number" name="jobNumber" placeholder="New Job Number">
		<br>
		<label for="input[name=location]">Location:</label>
		<select name="location">
			<option value="Awaiting Arrival">Awaiting Arrival</option>
			<option value="Green Inventory">Green Inventory</option>
			<option value="Gold Inventory">Gold Inventory</option>
			<option value="Sanwa">Sanwa</option>
			<option value="Heidelberg">Heidelberg</option>
			<option value="Kluge">Kluge</option>
		</select>
		<br><br>
		<input type="submit" value="Request">
	</form>
</div>