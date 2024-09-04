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

$student = isset( $_POST["student"]) ? "Yes" : "No";
$dinner = isset( $_POST["dinner"]) ? "Yes" : "No";
//$jaap = isset( $_POST["jaap"]) ? "Yes" : "No";
$excor = isset( $_POST["excor"]) ? $_POST["excor"] : "";
$payment = $_POST["payment"];
$id = $_POST["id"];

try{
	$resume =  $conn->query("INSERT registration (id, name, affilia, email, student, dinner, excorsion, price, pay_method) 
			VALUES (0, \"$name\", \"$affili\", \"$mail\", \"$student\", \"$dinner\", \"$excor\", $price, \"$payment\")");
	$lastID = mysqli_insert_id($conn);

}catch (Exception $e){
	die( $e->getMessage());
}


if( $payment == "card"){
	$id = $lastID;	
	$price= $price *100; 

	$headers = [
		'Content-Type' => 'application/x-www-form-urlencoded',
		'Accept' => 'application/x-www-form-urlencoded',
	];

	$request_params = [
		'merchant' => '484182',
		'price' => $price,
		'curr' => 'EUR',
		'label' => 'EWGCFM & MMEI',
		'fullName' => $name,
		'refId' => $id,
		'method' => 'CARD_ALL',
		'email' => $mail,
		'prepareOnly' => '1',
		'secret' => '0iiANuhIzA9UegUsQKUlYmadzGX3VkVX',
		'country' => 'ALL',
		'lang' => 'en'
	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://payments.comgate.cz/v1.0/create');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_params));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
	try {
		$response = curl_exec($ch);
		if ($response === false) {
				throw new \Exception(curl_error($ch), curl_errno($ch));
		}
		$result = array("id"=>$id, 'response'=>$response);
		//print_r($response);
		echo json_encode($result);
		$re = explode("&", $response);
		$re = explode("=", $re[2]);
		try{
			$resume = $conn->query("UPDATE registration SET transID= \"$re[1]\" WHERE id=$id");
		}catch (Exception $e){
			die( $e->getMessage());
		}							

	} catch (\Exception $e) {
			// handle exception or api errors.
			print_r($e->getMessage());
	} finally {
			curl_close($ch);
	}
}else{
	$id = $lastID;
	require_once "mail.php";

}

?>