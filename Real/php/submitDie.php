<?php
	require_once "Database.php";
	include_once "../includes/constants.php";

	// fields to ignore when sorting through all the POST data
	$unwantedFields = [ "function", "dieID" ];

	// for each POST, add it to the respective array, ignoring entries in unwantedFields
	foreach ($_POST as $col => $value) {
		// avoid sending unwanted data
		if (in_array($col, $unwantedFields))
			continue;
		
		$cols[] = $col;
		$values[] = $value;
	}

	$table = DIE_TABLE;

	// connect to the database
	$db = new Database();
	$db->connect(/*$updateUser, $updateUserPass*/);

	// adding new entry or editing an existing one?
	$function = $_POST['function'];

	if ($function == "add")
		$db->insert($table, $values, $cols);
	else if ($function == "edit") {
		$where = "dieID";
		$in = $_POST["dieID"];
		$db->update($table, $values, $cols, $where, $in);
	}

	$db->disconnect();
?>