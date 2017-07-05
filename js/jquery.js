/*
	This runs when the webpage is loaded, event handlers need to be here so they get initialized
*/
$(document).ready(function() {

	// create event handler for tabs
	$(".tab-buttons").on("click", "button", function() {
		// remove the active class from all buttons
		$(".tab-buttons button").removeClass("active-tab");
		// add active to the button that called the handler
		$(this).addClass("active-tab");

		// hide all tab content and show the relevant content, target content is in the name attribute
		var $target = $(this).attr("name");
		$(".tab-content").hide();
		$("#" + $target).show();

	});

	// set the active tab
	$("#die-table-btn").click();

	// make tables of class tablesorter, sortable
	$(".tablesorter").tablesorter();

	// populate the table when the page loads
	populateDieTable();
	populateJobTable()

	// handler for any forms
	$(".forms form").submit(function(event) {
		// if(typeof window.FormData === 'undefined') 
		event.preventDefault();

		// change the way the tag select sends data
		if ($(this).has("#tags")) {
			var selMulti = $.map($("#tags option:selected"), function (el, i) {
		         return $(el).text();
		    });

			$("input[name=\"tags\"]").val(selMulti.join(", "));
		}

		// grab the url
		var $url = $(this).attr("action");

		var $formData;

		// if the form has a file to upload, the data needs to be sent a different way
		if ($(this).has("input[type=file]")) {
			// grab form data
			$formData = new FormData();
			var $pdfFile = $("#file-upload").prop("files")[0];
			
			if ($pdfFile)
				$formData.append("pdfFile", $pdfFile);

			// append all other input data
			$(this).find("input[type!=submit][name], select[name]").each(function() {
				$name = $(this).attr("name");
				$val = $(this).val();

				$formData.append($name, $val);
			});
		} else {
			$formData = $(this).serialize();
		}

		// send POST to the url, where the data is handled and the entry is added
		$.ajax({
			url: $url,
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
		})
	});

	// handler for clicking a die entry, pull up the update form and fill it with that die's info
	$(".tables tbody").on("click", "tr", function() {
		// grab the die id of the current entry
		var $dieID = $(this).attr("name");
		var $url = "../php/populateUpdateDieForm.php";

		// sent a GET request to grab all the info about the clicked entry
		$.ajax({
			url: $url,
			type: "GET",
			data: {
				dieID: $dieID
			},
			success: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);

				// extract the json object from the returned data
				$json = data.substring(data.indexOf("{"), data.indexOf("}") + 1);
				$json = $.parseJSON($json);

				for (var name in $json) {
					// any element in the div with name attribute ending with name string
					$("#update-form-container [name$=\"" + name + "\"").val($json[name]);

				}

				// for viewing the pdf of the die
				$pdfLocation = "../dies/" + $dieID + ".pdf"
				$("#pdf-obj").attr("data", $pdfLocation);
				$("#pdf-obj a").attr("href", $pdfLocation);
				$("#pdf-obj iframe").attr("src", $pdfLocation);

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

		// set the die id in the pull request form and switch tabs
		$("#pull-form-container [name=\"dieID\"").val($dieID);
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

function populateDieTable() {
	var $url = "../php/getDieTable.php";

	$.ajax({
		url: $url,
		type: "GET",
		data: { table: "die" },
		success: function(data, status) {
			// add ignore json data
			console.log("Status: " + status + "\nData: " + data);

			// used to loop through each JSON object (they are separated by '~')
			$begin = data.indexOf("{");
			$end = data.indexOf("}");

			// prime the json data
			$json = $.parseJSON(data.substring($begin, $end + 1));

			// empty the existing data
			$("#die-table tbody").empty();

			// while there is another json object
			while ($begin > 0 && $end > 0) {
				// create the row element
				$row =  "<tr class=\"table-rows\" name=\"" + $json['dieID'] + "\">";
				$row +=		"<td class=\"dieID-row\">" + $json['dieID'] + " </td>";
				$row +=		"<td class=\"datePurchased-row\">" + $json['datePurchased'] + " </td>";
				$row +=		"<td class=\"machine-row\">" + $json['machine'] + " </td>";
				$row +=		"<td class=\"location-row\">" + $json['location'] + " </td>";
				$row +=		"<td class=\"description-row\">" + $json['description'] + " </td>";
				$row +=		"<td class=\"pull-row\"><button class=\"pull-btn\">Pull </button></td>";
				$row +=		"<td hidden>" + $json['tags'] + " </td>";
				$row +=	"</tr>";

				// add the row to the table
				$("#die-table tbody").append($row);


				// grab the next json object
				$begin = data.indexOf("{", $end + 1);
				$end = data.indexOf("}", $begin);

				if ($begin > 0 && $end > 0)
					$json = $.parseJSON(data.substring($begin, $end + 1));
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
	var $url = "../php/getDieTable.php";

	$.ajax({
		url: $url,
		type: "GET",
		data: { table: "job" },
		success: function(data, status) {
			// add ignore json data
			console.log("Status: " + status + "\nData: " + data);

			// used to loop through each JSON object (they are separated by '~')
			$begin = data.indexOf("{");
			$end = data.indexOf("}");

			// prime the json data
			$json = $.parseJSON(data.substring($begin, $end + 1));

			// empty the existing data
			$("#job-table tbody").empty();

			// while there is another json object
			while ($begin > 0 && $end > 0) {
				// create the row element
				$row =  "<tr class=\"table-rows\" name=\"" + $json['dieID'] + "\">";
				$row +=		"<td>" + $json['jobNumber'] + "</td> "
				$row +=		"<td>" + $json['dieID'] + "</td> "
				$row +=		"<td>" + $json['customerName'] + "</td> "
				$row +=		"<td>" + $json['jobDate'] + "</td> "
				$row +=	"</tr>";

				// add the row to the table
				$("#job-table tbody").append($row);


				// grab the next json object
				$begin = data.indexOf("{", $end + 1);
				$end = data.indexOf("}", $begin);

				if ($begin > 0 && $end > 0)
					$json = $.parseJSON(data.substring($begin, $end + 1));
			}

			// update sorting
			$(".tablesorter").trigger("update");
		},
		error: function(data, status) {
			console.log("Status: " + status + "\nData: " + data);
		}
	})
}