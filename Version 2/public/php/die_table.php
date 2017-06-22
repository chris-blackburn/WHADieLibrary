<?php require_once "../includes/Database.php" ?>
<?php require_once "../includes/Table.php" ?>

<?php
	
	// set up the parameters for the table
	$db = new Database();
	$tableName = "dieBase2";
	$columns = [ "dieID", "dateLastUsed", "machine", "description" ];

	// create the table object
	$table = new Table($db, $tableName, $columns);

	// connect to the database (must be done before calling any functions in Table())
	$db->connect();
?>

<div id="table-container">
	<!-- Search box for the table -->
	<input type="text" id="table-quick-search" placeholder="Quick Search">

	<table>
		<thead>
			<?php
				// generate the headers of the table
				$table->getHeaders();
			?>				
		</thead>
		<tbody>
			<?php
				// generate the body of the table
				$table->getBody();
			?>	
		</tbody>
	</table>
</div>

<?php $db->disconnect(); ?>