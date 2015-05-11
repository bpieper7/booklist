<?php
 
/*
Edit a pre-existing book by specifiying a uid and the updated parameters
*/

require_once 'DatabaseConnect.php';

// check for required fields
if(isset($_REQUEST['uid']) && isset($_REQUEST['title']) && isset($_REQUEST['description']) && isset($_REQUEST['price']) 
    && isset($_REQUEST['author']) && isset($_REQUEST['edition']) && isset($_REQUEST['isbn']) && isset($_REQUEST['creator']) 
    && isset($_REQUEST['contact_email']) && isset($_REQUEST['contact_phone']) && isset($_REQUEST['contact_type'])) {
 
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
    $uid = $con->real_escape_string($_REQUEST['uid']);
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
     
    // mysql inserting a new row
    $queryString = "UPDATE books SET title = '$title', description = '$description', price = '$price', author = '$author', edition = '$edition', isbn = '$isbn', creator = '$creator', contact_email = '$contact_email', contact_phone = '$contact_phone', contact_type = '$contact_type' WHERE uid = $uid;";
        
    $queryResult = $con->query($queryString);
    
    // check if row inserted or not
    if ($queryResult) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Book successfully edited.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";

        // echoing JSON response
        echo json_encode($response);
    }
} else {
        // required field is missing
        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing";
 
        // echoing JSON response
        echo json_encode($response);
}
?>
