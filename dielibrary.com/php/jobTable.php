<input type="text" class="table-quick-search" placeholder="Quick Search">
<button class="refresh-table">Refresh Table</button>
<table class="tablesorter tables">
	<thead class="table-head">
		<tr>
			<th>Job Number</th>
			<th>Die ID</th>
			<th>Customer Name</th>
			<th>Job Date</th>
		</tr>
	</thead>
	<tbody class="table-body">
		<!-- This gets populated by populateTable.php, see js/jquery.js -->
	</tbody>

	<span><b>Number of Records: </b>
		<?php
			require_once "Database.php";

			ob_start();
			$db = new Database(DB_HOST, DB_DBASE);
			$db->connect(DB_USER, DB_PASS);

			$sql = "SELECT count(*) FROM " . JOB_TABLE;

			$result = $db->query($sql);
			ob_end_clean();

			echo $result->fetch_array()[0];

			ob_start();
			$result->free_result();
			$db->disconnect();
			ob_end_clean();
		?>
	</span>
</table>