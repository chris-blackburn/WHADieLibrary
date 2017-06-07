<?php
	require 'sqlHandler.php';

	$db = new Database('localhost', 'monty', 'some_pass', 'testDB');
	$db->connect();

	$table = "DieLibrary";
	$result = $db->select($table);

	$db->disconnect();

	echo "
		<table>
			<caption>WHA Die Library</caption>
			<thead>
				<tr>
					<th id=\"id_header\">ID</th>
					<th id=\"jb_header\">Job Number</th>
					<th id=\"csr_header\">CSR Name</th>
					<th id=\"dt_header\">Date</th>
				</tr>
			</thead>
			<tbody>
		";

	while ($row = $result->fetch_assoc()) {
		echo "	<tr>
					<td>" . $row['id'] . "</td>
					<td>" . $row['job_num'] . "</td>
					<td>" . $row['csr_name'] . "</td>
					<td>" . $row['date'] . "</td>
				</tr>";
	}

	echo "
			</tbody>
		</table>
		";
?>