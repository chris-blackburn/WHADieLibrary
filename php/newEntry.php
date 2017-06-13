<?php
	require 'sqlHandler.php';

	$table = 			$_POST["table"];
	$jobNumber =  		$_POST["jobNumber"];
	$customerID = 		$_POST["customerID"];
	$description = 		$_POST["description"];
	$tags = 			$_POST["tags"];
	$datePurchased = 	$_POST["date"];
	$expectedUsage =	$_POST["expectedUsage"];
	$location =			$_POST["location"];
	$machine = 			$_POST["machine"];
	$flatWidth = 		$_POST["flatWidth"];
	$flatHeight = 		$_POST["flatHeight"];
	$finishedWidth = 	$_POST["finishedWidth"];
	$finishedHeight = 	$_POST["finishedHeight"];
	$pockets = 			$_POST["pockets"];
	$pocketSize = 		$_POST["pocketSize"];
	$numberUp = 		$_POST["numberUp"];
	$reviewed = 		$_POST["reviewed"];

	
		// prepare the arguements for database's insert() function
	$values = 	[
					$jobNumber,
					$customerID,
					$description,
					$tags,
					$datePurchased,
					$expectedUsage,
					$location,
					$machine,
					$flatWidth, 
					$flatHeight,
					$finishedWidth, 
					$finishedHeight,
					$pockets,
					$pocketSize,
					$numberUp,
					$reviewed
				];

		// columns to be affected
	
	$cols = 	[
					"jobNumber",
					"customerID",
					"description",
					"tags",
					"datePurchased",
					"expectedUsage",
					"location",
					"machine",
					"flatWidth", 
					"flatheight",
					"finishedWidth", 
					"finishedHeight",
					"numPockets",
					"pocketSize",
					"numberUp",
					"reviewed"
				];
			

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