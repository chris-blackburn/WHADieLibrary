<!DOCTYPE html>

<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

<html>
<head>
	<title>WHA Die Library</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<script>
	/* 
		This function access populateTable.php and grabs the data. It proceeds to parse it into
			the table body with id 'table_body'
			*/
	function populateTable(argv) {

		// default to order by date, ascending
		if (argv == null) {
			argv = [ "date", "asc" ];
		}
		
		// send post request
		$.ajax({
			type: "POST",
			url: "populateTable.php",
			data: { order: argv },
			success: function(data, status) { 
				console.log("Data: " + data + "\nPost Status: " + status);
				$(".table_body").html(data);
			}
		})
	}

	function populateTableByOrder(headerID, order) {
		asc_desc = $(headerID).attr("value");

		populateTable([ order, asc_desc ]);

		if (asc_desc == "asc")
			$(headerID).attr("value", "desc");
		else if (asc_desc == "desc")
			$(headerID).attr("value", "asc");
	}

	/*
		This runs when the webpage is loaded, it sets up triggers and populates the table on startup
		*/
		$(document).ready(function() {
			populateTable(null);

		/*
			on click, run populateTable()
			*/
			$("#table_refresh").click(function() {
				populateTable(null);
			});

		/*
			on click, show the form for entering new data
			*/
			$("#insert_btn").click(function() {
				$(".insert_form").toggle();
			});

		/*
			Handles the form submit event, sends a post request to newEntry.php with 
				the data in the form and refreshes the table
				*/
			$("#insert_form").submit(function(event) {
				event.preventDefault();

				url = $(this).attr("action");

				$.ajax({
					type: "POST",
					url: url,
					data: { job_num: $("#job_num").val(), csr_name: $("#csr_name").val() },
					success: function(data, status) {
						console.log("Data: " + data + "\nPost Status: " + status);
						populateTable(null);
					}
				})
			});

		/*
			deletes entries that have their boxes checked
			*/
			$("#delete_btn").click(function() {
			// grab all the checked boxes
			var selected = [];
			$(".table_checkboxes input[type=\"checkbox\"]:checked").each(function() {
				selected.push($(this).attr("id"));
			});

			if (selected.length != 0) {
				// send POST data to deleteSelected.php containing the array of checked boxes
				$.ajax({
					type: "POST",
					url: "deleteSelected.php",
					data: { checks: selected },
					success: function(data, status) {
						console.log("Data: " + data + "\nPost Status: " + status);
						populateTable(null);
						}
					})
				} else {
					console.log("Delete: Nothing is Selected");
				}
			});

		/*
			used for ordering the table when clicking on the headers
			*/
			$("#jb_header").click(function() {
				populateTableByOrder($(this), "job_num");
			});

			$("#csr_header").click(function() {
				populateTableByOrder($(this), "csr_name");
			});

			$("#dt_header").click(function() {
				populateTableByOrder($(this), "date");
			});
		/*
			bring up form for update entry wen double click entry
			*/
		});

</script>

<body>
	<button id="table_refresh">Refresh Table</button>

	<div class="table_container">
		<table>
			<thead>
				<tr class="headers">
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

	<button id="insert_btn">New Entry</button>
	<button id="delete_btn">Delete Selected</button>
	<button id="update_btn">Update Selected</button>

	<div hidden class="insert_form">
		<h3>Create New Entry</h3>
		<form id="insert_form" method="POST" action="newEntry.php">
			Job Number: <input type="text" id="job_num" required><br>
			Your Name: <input type="text" id="csr_name" required><br>
			<input type="submit" value="Submit">
		</form>
	</div>

</body>
</html>