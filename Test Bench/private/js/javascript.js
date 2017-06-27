function trimJSONData(data) {
	// remove anything that hasnt been encoded 
	return data.substring(data.indexOf('{'), data.lastIndexOf('}') + 1);
}

function populateList() {
	$.ajax({
		url: "../private/populateList.php",
		type: "GET",
		success: function(data, status) {
			console.log("Satus: " + status + "\nData: " + data);

			data = $.parseJSON(trimJSONData(data));
			for (var name in data) {
				$("#list-container p").append(name + " => " + data[name] + "<br>");
			};
		}
	})	

}


$(document).ready(function() {
	// List Population
	populateList();
});