<?php

	require_once ("../connector/connect.php");	

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require_once ("vendor/autoload.php");

	/*$today = date("Y-m-d");
	echo "today is ".$today;
	$startdate = strtotime("$today");
	echo '<br/>'.$startdate;*/

	//echo date("Md");
	/*$getcomms = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM comms WHERE status = 1"));
	$receiver = $getcomms->email;*/

			
			$mail = new PHPMailer(true); // Passing `true` enables exceptions

			    //Server settings
                $mail->isSMTP();
                //$mail->SMTPDebug = 3;
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

            	$mail->Hostname = 'smtp.gmail.com';  //gmail SMTP server
            	$mail->SMTPAuth = true;
            	$mail->Username = 'promisysapp@gmail.com';   //username
            	$mail->Password = 'xxxxxxxxxxxxxx';   //password
            	//$mail->SMTPSecure = 'tls';
            	$mail->Port = 587;                    //smtp 
                
                $receiver = 'chukwuemeka.n@hall7projects.com';
                //$newpassword = $randomPassword;
			    //Recipients
			    $mail->setFrom('promisysapp@gmail.com', 'Hall 7 Promisys');
			    $mail->addAddress($receiver);     // Add a recipient
                
                $body = 'Hello,<br/>Please follow the link below to login to the portal for details.<br/><a href="hall7promisys.com.ng">www.hall7promisys.com.ng</a> continue';
                
			    //Content
			    $mail->isHTML(true);    // Set email format to HTML
			    $mail->Subject = 'Birthdays - Hall7PROMiSYS';
			    $mail->Body    = $body;

			    $mail->send();


/*//PHPMailer Object
$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

                $mail->isSMTP();
                $mail->SMTPDebug = 3;
            	$mail->Hostname = 'smtp.gmail.com';  //gmail SMTP server
            	$mail->SMTPAuth = true;
            	$mail->Username = 'promisysapp@gmail.com';   //username
            	$mail->Password = 'xxxxxxxxxxxxxx';   //password
            	$mail->SMTPSecure = 'ssl';
            	$mail->Port = 587;                    //smtp 


//From email address and name
$mail->From = "promisysapp@gmail.com";
$mail->FromName = "Full Name";

//To address and name
$mail->addAddress("chukwuemeka.n@hall7projects.com", "Recepient Name");
//$mail->addAddress("recepient1@example.com"); //Recipient name is optional

//Address to which recipient will reply
$mail->addReplyTo("promisysapp@gmail.com", "Reply");

//CC and BCC
$mail->addCC("emeka.daniels@gmail.com");
$mail->addBCC("emeka.daniels@yahoo.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Subject Text";
$mail->Body = "<i>Mail body in HTML</i>";
$mail->AltBody = "This is the plain text version of the email content";

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}*/


?>