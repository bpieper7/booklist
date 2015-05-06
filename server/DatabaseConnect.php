<?php
require_once 'DatabaseConfig.php';

/*
This class will handle connecting to an sql database using mysqli
*/
class DatabaseConnect {
	private $connection;

	/*
	Connect to the sql database and returns a reference to the connection, or -1 if the connection failed
	*/
	function connect() {
		$this->connection = new mysqli(serverHostName, dbUsername, dbPassword, dbName);

		//ensure the connection did not error
		if($this->connection->connect_errno != 0) {
			return -1;
		}

		return $this->connection;
	}
	
	/*
	Disconnect from the database
	*/
	function disconnect() {
		$this->connection->close();
	}

}
?>