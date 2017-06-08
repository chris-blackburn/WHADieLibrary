<html>
<title>WHA Die Library</title>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<script>
	/* 
		This function access populateTable.php and grabs the data. It proceeds to parse it into
			the table body with id 'table_body'
	*/
	function populateTable() {
		$.get(
			"populateTable.php",
			null,
			function(data) { $("#table_body").html(data); },
			"html"
		);
	}

	/*
		This runs when the webpage is loaded, it sets up triggers and populates the table on startup
	*/
	$(document).ready(function() {
		populateTable();

		$("#table_refresh").click(function() {
			populateTable();
		});

		$("#insert_form").submit(function(event) {
			event.preventDefault();

			url = $(this).attr("action");

			$.post(
				url,
				{
					job_num: $("#job_num").val(),
					csr_name: $("#csr_name").val()
				},
				function(data, status) {
					//alert("Data: " + data + "\nPost Status: " + status);
					populateTable();
				});
		});
	});

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

		<button id="insert">Insert</button>
		<button id="delete">Delete Selected</button>
		<button id="update">Update Selected</button>
	</div>

	<div class="insert_form">
		<h3>Create New Entry</h3>
		<form id="insert_form" method="POST" action="newEntry.php">
			Job Number: <input type="text" id="job_num" name="job_num" required><br>
			Your Name: <input type="text" id="csr_name" name="csr_name" required><br>
			<input type="submit" value="Submit">
		</form>
	</div>

</body>
</html>