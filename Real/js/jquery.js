/*
	This runs when the webpage is loaded, event handlers need to be here so they get initialized
*/
$(document).ready(function() {
	// populate the table when the page loads
	getDieTable();

	// Form handler for the new die form
	$("#new-die-form-container form").submit(function(event) {
		// prevent the default form submit action from happening
		event.preventDefault();

		// grab the url
		$url = $(this).attr("action");

		$.ajax({
			url: $url,
			type: "POST",
			data: $(this).serialize(),
			success: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);

				// update the die table on success
				getDieTable();
			},
			error: function(data, status) {
				console.log("Status: " + status + "\nData: " + data);
			}
		})
	});
});

/*
	*****************************************************************************
	*****************************	Functions	*********************************
	*****************************************************************************
*/

function getDieTable() {
	$url = "../php/populateDieTable.php";

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
				$row +=	"<td class=\"table-checkboxes\"><input type=\"checkbox\"></td>";
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