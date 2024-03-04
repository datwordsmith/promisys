<?php
//Include database configuration file
	require_once ("connector/connect.php");	

	session_start();
	
	$clientemail = $_SESSION['clientemail'];
			
	
			//Fetching Values from URL
			$project=$_POST['pjt'];
			$property=$_POST['ppt'];
			$quantity=$_POST['qty'];

			$getProperty = mysqli_fetch_object(mysqli_query($conn,  "select * from property where project_id = $project and type_id = $property"));
			$amt = $getProperty->amount;
				
			$total = $amt * $quantity;
			
			if ($project !="") {

			//Insert query
			$query = mysqli_query($conn, "insert into client_property(email, project_id, property_id, quantity, amount) values ('$clientemail', '$project', '$property', '$quantity', '$total')");

			echo '<div class="callout callout-success" id="success"><i class="icon fa fa-pencil-square-o"></i> Project successfully edited! </div>';	

			}
			
			

				
?>