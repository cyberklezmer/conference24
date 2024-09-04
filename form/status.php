
<?php
try {
	require_once "connection.php";
	$conn = new mysqli($host, $username, $password, $database);
}catch (Exception $e){
	die( $e->getMessage());
}

$mail= "'hladikp@gmail.com','volakpa@seznam.cz'";
$headers = [
    'Content-Type' => 'application/x-www-form-urlencoded',
    'Accept' => 'application/x-www-form-urlencoded',
];


try{
	$result =  $conn->query("SELECT * FROM registration WHERE transId IS NOT NULL AND id>200 AND email NOT IN($mail)");
}catch (Exception $e){
	die( $e->getMessage());
}

while($row = $result->fetch_assoc()) {
    // Define array of request body.
    $request_params = [
        'merchant' => '484182',
        'transId' => $row['transId'],
        'secret' => '0iiANuhIzA9UegUsQKUlYmadzGX3VkVX',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://payments.comgate.cz/v1.0/status');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    try {
        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }

        $re = explode("&", $response);
        foreach ($re as $key => $value){
            if( str_contains($value, 'status')) {
                $r = explode("=", $value);
                $status = $r[1];
                break;
            }
        }
        if( $row['status'] != $status){
            try{
    			$resume = $conn->query("UPDATE registration SET status= \"$status\", date=NOW() WHERE id=".$row['id']);
    		}catch (Exception $e){
    			die( $e->getMessage());
    		}							
        }
    } catch (\Exception $e) {
        // handle exception or api errors.
        print_r($e->getMessage());
    } finally {
        curl_close($ch);
    }
}

try{
	$result =  $conn->query("SELECT * FROM registration WHERE email NOT IN ($mail) AND id>200 ORDER BY date DESC");
}catch (Exception $e){
	die( $e->getMessage());
}
$j= 0;
echo "<table><tr>";
echo "<th>email</th><th>affilia</th><th>name</th><th>excorsion</th><th>dinner</th><th>student</th>
	<th>price</th><th>pay_method</th><th>transId</th><th>status</th><th>date</th></tr>";
while($row = $result->fetch_array()) {
    if( $j==1){
        echo "<tr>";
        $j=0;
    }else{
        echo "<tr  style='background-color: rgb(153, 204, 255);'>";
        $j=1;
    }
    for( $i=1; $i<12; $i++){
        echo '<td>'.$row[$i].'</td>';
    }
}
echo '</table>';