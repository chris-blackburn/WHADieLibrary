<!DOCTYPE html>

<html>
<head>
	<title>WHA Die Library</title>
	<!-- Grab the required libraries and constants -->
	<?php include "../includes/libs.php" ?>
</head>

<body>

	<div class="tabs">
		<button id="table-btn">View Table</putton>
		<button id="insert-btn">New Entry</putton>
		<button hidden id="update-btn">Update Entry</putton>
		<button hidden id="pull-btn">Pull Request</putton>
	</div>

	<div id="list-container">
		<!-- Search box for the table -->
		<input type="text" id="table-quick-search" placeholder="Quick Search">
		<button id="refresh-list" onclick="populateList()">Refresh Die List</button>

		<p></p>

		<ul>
		</ul>
	</div>

</body>
</html>