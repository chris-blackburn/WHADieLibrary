<?php
	require 'sqlHandler.php';

	// create a new database object and connect
	$db = new Database('localhost', 'monty', 'some_pass', 'testDB');
	$db->connect();

	/*
		by sending only the table argument to select(), it returns every entry in that table 
			which we store into the variable 'result'
	*/
	$table = "DieLibrary";
	$result = $db->select($table);

	// disconnect from the sql server, we already have the data we need
	$db->disconnect();

	// parse the data into table rows
	while ($row = $result->fetch_assoc()) {
		echo "	<tr>
					<td class=\"checkboxes\"><input id=\"" . $row['id'] . "\" type=\"checkbox\"></td>
					<td>" . $row['job_num'] . "</td>
					<td>" . $row['csr_name'] . "</td>
					<td>" . $row['date'] . "</td>
				</tr>";
	}
?>