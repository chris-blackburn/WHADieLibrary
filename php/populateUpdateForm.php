<?php
	require "sqlHandler.php";

	$table = $_GET["table"];
	$dieID = $_GET["dieID"];

	// create the form and fill it with the data of the selected table entry
	
	$db = new Database("localhost", "monty", "some_pass", "testDB");
	$db->connect();

	$cols = '*';
	$where = "dieID";
	$in = $dieID;

	// use row["name"] to access the data
	$result = $db->select($table, $cols, $where, $in);
	$row = $result->fetch_assoc();

	$db->disconnect();

	echo json_encode($row);
?>