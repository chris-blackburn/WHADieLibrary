<!DOCTYPE html>
<html>
<head>
	<title>WHA Die Library</title>
	<!-- Include libraries and css forms -->
	<?php include "../php/libs.php"; ?>
</head>

<body>

	<!-- the name attribute for each button should be the target div for which its content holds -->
	<div class="tab-buttons">
		<button id="die-table-btn" name="die-table" class="active-tab">Die Table</button>
		<button id="job-table-btn" name="job-table">Transaction History</button>
		<button id="insert-btn" name="new-die-form-container">Create New Die</button>
		<button hidden id="update-btn" name="update-form-container" class="hidden">Update Die</button>
		<button hidden id="pull-btn" name="pull-form-container" class="hidden">Pull Request</button>

		<a href="user guide.html" style="font-size: .75em; float: right; padding: .75em;">help</a>
	</div>

<!-- ***************************************************** DIE TABLE ***************************************************** -->

	<div id="die-table" class="table-container tab-content">
		<?php include "../php/dieTable.php" ?>
	</div>

<!-- ***************************************************** JOB TABLE ***************************************************** -->
	
	<div id="job-table" class="table-container tab-content">
		<?php include "../php/jobTable.php" ?>
	</div>

<!-- ***************************************************** NEW DIE FORM ***************************************************** -->

	<div id="new-die-form-container" class="forms tab-content">
		<?php include "../php/newDieForm.php" ?>
	</div>

<!-- ***************************************************** UPDATE DIE FORM ***************************************************** -->

	<div id="update-form-container" class="forms tab-content">
		<?php include "../php/updateDieForm.php" ?>
	</div>

<!-- ***************************************************** PULL FORM ***************************************************** -->

	<div id="pull-form-container" class="forms tab-content">
		<?php include "../php/newJobForm.php" ?>
	</div>

</body>
</html>