<?php
try {
	require_once "connection.php";
	$conn = new mysqli($host, $username, $password, $database);
} catch(\Throwable  $e){
//}catch (Exception $e){
	die( $e->getMessage());
}
	 
	
foreach ($_POST as $key => $val) {
	$$key =  htmlentities($val, ENT_QUOTES);
}
echo $name;  
		
//$b = html_entity_decode($a)