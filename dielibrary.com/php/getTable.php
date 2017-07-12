<?php

	require_once "Database.php";
	include_once "constants.php";

	// create a new database object, default constructor
	$db = new Database();

	// connect to the database, default parameters
	$db->connect();

	// grab the data from the die table
	$table = $_GET['table'];
	
	if ($table == "die")
		$result = $db->select(DIE_TABLE, "*", NULL, NULL, "dieID", "desc");
	else if ($table == "job")
		$result = $db->select(JOB_TABLE, "*", NULL, NULL, "jobDate", "desc");

	// disconnect from the database
	$db->disconnect();

	// return the data in json format, separated by tilde's (to separate multiple json objects)x
	$rows = array();

	while ($row = $result->fetch_assoc()) {
		$rows[] = $row;
	}

	echo json_encode($rows);

	// release the data
	$result->free_result();
?>