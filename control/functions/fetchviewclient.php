<?php
	require_once ("../../connector/connect.php");

	// re-create session
	session_start();


	$loginid = $_SESSION['loginid'];
	$clientid = $_SESSION['clientid'];


//EDIT PROFILE SCRIPT
if(isset($_POST['editprofile'])) {
$clientid = $_SESSION["editprofile"];


function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$title = test_input($_POST["title"]);
		$lastname = test_input($_POST["lastname"]);
		$firstname = test_input($_POST["firstname"]);
		$middlename = test_input($_POST["middlename"]);
		$dob = $_POST["dob"];
		//$fileid = test_input($_POST["fileid"]);
		$sex = test_input($_POST["gender"]);
		$phone = test_input($_POST["phone"]);
		$mobile = test_input($_POST["mobile"]);
		$occupation = test_input($_POST["occupation"]);
		$address = test_input($_POST["address"]);

}

		$newdob = date("Y-m-d", strtotime($dob));

				$check = mysqli_query($conn, "SELECT * FROM client WHERE id = '$clientid'");

				if (mysqli_num_rows($check) > 0) {

						$edit = "UPDATE client set title = '$title', lastname = '$lastname', firstname = '$firstname', middlename = '$middlename', sex = '$sex', dob = '$newdob', phone = '$phone', mobile = '$mobile', occupation = '$occupation', address = '$address' WHERE id = '$clientid'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));

						if ($edited) {

							$clientUpdated = "clientUpdated";
							$_SESSION['clientUpdated'] = $clientUpdated;
							header("location: ../viewclient?details=".$clientid);
						}
						else {
							$clientUpdateFailed = "clientUpdateFailed";
							$_SESSION['clientUpdateFailed'] = $clientUpdateFailed;
							header("location: ../viewclient?details=".$clientid);
						}
				}

				else {
							$clientUpdateFailed = "clientUpdateFailed";
							$_SESSION['clientUpdateFailed'] = $clientUpdateFailed;
							header("location: ../viewclient?details=".$clientid);
				}
}


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
								header("location: ../viewclient?details=".$clientid);
						}
						else {
								$paymentFailed = "paymentFailed";
								$_SESSION['paymentFailed'] = $paymentFailed;
								header("location: ../viewclient?details=".$clientid);
						}

}


//REASSIGN PROPERTY
if(isset($_POST['reassignproperty'])) {

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$newstaffid = test_input($_POST["staff"]);
	}

		$clientPropertyId = $_SESSION['clientPropertyId'];
		$clientid = $_SESSION['clientid'];
		$oldstaffid = $_SESSION['old_staff'];

	if (($loginid) == "") {
				$ReassignmentFailed = "ReassignmentFailed";
				$_SESSION['ReassignmentFailed'] = $ReassignmentFailed;
				header("location: ../viewclient?details=".$clientid);

	} else {

		$update = "UPDATE client_property set staff_id = '$newstaffid' WHERE id = '$clientPropertyId'";
		$updated = mysqli_query($conn, $update) or die(mysqli_error($conn));

		$add = "INSERT INTO assign (clientproperty_id, former_staff, new_staff, assignedby) VALUES ('$clientPropertyId', '$oldstaffid', '$newstaffid', '$loginid')";
		$added = mysqli_query($conn, $add) or die(mysqli_error($conn));

		if ($updated) {
				$ReassignmentOk = "ReassignmentOk";
				$_SESSION['ReassignmentOk'] = $ReassignmentOk;
				header("location: ../viewclient?details=".$clientid);
		}
		else {
				$ReassignmentFailed = "ReassignmentFailed";
				$_SESSION['ReassignmentFailed'] = $ReassignmentFailed;
				header("location: ../viewclient?details=".$clientid);
		}
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
				$propertyid = test_input($_POST["property"]);
				$quantity = test_input($_POST["quantity"]);
				$category = test_input($_POST["category"]);
				$staff = test_input($_POST["staff"]);
				$unitcost = (int)test_input($_POST["amount"]);
				$discount = (int)test_input($_POST["discount"]);
				$markup = (int)test_input($_POST["markup"]);

				/*$getAmt = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property where id = $propertyid"));
				$unitcost = $getAmt->amount;*/

				/* echo $propertyid.'<br/>';
				echo $quantity.'<br/>';
				echo $category.'<br/>';
				echo $staff.'<br/>';
				echo $unitcost.'<br/>';
				echo $discount.'<br/>';
				echo $markup.'<br/>'; */
		}
						$clientid = $_SESSION['clientid'];


							//PROPERTY COUNT
							$getpptcount = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property where id = $propertyid"));
							$propertyCount = $getpptcount->quantity;
							$propertyCount = (int)$propertyCount;

							//QUANTITY SOLD
							$getpptsold = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertySold FROM client_property where property_id = $propertyid"));
							$propertySold = $getpptsold->propertySold;
							$propertySold = (int)$propertySold;

							//CHECK DIFFERENCE
							$balance = ($propertyCount - $propertySold);

						if ($balance >= $quantity) {

							$baseamount = (($unitcost + $markup) - $discount);

							$amount = ($baseamount * $quantity);


							$loginid = $_SESSION['loginid'];

							$add = "INSERT INTO client_property (client_id, property_id, quantity, investmentcategory_id, amount, discount, markup, staff_id, assigned_by) VALUES ('$clientid', '$propertyid', '$quantity', '$category', '$amount', '$discount', '$markup', '$staff', '$loginid')";
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

						}/**/
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


