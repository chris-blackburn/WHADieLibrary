<form action="../php/submitDie.php">

	<!-- use this to store other data and switch between adding/updating -->
	<input type="hidden" name="?type" value="die">
	<input type="hidden" name="?function" value="add">

	<input type="text" name="dieVendor" placeholder="Die Vendor">

	<div>
		<label for="input[name=description]">Description:</label>
			<input type="text" name="description">
	</div>

	<div>
		<label for="input[name=tags]">Tags:</label>
			<input type="text" name="tags" id="tags">
	</div>

	<div>
		<label for="input[name=datePurchased]">Date Purchased:</label>
			<input type="date" name="datePurchased" value="<?php echo date("Y-m-d"); ?>" required>
	</div>

	<div>
		<label for="input[name=expectedUsage]">Expected usage:</label>
			<select name="expectedUsage">
				<option value="One time use" selected>One time use</option>
				<option value="More than once">More than once</option>
				<option value="Regular">Regular</option>
				<option value="Unknown">Unknown</option>
			</select>
	</div>

	<div>
		<label for="input[name=location]">Location:</label>
			<select name="location">
				<option value="Awaiting Arrival" selected>Awaiting Arrival</option>
				<option value="Green Inventory">Green Inventory</option>
				<option value="Gold Inventory">Gold Inventory</option>
				<option value="Sanwa">Sanwa</option>
				<option value="Heidelberg">Heidelberg</option>
				<option value="Kluge">Kluge</option>
			</select>
	</div>

	<div>
		<label for="input[name=machine]">Machine:</label>
			<select name="machine">
				<option value="Sanwa">Sanwa</option>
				<option value="Heidelberg">Heidelberg</option>
				<option value="Kluge">Kluge</option>
			</select>
	</div>

	<div>
		<label for="flat-sizes">Flat Size:</label>
			<input type="number" name="flatWidth" placeholder="Flat Width" step="any">
			X
			<input type="number" name="flatHeight" placeholder="Flat Height" step="any">
	</div>

	<div>
		<label for="finished-sizes">Finished Size:</label>
			<input type="number" name="finishedWidth" placeholder="Finished Width" step="any">
			X
			<input type="number" name="finishedHeight" placeholder="Finished Height" step="any">
	</div>

	<div>
		<label for="input[name=numPockets]">Pockets:</label>
			<input type="number" name="numPockets" max="10">
	</div>

	<div>
		<label for="input[name=pocketSize]">Pocket Size:</label>
			<input type="number" name="pocketSize"  step="any">
	</div>

	<div>
		<label for="input[name=numberUp]"># Up:</label>
			<input type="number" name="numberUp" min="0" max="100">
	</div>

	<div>
		<label for="input[name=dieReviewed]">Die Reviewed:</label>
			<select name="dieReviewed">
				<option value="false" selected>false</option>
				<option value="true">true</option>
			</select>
	</div>

	<input type="submit" value="Create Die">
</form>