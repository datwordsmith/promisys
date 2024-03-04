<?php
	require_once ("../../connector/connect.php");

	// re-create session
	session_start();

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader
	require '../../vendor/autoload.php';


	$loginid = $_SESSION['loginid'];
	$prospectid = $_SESSION['prospectid'];


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


//REQUEST OFFER LETTER
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
			//$staff = test_input($_POST["staff"]);
			$unitcost = (int)test_input($_POST["amount"]);
		}
						$prospectid = $_SESSION['prospectid'];


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

							//$baseamount = (($unitcost + $markup) - $discount);

							$amount = ($unitcost * $quantity);


							$loginid = $_SESSION['loginid'];

							$add = "INSERT INTO prospect_property (prospect_id, property_id, quantity, investmentcategory_id, amount, staff_id) VALUES ('$prospectid', '$propertyid', '$quantity', '$category', '$amount', '$loginid')";
							$added = mysqli_query($conn, $add) or die(mysqli_error($conn));


							if ($added) {

									$getRecipient = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM hod where department = 'admin'"));
									$recipient = $getRecipient->email;	

									$mail = new PHPMailer();

								    //Server settings
								    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
								    $mail->isSMTP();                                            // Send using SMTP
								    $mail->Host       = 'mail.hall7projects.com';                    // Set the SMTP server to send through
								    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
								    $mail->Username   = 'promisys@hall7projects.com';                     // SMTP username
								    $mail->Password   = 'f#IHD&9_YHMD';                               // SMTP password
								    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
								    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

								    //Recipients
								    $mail->setFrom('promisys@hall7projects.com', 'PROMISYS');
								    $mail->addAddress($recipient, 'Admin');     // Add a recipient

								    // Content
								    $mail->isHTML(true);                                  // Set email format to HTML
								    $mail->Subject = 'Request for Offer Letter';
								    $mail->Body    = 'Hello Admin,<p>You have a new Request for Offer Letter</p>.<p>Kindly Visit <a href="http://promisys.hall7projects.com/">PROMISYS</a> for details.</p>';

								    $mail->send();	

									$buyPropertyOk = "buyPropertyOk";
									$_SESSION['buyPropertyOk'] = $buyPropertyOk;
									header("location: ../viewprospect?details=".$prospectid);
							}
							else {
									$buyPropertyFailed = "buyPropertyFailed";
									$_SESSION['buyPropertyFailed'] = $buyPropertyFailed;
									header("location: ../viewprospect?details=".$prospectid);
							}

						}

						else {
							//QUANTITY ORDERED > QUANTITY REMAINING
							$buyPropertyError = "buyPropertyError";
							$_SESSION['buyPropertyError'] = $buyPropertyError;
							header("location: ../viewprospect?details=".$prospectid);

						}/**/
}


//DELETE PROPERTY SCRIPT
if(isset($_POST['deleteproperty'])) {

		$prospectPropertyId = $_SESSION['prospectProperty_id'];

						$delete = mysqli_query($conn, "DELETE FROM prospect_property WHERE id = $prospectPropertyId");

						if ($delete) {
								$deletePropertyOk = "deletePropertyOk";
								$_SESSION['deletePropertyOk'] = $deletePropertyOk;
								header("location: ../viewprospect?details=".$prospectid);
								//echo "DELETED";
						}
						else {
								$deletePropertyFailed = "deletePropertyFailed";
								$_SESSION['deletePropertyFailed'] = $deletePropertyFailed;
								header("location: ../viewprospect?details=".$prospectid);
								//echo "NOT DELETED";
						}
}


