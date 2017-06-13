<?php
	require "sqlHandler.php";

	$table = $_POST["table"];
	$dieID = $_POST["dieID"];

	// create the form and fill it with the data of the selected table entry

	$db = new Database("localhost", "monty", "some_pass", "testDB");
	$db->connect();

	$cols = '*';
	$where = "dieID=" . $dieID;

	// use row["name"] to access the data
	$result = $db->select($table, $cols, $where, $in);
	$row = $result->fetch_assoc();

	$db->disconnect();

	// return $row;
?>