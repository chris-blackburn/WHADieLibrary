<?php
	include "../includes/constants.php";
	/*

	This is the Database class. It is used to create a new database object which has various functions
		that allow it to manage an sql database through php. It is meant to make commonly used functions 
		easier to use and access by parsing incoming data into SQL code which is then submitted to 
		an sql server (this script has only been tested on MySQL, for other SQL servers, you may need
		to adjust SQL syntax).

	*/

	class Database {
		protected $conn;

		private $echo_off = 1;

		private $server = '';
		private $db = '';

		function __construct($server = DB_HOST, $db = DB_DBASE) {
			$this->server = $server;
			$this->db = $db;
		}

		public function connect($user = DB_USER, $pass = DB_PASS) {
			// check if a connection already exists
			if (!$this->conn) {
				// if not, create the new connection
				$this->conn = new mysqli($this->server, $user, $pass, $this->db);

				// if there exists an error number (therefore it did not connect), display the error message and number
				if ($this->conn->connect_errno) {
					die("Connection failed: " . $this->conn->connect_error . " (" . $this->conn->connect_errno . ")");
				}

				echo "Connected Succesfully";
			} else {
				echo "Already Connected";
			}
		}

		public function disconnect() {
			$this->conn->close();
			echo "Connection closed";
		}

		/*
			handles array arguments and prepares them for sql script, puts quotes around each
				entry, with commas between them, and parenthases around all of it
				( "[arg1]", "[arg2]", ... )
		*/
		private function formatArray($arg) {
			if (is_array($arg))
				return "( \"" . implode("\", \"", $arg) . "\" )";
			return "( \"" . $arg . "\" )";
		}

		/*
			Sends an sql query to the database and returns the output, also error catches
		*/
		public function query($sql) {
			// query the sql code
			$result = $this->conn->query($sql);

			// if the query failed, die with error message
			if (!$result) {
				die("Query Failed for: " . $sql . " " . $this->conn->error . " (" . $this->conn->errno . ")");
			}

			echo "Success: \"" . $sql . "\"";
			return $result;
		}

		/*
			Resulting SQL code:
				SELECT [column1, column2, ...] FROM [table] WHERE [condition] ORDER BY [column]
		*/
		public function select($table, $cols = '*', $where = null, $in = null, $order = null, $asc_desc = null) {

			if ($cols != '*') {
				$sql = "SELECT " . implode(", ", $cols) . " FROM " . $table;
			} else {
				$sql = "SELECT " . $cols . " FROM " . $table;
			}

			if ($where != NULL)	{
				$sql .= " WHERE " . $where;
				if ($in != NULL)
					$sql .= " IN " . $this->formatArray($in);
			}

			if ($order != NULL) {
				$sql .= " ORDER BY " . $order;
				if ($asc_desc == "desc")
					$sql .= " DESC";
			}
	
			return $this->query($sql);
		}

		/*
			Resulting SQL code:
				INSERT INTO [table] ([column1], [column2], ...) VALUES ([value1], [value2], ...)
		*/
		public function insert($table, $values, $cols = null) {
			$sql = "INSERT INTO " . $table;
			if ($cols != NULL)
				$sql .= " ( " . implode(", ", $cols) . " )";

			$sql .= " VALUES " . $this->formatArray($values);

			$this->query($sql);
		}

		/*
			Resulting SQL code:
				UPDATE [table] SET [column1] = [value1], [column2] = [value2], ... WHERE [condition] IN ([value1], [value2], ...)
		*/
		public function update($table, $values, $cols, $where = null, $in = null) {
			$sql = "UPDATE " . $table . " SET";

			if (is_array($cols)) {
				$set = array_combine($cols, $values);

				foreach ($set as $col => $value) {
					$sql .= " " . $col . " = \"" . $value . "\",";
				}

				$sql = substr($sql, 0, -1);
			} else
				$sql .= " " . $cols . " = \"" . $values . "\"";
			

			if ($where != NULL)	{
				$sql .= " WHERE " . $where;
				if ($in != NULL)
					$sql .= " IN " . $this->formatArray($in);
			}

			$this->query($sql);
		}
	}
?>