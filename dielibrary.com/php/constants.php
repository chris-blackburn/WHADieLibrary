<?php
	define("SITE_HOST", "http:\\\\seefile");

	define("DB_HOST", "localhost");
	define("DB_USER", "monty");
	define("DB_PASS", "some_pass");
	define("DB_DBASE", "DieLibrary");

	define("DIE_TABLE", "dies");
	define("JOB_TABLE", "jobs");

	define("PDF_DIR", "../dies/");

	define("MAIL_TO_PRODUCTION", "dieapproval@whaprint.com");
	define("MAIL_TO_CSR", "customer.service@whaprint.com");

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: Die Library <dielibrary@whaprint.com>" . "\r\n";
	$headers .= "Reply-To: <" . MAIL_TO_CSR . ">" . "\r\n";

	define("MAIL_HEADERS", $headers);

	// customer.service@whaprint.com
	// cvbhuy

?>