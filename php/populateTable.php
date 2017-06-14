<?php
	require 'sqlHandler.php';

	// Prepare the arguments
	$table = $_POST["table"];
	$cols = '*';
	$where = NULL;
	$in = NULL;
	$order = $_POST["order"];

	// create a new database object and connect
	$db = new Database('localhost', 'monty', 'some_pass', 'testDB');
	$db->connect();

	// if there is an order, submit different arguments
	if ($order == NULL)
		$result = $db->select($table);
	else
		$result = $db->select($table, $cols, $where, $in, $order[0], $order[1]);

	// disconnect from the sql server, we already have the data we need
	$db->disconnect();

	// parse the data into table rows
	while ($row = $result->fetch_assoc()) {
		$dateLastUsed = $row['dateLastUsed'];

		if ($dateLastUsed == "1983-01-01")
			$dateLastUsed = "Never";

		echo "	<tr class=\"table_rows\" name=\"" . $row['dieID'] . "\">
					<td class=\"table_checkboxes\"><input name=\"" . $row['dieID'] . "\" type=\"checkbox\"></td>
					<td class=\"dieID_row\">" . $row['dieID'] . "</td>
					<td class=\"dateLastUsed_row\">" . $dateLastUsed . "</td>
					<td class=\"machine_row\">" . $row['machine'] . "</td>
					<td class=\"location_row\">" . $row['location'] . "</td>
					<td class=\"description_row\">" . $row['description'] . "</td>
				</tr>";
	}
?>