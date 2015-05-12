<?php

/*
Will get a set of x(25?) books from the database that match various search criteria, starting from a certain uid
*/

require_once 'DatabaseConnect.php';

//ensure an initial uid is specified
if (isset($_GET["uid"])) {
	$db = new DatabaseConnect();

	//connect to sql database
	$con = $db->connect();

	//array for response, set everything to wildcard before pulling in actual values
	$response = array();
	$title = "%";
	$description = "%";
	$creator = "%";
	$author = "%";
	$edition = "%";
	$isbn = "%";
	$condition = 0;
	$price = 100000;

	//if the parameter is specified, set it, otherwise the variable will stay as wildcard
	$uid = $con->real_escape_string($_GET['uid']);
	$title = $con->real_escape_string($_GET['title']);
	$description = $con->real_escape_string($_GET['description']);
	$creator = $con->real_escape_string($_GET['creator']);
	$author = $con->real_escape_string($_GET['author']);
	$edition = $con->real_escape_string($_GET['edition']);
	$isbn = $con->real_escape_string($_GET['isbn']);
	if(isset($_GET['condition'])) {
		$condition = $con->real_escape_string($_GET['condition']);
	}
	if(isset($_GET['price'])) {
		$price = $con->real_escape_string($_GET['price']);
	}

	//get next x books from the table that match search parameters
	$sql = "SELECT * FROM books WHERE uid > $uid AND title LIKE '%$title%' AND description LIKE '%$description%' AND creator LIKE '%$creator%' AND author LIKE '%$author%' AND edition LIKE '%$edition%' AND isbn LIKE '%$isbn%' AND bookcondition >= '$condition' AND price <= '$price' LIMIT 25;";
	$queryResult = $con->query($sql);
	
	//check for empty result
	if ($queryResult->num_rows > 0) {
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
			$book["condition"] = $row["bookcondition"];

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

