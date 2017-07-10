<?php
	// open the directory to search through
	$dir = $_POST["dir"];

	// find each file in the directory and create a link for it
	foreach (array_diff(scandir($dir), array("..", ".")) as $file) {
		echo "<br><a href=\"" . $dir . $file . "\" download>" . $file . "</a>";
	}
?>