<?php
	require 'sqlHandler.php';

	$job_num = $_POST["job_num"];
	$csr_name = $_POST["csr_name"];
	$date = date('Y-m-d h:i:sa');

	$table = "DieLibrary";
	$values = $job_num . ", \"" . $csr_name . "\", \"" . $date . "\"";
	$cols = "job_num, csr_name, date";

	//$sql = "INSERT INTO DieLibrary (job_num, csr_name, date) VALUES (" . $job_num . ", \"" . $csr_name . "\", \"" . $date . "\")";

	$db = new Database('localhost', 'monty', 'some_pass', 'testDB'); $db->setEcho(1);
	$db->connect();
	$db->insert($table, $values, $cols);
	$db->disconnect();

	//header("Location: index.php");
?>