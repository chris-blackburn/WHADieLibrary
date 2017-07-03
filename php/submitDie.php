<?php
	require_once "Database.php";
	include_once "../includes/constants.php";

	// for each POST, add it to the respective array, ignoring entries in unwantedFields
	foreach ($_POST as $col => $value) {
		// avoid sending unwanted data, unwanted fields start with "?" in the forms
		if ($col{0} == "!")
			continue;
		
		$cols[] = $col;
		$values[] = $value;
	}

	// switch tables depending on the entry type determined by the html form
	$type = $_POST["!type"];

	if ($type == "die")
		$table = DIE_TABLE;
	else if ($type == "job")
		$table = JOB_TABLE;

	// connect to the database
	$db = new Database();
	$db->connect(/*$updateUser, $updateUserPass*/);

	// adding new entry or editing an existing one?
	$function = $_POST["!function"];

	if ($function == "add")
		$db->insert($table, $values, $cols);
	else if ($function == "edit") {
		$where = "dieID";
		$in = $_POST["!dieID"];
		$db->update($table, $values, $cols, $where, $in);
	}

	$db->disconnect();
?>