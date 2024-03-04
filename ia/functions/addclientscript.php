<?php
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();


//ASSIGN PROPERTY SCRIPT
if(isset($_POST['addclient'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = test_input($_POST["email"]);
		$title = test_input($_POST["title"]);
		$lastname = test_input($_POST["lastname"]);
		$firstname = test_input($_POST["firstname"]);
		$middlename = test_input($_POST["middlename"]);
		$sex = test_input($_POST["gender"]);
		$dob = $_POST["dob"];
		$phone = test_input($_POST["phone"]);
		$mobile = test_input($_POST["mobile"]);
		$occupation = test_input($_POST["occupation"]);
		$address = $_POST["address"];
			
}

 $newdob = date("Y-m-d", strtotime($dob));
 


		
				/**/$check = mysqli_query($conn, "SELECT * FROM client WHERE email = $email");				

				if (mysqli_num_rows($check) < 1) {
						
						$add = "INSERT INTO client (email, title, lastname, firstname, middlename, sex, dob, phone, mobile, occupation, address) VALUES ('$email', '$title', '$lastname', '$firstname', '$middlename', '$sex', '$newdob', '$phone', '$mobile', '$occupation', '$address')";
						$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
												
						if ($added) {								
								header("location: ../addclient?added");																	
						}
						else {
								header("location: ../addclient?failed");			
						}
				}
			
				else {
						
						header("location: ../addclient?clientexists");	
				}		

}

?>