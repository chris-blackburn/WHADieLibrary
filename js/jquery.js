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
		url: "php/populateTable.php",
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
		$(".insert_form_container").toggle();
	});

/*
	Handles the form submit event, sends a post request to newEntry.php with 
		the data in the form and refreshes the table
		*/
	$(".insert_form_container form").submit(function(event) {
		event.preventDefault();

		$.ajax({
			type: "POST",
			url: "php/newEntry.php",
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
			url: "php/deleteSelected.php",
			data: { checks: selected },
			success: function(data, status) {
				console.log("Data: " + data + "\nPost Status: " + status);
				populateTable(null);
				}
			})
		} else {
			console.log("Cannot Delete: Nothing is Selected");
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
