<?php require_once "../includes/Database.php" ?>
<?php require_once "../includes/List.php" ?>

<?php
	
	// set up the parameters for the List
	$db = new Database();
	$table = "dieBase2";
	$columns = [ "dieID", "dateLastUsed", "machine", "description" ];

	// create the List object
	$list = new List($db, $table, $columns);
?>

<div id="list-container">
	<!-- Search box for the table -->
	<input type="text" id="table-quick-search" placeholder="Quick Search">

	<ul>

	</ul>

</div>