<?php
	require 'sqlHandler.php';

		// grab the data posted to this script
	$job_num = $_POST["job_num"];
	$csr_name = $_POST["csr_name"];
	
		// prepare the arguements for database's insert() function
	$table = "DieLibrary";
	$values = [$job_num, $csr_name];
	$cols = ["job_num", "csr_name"];

		/*
			Create new database object, setEcho on for error messages, connect to it,
				insert using the prepped variables, and disconnect once we have the data
		*/
	$db = new Database('localhost', 'monty', 'some_pass', 'testDB'); 
	$db->setEcho(1);
	$db->connect();
	$db->insert($table, $values, $cols);
	$db->disconnect();
?>