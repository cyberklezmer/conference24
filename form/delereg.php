<?php
try {
	require_once "connection.php";
	$conn = new mysqli($host, $username, $password, $database);
}catch (Exception $e){
	die( $e->getMessage());
}
	 
	
foreach ($_POST as $key => $val) {
	if( !is_array( $val)){
	$$key =  htmlentities($val, ENT_QUOTES);
	}
}

try{
//	$resume = $conn->query( "DELETE FROM registration WHERE id=$id");
	$resume =  $conn->query("UPDATE registration SET status=\"$status\", date=NOW() WHERE id=$id");
}catch (Exception $e){
	die( $e->getMessage());
}
