<?php

	require_once "Database.php";
	include_once "../includes/constants.php";

	// create a new database object, default constructor
	$db = new Database();

	// connect to the database, default parameters
	$db->connect();

	// grab the data from the die table
	$table = $_GET['table'];
	
	if ($table == "die")
		$result = $db->select(DIE_TABLE);
	else if ($table == "job")
		$result = $db->select(JOB_TABLE);

	// disconnect from the database
	$db->disconnect();

	// return the data in json format, separated by tilde's (to separate multiple json objects)
	while ($row = $result->fetch_assoc()) {
		echo json_encode($row);
	}

	// release the data
	$result->free_result();
?>