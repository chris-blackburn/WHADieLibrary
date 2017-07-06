<form action="../php/submitForm.php" enctype="multipart/form-data">

	<!-- use this to store other data and switch between adding/updating -->
	<input type="hidden" name="!type" value="die">
	<input type="hidden" name="!function" value="add">

	<input type="number" name="?jobNumber" placeholder="Job number" required>
	<input type="text" name="?customerName" placeholder="Customer Name">

	<div>
		<label for="input[name=jobDate]">Job Date:</label>
			<input type="date" name="?jobDate" value="<?php echo date("Y-m-d"); ?>">
	</div>

	<input type="text" name="dieVendor" placeholder="Die Vendor">

	<div>
		<label for="input[name=description]">Description:</label>
			<input type="text" name="description">
	</div>

	<div>
		<label for="tags">Tags:</label>
		<select style="height: 10em;" id="tags" multiple="multiple" class="multi-select">
			<?php
				$productTags = [ "Business Card", "Brochure", "Booklet/Catalog", "Box", "Coupon", "Coaster", "CD/DVD Holder", "Door Hanger", "Envelope", "Hang Tag", "Invitation/Greeting Card", "Pocket", "Sticker/Label", "Tent" ];

				$featuresTags = [ "BC Slit", "Corner", "Gusset", "Horizontal Pocket", "Moon BC Slits", "Perforation", "Pop Up/3D", "Shape", "Tabs", "Vertical Pocket", "Window", "Wrap" ];

				$tags = array_merge($productTags, $featuresTags);

				foreach($tags as $tag) {
					echo "<option value=\"" . $tag . "\">" . $tag . "</option>";
				}
			?>
		</select>
		(Tip: Ctrl+Click to select multiple tags)
		<input type="hidden" name="tags">
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

	<div>
		<label for="input[name=pdfFile]">Upload PDF:</label> <input id="file-upload" type="file">
	</div>

	<input type="submit" value="Create Die">
</form>