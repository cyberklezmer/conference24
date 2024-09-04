<?php

try {
	require_once "connection.php";
	$conn = new mysqli($host, $username, $password, $database);
}catch (Exception $e){
	die( $e->getMessage());
}
	 
	
foreach ($_POST as $key => $val) {
	$$key =  htmlentities($val, ENT_QUOTES);
}

try{
	$resume =  $conn->query("UPDATE registration SET status=\"$status\", date=NOW() WHERE id=$id");

}catch (Exception $e){
	die( $e->getMessage());
}

//$id=72;
//$status="PENDING";
if($status == "UNKNOWN"){
	$error = "<p>Your payment has not been accomplished due to an unknown error. Please try again or contact us at <a mailto='conference24@utia.cas.cz'>conference24@utia.cas.cz</a>.</p>";
}else	{
	$error = "<p> Not paid yet. Please try again or contact us at <a mailto='conference24@utia.cas.cz'>conference24@utia.cas.cz</a>.</p>";
}
require_once "mail.php";