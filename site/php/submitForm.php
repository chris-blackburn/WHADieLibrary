<?php
	require_once "Database.php";
	include_once "constants.php";

	// for each POST, add it to the respective array, ignoring entries in unwantedFields
	foreach ($_POST as $col => $value) {
		// avoid sending unwanted data, unwanted fields have no markers, ! is for dies, ? is for jobs
		if ($col{0} == "!") {
			$dieArr[substr($col, 1)] = $value;
		} else if ($col{0} == "?") {
			$jobArr[substr($col, 1)] = $value;
		}
	}

	// connect to the database
	$db = new Database();
	$db->connect(/*$updateUser, $updateUserPass*/);

	// "add" or "edit" for each type of data (jobs only have "add")
	if (isset($_POST["dieFunction"]))
		$dieFunction = $_POST["dieFunction"];

	if (isset($_POST["jobFunction"]))
		$jobFunction = $_POST["jobFunction"];

	// init vars so they are in a greater scope
	$qID = -1;

	// dies
	$table = DIE_TABLE;

	if ($dieFunction == "add") {
		$db->insert($table, array_values($dieArr), array_keys($dieArr));

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
				echo "Failed to upload file: " . $targetFile . " (" . $_FILES["pdfFile"]["error"] . ")";
		} else {
			echo "No File Uploaded";
		}
	} else if ($dieFunction == "edit") {
		// if the marker for dieID (not to be submited normally) is set, update where the ID is matched
		if (isset($_POST["dieID"])) {
			$db->update($table, array_values($dieArr), array_keys($dieArr), "dieID", $_POST["dieID"]);
		} else {
			echo "No Die ID set for update...";
		}
	}

	// jobs
	$table = JOB_TABLE;

	if ($jobFunction == "add") {
		// add the dieID for the job if it is not already set
		if (!array_key_exists("dieID", $jobArr))
			$jobArr["dieID"] = $qID;

		$db->insert($table, array_values($jobArr), array_keys($jobArr));
	}

	$db->disconnect();
?>