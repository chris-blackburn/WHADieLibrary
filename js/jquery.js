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
This runs when the webpage is loaded
*/
$(document).ready(function() {
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
	on click, run populateTable()
	*/
	$("#table_btn").click(function() {
		// change the active tab
		$(".tabs button").removeClass("active_tab");
		$(this).addClass("active_tab");

		$(".tab_content").hide();
		$("#table_container").show();
		populateTable(null);
	});

	// open the table tab and load the table by calling the table button click event function
	$("#table_btn").click();

	/*
		on click, show the form for entering new data
	*/
	$("#insert_btn").click(function() {
		$(".tabs button").removeClass("active_tab");
		$(this).addClass("active_tab");

		$(".tab_content").hide();
		$("#insert_form_container").show();
	});

	/*
		Handles the form submit event, sends a post request to newEntry.php with 
			the data in the form and refreshes the table
		*/
	$("#insert_form_container form").submit(function(event) {
		event.preventDefault();

		$.ajax({
			type: "POST",
			url: "php/newEntry.php",
			data: { 
				// This is where all the form data is set
				job_num: $("#job_num").val(), 
				csr_name: $("#csr_name").val() 
			},
			success: function(data, status) {
				console.log("Data: " + data + "\nPost Status: " + status);

				$("#table_btn").click();
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
		go to edit tab when an entry is clicked
	*/
	$(".table_body tr").click(function() {
		alert("row clicked");

		/*// reset the active tab
		$(".tabs button").removeClass("active_tab");
		$("#update_btn").addClass("active_tab");
		$("#update_btn").show();

		// hide all other content and show the update form
		$(".tab_content").hide();*/

	});

	

});
