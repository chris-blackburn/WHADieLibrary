function parseHTMLTemplate($template, $vars) {
	
}

function populateList() {
	$listItemTemplate = "<li><h2><strong>Die Number:</strong> {{dieID}} | " +
		"<strong>Date Last Used:</strong> {{dateLastUsed}}<br>" +
		"<strong>Machine:</strong> {{machine}} | " +
		"<strong>Location:</strong> {{location}}</h2>" +
		"<p>{{description}}</p></li>";

	

}


$(document).ready(function() {
	// List Population
	populateList();
});