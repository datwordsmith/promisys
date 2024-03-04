<?php
	require_once ("../connector/connect.php");	

	// re-create session
	session_start();


	$loginid = $_SESSION['loginid'];

	//$clientid = $_SESSION['clientid'];

//MAKE PAYMENT
if(isset($_POST['updatepayment'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$amount = test_input($_POST["amount"]);
				$date = $_POST["date"];
		}

		$newdate = date("Y-m-d", strtotime($date));

		/*echo "Newdate = ".$newdate;
		echo "Amount = ".$amount;*/

						$clientid = $_SESSION['clientid'];	
						$clientpropertyid = $_SESSION['clientpropertyid'];	

						$add = "INSERT INTO account (client_id, client_property_id, amount, staff_id, date) VALUES ('$clientid', '$clientpropertyid', '$amount', '$loginid', '$newdate')";
						$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
												
						if ($added) {								
								$paymentOk = "paymentOk";
								$_SESSION['paymentOk'] = $paymentOk;
								header("location: ../sales");	
						}
						else {
								$paymentFailed = "paymentFailed";
								$_SESSION['paymentFailed'] = $paymentFailed;
								header("location: ../sales");		
						}
						
}


//BUY PROPERTY
if(isset($_POST['buyproperty'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$project = test_input($_POST["project"]);
				$property = test_input($_POST["property"]);
				$quantity = test_input($_POST["quantity"]);
				$staff = test_input($_POST["staff"]);
		}
						$clientid = $_SESSION['clientid'];	

							//PROPERTY COUNT
							$getpptcount = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property where project_id = $project and type_id = $property"));
							$propertyCount = $getpptcount->quantity;
							$propertyCount = (int)$propertyCount;
							
							//QUANTITY SOLD
							$getpptsold = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertySold FROM client_property where project_id = $project and property_id = $property"));
							$propertySold = $getpptsold->propertySold;
							$propertySold = (int)$propertySold;
							
							//CHECK DIFFERENCE
							$balance = ($propertyCount - $propertySold);	
						
						if ($balance >= $quantity) {	
						
							$getCost = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM property WHERE project_id = '$project' and type_id = '$property'"));
							$unitcost = $getCost->amount;
							$amount = ($unitcost * $quantity);
							
							
							$add = "INSERT INTO client_property (client_id, project_id, property_id, quantity, amount, staff_id) VALUES ('$clientid', '$project', '$property', '$quantity', '$amount', $staff)";
							$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
													
							if ($added) {								
									$buyPropertyOk = "buyPropertyOk";
									$_SESSION['buyPropertyOk'] = $buyPropertyOk;
									header("location: ../viewclient?details=".$clientid);	
							}
							else {
									$buyPropertyFailed = "buyPropertyFailed";
									$_SESSION['buyPropertyFailed'] = $buyPropertyFailed;
									header("location: ../viewclient?details=".$clientid);		
							}

						} 
						
						else {
							//QUANTITY ORDERED > QUANTITY REMAINING
							$buyPropertyError = "buyPropertyError";
							$_SESSION['buyPropertyError'] = $buyPropertyError;
							header("location: ../viewclient?details=".$clientid);							
						
						}
						
	

}


//DELETE PROJECT SCRIPT
if(isset($_POST['deleteproperty'])) {

		$clientPropertyId = $_SESSION['clientProperty_id'];
					
						$delete = mysqli_query($conn, "DELETE FROM client_property WHERE id = $clientPropertyId");
												
						if ($delete) {								
								$deletePropertyOk = "deletePropertyOk";
								$_SESSION['deletePropertyOk'] = $deletePropertyOk;
								header("location: ../viewclient?details=".$clientid);																		
						}
						else {
								$deletePropertyFailed = "deletePropertyFailed";
								$_SESSION['deletePropertyFailed'] = $deletePropertyFailed;
								header("location: ../viewclient?details=".$clientid);		
						}

}

//===========================================================================================================================================>


//BUY PROPERTY MODAL

if(isset($_GET['buyproperty'])) {	
?>

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Buy Property</h4>
				</div>

				<div class="modal-body">
									
								<form  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="assign_form">
									<div class="col-md-4 col-xs-12">
											<select name="project" id="project" class="form-control" onChange="change_project()">
												<option value="">Select Project</option>
												<?php
												$pjt = mysqli_query($conn,  "SELECT * FROM project order by name");
												$projectCount = $pjt->num_rows;
												if($projectCount > 0){
													while ($project = mysqli_fetch_object($pjt)){ 
														echo '<option value="'.$project->id.'">'.$project->name.'</option>';
													}
												}else{
													echo '<option value=""></option>';
												}
												?>
											</select>	
										<div style="clear:both;">&nbsp;</div>												
									</div>
															
									<div class="col-md-6 col-xs-12">								
										<select name="property" id="property" class="form-control" onChange="change_property()" disabled>
											<option value="">Property</option>
										</select>
										<div style="clear:both;">&nbsp;</div>
									</div>

									<div class="col-md-2 col-xs-12">									
										<input onChange="choose_unit()" type="number" class="form-control" min="1" placeholder="Qty" name = "quantity" id = "quantity" required disabled>		
										<div style="clear:both;">&nbsp;</div>											
									</div>		

									<div class="col-md-12 col-xs-12">									
										<select name="staff" id="staff" class="form-control" onChange="change_staff()" required>
											<option value="">Select Staff</option>
											<?php
											$stf = mysqli_query($conn,  "SELECT * FROM staff where status = 1 and role_id > 1 order by lastname");
											$staffCount = $stf->num_rows;
											if($staffCount > 0){
												while ($staff = mysqli_fetch_object($stf)){ 
													echo '<option value="'.$staff->id.'">'.$staff->lastname.' '.$staff->firstname.'</option>';
												}
											}else{
												echo '<option value="0">N/A</option>';
											}
											?>
										</select>
										<div style="clear:both;">&nbsp;</div>											
									</div>										
									
									<div class="col-md-12 col-xs-12">									
										<center>
											<button type="submit" name="buyproperty" id="buyproperty" class="btn btn-info col-xs-12" disabled><i class="ace-icon fa fa-floppy-o"></i></button>
										</center>
									</div>
									<div style="clear: both;"></div>
								</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>

<?php
}



// MAKE PAYMENT MODAL
if(isset($_GET['addpayment'])) {	
		
		//$clientPropertyId = $_SESSION["clientpropertyid"];
		$clientPropertyId = $_GET['addpayment'];
		$_SESSION["clientpropertyid"] = $clientPropertyId; 
				
			$detail = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property WHERE id = '$clientPropertyId'"));
			$clientid = $detail->client_id;
			//
			$propertyid = $detail->property_id;
			$amount = $detail->amount;
			
			$_SESSION['clientid'] = $clientid;	
			
			$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));
			$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
			
			$property = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property WHERE id = $propertyid"));
			$projectid = $property->project_id;

			$project = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project WHERE id = $projectid"));
			
			$account = mysqli_query($conn,  "SELECT SUM(amount) AS amountpaid FROM account where client_property_id = $clientPropertyId GROUP BY client_property_id;");
			if (mysqli_num_rows($account)>0) {
				$getacc = mysqli_fetch_object($account);
				$amountpaid = $getacc->amountpaid;
				$balance = ($amount - $amountpaid);
				
			} else {
				$amountpaid = 0;
				$balance = ($amount - $amountpaid);
			}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Update Payment</h4>
</div>
    <script>
      $(document).on("click", ".modal-body", function () {
       $("#datepicker").datepicker({
         dateFormat: 'yy-mm-dd'                                    
         });
          });  
    </script>
<div class="modal-body">

			<table id="myTable" class="table " >
					<tr><th width=30%>Client Email</th> <td><?php echo $client->email; ?></td> </tr>
					<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>
					<tr><th width=30%>File ID</th> <td><?php echo strtoupper($detail->fileid); ?></td> </tr>
					<tr><th width=30%>Project</th> <td><?php echo $project->name.' - '.$project->state; ?></td> </tr>
					<tr><th width=30%>Property Type</th> <td><?php echo $property->property_type; ?></td> </tr>
					<tr><th width=30%>Number of Units</th> <td><?php echo $detail->quantity; ?></td> </tr>
					<tr><th width=30%>Total Cost</th> <td><?php echo $sign.number_format($detail->amount); ?></td> </tr>
					<tr><th width=30%>Amount Paid</th> <td><?php echo $sign.number_format($amountpaid); ?></td> </tr>
					<tr><th width=30%>Balance</th> <td><?php echo $sign.number_format($balance); ?></td> </tr>
			</table>
			
			<hr/>

			<form  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="assign_form">
				<div class="col-md-2 col-xs-12">
					<h4>Pay <i class="fa fa-hand-o-right" aria-hidden="true"></i></h4>
				</div>	
				
				<div class="col-md-4 col-xs-12">
					<input type="number" class="form-control" min="1" max="<?php echo $balance;?>" placeholder="Amount" name = "amount" id = "amount" required>		
					<div style="clear:both;">&nbsp;</div>											
				</div>		

				<div class="col-md-4 col-xs-12">
				  	<div class="input-group date">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" placeholder="Date" class="form-control" id="datepicker" name="date" required>

				  	</div>
				
					<div style="clear: both;">&nbsp;</div>											
				</div>	

				<div class="col-md-2 col-xs-12 pull-right">
					<button type="submit" name= "updatepayment" id="updatepayment" class="btn btn-info form-control"><i class="ace-icon fa fa-floppy-o"></i></button>									
				</div>	
					
				<div style="clear: both;"></div>
			</form>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
              </div>

<?php
}


