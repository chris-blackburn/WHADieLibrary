<?php
	require_once "Database.php";
	include_once "../includes/constants.php";

	print_r($_FILES);
	print_r($_POST);

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

	if ($function == "add") {
		$db->insert($table, $values, $cols);

		// grab the id of the query that just went through
		$qID = $db->getQueryID();

		// check if a file was uploaded 
		if (is_uploaded_file($_FILES["pdfFile"]["tmp_name"])) {
			// setup save location and filename (used the id of what was just submitted)
			$targetDir = PDF_DIR;
			$targetFile = $targetDir . $qID . ".pdf";

			// upload the file
			if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile))
				echo "File Uploaded!";
			else
				echo "Failed to upload file";
		} else {
			echo "No File Uploaded";
		}

	} else if ($function == "edit") {
		$where = "dieID";
		$in = $_POST["!dieID"];
		$db->update($table, $values, $cols, $where, $in);
	}

	$db->disconnect();
?>