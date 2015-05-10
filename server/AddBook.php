<?php
 
/*
This will create a new book in the database and return the uid of said book on success
*/

require_once 'DatabaseConnect.php';
 
// check for required fields
if(isset($_REQUEST['title']) && isset($_REQUEST['description']) && isset($_REQUEST['price']) && isset($_REQUEST['author']) 
	&& isset($_REQUEST['edition']) && isset($_REQUEST['isbn']) && isset($_REQUEST['creator']) && isset($_REQUEST['contact_email']) 
	&& isset($_REQUEST['contact_phone']) && isset($_REQUEST['contact_type']) && isset($_REQUEST['condition'])) {
	
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

	//sanatize input and store in variables
	$title = $con->real_escape_string($_REQUEST['title']);
	$description = $con->real_escape_string($_REQUEST['description']);
	$price = $con->real_escape_string($_REQUEST['price']);
	$author = $con->real_escape_string($_REQUEST['author']);
	$edition = $con->real_escape_string($_REQUEST['edition']);
	$isbn = $con->real_escape_string($_REQUEST['isbn']);
	$creator = $con->real_escape_string($_REQUEST['creator']);
	$contact_email = $con->real_escape_string($_REQUEST['contact_email']);
	$contact_phone = $con->real_escape_string($_REQUEST['contact_phone']);
	$contact_type = $con->real_escape_string($_REQUEST['contact_type']);
	$condition = $con->real_escape_string($_REQUEST['condition']);
	 
	//mysql inserting a new row for the new book
	$queryString = "INSERT INTO books(title, description, price, author, edition, isbn, creator, contact_email, contact_phone, contact_type, bookcondition) VALUES('$title', '$description', '$price', '$author', '$edition', '$isbn', '$creator', '$contact_email', '$contact_phone', '$contact_type', '$condition');";

	//$result = mysql_query($query_string);
	$queryResult = $con->query($queryString);
	
	//store the uid of the newly created book	
	$uid = $con->insert_id;
    
	//check if row inserted or not
	if ($queryResult) {
    	//successfully inserted into database
    	$response["success"] = 1;
    	$response["message"] = "Successfully added book.";
		$response["uid"] = $uid;

    	//echoing JSON response
    	echo json_encode($response);
	} else {
    	//failed to insert row
    	$response["success"] = 0;
    	$response["message"] = "Error occurred.";

    	//echoing JSON response
    	echo json_encode($response);
	}
} else {
    	//required field is missing
    	$response["success"] = 0;
    	$response["message"] = "Required field(s) is missing";
 
    	//echoing JSON response
    	echo json_encode($response);
}
?>
