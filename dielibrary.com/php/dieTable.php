<input type="text" class="table-quick-search" placeholder="Quick Search">
<button class="refresh-table">Refresh Table</button>
<table class="tablesorter tables">
	<thead class="table-head">
		<tr>
			<th id="dieID-header">Die ID</th>
			<th id="datePurchased-header">Purchase Date</th>
			<th id="machine-header">Machine</th>
			<th id="location-header">Location</th>
			<th id="description-header">Description</th>
		</tr>
	</thead>
	<tbody class="table-body">
		<!-- This gets populated by populateTable.php, see js/jquery.js -->
	</tbody>

	<span><b>Number of Records: </b><span class="num-records"></span></span>
</table>