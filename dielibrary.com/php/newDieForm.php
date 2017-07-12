<form action="../php/submitForm.php" enctype="multipart/form-data">

	<!-- use this to store other data and switch between adding/updating -->
	<input type="hidden" name="dieFunction" value="add">
	<input type="hidden" name="jobFunction" value="add">

	<input type="number" name="?jobNumber" placeholder="Job number" min="0" required>
	<input type="text" name="?customerName" placeholder="Customer Name">

	<div>
		<label for="input[name=jobDate]">Job Date:</label>
			<input type="date" name="?jobDate" value="<?php echo date("Y-m-d"); ?>">
	</div>

	<div>
		<label for="input[name=description]">Description:</label>
			<textarea name="!description"></textarea>
	</div>

	<div>
		<label for="tags">Tags:</label>
		<select style="height: 10em;" multiple="multiple" class="tags multi-select">
			<?php
				$productTags = [ "Business Card", "Brochure", "Booklet/Catalog", "Box", "Coupon", "Coaster", "CD/DVD Holder", "Door Hanger", "Envelope", "Hang Tag", "Invitation/Greeting Card", "Pocket", "Sticker/Label", "Tent" ];

				$featuresTags = [ "BC Slit", "Corner", "Gusset", "Horizontal Pocket", "Moon BC Slits", "Perforation", "Pop Up/3D", "Shape", "Tabs", "Vertical Pocket", "Window", "Wrap" ];

				$tags = array_merge($productTags, $featuresTags);
				asort($tags);

				foreach($tags as $tag) {
					echo "<option value=\"" . $tag . "\">" . $tag . "</option>";
				}
			?>
		</select>
		(Tip: Ctrl+Click to select multiple tags)
		<input type="hidden" name="!tags">
	</div>

	<div>
		<label for="input[name=datePurchased]">Date Purchased:</label>
			<input type="date" name="!datePurchased" value="<?php echo date("Y-m-d"); ?>" required>
	</div>

	<div>
		<label for="input[name=expectedUsage]">Expected usage:</label>
			<select name="!expectedUsage">
				<option value="One time use" selected>One time use</option>
				<option value="More than once">More than once</option>
				<option value="Regular">Regular</option>
				<option value="Unknown">Unknown</option>
			</select>
	</div>

	<div>
		<label for="input[name=location]">Location:</label>
			<select name="!location">
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
			<select name="!machine">
				<option value="Sanwa">Sanwa</option>
				<option value="Heidelberg">Heidelberg</option>
				<option value="Kluge">Kluge</option>
			</select>
	</div>

	<div>
		<label for="flat-sizes">Flat Size:</label>
			<input type="number" name="!flatWidth" placeholder="Flat Width" min="0" step="any">
			X
			<input type="number" name="!flatHeight" placeholder="Flat Height" min="0" step="any">
	</div>

	<div>
		<label for="finished-sizes">Finished Size:</label>
			<input type="number" name="!finishedWidth" placeholder="Finished Width" step="any" min="0">
			X
			<input type="number" name="!finishedHeight" placeholder="Finished Height" step="any" min="0">
	</div>

	<div>
		<label for="input[name=numPockets]">Pockets:</label>
			<input type="number" name="!numPockets" max="10" min="0">
	</div>

	<div>
		<label for="input[name=pocketSize]">Pocket Size:</label>
			<input type="number" name="!pocketSize" step="any" min="0">
	</div>

	<div>
		<label for="input[name=numberUp]"># Up:</label>
			<input type="number" name="!numberUp" min="0" max="100">
	</div>

	<div>
		<label for="input[name=dieReviewed]">Die Reviewed:</label>
			<select name="!dieReviewed">
				<option value="false" selected>false</option>
				<option value="true">true</option>
			</select>
	</div>

	<div>
		<label for="input[name=pdfFile]">Upload PDF:</label> <input name="pdfFile" type="file" accept=".pdf,application/pdf">
	</div>

	<div>
		<label for="input[name=otherFiles]">Upload Other Files:</label> <input name="otherFiles[]" type="file" multiple accept=".pdf,.eps,application/pdf,application/postscript">
	</div>

	<input type="submit" value="Create Die">
</form>