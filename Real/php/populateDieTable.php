<?php

	require_once "Database.php";
	include_once "../includes/constants.php";

	// create a new database object, default constructor
	$db = new Database();

	// connect to the database, default parameters
	$db->connect();

	// grab the data from the die table
	$result = $db->select(DIE_TABLE);

	// return the data in json format, separated by tilde's (to separate multiple json objects)
	while ($row = $result->fetch_assoc()) {
		echo json_encode($row) . "~";
	}

	// release the data and disconnect
	$result->free_result();
	$db->disconnect();
?>