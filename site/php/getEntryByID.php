<?php
	require_once "Database.php";
	include_once "constants.php";

	// get the die ID
	$dieID = $_GET["dieID"];

	// create new database connection
	$db = new Database();
	$db->connect();

	// grab the data from the database
	$result = $db->select(DIE_TABLE, "*", "dieID", $dieID);
	$row = $result->fetch_assoc();

	// free the result data
	$result->free_result();

	// disconnect from the database
	$db->disconnect();

	// return json of the row data
	echo json_encode($row);
?>

