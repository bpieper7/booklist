<?php

/*
Gets a unique id number for a client to associate their books with them. A text file on the server stores all of the previously issued uids.
*/

$respones = array();

$line = file_get_contents("uid");

if($line != false) {
	$response["success"] = 1;
	$response["uid"] = $line;

	file_put_contents("uid", intval($line)+1);
}
else{
	$response["success"] = 0;
}

echo json_encode($response);
?>
