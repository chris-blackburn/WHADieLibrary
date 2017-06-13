<?php
	require 'sqlHandler.php';

	// Prepare the arguments
	$table = $_POST["table"];
	$cols = '*';
	$where = NULL;
	$order = $_POST["order"];

	// create a new database object and connect
	$db = new Database('localhost', 'monty', 'some_pass', 'testDB');
	$db->connect();

	// if there is an order, submit different arguments
	if ($order == NULL)
		$result = $db->select($table);
	else
		$result = $db->select($table, $cols, $where, $order[0], $order[1]);

	// disconnect from the sql server, we already have the data we need
	$db->disconnect();

	// parse the data into table rows
	while ($row = $result->fetch_assoc()) {
		echo "	<tr class=\"table_rows\">
					<td class=\"table_checkboxes\"><input name=\"" . $row['id'] . "\" type=\"checkbox\"></td>
					<td class=\"row_id\">" . $row['id'] . "</td>
					<td class=\"row_dateEntered\">" . $row['dateEntered'] . "</td>
					<td class=\"row_machine\">" . $row['machine'] . "</td>
					<td class=\"row_location\">" . $row['location'] . "</td>
					<td class=\"row_description\">" . $row['description'] . "</td>
				</tr>";
	}
?>