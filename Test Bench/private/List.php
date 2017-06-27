<?php
	
	

	class Lisst {

		private $db;
		private $table;
		private $columns;

		/*
			constructor, asks for a table name, null by default, and a
				Database() object, $db, which by default simply creates the 
				object with no arguments
		*/
		function __construct(Database &$db, $table = DIE_TABLE, $columns = '*') {
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

		public function getList() {
			$this->db->connect();

			// grab the data
			$result = $this->db->select($this->table, $this->columns);

			echo json_encode($result->fetch_assoc());

			// free the data
			$result->free_result();
			$this->db->disconnect();
		}
	}
?>