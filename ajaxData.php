<?php
//Include database configuration file 
	require_once ("connector/connect.php");	

	$output = '';
	
	if (isset($_POST["projectId"])) {
		$project  = $_POST["projectId"];
	
		$ppt = mysqli_query($conn,  "select * from project_property where project_id = $project");
	
		if ($project !="")
		{
						$output = '<option value="">Property Type</option>';
							while ($property = mysqli_fetch_object($ppt)){ 
								$propertyid = $property->id;
								$property_type = $property->property_type;
								$propertyCount = $property->quantity;
								
								$getpptsold = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertySold FROM client_property where property_id = $propertyid"));
								$propertySold = $getpptsold->propertySold;
								$propertySold = (int)$propertySold;
								
								//CHECK DIFFERENCE
								$balance = ($propertyCount - $propertySold);		
								
								if ($balance > 0) {
									$output .= '<option value="'.$propertyid.'">'.$property_type.' - '.$balance.' Available</option required>';
								} else {
								
								}
							}
							echo $output;
		}
	}
	

	if (isset($_POST["propertyId"]))
	{
		$propertyId = $_POST["propertyId"];

		if ($propertyId != '') {
			$ppt = mysqli_query($conn,  "select * from project_property where id = $propertyId");			
			while ($property = mysqli_fetch_object($ppt)){
				$amount = $property->amount;
				$output = number_format($amount);
			}			
			echo $output;
		}
	}	
	
?>