//EDIT PROFILE MODAL

if(isset($_GET['editprofile'])) {


$editid = $_SESSION["editprofile"]; //escape the string if you like

	$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = '$editid'"));

			//$viewid = $staff->id;
			//$_SESSION['editid'] =  $editid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Client - <?php echo $client->email; ?></h4>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div class="modal-body">

															  <div class="form-group">
																	<div class="col-md-3 col-xs-12">
																			<input type="text" class="form-control" placeholder="Title" name = "title" value="<?php echo $client->title; ?>" required>
																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-9 col-xs-12">
																			<input type="text" class="form-control" placeholder="Lastname" name = "lastname" value="<?php echo $client->lastname; ?>" required>
																			<div style="clear: both;">&nbsp;</div>
																	</div>
															  </div>

															  <div class="form-group">
																	<div class="col-md-6 col-xs-12">
																			<input type="text" class="form-control" placeholder="Firstname" name = "firstname" value="<?php echo $client->firstname; ?>" required>
																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-6 col-xs-12">
																			<input type="text" class="form-control" placeholder="Middlename" name = "middlename" value="<?php echo $client->middlename; ?>" >
																			<div style="clear: both;">&nbsp;</div>
																	</div>

															  </div>

															  <div class="form-group">
																	<!--
																	<div class="col-md-3 col-xs-12">
																		<input type="text" class="form-control" placeholder="File ID" name = "fileid" value="<?php echo $client->fileid; ?>" >
																		<div style="clear: both;">&nbsp;</div>
																	</div>
																	-->

																	<div class="col-md-6 col-xs-12">
																		  <select class="form-control" placeholder="Gender" name="gender" required>
																				<option value="" selected>Gender</option>
																				<option value="Male">Male</option>
																				<option value="Female">Female</option>
																		  </select>
																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-6 col-xs-12">
																			  <div class="input-group date">
																				  <div class="input-group-addon">
																					<i class="fa fa-calendar"></i>
																				  </div>
																				  <input type="text" placeholder="Date of Birth" class="form-control pull-right" id="datepicker" name="dob" required>
																			  </div>

																			<div style="clear: both;">&nbsp;</div>
																	</div>
															  </div>

															  <div class="form-group">
																	<div class="col-md-6 col-xs-12">
																			<input type="text" class="form-control " placeholder="Telephone #1" name = "phone" value="<?php echo $client->phone; ?>" required>
																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-6 col-xs-12">
																			<input type="text" class="form-control" placeholder="Telephone #2" name = "mobile" value="<?php echo $client->mobile; ?>" >
																			<div style="clear: both;">&nbsp;</div>
																	</div>
															  </div>


															  <div class="form-group">
																	  <div class="col-md-12 col-xs-12">
																			<input type="text" class="form-control col-md-6" placeholder="Occupation" name = "occupation" value="<?php echo $client->occupation; ?>" required>
																			<div style="clear: both;">&nbsp;</div>
																	  </div>
															  </div>

															<div class="form-group">
																	  <div class="col-md-12 col-xs-12">
																			<textarea class="form-control" rows="3" name="address" placeholder="Address" ><?php echo $client->address; ?></textarea>
																	  </div>
																	<div style="clear: both;">&nbsp;</div>
															</div>

		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>
			<button type="submit" name= "editprofile" class="btn btn-info btn-outline pull-left"><i class="ace-icon fa fa-floppy-o"></i> Save</button>
		</div>
</form>

<?php
}






