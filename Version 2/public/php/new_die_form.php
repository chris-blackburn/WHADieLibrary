<div id="insert-form-container" class="die-form tab-content">
	<form> <!-- The form tag doesn't need any attributes because jquery handles the submission -->

		<!-- use this to store other data and switch between adding/updating -->
		<input type="hidden" name="function" value="add">
		<input type="hidden" name="table" value="dieBase2">

		<div class="center">
			<input type="text" name="jobNumber" placeholder="Job number" required>
			<input type="text" name="customerID" placeholder="Customer ID" required>
		</div>

		<div class="center">
			<input type="text" name="customerName" placeholder="Customer Name" required>
		</div>

		<div class="center">
			<input type="text" name="dieVendor" placeholder="Die Vendor">
		</div>

		<div class="field">
			<label for="input[name=description]">Description:</label>
			<div class="field-input">	
				<input type="text" name="description">
			</div>
		</div>

		<div class="field">
			<label for="input[name=tags]">Tags:</label>
			<div class="field-input">
				<input type="text" name="tags" id="tags">
			</div>
		</div>

		<div class="field">
			<label for="input[name=datePurchased]">Date Purchased:</label>
			<div class="field-input">
				<input type="date" name="datePurchased" required>
			</div>	
		</div>

		<div class="field">
			<label for="input[name=expectedUsage]">Expected usage:</label>
			<div class="field-input">
				<select name="expectedUsage">
					<option value="One time use" selected>One time use</option>
					<option value="More than once">More than once</option>
					<option value="Regular">Regular</option>
					<option value="Unknown">Unknown</option>
				</select>
			</div>	
		</div>

		<div class="field">
			<label for="input[name=location]">Location:</label>
			<div class="field-input">
					<select name="location">
					<option value="Awaiting Arrival" selected>Awaiting Arrival</option>
					<option value="Green Inventory">Green Inventory</option>
					<option value="Gold Inventory">Gold Inventory</option>
					<option value="Sanwa">Sanwa</option>
					<option value="Heidelberg">Heidelberg</option>
					<option value="Kluge">Kluge</option>
				</select>
			</div>	
		</div>

		<div class="field">
			<label for="input[name=machine]">Machine:</label>
			<div class="field-input">
					<select name="machine">
					<option value="Sanwa">Sanwa</option>
					<option value="Heidelberg">Heidelberg</option>
					<option value="Kluge">Kluge</option>
				</select>
			</div>	
		</div>

		<div class="field sizes">
			<label for="flat-sizes">Flat Size:</label>
			<div class="field-input" id="flat-sizes">
				<input type="number" name="flatWidth" placeholder="Flat Width" step="any">
				X
				<input type="number" name="flatHeight" placeholder="Flat Height" step="any">
			</div>	
		</div>
			
		<div class="field sizes">
			<label for="finished-sizes">Finished Size:</label>
			<div class="field-input" id="finished-sizes">
				<input type="number" name="finishedWidth" placeholder="Finished Width" step="any">
				X
				<input type="number" name="finishedHeight" placeholder="Finished Height" step="any">
			</div>	
		</div>

		<div class="field">
			<label for="input[name=numPockets]">Pockets:</label>
			<div class="field-input">
				<input type="range" name="numPockets" value="0" min="0" max="10">
			</div>	
		</div>

		<div class="field">
			<label for="input[name=pocketSize]">Pocket Size:</label>
			<div class="field-input">
				<input type="number" name="pocketSize"  step="any">
			</div>	
		</div>
		
		<div class="field">
			<label for="input[name=numberUp]"># Up:</label>
			<div class="field-input">
				<input type="range" name="numberUp" value="0" min="0" max="100">
			</div>	
		</div>
		
		<div class="field">
			<label for="input[name=docketReviewed]">Docket Reviewed:</label>
			<div class="field-input">
				<input type="hidden" name="docketReviewed" value="false">
				<input type="checkbox" name="docketReviewed" value="true">
			</div>	
		</div>
		
		<div class="field">
			<label for="input[name=notes]">Notes:</label>
			<div class="field-input">
				<input type="text" name="notes">
			</div>	
		</div>
		
		<div class="center">
			<input type="submit" value="Add">
		</div>

	</form>
</div>