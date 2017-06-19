/* 
This function access populateTable.php and grabs the data. It proceeds to parse it into
	the table body with id 'table-body'
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
			table: $("#table-container").attr("value"),
			order: argv 
		},
		success: function(data, status) { 
			console.log("Data: " + data + "\nPost Status: " + status);
			$(".table-body").html(data);
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
	$(".table-head th").click(function() {
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
	$("#table-btn").click(function() {
		populateTable(null);

		// change the active tab
		$(".tabs button").removeClass("active-tab");
		$(this).addClass("active-tab");

		$(".tab-content").hide();
		$("#table-container").show();
	});

	// open the table tab and load the table by calling the table button click event function
	$("#table-btn").click();

	/*
		on click, show the form for entering new data
	*/
	$("#insert-btn").click(function() {
		$(".tabs button").removeClass("active-tab");
		$(this).addClass("active-tab");

		$(".tab-content").hide();

		// set the date fields to have the current date
		$.ajax({
			type: "GET",
			url: "php/getCurrentDate.php",
			success: function(data) {
				$("#insert-form-container [name=\"datePurchased\"]").val(data);
			}
		})

		$("#insert-form-container").show();
	});

	// the update button is hidden on page load
	$("#update-btn").click(function() {
		// reset the active tab
		$(".tabs button").removeClass("active-tab");
		$("#update-btn").addClass("active-tab");
		$("#update-btn").show();

		// hide all other content and show the update form
		$(".tab-content").hide();
		$("#update-form-container").show();
	});

	$("#pull-btn").click(function() {
		// reset the active tab
		$(".tabs button").removeClass("active-tab");
		$("#pull-btn").addClass("active-tab");
		$("#pull-btn").show();

		// hide all other content and show the pull request form
		$(".tab-content").hide();
		$("#pull-form-container").show();
	});

	// pull requests
	$(".table-body").delegate(".pull-btn", "click", function(event) {
		var rowID = $(this).parents(".table-rows").attr("name");
		var dateLastUsed = $(this).parent().siblings(".dateLastUsed-row").text();

		$("#pull-form-container [name=\"dieID\"]").val(rowID);
		$("#pull-form-container [name=\"dateLastUsed\"]").val(dateLastUsed);
		
		$("#pull-btn").click();
	});

	/*
		Handles the form submit event, sends a post request to insertEntry.php with 
			the data in the form and refreshes the table
	*/
	$("#insert-form-container form").submit(function(event) {
		event.preventDefault();

		$.ajax({
			type: "POST",
			url: "php/insertEntry.php",
			data: $(this).serialize(),
			success: function(data, status) {
				console.log("Data: " + data + "\nPost Status: " + status);

				$("#table-btn").click();
			}
		})
	});

	/*
		deletes entries that have their boxes checked
	*/
	$("#delete-btn").click(function() {
		// confirmation dialog
		$("#confirm-delete").dialog({
			buttons: {
				"Cancel": function() {
					$(this).dialog("close");
				},

				"Confirm": function() {
					// grab all the checked boxes
					var selected = new Array();
					$(".table-checkboxes [type=\"checkbox\"]:checked").each(function() {
						selected.push($(this).parents(".table-rows").attr("name"));
					});

					if (selected.length != 0) {
						// send POST data to deleteSelected.php containing the array of checked boxes
						$.ajax({
							type: "POST",
							url: "php/deleteSelected.php",
							data: { 
								table: $("#table-container").attr("value"),
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

					$(this).dialog("close");
				}
			}
		});
	});

	/*
		go to edit form when an entry is double clicked and
			populate it with the entry's data
	*/
	$(".table-body").delegate("tr", "dblclick", function() {
		// send a post request with the table name and dieID to grab the rest of the data
		$.ajax({
			type: "GET",
			url: "php/populateUpdateForm.php",
			data: {
				table: $("#table-container").attr("value"),
				dieID: $(this).attr("name"),
				cols: '*'
			},
			dataType: "JSON",
			success: function(data, status) {
				console.log("Data: " + data + "\nGET Status: " + status);

				// fill up the form with the existing data, contains some conditionals for dates and checkboxes
				for (var name in data) {
					console.log(name + "->" + data[name]);
					if (name == "docketReviewed") {
						if (data[name] == "true") // used to make the checkbox checked or not
							$("#update-form-container [type=\"checkbox\"][name=\"" + name + "\"]").attr("checked", true);
						else
							$("#update-form-container [type=\"checkbox\"][name=\"" + name + "\"]").attr("checked", false);
					} if (name == "dateLastUsed" && (data[name] == "1983-01-01" || data[name] == "0000-00-00")) {
						$("#update-form-container output[name=\"dateLastUsed\"]").val("Never");
					} else {
						$("#update-form-container [name=\"" + name + "\"]").val(data[name]);
					}
				}
			}
		})

		$("#update-btn").click();

	});

	$("#update-form-container form").submit(function(event) {
		event.preventDefault();

		$.ajax({
			type: "POST",	
			url: "php/insertEntry.php",
			data: $(this).serialize(),
			success: function(data, status) {
						console.log("Data: " + data + "\nPost Status: " + status);

						$("#table-btn").click();
					}
		})
	});

	// filter 
	function filter(selector, query) {
		query = $.trim(query);
		query = query.replace(/ /gi, "|");

		if ($(this).text().search(new RegExp(query, "i")) < 0) {
			$(this).hide();
		} else {
			$(this).show();
		}
	}

	// quick search 
	$("#table-quick-search").keyup(function(event) {
		var $row = $(".table-body tr");

		if ($(this).val() == '') {
			$(".table-body tr").show();
		} else {
			var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
	        	reg = RegExp(val, 'i'),
	        	text;		

        	$row.show().filter(function() {
		        text = $(this).text().replace(/\s+/g, ' ');
		        return !reg.test(text);
		    }).hide();
        }
	});

	// auto-complete for tags, separated arrays for later implemenation
	$(function() {
		var productTags = [
			"Business Card",
			"Brochure",
			"Booklet/Catalog",
			"Box",
			"Coupon",
			"Coaster",
			"CD/DVD Holder",
			"Door Hanger",
			"Envelope",
			"Hang Tag",
			"Invitation/Greeting Card",
			"Pocket",
			"Sticker/Label",
			"Tent"
		];

		var featuresTags = [
			"BC Slit",
			"Corner",
			"Gusset",
			"Horizontal Pocket",
			"Moon BC Slits",
			"Perforation",
			"Pop Up/3D",
			"Shape",
			"Tabs",
			"Vertical Pocket",
			"Window",
			"Wrap"
		];

		var items = $.merge(productTags, featuresTags);

		function split( val ) {
		    return val.split( /,\s*/ );
		}

		function extractLast(term) {
			return split(term).pop();
		}

		// this is where the autocomplete happens, jquery makes it easy
		$("#insert-form-container [name=\"tags\"]").autocomplete({
			source: function(request, response) {
                response($.ui.autocomplete.filter(
                items, extractLast(request.term)));
            },
			focus: function() {
				return false;
			},
			select: function( event, ui ) {
		        var terms = split( this.value );
		        // remove the current input
		        terms.pop();
		        // add the selected item
		        terms.push( ui.item.value );
		        // add placeholder to get the comma-and-space at the end
		        terms.push( "" );
		        this.value = terms.join( ", " );
		        return false;
	        }
		});
	});
	
	

});
