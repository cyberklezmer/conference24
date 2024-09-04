<?php

try {
    require_once "connection.php";
    $conn = new mysqli($host, $username, $password, $database);
} catch (Exception $e) {
    die($e->getMessage());
}


try {
    $result = $conn->query("SELECT * FROM registration WHERE id=$id");
    $result = $result->fetch_assoc();
} catch (Exception $e) {
    die($e->getMessage());
}

$message = "
<html>
<head>

<style>
    body {max-width: 720px; height: auto; padding: 40px 80px}
    h3 {margin-top: 20px; margin-bottom: 10px; text-align:left; font-size:20px; color:#f63}
    .message {width: 100%; height: auto; margin:20px auto;}
    .sign {margin-top: 20px; margin-bottom: 5px; text-align: left;}
</style>

    </head>  <body>";

if( !isset($error)){        
    $card = "<h3><a href='https://conference24.utia.cas.cz' target='utia'>EWGCFM & MMEI 2024</a></h3>
    <div class = 'message'><p>";
    $card .= "<strong>Participant Name : </strong>".$result['name'] . "<br />";
    $card .= "<strong>Email : </strong>".$result['email'] . "<br />";
    $card .= "<strong>Registration ID : </strong>".$result['id'] . "<br />";
    $card .= "<strong>Registration Date : </strong>".date("d.m.Y") . "<br />";
    $stu = $result['student'] ? "Regular" : "Student";
    $card .= "<strong>Registration Type : </strong>". $stu . "<br />";
    $card .= "<strong>Amount Paid: </strong>&euro;".$result['price'] . "<br />";

    $card.= "</p><p>&nbsp</p>
    <p>Thank you for registering for the EWGCFM & MMEI 2024 Conference.</p>
    <p>We look forward to your participation.</p>
    <p>If you have any questions, please contact us at <a href='mailto:conference24@utia.cas.cz'>conference24@utia.cas.cz</a>.</p>

    <p>Please check the conference website for the latest information and updates: <a href='https://conference24.utia.cas.cz' target='utia'>conference24.utia.cz</a><p>
    </div>
    <div class = 'sign'>EWGCFM & MMEI 2024 Conference Committee</div>
    <p>&nbsp;</p>
    <div>";
    if( $result['affilia'] != ""){
        $card .= "<strong>Affiliation: </strong>".$result['affilia'] . "<br />";
    }
    if( $result['excorsion'] != ""){
        $card .= "<strong>City Tour: </strong>".$result['excorsion'] . "<br />";
    }
    $card .= "<strong>Conference dinner : </strong>".$result['dinner'] . "<br />
    <strong>Payment method: </strong>".$result['pay_method'] . "</div>";
    


    $trans = "<div class = 'message'>";
    
    $trans.= "<p>Thank you for your registration to EWGCFM & MMEI 2024 conference. Please transfer <strong>".$result['price'] ." EUR</strong> to the following account:</p>
            
            IBAN: <strong>CZ92 0300 0000 0002 9898 5606</strong><br />
            BIC/SWIFT: <strong>CEKOCZPP</strong><br />
            Account No.: <strong>298985606/0300</strong><br />
            Name: <strong>USTAV TEORIE INFORMACE</strong><br />
            Message to recipient: ".$result['name']."</p><p>
            For information or payment in CZK, please contact <a href='mailto:fakturace@utia.cas.cz'>fakturace@utia.cas.cz</a></p></div>";

    if ($result['pay_method'] == 'card') {
        $message.= $card;// . $message;
        echo "<div class='comgate_mess'>$card</div>";
    } else {
        $message.= $trans;

        $trans.="<p><button onClick='window.print()'>Print this page</button></p>"; 
        echo "<div class='comgate_mess'>$trans</div>";
    }
}else{
    $card = " 
    <h3><a href='https://conference24.utia.cas.cz' target='utia'>EWGCFM & MMEI 2024</a></h3>
    <div class = 'message'><p>";
    $card .= "<strong>Participant Name : </strong>".$result['name'] . "<br />";
    $card .= "<strong>Email : </strong>".$result['email'] . "<br />";
    $card .= "<strong>Registration ID : </strong>".$result['id'] . "<br />";
    $card .= "<strong>Registration Date : </strong>".date("d.m.Y") . "<br />";
    $stu = $result['student'] ? "Regular" : "Student";
    $card .= "<strong>Registration Type : </strong>". $stu . "<br />";
    $card .= "<strong>Amount Paid: </strong>&euro;".$result['price'] . "<br />";

    $card.= "</p><p>&nbsp</p>
    <p>Thank you for registering for the EWGCFM & MMEI 2024 Conference.</p>";
    $error.= "</div><div class = 'sign'>EWGCFM & MMEI 2024 Conference Committee</div>
    <p>&nbsp;</p>
    <div>";
    if( $result['affilia'] != ""){
        $error .= "<strong>Affiliation: </strong>".$result['affilia'] . "<br />";
    }
    if( $result['excorsion'] != ""){
        $error .= "<strong>City Tour: </strong>".$result['excorsion'] . "<br />";
    }
    $error .= "<strong>Conference dinner : </strong>".$result['dinner'] . "<br />";
    $error .= "<strong>Payment method: </strong>".$result['pay_method'] . "</div>";
    $message.= $card.$error;
    
    echo "<div class='comgate_mess'>$card $error</div>";
}    
    $message .= "</body></html>";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'hermes.utia.cas.cz';                     //Set the SMTP server to send through
    $mail->SMTPAuth = false;                                   //Enable SMTP authentication
    $mail->Username = 'user@example.com';                     //SMTP username
    $mail->Password = 'secret';                               //SMTP password
    $mail->Port = 25;                                    //TCP port to connect to; use 587 if you h
    $mail->setFrom('conferece24@utia.cas.cz', 'Mailer');
    $mail->addAddress($result['email'], $result['name']);     //Add a recipient
    $mail->addReplyTo('conferece24@utia.cas.cz', 'Information');

    //Attachments

    //Content
    /*$mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
*/

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'EWGCFM & MMEI 2024 registration';
    $mail->Body = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

