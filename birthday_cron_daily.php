<?php

	require_once ("connector/connect.php");	

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require_once ("vendor/autoload.php");

	/*$today = date("Y-m-d");
	echo "today is ".$today;
	$startdate = strtotime("$today");
	echo '<br/>'.$startdate;*/

	$today = date("m-d");

	$getcomms = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM comms WHERE status = 1"));
	$receiver = $getcomms->email;

	//CLIENTS
	$clients = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from client where DATE_FORMAT(dob,'%m-%e') = '$today'"));

	$clientcount = $clients->count;
	if ($clientcount < 1) {
		$clientcount = 0;
		$clientBirthdays = "";
	}
	else {
		$clientBirthdays = "You have ".$clientcount." Client birthday(s) today";
	}


	//STAFF
	$staff = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from staff where DATE_FORMAT(dob,'%m-%e') = '$today'"));

	$staffcount = $staff->count;


	if ($staffcount < 1) {
		$staffcount = 0;
		$staffBirthdays = "";
	}
	else {
		$staffBirthdays = "You have ".$staffcount." Staff birthday(s) today";
	}


	$totalCount = ($clientcount + $staffcount);
	/*echo "Total Count - ".$totalCount."<br/>";
	echo "Client Birthdays - ".$clientBirthdays."<br/>";
	echo "Staff Birthdays - ".$staffBirthdays."<br/>";*/

	if ($totalCount > 0) {

		//CLIENT
		if (($clientcount > 0)&&($staffcount == 0)) {

			$mail = new PHPMailer(true); // Passing `true` enables exceptions

			    //Server settings
                //$mail->isSMTP();
                //$mail->SMTPDebug = 2;
            	$mail->Hostname = 'smtp.gmail.com';  //gmail SMTP server
            	$mail->SMTPAuth = true;
            	$mail->Username = 'promisysapp@gmail.com';   //username
            	$mail->Password = 'xxxxxxxxxxxxxx';   //password
            	$mail->SMTPSecure = 'ssl';
            	$mail->Port = 465;                    //smtp 
                
                $receiver = $email;
                $newpassword = $randomPassword;
			    //Recipients
			    $mail->setFrom('promisysapp@gmail.com', 'Hall 7 Promisys');
			    $mail->addAddress($receiver);     // Add a recipient
                
                $body = 'Hello,<br/>'.$clientBirthdays.'<br/>Please follow the link below to login to the portal for details.<br/><a href="hall7promisys.com.ng">www.hall7promisys.com.ng</a> continue';
                
			    //Content
			    $mail->isHTML(true);    // Set email format to HTML
			    $mail->Subject = 'Birthdays - Hall7PROMiSYS';
			    $mail->Body    = $body;

			    $mail->send();

		} 

		//STAFF
		elseif (($clientcount == 0)&&($staffcount > 0)) {

			$mail = new PHPMailer(true); // Passing `true` enables exceptions

			    //Server settings
                //$mail->isSMTP();
                //$mail->SMTPDebug = 2;
            	$mail->Hostname = 'smtp.gmail.com';  //gmail SMTP server
            	$mail->SMTPAuth = true;
            	$mail->Username = 'promisysapp@gmail.com';   //username
            	$mail->Password = 'xxxxxxxxxxxxxx';   //password
            	$mail->SMTPSecure = 'ssl';
            	$mail->Port = 465;                    //smtp 
                
                $receiver = $email;
                $newpassword = $randomPassword;
			    //Recipients
			    $mail->setFrom('promisysapp@gmail.com', 'Hall 7 Promisys');
			    $mail->addAddress($receiver);     // Add a recipient
                
                $body = 'Hello,<br/>'.$staffBirthdays.'<br/>Please follow the link below to login to the portal for details.<br/><a href="hall7promisys.com.ng">www.hall7promisys.com.ng</a> continue';
                
			    //Content
			    $mail->isHTML(true);    // Set email format to HTML
			    $mail->Subject = 'Birthdays - Hall7PROMiSYS';
			    $mail->Body    = $body;

			    $mail->send();

		}
		
		//DEFAULT - BOTH
		else {

			$mail = new PHPMailer(true); // Passing `true` enables exceptions

			    //Server settings
                //$mail->isSMTP();
                //$mail->SMTPDebug = 2;
            	$mail->Hostname = 'smtp.gmail.com';  //gmail SMTP server
            	$mail->SMTPAuth = true;
            	$mail->Username = 'promisysapp@gmail.com';   //username
            	$mail->Password = 'xxxxxxxxxxxxxx';   //password
            	$mail->SMTPSecure = 'ssl';
            	$mail->Port = 465;                    //smtp 
                
                $receiver = $email;
                $newpassword = $randomPassword;
			    //Recipients
			    $mail->setFrom('promisysapp@gmail.com', 'Hall 7 Promisys');
			    $mail->addAddress($receiver);     // Add a recipient
                
                $body = 'Hello,<br/>'.$clientBirthdays.'<br/>'.$staffBirthdays.'<br/>Please follow the link below to login to the portal for details.<br/><a href="hall7promisys.com.ng">www.hall7promisys.com.ng</a> continue';
                
			    //Content
			    $mail->isHTML(true);    // Set email format to HTML
			    $mail->Subject = 'Birthdays - Hall7PROMiSYS';
			    $mail->Body    = $body;

			    $mail->send();	

		}

	} else {
	
	}

?>