<html>
<title>WHA Die Library</title>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<script>
	function viewTable() {
		$.get(
			"viewTable.php",
			null,
			function(data) { $("#table").html(data); },
			"html"
		);
	}

	$(document).ready(function() {
		viewTable();

		$("#table_refresh").click(function() {
			viewTable();
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
	<button id="table_refresh">Refresh Table</button>
	<div id="table">Could Not Grab Table Data</div>

	<button class="insert">Insert</button>
	<button class="delete">Delete</button>
	<button class="update">Update</button>

	<h3 class="insert_form">Create New Entry</h3>
	<form id="insert_form" class="insert_form" method="POST" action="newEntry.php">
		Job Number: <input type="text" name="job_num" required><br>
		Your Name: <input type="text" name="csr_name" required><br>
		<input type="submit" value="Submit">
	</form>

</body>
</html>