<?php
	require_once "Database.php";

	class Table {

		private $db;
		private $table;
		private $columns;

		/*
			constructor, asks for a table name, null by default, and a
				Database() object, $db, which by default simply creates the 
				object with no arguments
		*/
		function __construct(Database &$db, $table, $columns) {
			// set the table
			$this->setTable($table);

			// set which database to use
			$this->setDB($db);

			// set which columns to use
			$this->setCols($columns);
		}

		/*
			set the table name 
		*/
		public function setTable($table) {
			$this->table = $table;
		}

		/*
			set up the database
		*/
		public function setDB(Database &$db) {
			$this->db = $db;
		}

		public function setCols($columns) {
			$this->columns = $columns;
		}

		/*
			Create the sql query $sql = "DESCRIBE {$table}" and fetch 
				the column names of $table. Using $result,
				generate the html tags for the table headers
		*/
		public function getHeaders() {
			// create the sql query
			$sql = "DESCRIBE {$this->table}";

			// grab the data
			$result = $this->db->query($sql);

			$headers = "<tr>";

			// generate the html for the table
			while ($row = $result->fetch_array()) {
				if (in_array($row["Field"], $this->columns))
					$headers .= "<th>" . $row["Field"] . "</th>";
			}

			$headers .= "</tr>";

			// free the data and disconnect
			$result->free_result();

			echo $headers;
		}

		/*
			Create the sql query SELECT * FROM $table and use
				$result to create the html for the table body
		*/
		public function getBody() {
			// grab the data
			$result = $this->db->select($this->table, $this->columns);

			$body = "";

			// generate the html for the table
			while ($row = $result->fetch_row()) {
				$body .= "<tr>";

				foreach ($row as $key => $value) {
					$body .= "<td>" . $value . "</td>";
				}

				$body .= "</tr>";
			}

			// free the data and disconnect
			$result->free_result();

			echo $body;
		}
	}
?>