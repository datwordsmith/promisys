<?php
	/* require_once ("connector/connect.php");	

	session_start(); */
	
//login
if(isset($_POST['login'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = test_input($_POST["email"]);
		$get_password = test_input($_POST["password"]);
		$password = md5($get_password);
}


				$checkuser = mysqli_query($conn, "SELECT * FROM hod WHERE email = '$email' and password = '$password' ");

				if (mysqli_num_rows($checkuser) > 0) {
				
						//GET VALIDATION KEY GENERATION DATE
						$logindata = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM hod WHERE email = '$email' and password = '$password' "));
						$department = $logindata->department;
						$loginid = $logindata->id;

							$now =  time();
							$sessionWindow = ($now + (30*60));
							$_SESSION['expire'] = $sessionWindow;							

							//ACCOUNTS
							if ($department == "accounts") //ACCOUNTS
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?accounts");							
							} 
							//HR
							elseif ($department == "hr") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?hr");	
							}
							//ADMIN
							elseif ($department == "admin") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?admin");	
							}	
							//ADVISORY
							elseif ($department == "advisory") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?advisory");	
							}		
							//COMMS
							elseif ($department == "comms") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?comms");	
							}	
							//INNOVATION STUDIO
							elseif ($department == "studio") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?studio");	
							}	
							//PROJECTS
							elseif ($department == "projects") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?projects");	
							}		
							//PROCUREMENT
							elseif ($department == "procurement") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?procurement");	
							}	
							//LEGAL
							elseif ($department == "legal") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?legal");	
							}		
							//CONTROL
							elseif ($department == "control") 
							{
								$_SESSION['department'] = $department;
								$_SESSION['loginid'] = $loginid;
								header("location: hod?control");	
							}																																																					
							/* elseif ($staffrole == 2) //Super Admin
							{
								$_SESSION['roleid'] = $staffrole;
								$_SESSION['loginid'] = $loginid;
								header("location: index?administrator");												
							} 
							elseif ($staffrole == 3) //Office Admin
							{
								$_SESSION['roleid'] = $staffrole;
								$_SESSION['loginid'] = $loginid;
								header("location: index?officer");	
							}
							elseif ($staffrole == 4) //Accounts
							{
								$_SESSION['roleid'] = $staffrole;
								$_SESSION['loginid'] = $loginid;
								header("location: index?accounts");	
							}
							elseif ($staffrole == 6) //Projects
							{
								$_SESSION['roleid'] = $staffrole;
								$_SESSION['loginid'] = $loginid;
								header("location: index?hr");	
							} */							
							else //Investment Advisor
							{
								$_SESSION['roleid'] = $staffrole;
								$_SESSION['loginid'] = $loginid;								
								header("location: index?staff");	
							}							
				}
			
				else {
						header("location: hod?login_error");		
				}
}

//ChangePassword
if(isset($_POST['changePassword'])) {

	function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			return $data;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$email = test_input($_POST["email"]);
			
	}

		 $check = mysqli_query($conn, "SELECT * FROM staff WHERE email = '$email'");				

		if (mysqli_num_rows($check) > 0) {			
			
			$length = 6;
			$randomPassword = "";
			$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
			$max = count($characters) - 1;
			for ($i = 0; $i < $length; $i++) {
				$rand = mt_rand(0, $max);
				$randomPassword .= $characters[$rand];
				$password = md5($randomPassword);
			}

                    $receiver = $email;
                    $newpassword = $randomPassword;
							
                    $body = 'The Password for your Hall7PROMiSYS account with email address - '.$receiver.'has been reset.'."\r\n".'Your new password is '. $newpassword."\r\n".'Log in to www.hall7promisys.com.ng to continue';
                        
                        $to = $email; //email
                        $subject = 'Password Recovery';
                        $message = $body;
                        
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html\r\n";
                        $headers .= 'From: "HALL7PROMISYS" <info@hall7promisys.com.ng>';
                        
                        $sentmail = mail($to, $subject, $message, $headers);
                        

				    if ($sentmail) {

			            $update = "UPDATE staff set password = '$password' where email = '$email'";
				    	
						$updated = mysqli_query($conn, $update) or die(mysqli_error($conn));
						
						header("location: forgotpassword?success");
																				
			        }
			        
			        else {
					    
					    header("location: forgotpassword?failed");			
			        
			        }
		}
	
		else {
				
				header("location: forgotpassword?wrongemail");	
		} 
	



}
	
?>