//LOAD PLAN

if(isset($_GET['loadplan'])) {

		$clientPropertyId = $_GET['loadplan'];
		$_SESSION["clientpropertyid"] = $clientPropertyId;

			$detail = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property WHERE id = '$clientPropertyId'"));
			$clientid = $detail->client_id;
			//$projectid = $detail->project_id;
			$propertyid = $detail->property_id;
			$fileid = $detail->fileid;
			$amount = $detail->amount;

			$getppt = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property WHERE id = $propertyid"));
			$projectid = $getppt->project_id;
			$property = $getppt->property_type;

			$getpjt = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project WHERE id = $projectid"));
			$project = $getpjt->name;
			$state = $getpjt->state;


			$_SESSION['clientid'] = $clientid;

			$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = '$clientid'"));
			$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';



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

	<!-- INFO BOX -->
	<div class="col-md-4 col-xs-12">

		<div class="box box-default" style="overflow-x:auto; background: #F2DEDE;">

			<div class="box-header with-border">
			  <h3 class="box-title">Property Information</h3>
			</div>
			<!-- /.box-header -->

			<div class="box-body"  >
				<table id="myTable" class="table " >
					<!--<tr><th width=40%>Client Email</th> <td><?php echo $client->email; ?></td> </tr>
					<tr><th width=40%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>-->
					<tr><th width=30%>File ID</th> <td><?php echo strtoupper($fileid); ?></td> </tr>
					<tr><th width=40%>Project</th> <td><?php echo $project.' - '.$state; ?></td> </tr>
					<tr><th width=40%>Property Type</th> <td><?php echo $property; ?></td> </tr>
					<tr><th width=40%>Number of Units</th> <td><?php echo $detail->quantity; ?></td> </tr>
					<tr><th width=40%>Total Cost</th> <td><?php echo $sign.number_format($detail->amount); ?></td> </tr>

				</table>

						<div id="error"></div>

				<form method="post" id="planForm" action="">

					<input value="<?php echo $clientPropertyId; ?>" id = "clientPropertyId" hidden>

					<table class="table" >

						<tr>

							<td>
								<input type="number" class="form-control" min="1" placeholder="Amount" name = "planamount" id = "planamount" required>
							</td>

							<td>
							  	<div class="input-group date">
								  <div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								  </div>
								  <input type="text" placeholder="Date" class="form-control" id="plandate" name="plandate" required>

							  	</div>
							</td>
						</tr>

						<tr>
							<td colspan=2>
								<center>
									<div id="flash"></div>
									<!--<input type="submit" id="submitPlan" class="btn btn-default" value="Add Investment Plan" onclick="aa();">-->
									<button id="submitPlan" type="button" class="btn btn-info col-xs-12 submitPlan"><span id="spinner"></span> <span id="disk"><i class="ace-icon fa fa-floppy-o"></i></span> Add Investment Plan</button>
								</center>
							</td>
						</tr>

					</table>

				</form>
			</div>
		</div>
		<!-- CLOSE BOX -->
	</div>
	<!-- CLOSE LEFT SIDE -->

	<!-- PLAN LIST -->
	<div class="col-md-8 col-xs-12">

		<div class="box  box-danger" id="">

		<div class="box-header with-border">
		  <h3 class="box-title">Investment Plans</h3>

		  <div class = "pull-right">

		  </div>
		</div>
		<!-- /.box-header -->

		<div class="box-body" id="planList" style="overflow-x:auto;">

				<div id="deleteError"></div>

				<table id="myTable" class="table" >

					<thead><tr><th>Investment</th> <th width=25%>Date</th> <th><span style="float: right;">Amount (<?php echo $sign; ?>)</span></th> <th><center>Action</center></th> </tr> </thead>

							<tbody id="exbody">
								<?php
									$counter = 1;

									$all = mysqli_query($conn,  "SELECT * FROM plan where clientproperty_id = '$clientPropertyId' order by id asc");
									while($row = mysqli_fetch_object($all))
										{
											$date = $row->date;
											$date = strtotime($date);
												ob_start();

												echo '
														<tr>
															<td>#'.$counter.'</td>
															<td>'.date("Y-M-d",$date).'</td>
															<td><span style="float: right;">'.$sign.number_format($row->amount).'</span></td>

															<td>
																<center>
																<button type="button" id="'.$row->id.'" class="deletePlan btn btn-xs btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Delete</button>
																</center>
															</td>

														</tr>
													';
												$GLOBALS['exbox'] = ob_get_contents();

												ob_end_clean();

												echo $exbox;

											$counter++;
										}
								?>
							</tbody>

							<tbody class="getbody">

							</tbody>
				</table>
		</div>
		<!-- box-body -->

		</div>
		<!-- CLOSE BOX -->
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
			//$projectid = $detail->project_id;
			$propertyid = $detail->property_id;
			$amount = $detail->amount;

			$_SESSION['clientid'] = $clientid;

			$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));
			$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';

			$getppt = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property WHERE id = $propertyid"));
			$property = $getppt->property_type;
			$projectid = $getppt->project_id;

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
					<!--<tr><th width=30%>File ID</th> <td><?php echo $client->fileid; ?></td> </tr>-->
					<tr><th width=30%>Project</th> <td><?php echo $project->name.' - '.$project->state; ?></td> </tr>
					<tr><th width=30%>Property Type</th> <td><?php echo $property; ?></td> </tr>
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
					<button type="submit" name= "updatepayment" id="updatepayment" class="btn btn-info"><i class="ace-icon fa fa-floppy-o"></i></button>
				</div>

				<div style="clear: both;"></div>
			</form>

