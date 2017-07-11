<?php
	function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}

	function uploadFiles($qID) {
		// if no files were uploaded, then return
		if (empty($_FILES))
			return "No Files Uploaded.\n";

		$targetPath = PDF_DIR . $qID . "/";
		// make a new folder for the die unless it already exists
		if (@mkdir(PDF_DIR . $qID)) {
			echo "Directory " . $qID . " successfully created.\n";
		} else {
			echo "Could not create directory: " . $qID . ", " . error_get_last()["message"] . "\n";
		}

		// check if a die pdf file was uploaded 
		if ($_FILES["pdfFile"]["error"] != UPLOAD_ERR_NO_FILE) {
			// grab the filetype
			$filetype = end((explode(".", $_FILES["pdfFile"]["name"]))); # extra () to prevent notice

			// specify the target file
			if ($filetype == "pdf") {
				$targetFile = $targetPath . $qID . ".pdf";

				// upload the file
				if (@move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile))
					echo "File " . $targetFile . " Uploaded!\n";
				else
					echo "Failed to upload file: " . $targetFile . " (" . error_get_last()["message"] . ")\n";
			} else {
				echo "Incorrect Filetype...\n";
			} 
		} else {
			echo "No Die PDF File Uploaded.\n";
		}

		// for all the other files
		if ($_FILES["otherFiles"]["error"][0] != UPLOAD_ERR_NO_FILE) {
			// rearrange so the array is easier to use
			$otherFiles = reArrayFiles($_FILES["otherFiles"]);

			// upload each file
			foreach ($otherFiles as $file) {
				$targetFile = $targetPath . $file["name"];

				if (move_uploaded_file($file["tmp_name"], $targetFile))
					echo "File " . $targetFile . " Uploaded!\n";
				else
					echo "Failed to upload file: " . $targetFile . " (" . $file["error"] . ")\n";
			}
		} else {
			echo "No other files uploaded.\n";
		}
	}
?>

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

		echo uploadFiles($qID);
	} else if ($dieFunction == "edit") {
		// if the marker for dieID (not to be submited normally) is set, update where the ID is matched
		if (isset($_POST["dieID"])) {
			$db->update($table, array_values($dieArr), array_keys($dieArr), "dieID", $_POST["dieID"]);
			echo uploadFiles($_POST["dieID"]);
		} else {
			echo "No Die ID set for update...\n";
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