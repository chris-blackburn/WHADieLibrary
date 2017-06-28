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
	$("#table-btn").click();

	// populate the table when the page loads
	getDieTable();

	// handler for any forms regarding dies
	$(".die-form form").submit(function(event) {
		// prevent the default form submit action from happening
		event.preventDefault();

		// grab the url
		var $url = $(this).attr("action");

		// send POST to the url, where the data is handled and the entry is added
		$.ajax({
			url: $url,
			type: "POST",
			data: $(this).serialize(),
			success: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);

				// update the die table on success and switch to the table tab
				getDieTable();
				$("#table-btn").click();
			},
			error: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);
			}
		})
	});

	// handler for double clicking a die entry, pull up the update form and fill it with that die's info
	$("#table-container tbody").on("dblclick", "tr", function() {
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
					console.log(name + "=>" + $json[name]);

					$("#update-form-container [name=\"" + name + "\"").val($json[name]);

					$("#update-btn").click();
				}

			},
			error: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);
			}
		})

	});

	// ***************************************************** NEED NEW SEARCH FUNCTION
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

});

/*
	*****************************************************************************
	*****************************	Functions	*********************************
	*****************************************************************************
*/

function getDieTable() {
	var $url = "../php/populateDieTable.php";

	$.ajax({
		url: $url,
		type: "GET",
		success: function(data, status) {
			// add ignore json data
			console.log("Status: " + status + "\nData: " + data);

			// used to loop through each JSON object (they are separated by '~')
			$begin = data.indexOf("{");
			$end = data.indexOf("~");

			// prime the json data
			$json = $.parseJSON(data.substring($begin, $end));

			// empty the existing data
			$("#table-container tbody").empty();

			// while there is another json object
			while ($begin > 0 && $end > 0) {
				// create the row element
				$row =  "<tr class=\"table-rows\" name=\"" + $json['dieID'] + "\">";
				$row +=		"<td class=\"dieID-row\">" + $json['dieID'] + "</td>"
				$row +=		"<td class=\"dateLastUsed-row\">" + $json['dateLastUsed'] + "</td>"
				$row +=		"<td class=\"machine-row\">" + $json['machine'] + "</td>"
				$row +=		"<td class=\"location-row\">" + $json['location'] + "</td>"
				$row +=		"<td class=\"description-row\">" + $json['description'] + "</td>"
				$row +=		"<td class=\"pull-row\"><button class=\"pull-btn\">Pull</button></td>"
				$row +=	"</tr>";

				// add the row to the table
				$("#table-container tbody").append($row);


				// grab the next json object
				$begin = data.indexOf("{", $end);
				$end = data.indexOf("~", $begin);

				if ($begin > 0 && $end > 0)
					$json = $.parseJSON(data.substring($begin, $end));
			}

		},
		error: function(data, status) {
			console.log("Status: " + status + "\nData: " + data);
		}
	})
}