</div>

              <div class="modal-footer">
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

//REASSIGN PROPERTY MODAL
if(isset($_GET['reassignstaff'])) {
	$clientPropertyId = $_GET["reassignstaff"];
	$_SESSION['clientPropertyId'] = $clientPropertyId;


			$detail = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property WHERE id = '$clientPropertyId'"));
			$clientid = $detail->client_id;
			//$projectid = $detail->project_id;
			$propertyid = $detail->property_id;
			$amount = $detail->amount;
			$staffid = $detail->staff_id;

			$_SESSION['clientid'] = $clientid;
			$_SESSION['old_staff'] = $staffid;

			$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));
			$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';

			$staff = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = $staffid"));
			$staffname = $staff->lastname.' '.$staff->firstname.' '.$staff->middlename;

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
    <h4 class="modal-title">Reassign Property to Staff</h4>
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
					<tr><th width=30%>Project</th> <td><?php echo $project->name.' - '.$project->state; ?></td> </tr>
					<tr><th width=30%>Property Type</th> <td><?php echo $property->property_type; ?></td> </tr>
					<tr><th width=30%>Number of Units</th> <td><?php echo $detail->quantity; ?></td> </tr>
					<tr><th width=30%>Total Cost</th> <td><?php echo $sign.number_format($detail->amount); ?></td> </tr>
					<tr><th width=30%>Amount Paid</th> <td><?php echo $sign.number_format($amountpaid); ?></td> </tr>
					<tr><th width=30%>Balance</th> <td><?php echo $sign.number_format($balance); ?></td> </tr>
					<tr><th width=30%>File ID</th> <td><?php echo strtoupper($detail->fileid); ?></td> </tr>
					<tr><th width=30%>Managed By</th> <td><?php echo $staffname; ?></td> </tr>
			</table>

			<hr/>

			<form  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="assign_form">
				<div class="col-md-4 col-xs-12">
					<h4><i class="ion ion-person-stalker"></i> Assign New Staff</h4>
				</div>

				<div class="col-md-6 col-xs-12">
					<select name="staff" id="staff" class="form-control" onChange="change_staff()" required>
						<option value="">Select Staff</option>
						<?php
						$stf = mysqli_query($conn,  "SELECT * FROM staff where status = 1 and role_id > 1 and id <> $staffid order by lastname");
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
				</div>


				<div class="col-md-2 col-xs-12 pull-right">
					<button type="submit" name= "reassignproperty" id="reassignproperty" class="btn btn-info"><i class="ace-icon fa fa-floppy-o"></i></button>
				</div>

				<div style="clear: both;"></div>
			</form>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
              </div>
