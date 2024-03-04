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


//INVITE FOR SALES AGREEMENT
if(isset($_POST['invite'])) {

	$prospectPropertyId = $_POST["invite"];

	$edit = "UPDATE prospect_property set payStatus = '2' WHERE id = '$prospectPropertyId'";
	$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));

	if ($edited) {

		$getStaff = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospect_property WHERE id = '$prospectPropertyId'"));
		$staffid = $getStaff->staff_id;	

		$getRecipient = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = '$staffid'"));
		$recipient = $getRecipient->email;
		$staffname = $getRecipient->lastname;


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
	    $mail->isHTML(true);  // Set email format to HTML
	    $mail->Subject = 'Request for Offer Letter';
	    $mail->Body    = 'Hello '.$staffname.',<p>You have a new Sales Agreement awaiting pickup</p>.<p>Kindly Visit Legal and Regulatory Compliance office.</p>';

	    $mail->send();

	} else {

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
