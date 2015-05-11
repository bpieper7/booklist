<?php

/*
This will get the book information for each uid passed to it. Each parameter is treated as a uid, 
the parameter names are not used. 
*/

require_once 'DatabaseConnect.php';

if(isset($_GET["fav1"])){
	$db = new DatabaseConnect();
	
	$fav1 = $_GET['fav1'];

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
	
	//base sql command string
	$sql = "SELECT * FROM books WHERE uid = '";	
	$sql =  $sql .  $con->real_escape_string($fav1) . "'";

	//get the remaining favorite book uids 
	foreach($_REQUEST as $temp) {
		$temp = $con->real_escape_string($temp);
		$sql = $sql . " OR uid = '$temp'";
	}	
	
	$queryResult = $con->query($sql);

	//check for empty result
	if($queryResult->num_rows > 0){
		$response["books"] = array();

		while($row = $queryResult->fetch_array()){
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
			
			array_push($response["books"],$book);	
		}
		$response["success"] = 1;

		echo json_encode($response);
	}
	else{
		//no books found
		$response["success"] = 0;
		$response["message"] = "No Books found.";

		echo json_encode($response);
	}

}else{
	$response["success"] = 0;
	$response["message"] = "Required field missing";
	
	echo json_encode($response);
}
?>
