<form action="../php/submitForm.php" enctype="multipart/form-data">

	<div class="form-section">
		<!-- use this to store other data and switch between adding/updating -->
		<input type="hidden" name="dieFunction" value="add">
		<input type="hidden" name="jobFunction" value="add">

		<input type="hidden" name="!newDie" value="yes">

		<div class="field center">
			<input type="number" name="?jobNumber" placeholder="Job number"  min="0" required>
			<input type="text" name="?customerName" placeholder="Customer Name">
		</div>

		<div class="field">
			<label>Job Date:
			<div class="field-input">
				<input type="date" name="?jobDate" value="<?php echo date("Y-m-d"); ?>">
			</div>
			</label>
		</div>

		<div class="field">
			<label>Description:
			<div class="field-input">	
				<textarea name="!description"></textarea>
			</div>
			</label>
		</div>

		<div class="field">
			<label>Tags:
			<div class="field-input">
			<select style="height: 10em;"" multiple="multiple" class="tags multi-select">
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
			</div>
			</label>
			<input type="hidden" name="!tags">
		</div>

		<div class="field">
			<label>Date Purchased:
			<div class="field-input">
				<input type="date" name="!datePurchased" value="<?php echo date("Y-m-d"); ?>" required>
			</div>
			</label>
		</div>

		<div class="field">
			<label>Expected usage:
			<div class="field-input">
				<select name="!expectedUsage">
					<option value="One time use">One time use</option>
					<option value="More than once">More than once</option>
					<option value="Regular">Regular</option>
					<option value="Unknown">Unknown</option>
				</select>
			</div>
			</label>
		</div>

		<div class="field">
			<label>Location:
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

		<div class="field">
			<label>Machine:
			<div class="field-input">
				<select name="!machine">
					<option value="Sanwa">Sanwa</option>
					<option value="Heidelberg">Heidelberg</option>
					<option value="Kluge">Kluge</option>
				</select>
			</div>
			</label>
		</div>
	</div>	

	<div class="form-section" style="margin-top: 10em;">

		<div class="field sizes">
			<label for="flat-sizes">Flat Size:
			<div class="field-input" id="flat-sizes">
				<input type="number" name="!flatWidth" placeholder="Flat Width" step="any" min="0">
				X
				<input type="number" name="!flatHeight" placeholder="Flat Height" step="any" min="0">
			</div>
			</label>
		</div>
			
		<div class="field sizes">
			<label for="finished-sizes">Finished Size:
			<div class="field-input" id="finished-sizes">
				<input type="number" name="!finishedWidth" placeholder="Finished Width" step="any" min="0">
				X
				<input type="number" name="!finishedHeight" placeholder="Finished Height" step="any" min="0">
			</div>
			</label>
		</div>

		<div class="field">
			<label>Pockets:
			<div class="field-input">
				<input type="number" name="!numPockets" min="0" max="10">
			</div>
			</label>
		</div>

		<div class="field">
			<label>Pocket Size:
			<div class="field-input">
				<input type="number" name="!pocketSize" step="any" min="0">
			</div>
			</label>
		</div>
		
		<div class="field">
			<label>Number Up:
			<div class="field-input">
				<input type="number" name="!numberUp" min="0" max="100">
			</div>
			</label>
		</div>
		
		<div class="field">
			<label>Die Reviewed:
			<div class="field-input">
				<select name="!dieReviewed">
					<option value="false">no</option>
					<option value="true">yes</option>
				</select>
			</div>	
			</label>
		</div>

		<div>
			<label>Upload Preview PDF: <input name="pdfFile" type="file" accept=".pdf,application/pdf"></label>
		</div>

		<div>
			<label>Upload Other Files: <input name="otherFiles[]" type="file" multiple accept=".pdf,.eps,application/pdf,application/postscript"></label>
		</div>

	</div>

	<input type="submit" value="Create Die">
</form>