<?php
}
?>


<!-- bootstrap datepicker -->
<script src="styles/js/bootstrap-datepicker.js"></script>

<script>


    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });


$(document).ready(function(){
 $("#submitPlan").click(function(e){

 	 e.preventDefault();

	 var clientPropertyId = document.getElementById( "clientPropertyId").value;
	 var amount=document.getElementById( "planamount" ).value;
	 var date=document.getElementById( "plandate" ).value;


		if (isNaN(amount) || amount < 1 || amount.trim == '') {
			    $('#planamount').focus();
			    return false;
		}
		else if (date == '' ){
		    $('#plandate').focus();
		    return false;
		}
		else {

	 	 $("#disk").hide();
		 $("#spinner").fadeIn(600).html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');

		 $.ajax({
		  type: 'post',
		  url: 'functions/insertdata.php',
		  data: {
		  	cpId: clientPropertyId,
		  	amount: amount,
		  	date: date
		  }
		})
		    .done(function(data){
		     	//alert('Ajax Submit Correct ...');
				$('#planList').fadeOut('slow', function(){
				    $('#planList').fadeIn('slow').html(data);

					window.setTimeout(function() {
						$("#success").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
						});
					}, 4000);
				});
		    })
		    .fail(function(){
		 		$("#error").fadeIn(600).html('<div class="callout callout-danger" id ="success"><i class="icon fa fa-exclamation-triangle"></i> Error, Please try again!</div>');

					window.setTimeout(function() {
						$("#success").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
						});
					}, 4000);
		    });


		    $('#planamount').val('');
		    $('#plandate').val('');


		    //$('.statusMsg').html(amount+" will be saved");
		    $('.submitPlan').removeAttr("disabled");

		    $("#spinner").hide();
		    $("#disk").show();
		    $("#planForm").reset();

		}

	$("#planForm").reset();
 	return false;
    });
});

// DELETE PLAN
$(document).ready(function(){
    $(".deletePlan").click(function(e) {

        var planid = $(this).attr("id");

 	 	e.preventDefault();

        /*if (confirm("Sure you want to delete this post? This cannot be undone later.")) {
        } */
            $.ajax({
                type : 'POST',
                url : 'functions/deleteplan.php', //URL to the delete php script
				data: {
				  	planid: planid
				}
            })
 		    .done(function(data){
		     	//alert('Ajax Submit Correct ...');
				$('#planList').fadeOut('slow', function(){
				    $('#planList').fadeIn('slow').html(data);

					window.setTimeout(function() {
						$("#success").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
						});
					}, 4000);
				});
		    })
		    .fail(function(){
		 		$("#deleteError").fadeIn(600).html('<div class="callout callout-danger" id ="success"><i class="icon fa fa-exclamation-triangle"></i> Error, Please try again!</div>');

					window.setTimeout(function() {
						$("#success").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
						});
					}, 4000);
		    });

        return false;
    });
});





</script>
