<?php
	require_once("Database.php");
	require_once("constants.php");

	$sql = "SELECT d.*, jobDateMax.dateLastUsed FROM dies d LEFT JOIN( SELECT dieID, MAX(jobDate) AS dateLastUsed FROM jobs GROUP BY dieID ) jobDateMax ON d.dieID = jobDateMax.dieID WHERE dateLastUsed < CURRENT_DATE() - INTERVAL 6 MONTH ORDER BY d.dieID DESC";

	// connect to the database and submit the query
	$db = new Database();
	$db->connect("exporter", "exporter");

	$result = $db->query($sql);

	$db->disconnect();

	$tableRows;
	// generate the table
	while ($row = $result->fetch_assoc()) {
		$tableRows .= "<tr><td>" . $row["dieID"] . "</td>";
		$tableRows .= "<td>" . $row["dateLastUsed"] . "</td></tr>";
	}

	$result->free_result();

	// header
	$message = sprintf("<!DOCTYPE html>
						<html>
						<head>
							<title>Die Usage Report</title>
							<style>
								table, th, td {border: 1px solid black;}
								th, td {padding: .5em;}
								th {font-weight: bold;}
								tr:nth-child(even) {background-color: white}
								tr:nth-child(odd) {background-color: #f2f2f2}
							</style>
						</head>
						<body>
							<p>This is an automated email, Please do not reply to this email</p>
							<p>Click <a href=\"%s\">here</a> to go to the die library</p>",
						SITE_HOST);

	// table
	$message .= sprintf("<p>These dies have not been used in the past 6 months</p>
						<table>
							<thead>
								<th>Die ID</th>
								<th>Date Last Used</th>
							</thead>
							<tbody>
								%s
							</tbody>
						</table>", $tableRows);

	// footer
	$message .= "	<br><br>
				</body>
				</html>";

	$subject = "Die Usage Report [TEST]";

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: Die Library <dielibrary@whaprint.com>" . "\r\n";
	$headers .= "Reply-To: <>" . "\r\n";

	$to = implode(",", array(MAIL_TO_PRODUCTION, MAIL_TO_CSR));
	
	// send the message
	if (!mail($to, $subject, $message, $headers))
		die("Mail could not be sent, check /var/log/mail.log for details.\n");
	echo "Mail has been sent!\n";
?>