/* 
This function access populateTable.php and grabs the data. It proceeds to parse it into
	the table body with id 'table_body'
	*/
function populateTable(argv) {

	// default to order by date, ascending
	if (argv == null) {
		argv = [ "dateLastUsed", "desc" ];
	}

	// send post request
	$.ajax({
		type: "POST",
		url: "php/populateTable.php",
		data: { 
			table: $("#table_container").attr("value"),
			order: argv 
		},
		success: function(data, status) { 
			console.log("Data: " + data + "\nPost Status: " + status);
			$(".table_body").html(data);
		}
	})
}

/*
This runs when the webpage is loaded
*/
$(document).ready(function() {
	/*
		used for ordering the table when clicking on the headers, access the name attribute
			to reference the sql table => (ORDER BY [name])
	*/
	$(".table_head th").click(function() {
		order = $(this).attr("name");
		asc_desc = $(this).attr("value");

		populateTable([ order, asc_desc ]);

		if (asc_desc == "asc")
			$(this).attr("value", "desc");
		else if (asc_desc == "desc")
			$(this).attr("value", "asc");
	});

	/*
	on click, run populateTable()
	*/
	$("#table_btn").click(function() {
		populateTable(null);

		// change the active tab
		$(".tabs button").removeClass("active_tab");
		$(this).addClass("active_tab");

		$(".tab_content").hide();
		$("#table_container").show();
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

	// the update button is hidden on page load
	$("#update_btn").click(function() {
		// reset the active tab
		$(".tabs button").removeClass("active_tab");
		$("#update_btn").addClass("active_tab");
		$("#update_btn").show();

		// hide all other content and show the update form
		$(".tab_content").hide();
		$("#update_form_container").show();
	});

	/*
		Handles the form submit event, sends a post request to insertEntry.php with 
			the data in the form and refreshes the table
	*/
	$("#insert_form_container form").submit(function(event) {
		event.preventDefault();

		$.ajax({
			type: "POST",
			url: "php/insertEntry.php",
			data: $(this).serialize(),
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
		var selected = new Array();
		$(".table_checkboxes [type=\"checkbox\"]:checked").each(function() {
			selected.push($(this).attr("name"));
		});

		if (selected.length != 0) {
			// send POST data to deleteSelected.php containing the array of checked boxes
			$.ajax({
				type: "POST",
				url: "php/deleteSelected.php",
				data: { 
					table: $("#table_container").attr("value"),
					checks: selected 
				},
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
		go to edit form when an entry is double clicked and
			populate it with the entry's data
	*/
	$(".table_body").delegate("tr", "dblclick", function() {
		// send a post request with the table name and dieID to grab the rest of the data
		$.ajax({
			type: "GET",
			url: "php/populateUpdateForm.php",
			data: {
				table: $("#table_container").attr("value"),
				dieID: $(this).attr("name")
			},
			dataType: "JSON",
			success: function(data, status) {
						console.log("Data: " + data + "\nGET Status: " + status);

						for (var name in data) {
							console.log(name + "->" + data[name]);
							if (name == "docketReviewed")
								if (data[name] == "true")
									$("#update_form_container [type=\"checkbox\"][name=\"" + name + "\"]").attr("checked", true);
								else
									$("#update_form_container [type=\"checkbox\"][name=\"" + name + "\"]").attr("checked", false);
							else
								$("#update_form_container [name=\"" + name + "\"]").val(data[name]);
						}
					}
		})

		$("#update_btn").click();

	});

	$("#update_form_container form").submit(function(event) {
		event.preventDefault();

		$.ajax({
			type: "POST",	
			url: "php/insertEntry.php",
			data: $(this).serialize(),
			success: function(data, status) {
						console.log("Data: " + data + "\nPost Status: " + status);

						$("#table_btn").click();
					}
		})
	});
	
});
