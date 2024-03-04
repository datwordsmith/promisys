<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

Echo "<br/><br/>";

$mail = new PHPMailer(true);



try {
    //$mail->isSMTP();
    $mail->SMTPDebug = 2;
	$mail->Hostname = 'smtp.gmail.com';  //gmail SMTP server
	$mail->SMTPAuth = true;
	$mail->Username = 'promisysapp@gmail.com';   //username
	$mail->Password = '3949ba59abbe';   //password
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;                    //smtp port

    //$receiver = 'projects@hall7projects.com';
    $receiver = 'emeka.daniels@gmail.com';
    //$receiver = 'test@hall7promisys.com.ng';

    $mail->setFrom('promisysapp@gmail.com', 'Hall 7 Promisys');
	$mail->addAddress($receiver);


    $mail->isHTML(true);

    $mail->Subject = 'Email Subject';
    $mail->Body    = 'Email Body';

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>