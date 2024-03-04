<?php


//ADD PROJECT SCRIPT
	if(isset($_GET['details'])) {	
		$clientid = $_GET['details'];
			$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));

			$viewid = $client->id;
			//$_SESSION['editid'] =  $editid;
			
			$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
			$sex = strtolower($client->sex);
				
				if ($sex == "male") {
					$sexcolor = "blue";
				} else {
					$sexcolor = "pink";
				}
	}




//===========================================================================================================================================>


?>

<!-- bootstrap datepicker -->
<script src="styles/js/bootstrap-datepicker.js"></script>

<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
</script>