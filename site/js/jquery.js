/*
	This runs when the webpage is loaded, event handlers need to be here so they get initialized
*/
$(document).ready(function() {

	// fallback for date fields
	if ( $('input[type="date"]').prop('type') != 'date' ) {
	    $('input[type="date"]').datepicker({
	    	dateFormat: "yy-mm-dd",
	    	closeText: "Close"
	    });
	}

	// create event handler for tabs
	$(".tab-buttons").on("click", "button", function() {

		// hide buttons that should be hidden
		$("button.hidden").each(function() {
			$(this).hide();
		});

		// remove the active class from all buttons
		$(".tab-buttons button").removeClass("active-tab");
		// add active to the button that called the handler
		$(this).addClass("active-tab");

		// hide all tab content and show the relevant content, target content is in the name attribute
		var $target = $(this).attr("name");
		$(".tab-content").hide();
		$("#" + $target).show();

		// if the class is hidden, hide, unless it is the active tab
		if ($(this).hasClass("hidden") && !$(this).hasClass("active-tab")) {
			$(this).hide();
		} else {
			$(this).show();
		}

	});

	// create event handler for tabs in the update form
	$(".tab-buttons-2").on("click", "button", function() {
		// remove the active class from all buttons
		$(".tab-buttons-2 button").removeClass("active-tab-2");
		// add active to the button that called the handler
		$(this).addClass("active-tab-2");

		// hide all tab content and show the relevant content, target content is in the name attribute
		var $target = $(this).attr("name");
		$(".tab-content-2").hide();
		$("#" + $target).show();
	});

	$("#pdf-container").click();

	// set the active tab
	$("#die-table-btn").click();
	
	// make tables of class tablesorter, sortable
	$(".tablesorter").tablesorter();

	// populate the table when the page loads
	populateDieTable();
	populateJobTable();

	// handler for any forms
	$(".forms form").submit(function(event) {
		// change the way the tag select sends data
		if ($(this).has("#tags")) {
			var selMulti = $.map($("#tags option:selected"), function (el, i) {
		         return $(el).text();
		    });

			$("input[name=\"tags\"]").val(selMulti.join(", "));
		}

		var $formData;

		// if the form has a file to upload, the data needs to be sent a different way
		if (typeof FormData !== 'undefined') {
			event.preventDefault();
			$formData = new FormData(this);
		} else if (!$(this).has("input[type=file]")) {
			event.preventDefault();
			$formData = $(this).serialize();
		} else {
			return;
		}

		// send POST to the url, where the data is handled and the entry is added
		$.ajax({
			url: $(this).attr("action"),
			type: "POST",
			data: $formData,
			contentType: false,
    		processData: false,
			success: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);

				// update the die table on success and switch to the table tab
				populateDieTable();
				populateJobTable();
				$("#die-table-btn").click();
			},
			error: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);
			}
		});

		$(this)[0].reset();
	});

	// handler for clicking a die entry, pull up the update form and fill it with that die's info
	$(".tables tbody").on("dblclick", "tr", function() {
		// grab the die id of the current entry
		var $dieID = $(this).attr("name");
		var $url = "../php/getEntryByID.php";

		// sent a GET request to grab all the info about the clicked entry
		$.ajax({
			url: $url,
			type: "GET",
			data: {
				dieID: $dieID
			},
			success: function(data, status) {
				data = trimJSON(data);
				console.log("Status: " + status + "\nData: " + data[0]);

				// extract the json object from the returned data
				$json = $.parseJSON(data[1]);

				for (var name in $json) {
					// any element in the div with name attribute ending with name string
					$("#update-form-container [name$=\"" + name + "\"").val($json[name]);

				}

				// for viewing the pdf of the die
				$diePath = "../dies/" + $dieID + "/";

				$pdfLocation = "../dies/" + $dieID + "/" + $dieID + ".pdf"
				$("#pdf-obj").attr("data", $pdfLocation);
				$("#pdf-obj a").attr("href", $pdfLocation);
				$("#pdf-obj iframe").attr("src", $pdfLocation);

				$("#pdf-container-btn").click();

				// grab all other files
				$.ajax({
					url: "../php/getFilesByID.php",
					type: "POST",
					data: {
						dir: $diePath
					},
					success: function(data, status) {
						$("#download-links").empty();
						$("#download-links").append("Download Links:" + data);
					},
					error: function(data, status) {
						console.log("Status: " + status + "\nData: " + data);
					}
				});

				$("#update-btn").click();

			},
			error: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);
			}
		})

	});

	$("#die-table").on("click", ".pull-btn", function() {
		// grab the die id from the row of the clicked button
		$dieID = $(this).parents("tr").attr("name");
		$location = $(this).parent().siblings(".location-row").text().slice(0, -1);

		// set the die id in the pull request form and switch tabs
		$("#pull-form-container [name$=\"dieID\"").val($dieID);
		$("#pull-form-container [name$=\"location\"").val($location);
		$("#pull-btn").click();
	});

	$("button.refresh-table").on("click", function() {
		var $parentID = $(this).parent().attr("id");

		if ($parentID == "die-table")
			populateDieTable();
		else if ($parentID == "job-table")
			populateJobTable();
	});

	// quick search 
	$(".table-quick-search").keyup(function(event) {
		var $rows = $("#" + $(this).parent().attr("id") + " tbody tr");

		if ($(this).val() == '') {
			$rows.show();
		} else {
			var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
	        	reg = RegExp(val, 'i'),
	        	text;		

        	$rows.show().filter(function() {
		        text = $(this).text().replace(/\s+/g, ' ');
		        return !reg.test(text);
		    }).hide();
        }
	});
});

