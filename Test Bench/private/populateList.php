<?php
	include "../includes/constants.php";
	require_once "Database.php";

	$db = new Database();
	$db->connect();

	$result = $db->select(DIE_TABLE);

	while ($row = $result->fetch_assoc())
		echo json_encode($row);
	
	$result->free_result();
	$db->disconnect();
?>