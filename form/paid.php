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


//echo file_get_contents("./head.html");
//echo "<div class='comgate_mess'>result.php vraci $status<p>";
//echo file_get_contents("./foot.html");

require_once "mail.php";