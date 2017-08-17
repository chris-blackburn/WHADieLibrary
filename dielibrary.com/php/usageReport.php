<?php
	require_once("Database.php");
	require_once("constants.php");

	$sql = "SELECT d.*, jobDateMax.dateLastUsed FROM dies d LEFT JOIN( SELECT dieID, MAX(jobDate) AS dateLastUsed FROM jobs GROUP BY dieID ) jobDateMax ON d.dieID = jobDateMax.dieID WHERE dateLastUsed < CURRENT_DATE() - INTERVAL 1 MONTH ORDER BY d.dieID DESC";

	// connect to the database and submit the query
	$db = new Database();
	$db->connect("exporter", "exporter");

	$result = $db->query($sql);

	$db->disconnect();

	$tableRows;
	// generate the table
	while ($row = $result->fetch_assoc()) {
		$tableRows .= "<td>" . $row["dieID"] . "</td>";
		$tableRows .= "<td>" . $row["dateLastUsed"] . "</td>";
	}

	$result->free_result();

	// header
	$message = sprintf("<!DOCTYPE html>
						<html>
						<head>
							<title>Die Usage Report</title>
						</head>
						<body>
							<p>This is an automated email, Please do not reply to this email</p>
							<p>Click <a href=\"%s\">here</a> to go to the die library</p>",
						SITE_HOST);

	// table
	$message .= sprintf("<table>
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