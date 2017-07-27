<?php

	function brackets($str) {
		return "[ " . $str . " ]";
	}

	// grab the log data
	$data = $_POST['log'];

	date_default_timezone_set('America/New_York');

	// grab the date and time for entry in the log file
	$date = Date("m-d-Y H:i:s");

	$log = brackets($_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['SERVER_PORT']) . " " . brackets($date) . " " . $data;

	// write to the file
	$file = "../logs/client_logs.clogs";

	if (file_put_contents($file, $log, FILE_APPEND | LOCK_EX)) {
		// check file size and limit logs
	} else {
		die(error_get_last()["message"]);
	}

?>
