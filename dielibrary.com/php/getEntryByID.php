<?php
	require_once "Database.php";
	include_once "constants.php";

	// get the die ID
	$dieID = $_GET["dieID"];

	// create new database connection
	$db = new Database();
	$db->connect();

	// grab the data from the database
	//$result = $db->select(DIE_TABLE, "*", "dieID", $dieID);
	$sql = "SELECT
			    d.*,
			    jobDateMax.dateLastUsed
			FROM
			    dies d
			LEFT JOIN(
			    SELECT
			        dieID,
			        MAX(jobDate) AS dateLastUsed
			    FROM
			        jobs
			    GROUP BY
			        dieID
			) jobDateMax
			ON
			    d.dieID = jobDateMax.dieID
			WHERE
				d.dieID = " . $dieID;

	$result = $db->query($sql);
	$row = $result->fetch_assoc();

	// return json of the row data
	echo json_encode($row);

	// free the result data
	$result->free_result();

	// disconnect from the database
	$db->disconnect();

?>

