<?php
/*
	This script takes POST data containing a list of id numbers which it will use
		to create SQL code to remove entries with those id numbers
*/
require "sqlHandler.php";

// store the posted data into a variable
$selected = $_POST["checks"];

// make sure the array was populated, no reason to send a SQL query if it's NULL
if (count($selected) != 0) {
	//echo "SELECTED[]: " . implode(", ", $selected);

	// prepare arguments for delete function in the database class
	$table = "DieLibrary";
	$where = "id";
	$in = "( " . implode(", ", $selected) . " )";

	/*
	Create new database object, setEcho on for error messages, connect to it,
		insert using the prepped variables, and disconnect once we have the data
	*/
	$db = new Database('localhost', 'monty', 'some_pass', 'testDB'); 
	$db->setEcho(1);
	$db->connect();
	$db->delete($table, $where, $in);
	$db->disconnect();

} else {
	echo "Nothing Selected";
}
?>