<?php
	require 'sqlHandler.php';

	$db = new Database('localhost', 'monty', 'some_pass', 'testDB');
	$db->connect();

	$table = "DieLibrary";
	$result = $db->select($table);

	$db->disconnect();

	while ($row = $result->fetch_assoc()) {
		echo "	<tr>
					<td><input id=\"check" . $row['id'] . "\"type=\"checkbox\"></td>
					<td>" . $row['job_num'] . "</td>
					<td>" . $row['csr_name'] . "</td>
					<td>" . $row['date'] . "</td>
				</tr>";
	}
?>