// VIEW CLIENT MODAL
if(isset($_GET['viewclient'])) {	
		
		$clientid = $_GET["viewclient"]; 
				
			
			$_SESSION['clientid'] = $clientid;	
			
			$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));
			$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
			

			
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Client Details</h4>
</div>

<div class="modal-body">

			<table id="myTable" class="table " >
					<tr><th width=30%>Client Email</th> <td><?php echo $client->email; ?></td> </tr>
					<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>				
					<tr><th width=30%>Sex</th> <td><?php echo $client->sex; ?></td> </tr>
					<tr><th width=30%>D.O.B</th> <td><?php echo $client->dob; ?></td> </tr>
					<tr><th width=30%>Phone #1</th> <td><?php echo $client->phone; ?></td> </tr>
					<tr><th width=30%>Phone #2</th> <td><?php echo $client->mobile; ?></td> </tr>
					<tr><th width=30%>Occupation</th> <td><?php echo $client->occupation; ?></td> </tr>
					<tr><th width=30%>Address</th> <td><?php echo $client->address; ?></td> </tr>
			</table>
</div>

              <div class="modal-footer">
              	<!--<a href="viewclient?details="<?php echo $clientid; ?> class="btn btn-outline pull-left" data-dismiss="modal">Close</a>-->
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
              </div>

<?php
}



// DELETE CLIENT PROPERTY MODAL

if(isset($_GET['deleteproperty'])) {	
	$clientProperty_id = $_GET["deleteproperty"];
	$_SESSION['clientProperty_id'] = $clientProperty_id;
			
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Delete Client Property</h4>
</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">
	
		<p>Are you sure you want to delete this item?</p>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "deleteproperty" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Delete</span></button>
              </div>
</form>
<?php
}
?>

<!-- bootstrap datepicker -->
<script src="styles/js/bootstrap-datepicker.js"></script>

<script>
    //Date picker
    $('#datepicker').datepicker({
    });
</script>