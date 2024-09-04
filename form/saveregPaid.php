<?php
try {
	require_once "connection.php";
	$conn = new mysqli($host, $username, $password, $database);
}catch (Exception $e){
	die( $e->getMessage());
}
//require_once "mail.php";	 
	
foreach ($_POST as $key => $val) {
	if( !is_array( $val)){
	$$key =  htmlentities($val, ENT_QUOTES);
	}
}

try{
	$resume =  $conn->query("UPDATE registration SET status=\"$status\", date=NOW() WHERE id=$id");

}catch (Exception $e){
	die( $e->getMessage());
}

include("./head.html");
echo "<div class='comgate_mess'>zaplaceno</div>";
include("./foot.html");
?>