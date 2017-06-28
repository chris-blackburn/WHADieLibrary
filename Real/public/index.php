<!DOCTYPE html>

<html>
<head>
	<title>WHA Die Library</title>
	<!-- Include libraries and css forms -->
	<?php include "../includes/libs.php"; ?>

	<!-- include constants -->
	<?php include "../includes/constants.php" ?>
</head>

<body>

	<!-- the name attribute for each button should be the target div for which its content holds -->
	<div class="tab-buttons">
		<button id="table-btn" name="table-container" class="active-tab">View Table</button>
		<button id="insert-btn" name="new-die-form-container">New Entry</button>
		<button id="update-btn" name="update-form-container">Update Entry</button>
		<button id="pull-btn" name="pull-form-container">Pull Request</button>
	</div>

<!-- ***************************************************** TABLE ***************************************************** -->

	<div id="table-container" class="tab-content">
		<input type="text" id="table-quick-search" placeholder="Quick Search">
		<table class="tablesorter">
			<thead class="table-head">
				<tr>
					<th id="dieID-header" name="dieID" value="asc">ID</th>
					<th id="dateLastUsed-header" name="dateLastUsed" value="asc">Date Last Used</th>
					<th id="machine-header" name="machine" value="asc">Machine</th>
					<th id="location-header" name="location" value="asc">Location</th>
					<th id="description-header" name="description" value="asc">Description</th>
				</tr>
			</thead>
			<tbody class="table-body">
				<!-- This gets populated by populateTable.php, see js/jquery.js -->
			</tbody>
		</table>
	</div>

<!-- ***************************************************** NEW DIE FORM ***************************************************** -->

	<div id="new-die-form-container" class="die-form tab-content">
		<?php include "newDieForm.php" ?>
	</div>

<!-- ***************************************************** UPDATE DIE FORM ***************************************************** -->

	<div id="update-form-container" class="die-form tab-content">
		<?php include "updateDieForm.php" ?>
	</div>

<!-- ***************************************************** PULL FORM ***************************************************** -->

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

</body>
</html>