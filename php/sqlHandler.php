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

		function __construct($server, $user, $pass, $db) {
			$this->server = $server;
			$this->user = $user;
			$this->pass = $pass;
			$this->db = $db;
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
					die("Connection failed: " . $this->conn->connect_error . "<br>");
				}

				$this->disp("Connected Succesfully<br>");
			} else {
				$this->disp("Already Connected<br>");
			}
		}

		public function disconnect() {
			$this->conn->close();
			$this->disp("Connection closed<br>");
		}

		/*
			This is used by the functions insert, delete, and update. It relpies a success with the
				SQL code queried or Error along with the SQL code and error message.
		*/
		private function query($sql) {
			if ($this->conn->query($sql) === TRUE) {
				$this->disp("Success: " . $sql . "<br>");
			} else {
				$this->disp("Error: " . $sql . "<br>" . $this->conn->error . "<br>");
			}
		}

			/*
				Resulting SQL code:
					SELECT [column1, column2, ...] FROM [table] WHERE [condition] ORDER BY [column]
			*/
		public function select($table, $cols = '*', $where = null, $order = null, $asc_desc = null) {
			$sql = "SELECT " . $cols . " FROM " . $table;
			if ($where != NULL) 
				$sql .= " WHERE " . $where;
			if ($order != NULL) {
				$sql .= " ORDER BY " . $order;
				if ($asc_desc == "desc")
					$sql .= " DESC";
			}

			$result = $this->conn->query($sql);

			if ($result !== TRUE)
				$this->disp("Success: " . $sql . "<br>");
			else
				$this->disp("Error: " . $sql . "<br>" . $this->conn->error . "<br>");


			return $result;
		}

	/*
	Resulting SQL code:
		INSERT INTO [table] ([column1], [column2], ...) VALUES ([value1], [value2], ...)
	*/
		public function insert($table, $values, $cols = null) {
			$sql = "INSERT INTO " . $table;
			if ($cols != NULL)
				$sql .= " ( " . $cols . " )";

			$sql .= " VALUES ( " . $values . " )";

			$this->query($sql);
		}

	/*
	Resulting SQL code:
		DELETE FROM [table] WHERE [condition] IN ([value1], [value2], ...)
	*/
		public function delete($table, $where = null, $in = null) {
			$sql = "DELETE FROM " . $table;
			if ($where != NULL)
				$sql .= " WHERE " . $where;
			if ($in != NULL)
				$sql .= " IN " . $in;

			$this->query($sql);
		}

	/*
	Resulting SQL code:
		UPDATE [table] SET [column1] = [value1], [column2] = [value2], ... WHERE [condition] IN ([value1], [value2], ...)
	*/
		public function update($table) {
			$sql = "UPDATE " . $table . " SET";
		}


	}
?>