//CONFIRM PAYMENT SCRIPT
if(isset($_POST['confirm'])) {

		$prospectProperty_id = $_POST['confirm'];

			//PROSPECT PROPERTY
	   	$updateProperty = "UPDATE prospect_property set payStatus = '1' where id = '$prospectProperty_id'";
		$PropertyUpdated = mysqli_query($conn, $updateProperty) or die(mysqli_error($conn));

		if ($PropertyUpdated) {

			$getRecipient = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM hod where department = 'legal'"));
			$recipient = $getRecipient->email;	

			$mail = new PHPMailer();

		    //Server settings
		    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'mail.hall7projects.com';                    // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;// Enable SMTP authentication                                   
		    $mail->Username   = 'promisys@hall7projects.com';                     // SMTP username
		    $mail->Password   = 'f#IHD&9_YHMD';                               // SMTP password
		    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		    //Recipients
		    $mail->setFrom('promisys@hall7projects.com', 'PROMISYS');
		    $mail->addAddress($recipient, 'Legal');     // Add a recipient

		    // Content
		    $mail->isHTML(true);  // Set email format to HTML
		    $mail->Subject = 'Request for Sales Agreement';
		    $mail->Body    = 'Hello Legal,<p>You have a new request for Sales Agreement</p>.<p>Kindly Visit <a href="http://promisys.hall7projects.com/">PROMISYS</a> for details.</p>';

		    $mail->send();

		    $getprospectid = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM prospect_property where id = '$prospectProperty_id'"));
		    $prospectId = $getprospectid->prospect_id;
		    $property_id = $getprospectid->property_id;
		    $quantity = $getprospectid->quantity;
		    $investmentcategory_id = $getprospectid->investmentcategory_id;
		    $amount = $getprospectid->amount;
		    $tax = $getprospectid->tax;
		    $comment = $getprospectid->comment;
		    $date = $getprospectid->date;
		    $staff_id = $getprospectid->staff_id;

		    $getprospectemail = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM prospects where id = '$prospectId'"));
		    $prospectEmail = $getprospectemail->email;

		    $checkclient = mysqli_query($conn, "SELECT * FROM client where email = '$prospectEmail'");

		    //IF PROSPECT EXISTS IN CLIENT TABLE
			if (mysqli_num_rows($checkclient) > 0) {
				
				$getclient = mysqli_fetch_object($checkclient);
				$clientid = $getclient->id;

				//UPDATE CLIENT_PROPERTY
				$addclientproperty = "INSERT INTO client_property (id, client_id, property_id, quantity, investmentcategory_id, amount, tax, comment, date, 	staff_id) VALUES ('$prospectProperty_id', '$clientid', '$property_id', '$quantity', '$investmentcategory_id', '$amount', '$tax', '$comment', '$date', '$staff_id')";
					$clientpropertyadded = mysqli_query($conn, $addclientproperty) or die(mysqli_error($conn));


					if ($clientpropertyadded) {

						//GET INITAL AMOUNT 
						$getplan = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospectplan where prospectproperty_id = '$prospectProperty_id' order by date asc LIMIT 1"));
							$planid = $getplan->id;
							$amountdue = $getplan->amount;

							//UPDATE ACCOUNT TABLE
							$addaccount = "INSERT INTO account (client_id, client_property_id, amount, staff_id) VALUES ('$clientid', '$prospectProperty_id', 
											'$amountdue', '$staff_id')";
							$accountadded = mysqli_query($conn, $addaccount) or die(mysqli_error($conn));	

							if ($accountadded) {

								//UPDATE PROSPECT PLAN
								$update = "UPDATE prospectplan set status = '1' WHERE id = '$planid'";
									$updated = mysqli_query($conn, $update) or die(mysqli_error($conn));

									if($updated) {
										//UPDATE PLAN
										$addclientplan = "INSERT INTO plan (clientproperty_id, date, amount, status) SELECT prospectproperty_id, date, amount, status FROM prospectplan WHERE prospectproperty_id = '$prospectProperty_id'";			
											$clientplanadded = mysqli_query($conn, $addclientplan) or die(mysqli_error($conn));									

									}
							}
					}

			} 
			else {

				//ADD CLIENT
				$addclient = "INSERT INTO client 
					(email, title, lastname, firstname, middlename, sex, dob, phone, mobile, occupation, address, prospectid) 
					SELECT email, title, lastname, firstname, middlename, sex, dob, phone, mobile, occupation, address, id 
					FROM prospects WHERE email = '$prospectEmail'";			
					$clientadded = mysqli_query($conn, $addclient) or die(mysqli_error($conn));	

					if ($clientadded) {
						$checkclient = mysqli_query($conn, "SELECT * FROM client where email = '$prospectEmail'");

						$getclient = mysqli_fetch_object($checkclient);
						$clientid = $getclient->id;

							//UPDATE CLIENT_PROPERTY
							$addclientproperty = "INSERT INTO client_property (id, client_id, property_id, quantity, investmentcategory_id, amount, tax, comment, date, 	staff_id) VALUES ('$prospectProperty_id', '$clientid', '$property_id', '$quantity', '$investmentcategory_id', '$amount', '$tax', '$comment', '$date', '$staff_id')";
								$clientpropertyadded = mysqli_query($conn, $addclientproperty) or die(mysqli_error($conn));

							if ($clientpropertyadded) {
								//echo "CLIENT PROPERTY ADDED<br/>";

								//GET INITAL AMOUNT 
								$getplan = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospectplan where prospectproperty_id = '$prospectProperty_id' order by date asc LIMIT 1"));
									$planid = $getplan->id;
									$amountdue = $getplan->amount;

									echo "Amount Due ".$amountdue.'<br/>';

									//UPDATE ACCOUNT TABLE
									$addaccount = "INSERT INTO account (client_id, client_property_id, amount, staff_id) VALUES ('$clientid', '$prospectProperty_id', 
													'$amountdue', '$staff_id')";
									$accountadded = mysqli_query($conn, $addaccount) or die(mysqli_error($conn));	

									if ($accountadded) {

										//UPDATE PROSPECT PLAN
										$update = "UPDATE prospectplan set status = '1' WHERE id = '$planid'";
											$updated = mysqli_query($conn, $update) or die(mysqli_error($conn));

											if($updated) {
												//UPDATE PLAN
												$addclientplan = "INSERT INTO plan (clientproperty_id, date, amount, status) SELECT prospectproperty_id, date, amount, status FROM prospectplan WHERE prospectproperty_id = '$prospectProperty_id'";			
													$clientplanadded = mysqli_query($conn, $addclientplan) or die(mysqli_error($conn));									

											}
									}
							}						
					}
				
			}
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

// CONFIRM PAYMENT MODAL
if(isset($_GET['confirmpayment'])) {


		$prospectProperty_id = $_GET['confirmpayment'];
		$_SESSION["prospectProperty_id"] = $prospectProperty_id;

			$detail = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospect_property WHERE id = '$prospectProperty_id'"));
			$prospectid = $detail->prospect_id;


			$_SESSION['prospectid'] = $prospectid;
?>
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Confirm Initial Investment</h4>
		</div>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="modal-body">

					<p>Do you confirm that the Accounts Department has received the initital investment for this transaction?</p>

			</div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
			<button type="submit" name= "confirmPayment" class="btn btn-outline pull-right"><i class="ace-icon fa fa-check"></i> <span>Confirm</span></button>
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
