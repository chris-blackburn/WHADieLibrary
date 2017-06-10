<!DOCTYPE html>

<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

<html>
<head>
	<title>WHA Die Library</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="js/jquery.js" type="text/javascript"></script>
</head>

<body>

	<div class="table_container">
		<table>
			<thead>
				<tr>
					<th id="check_header">Select</th>
					<th id="jb_header" value="asc">Job Number</th>
					<th id="csr_header" value="asc">CSR Name</th>
					<th id="dt_header" value="asc">Date</th>
				</tr>
			</thead>
			<tbody class="table_body">
				<!-- This gets populated by populateTable.php -->
			</tbody>
		</table>
	</div>

	<button id="table_refresh">Refresh Table</button>

	<br>

	<button id="insert_btn">New Entry</button>
	<button id="delete_btn">Delete Selected</button>
	<button id="update_btn">Update Selected</button>

	<div hidden class="insert_form_container">
		<h3>Create New Entry</h3>
		<form method="POST" action="newEntry.php">
			Job Number: <input type="text" id="job_num" name="job_num" required><br>
			Your Name: <input type="text" id="csr_name" name="csr_name" required><br>
			<input type="submit" value="Submit">
		</form>
	</div>

</body>
</html>