/*
	*****************************************************************************
	*****************************	Functions	*********************************
	*****************************************************************************
*/

function trimJSON(data) {
	// extract the text to put in the console log
	var $regex = /\[?({(("[a-zA-Z_$][a-zA-Z_$0-9]*"):(".*"|null),?)+},?)+\]?/g;

	var str = [
		data.replace($regex, ""),
		data.match($regex)
	];

	return str;
}

function populateDieTable() {
	var $url = "../php/getTable.php";

	$.ajax({
		url: $url,
		type: "GET",
		data: { table: "die" },
		success: function(data, status) {
			// add ignore json data
			var data = trimJSON(data);
			console.log("Status: " + status + "\nData: " + data[0]);

			// prime the json data
			$json = $.parseJSON(data[1]);

			// empty the existing data
			$("#die-table tbody").empty();

			// while there is another json object
			for (var $index in $json) {
				// create the row element
				$row =  "<tr class=\"table-rows\" name=\"" + $json[$index]['dieID'] + "\">";
				$row +=	"<td class=\"dieID-row\">" + $json[$index]['dieID'] + " </td>";
				$row +=	"<td class=\"datePurchased-row\">" + $json[$index]['datePurchased'] + " </td>";
				$row +=	"<td class=\"machine-row\">" + $json[$index]['machine'] + " </td>";
				$row +=	"<td class=\"location-row\">" + $json[$index]['location'] + " </td>";
				$row +=	"<td class=\"description-row\">" + $json[$index]['description'] + " </td>";
				$row +=	"<td class=\"pull-row\"><button class=\"pull-btn\"><img style=\"height: 3em; width: auto;\" src=\"../img/pull.png\"></button></td>";
				$row +=	"<td hidden>" + $json[$index]['tags'] + " </td>";
				$row += "</tr>";

				// add the row to the table
				$("#die-table tbody").append($row);
			}
					
			// update sorting
			$(".tablesorter").trigger("update");
		
		},
		error: function(data, status) {
			console.log("Status: " + status + "\nData: " + data);
		}
	})
}

function populateJobTable() {
	var $url = "../php/getTable.php";

	$.ajax({
		url: $url,
		type: "GET",
		data: { table: "job" },
		success: function(data, status) {
			// add ignore json data
			data = trimJSON(data);
			console.log("Status: " + status + "\nData: " + data[0]);

			// prime the json data
			$json = $.parseJSON(data[1]);

			// empty the existing data
			$("#job-table tbody").empty();

			// while there is another json object
			for (var $index in $json) {
				// create the row element
				$row =  "<tr class=\"table-rows\" name=\"" + $json[$index]['dieID'] + "\">";
				$row +=		"<td>" + $json[$index]['jobNumber'] + "</td> "
				$row +=		"<td>" + $json[$index]['dieID'] + "</td> "
				$row +=		"<td>" + $json[$index]['customerName'] + "</td> "
				$row +=		"<td>" + $json[$index]['jobDate'] + "</td> "
				$row +=	"</tr>";

				// add the row to the table
				$("#job-table tbody").append($row);
			}

			// update sorting
			$(".tablesorter").trigger("update");
		},
		error: function(data, status) {
			console.log("Status: " + status + "\nData: " + data);
		}
	})
}