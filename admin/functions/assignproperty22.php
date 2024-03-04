<?php
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();


//ASSIGN PROPERTY SCRIPT
if(isset($_POST['assignproperty'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$propertytype = test_input($_POST["propertytype"]);
		$quantity = test_input($_POST["quantity"]);
}
		$projectid = $_SESSION['assignid'];
		
				$check = mysqli_query($conn, "SELECT * FROM property WHERE project_id = $projectid and type_id = '$propertytype'");				

				if (mysqli_num_rows($check) < 1) {
				
						$add = "INSERT INTO property (project_id, type_id, quantity) VALUES ('$projectid', '$propertytype', '$quantity')";
						$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
												
						if ($added) {								
								//header("location: ../projects?added");																	
						}
						else {
								//header("location: ../projects?failed");			
						}
				}
			
				else {
						$edit = "UPDATE property set type_id = '$propertytype', quantity = '$quantity' WHERE project_id = '$projectid' and type_id = '$propertytype'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
						
						//header("location: ../projects?edited");	
				}		

}

?>