<?php

	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();

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
		}
						$clientid = $_SESSION['clientid'];	
						$clientpropertyid = $_SESSION['clientpropertyid'];	

						$add = "INSERT INTO account (client_id, client_property_id, amount) VALUES ('$clientid', '$clientpropertyid', '$amount')";
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



// VIEW PAYMENT DETAIL
if(isset($_GET['paymentdetail'])) {	
		
		$accountid = $_GET["paymentdetail"]; 
		
		$account = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM account where id = $accountid"));			
		$clientid = $account->client_id;	

		$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));
		$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
			
		$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));
		$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
			
		$clientpropertyid = $account->client_property_id;
		$clientproperty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property where id = '$clientpropertyid'"));

		$propertyid = $clientproperty->property_id;
		$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from project_property where id = $propertyid"));
		$propertytype = $getppt->property_type;		

		$projectid = $getppt->project_id;
		$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
		$project = $getpjt->name;

		

		
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Payment Details</h4>
</div>

<div class="modal-body" id="paymentHistory">

			<table id="myTable" class="table " >
					<tr><th width=30%>Client Email</th> <td><?php echo $client->email; ?></td> </tr>
					<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>
					<tr><th width=30%>File ID</th> <td><?php echo strtoupper($clientproperty->fileid); ?></td> </tr>					
					<tr><th width=30%>Sex</th> <td><?php echo $client->sex; ?></td> </tr>
					<tr><th width=30%>Phone</th> <td><?php echo $client->phone.', '.$client->mobile; ?></td> </tr>
					<tr><th width=30%>Project</th> <td><?php echo $project; ?></td> </tr>
					<tr><th width=30%>Property Type</th> <td><?php echo $propertytype; ?></td> </tr>
					<tr><th width=30%>Quantity</th> <td><?php echo $clientproperty->quantity; ?></td> </tr>
					<tr><th width=30%>Cost</th> <td><?php echo $sign.number_format($clientproperty->amount); ?></td> </tr>


			</table>

			<table id="myTable" class="table" >
						
				<thead><tr><th></th> <th width=40%>Date</th> <th width=25%><span style="float: right;">Amount Paid(<?php echo $sign; ?>)</span></th> <th> </th> <th width=25%><span style="float: right;">Balance (<?php echo $sign; ?>)</span></th> </tr> </thead>  
						
						<tbody> 
							<?php
								$counter = 1;
								$cost = $clientproperty->amount;
								
								$all = mysqli_query($conn,  "SELECT * FROM account where client_property_id = $clientpropertyid");
								while($getaccount = mysqli_fetch_object($all))
									{
										$date = $getaccount->date;
										$date = strtotime($date);
										
										$paid = $getaccount->amount;
										$bal = ($cost - $paid);
										if ($bal == 0) {
											$status = '<span class=" btn-xs btn-danger" > COMPLETED </span>';
										}
										else {
											$status = $sign.number_format($bal);
										}
																				
										echo '	
											<tr>
												<td>'.$counter.'</td> 														
												<td>'.date("Y-M-d",$date).'</td> 														
												<td><span style="float: right;">'.$sign.number_format($paid).'</span></td>
												<td></td>
												<td><span style="float: right;">'.$status.'</span></td> 														
																										

											</tr>'; 
											$counter++;
											$cost = $bal;
									};									
							?>		
						</tbody>  
			</table>
			
</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="button" onclick="printFunction()" class="btn btn-outline pull-left"><i class="ace-icon fa fa-print"></i> <span>Print</span></button>				
              </div> 

<?php
}

?>
