<?php
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
		private $user = '';
		private $pass = '';
		private $db = '';

		function __construct($server = 'localhost', $user = null, $pass = null, $db = null) {
			$this->server = $server;
			$this->user = $user;
			$this->pass = $pass;
			$this->db = $db;
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
			This is used by the functions insert, delete, and update. It relpies a success with the
				SQL code queried or Error along with the SQL code and error message.
		*/
		private function query($sql) {
			if ($this->conn->query($sql) === TRUE) {
				$this->disp("Success: " . $sql);
			} else {
				$this->disp("Error: " . $sql . $this->conn->error);
			}
		}

		// setters
		public function setServer($server) {
			$this->server = $server;
		}

		public function setUser($user) {
			$this->user = $user;
		}

		public function setPass($pass) {
			$this->pass = $pass;
		}

		public function setDatabase($db) {
			$this->db = $db;
		}

		// getters
		public function getServer() {
			return $this->server;
		}

		public function getUser() {
			return $this->user;
		}

		public function getPass() {
			return $this->pass;
		}

		public function getDatabase() {
			return $this->db;
		}

		// setEcho() and disp() are used to control output by the database object (pass 1 for on, 0 for off)
		public function setEcho($bool) {
			$this->echo_off = !$bool;
		}

		private function disp($msg) {
			if (!$this->echo_off) {
				echo $msg;
			}
		}

		public function connect() {
			if (!$this->conn) {
				$this->conn = new mysqli($this->server, $this->user, $this->pass, $this->db);

				if ($this->conn->connect_error) {
					die("Connection failed: " . $this->conn->connect_error);
				}

				$this->disp("Connected Succesfully");
			} else {
				$this->disp("Already Connected");
			}
		}

		public function disconnect() {
			$this->conn->close();
			$this->disp("Connection closed");
		}

		/*
			Resulting SQL code:
				SELECT [column1, column2, ...] FROM [table] WHERE [condition] ORDER BY [column]
		*/
		public function select($table, $cols = '*', $where = null, $in = null, $order = null, $asc_desc = null) {
			$sql = "SELECT " . $cols . " FROM " . $table;

			if ($cols != '*') {
				$sql = "SELECT " . $this->formatArray($cols) . " FROM " . $table;
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
	
			$result = $this->conn->query($sql);

			return $result;
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
				DELETE FROM [table] WHERE [condition] IN ([value1], [value2], ...)
		*/
		public function delete($table, $where = null, $in = null) {
			$sql = "DELETE FROM " . $table;

			if ($where != NULL)	{
				$sql .= " WHERE " . $where;
				if ($in != NULL)
					$sql .= " IN " . $this->formatArray($in);
			}

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