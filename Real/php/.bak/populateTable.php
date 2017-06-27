<?php

	require_once "Databse.php";
	include_once "../includes/constants.php"

	// create a new database object, default constructor
	$db = new Database();

	// connect to the database, default parameters
	$db->connect();

	// grab the data from the die table
	$table = $_POST["table"];
	$result = $db->select($table);

	// return the data in json format, separated by tilde's (to separate multiple json objects)
	while ($row = $result->fetch_assoc()) {
		echo json_encode($row) . "~";
	}

	// release the data
	$result->free_result();

	/*
	require 'sqlHandler.php';

	// Prepare the arguments
	$table = $_POST["table"];
	$cols = '*';
	$where = NULL;
	$in = NULL;
	$order = $_POST["order"];

	// create a new database object and connect
	$db = new Database('localhost', 'monty', 'some_pass', 'testDB');
	$db->connect();

	// if there is an order, submit different arguments
	if ($order == NULL)
		$result = $db->select($table);
	else
		$result = $db->select($table, $cols, $where, $in, $order[0], $order[1]);

	// disconnect from the sql server, we already have the data we need
	$db->disconnect();

	// parse the data into table rows
	while ($row = $result->fetch_assoc()) {
		$dateLastUsed = $row['dateLastUsed'];

		if ($dateLastUsed == "1983-01-01" || $dateLastUsed == "0000-00-00")
			$dateLastUsed = "Never";

		echo "	<tr class=\"table-rows\" name=\"" . $row['dieID'] . "\">
					<td class=\"table-checkboxes\"><input type=\"checkbox\"></td>
					<td class=\"dieID-row\">" . $row['dieID'] . "</td>
					<td class=\"dateLastUsed-row\">" . $dateLastUsed . "</td>
					<td class=\"machine-row\">" . $row['machine'] . "</td>
					<td class=\"location-row\">" . $row['location'] . "</td>
					<td class=\"description-row\">" . $row['description'] . "</td>
					<td class=\"pull-row\"><button class=\"pull-btn\">Pull</button></td>
				</tr>";
*/
?>