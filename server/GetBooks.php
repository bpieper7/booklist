<?php
/*
This will return the next 25? books from the database starting at a specified uid 
encoded as a json array
*/

require_once 'DatabaseConnect.php';

//ensure the starting uid is specified
if(isset($_GET["uid"])) {
	$uid = $_GET["uid"];
	$db = new DatabaseConnect();

	//connect to sql database
	$con = $db->connect();
	
	//array for response
	$response = array();

	//check if the connection failed
	if($con == -1) {
		//quit
		$response["success"] = 0;
		$response["message"] = "Failed to connect to database";
		exit();
	}	

	//sanatize the input
	$uid = $con->real_escape_string($uid);
	$queryResult = $con->query("SELECT * FROM books WHERE uid > $uid LIMIT 25;");

	//check for empty result
	if($queryResult->num_rows > 0) {
		//create a books array in the response array
		$response["books"] = array();

		while($row = $queryResult->fetch_array()) {
			//create an array holding the information for one book
			$book = array();
			$book["uid"] = $row["uid"];
			$book["title"] = $row["title"];
			$book["description"] = $row["description"];
			$book["price"] = $row["price"];
			$book["creation_time"] = $row["creation_time"];
			$book["creator"] = $row["creator"];
			$book["contact_email"] = $row["contact_email"];
			$book["contact_phone"] = $row["contact_phone"];
			$book["contact_type"] = $row["contact_type"];
			$book["author"] = $row["author"];
			$book["edition"] = $row["edition"];
			$book["isbn"] = $row["isbn"];

			//push single book into final book array
			array_push($response["books"], $book);
		}

		//success
		$response["success"] = 1;

		//echo json response
		echo json_encode($response);
	}
	else {
		//no books found
		$response["success"] = 0;
		$response["message"] = "No books found";
		
		//echo json response
		echo json_encode($response);
	}
}
else {
	//required field missing
	$response["success"] = 0;
	$response["message"] = "Required field missing";

	//echo json response
	echo json_encode($response);
}

?>
