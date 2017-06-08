<html>
<title>WHA Die Library</title>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<script>
	function populateTable() {
		$.get(
			"populateTable.php",
			null,
			function(data) { $("#table_body").html(data); },
			"html"
		);
	}

	$(document).ready(function() {
		populateTable();

		$("#table_refresh").click(function() {
			populateTable();
		});
	});

	
/*
	$("#insert_form").submit(function(event) {
		event.preventDefault();

		$.post(
			url,
			$("#insert_form").serialize();,
			function(data) { $("#table").html(data); },
			"html"
		);

		posting.done(function(data) {
			alert('success');
		});
	});*/

</script>

<body>
	<div class="dieLibrary_div">
		<button id="table_refresh">Refresh Table</button>

		<table>
				<caption>WHA Die Library</caption>
				<thead>
					<tr>
						<th id="check"></th>
						<th id="jb_header">Job Number</th>
						<th id="csr_header">CSR Name</th>
						<th id="dt_header">Date</th>
					</tr>
				</thead>
				<tbody id="table_body">

				</tbody>
		</table>

		<button class="insert">Insert</button>
		<button class="delete">Delete</button>
		<button class="update">Update</button>
	</div>

	<h3 class="insert_form">Create New Entry</h3>
	<form id="insert_form" class="insert_form" method="POST" action="newEntry.php">
		Job Number: <input type="text" name="job_num" required><br>
		Your Name: <input type="text" name="csr_name" required><br>
		<input type="submit" value="Submit">
	</form>

</body>
</html>