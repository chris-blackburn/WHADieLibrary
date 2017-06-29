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
		<button id="insert-btn" name="new-die-form-container">Create New Die</button>
		<button id="update-btn" name="update-form-container">Update Die</button>
		<button id="pull-btn" name="pull-form-container">Pull Request</button>
	</div>

<!-- ***************************************************** DIE TABLE ***************************************************** -->

	<div id="table-container" class="tab-content">
		<?php include "dieTable.php" ?>
	</div>

<!-- ***************************************************** NEW DIE FORM ***************************************************** -->

	<div id="new-die-form-container" class="forms tab-content">
		<?php include "newDieForm.php" ?>
	</div>

<!-- ***************************************************** UPDATE DIE FORM ***************************************************** -->

	<div id="update-form-container" class="forms tab-content">
		<?php include "updateDieForm.php" ?>
	</div>

<!-- ***************************************************** PULL FORM ***************************************************** -->

	<div id="pull-form-container" class="forms tab-content">
		<?php include "newJobForm.php" ?>
	</div>

</body>
</html>