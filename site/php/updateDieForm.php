<!-- Display as non-editable: job number, customer ID, customer name, die id, purchase date, machine -->
<div id="entry-info">
	<!--<label for="output[name=customerName]">Customer Name:</label> <output name="customerName"></output> | -->
	<label for="output[name=!dieID]">Die ID:</label> <output name="!dieID"></output> | 
	<label for="output[name=datePurchased]">Date Purchased:</label> <output name="datePurchased"></output> <br>
	<!--<label for="output[name=jobDate]">Date Last Used:</label> <output name="jobDate"></output><br>-->
	<label for="output[name=machine]">Machine:</label> <output name="machine"></output><br>
	<label for="output[name=tags]">Tags:</label> <output name="tags"></output>
</div>


<form action="../php/submitForm.php">

	<!-- use this to store other data and switch between adding/updating -->
	<input type="hidden" name="dieID">
	<input type="hidden" name="dieFunction" value="edit">

	<div class="field">
		<label for="input[name=description]">Description:</label>
		<div class="field-input">	
			<textarea name="!description"></textarea>
		</div>
	</div>

	<div class="field">
		<label for="input[name=expectedUsage]">Expected usage:</label>
		<div class="field-input">
			<select name="!expectedUsage">
				<option value="One time use">One time use</option>
				<option value="More than once">More than once</option>
				<option value="Regular">Regular</option>
				<option value="Unknown">Unknown</option>
			</select>
		</div>	
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

	<div>
		<label for="tags">Tags:</label>
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
		(Tip: Tags that are greyed out are already associated with this die)
		<input type="hidden" name="!tags">
	</div>

	<div class="field sizes">
		<label for="flat-sizes">Flat Size:</label>
		<div class="field-input" id="flat-sizes">
			<input type="number" name="!flatWidth" placeholder="Flat Width" step="any" min="0">
			X
			<input type="number" name="!flatHeight" placeholder="Flat Height" step="any" min="0">
		</div>	
	</div>
		
	<div class="field sizes">
		<label for="finished-sizes">Finished Size:</label>
		<div class="field-input" id="finished-sizes">
			<input type="number" name="!finishedWidth" placeholder="Finished Width" step="any" min="0">
			X
			<input type="number" name="!finishedHeight" placeholder="Finished Height" step="any" min="0">
		</div>	
	</div>

	<div class="field">
		<label for="input[name=numPockets]">Pockets:</label>
		<div class="field-input">
			<input type="number" name="!numPockets" min="0" max="10">
		</div>	
	</div>

	<div class="field">
		<label for="input[name=pocketSize]">Pocket Size:</label>
		<div class="field-input">
			<input type="number" name="!pocketSize" step="any" min="0">
		</div>	
	</div>
	
	<div class="field">
		<label for="input[name=numberUp]">Number Up:</label>
		<div class="field-input">
			<input type="number" name="!numberUp" min="0" max="100">
		</div>	
	</div>
	
	<div class="field">
		<label for="input[name=dieReviewed]">Die Reviewed:</label>
		<div class="field-input">
			<select name="!dieReviewed">
				<option value="false">false</option>
				<option value="true">true</option>
			</select>
		</div>	
	</div>
<!--
	<div class="field">
		<label for="input[name=dateLastUsed]">Date Last Used:</label>
		<div class="field-input">
			<input type="date" name="dateLastUsed" required>
		</div>
	</div>
	-->

	<div class="center">
		<input type="submit" value="Update">
	</div>

</form>

<div class="tab-buttons-2">
	<button id="pdf-container-btn" name="pdf-container">Preview</button>
	<button name="die-files">Download</button>
</div>

<div id="pdf-container" class="tab-content-2 active-tab-2">
	<object id="pdf-obj" type="application/pdf">
		<iframe>If you are unable to see the pdf, your browser may not support it. Please click <a>here</a> to download it</iframe>
	</object>
</div>

<div id="die-files" class="tab-content-2">
	<p id="download-links">
		Download Links:
	</p>
</div>
