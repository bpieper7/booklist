<?php
require_once 'DatabaseConfig.php';

/*
This class will handle connecting to an sql database using mysqli
*/
class DatabaseConnect {
	private $connection;

	/*
	Connect to the sql database and returns a reference to the connection
	*/
	function connect() {
		$this->connection = new mysqli(serverHostName, dbUsername, dbPassword, dbName);

		//ensure the connection did not error
		if($this->connection->connect_errno != 0) {
			handleError($this->connection->connect_errno);
		}

		return $this->connection;
	}
	
	/*
	Disconnect from the database
	*/
	function disconnect() {
		$this->connection->close();
	}

	/*
	Writes output for errors encoded in a way the clients understand
	*/
	function handleError($errorNum) {
		//TODO: write actual error output
		echo $errorNum;
	}
}
?>