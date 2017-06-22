<!DOCTYPE html>

<html>
<head>
	<title>WHA Die Library</title>
	<!-- Grab the required libraries -->
	<?php include "../includes/lib.php" ?>
</head>

<body>

	<div class="tabs">
		<button id="table-btn">View Table</putton>
		<button id="insert-btn">New Entry</putton>
		<button hidden id="update-btn">Update Entry</putton>
		<button hidden id="pull-btn">Pull Request</putton>
	</div>

<!-- ***************************************************** TABLE ***************************************************** -->

	<?php include "php/die_list.php" ?>

<!-- ***************************************************** INSERT FORM ***************************************************** -->

	<?php include "php/new_die_form.php" ?>

<!-- ***************************************************** UPDATE FORM ***************************************************** -->

	<?php include "php/update_die_form.php" ?>

<!-- ***************************************************** PULL FORM ***************************************************** -->

	<?php include "php/pull_request_form.php" ?>

</body>
</html>