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

foreach ($_GET as $key => $val) {
	$$key =  htmlentities($val, ENT_QUOTES);
}

try{
	$resume =  $conn->query("UPDATE registration SET comgate=\"unsetted\", date=NOW() WHERE transId=\"$refId\"");

}catch (Exception $e){
	die( $e->getMessage());
}


echo file_get_contents("./head.html");
echo "<div class='comgate_mess'>zaplaceno<p>";
echo file_get_contents("./foot.html");

