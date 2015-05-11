<?php
 
/*
Delete a book from the database
*/

require_once 'DatabaseConnect.php';
 
//ensure a uid is specified
if (isset($_REQUEST['uid'])) {
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
    $queryResult = $con->query("DELETE FROM books WHERE uid = $uid");
 
    //check if row deleted or not
    if ($con->affected_rows > 0) {
        //successfully updated
        $response["success"] = 1;
        $response["message"] = "Book successfully deleted";
 
        //echoing JSON response
        echo json_encode($response);
    } else {
        //no book found
        $response["success"] = 0;
        $response["message"] = "No book found";
 
        //echo no users JSON
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