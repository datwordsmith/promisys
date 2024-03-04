<?php
	clearstatcache();

	require_once ("../connector/connect.php");

	//Declare Page
	$clients = "active";
	$pagename = "Client Details";

	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php");

	if(isset($_GET['details'])) {
		$clientid = $_GET['details'];

		if (is_numeric($clientid)) {
			$getconfam = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM client where id = $clientid"));

			if ($getconfam) {
				//$confam = mysqli_fetch_object($getconfam);
				$_SESSION['clientid'] = $clientid;
			}
			else {
				header("location: clients");
			}

		}
		else {
			header("location: clients");
		}

	} else
	{
		header("location: clients");
	}

	if(isset($_GET['editprofile'])) {
		$_SESSION['editprofile'] = $_GET['editprofile'];
		header("location: functions/fetchviewclient.php?editprofile");
	}

	$getpptcount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertyCount FROM client_property where client_id = '$clientid' and refund = 0;"));
	$propertyCount = $getpptcount->propertyCount;

	$gettotalcost = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(amount) AS totalCost FROM client_property where client_id = '$clientid' and refund = 0;"));
	$totalCost = $gettotalcost->totalCost;

	$getamountpaid = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(amount) AS amountPaid FROM account where client_id = '$clientid'  and refund = 0;"));
	$amountPaid = $getamountpaid->amountPaid;

	$outstanding = ($totalCost - $amountPaid);

	function load_projects(){
		global $conn;
		$output = '';
		$pjt = mysqli_query($conn,  "SELECT * FROM project where id in (select project_id from project_property) order by name");
		$projectCount = $pjt->num_rows;
		if($projectCount > 0){
			while ($project = mysqli_fetch_object($pjt)){
				echo '<option value="'.$project->id.'">'.$project->name.'</option>';
			}
		}else{
			//echo '<option value=""></option>';
		}
		return $output;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once ("objects/head.php");
	?>
</head>
<script>
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});

	window.setTimeout(function() {
		$("#propertyAdded").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
		});
	}, 4000);

	window.setTimeout(function() {
		$("#success").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
		});
	}, 4000);



</script>


<body class="hold-transition skin-blue sidebar-mini">
<div class="se-pre-con"></div>
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
	<?php include ("objects/top_bar.php"); 	?>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
	<?php include ("objects/sidebar.php"); 	?>
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="ion ion-ios-people"></i> Client Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="clients"><i class="ion ion-ios-people"></i> Clients</a></li>
        <li class="active">Client Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php
									if (isset($_GET['added'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-check-square-o"></i> Client Successfully Added.</h4>

									</div>';
									}
									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">
									<h4><i class="icon fa fa-exclamation-circle"></i> Oops</h4>
									Unsuccessful, Please try again.
									</div>';
									}
									if (isset($_GET['clientexists'])) {
									echo '<div class="callout callout-warning" id="inactive-alert">
									<h4><i class="icon fa fa-info"></i> Error</h4>
									Client already exists with the same email!
									</div>';
									}

									if (isset($_GET['edited'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Project successfully edited!
									</div>';
									}
									if (isset($_GET['deleted'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Project successfully deleted!
									</div>';
									}
						?>

     <div class="row">

				<div class="col-md-8 col-xs-12">

							<!-- BIO -->
							<div class="box  box-warning">
								<div class="box-header with-border">
								  <h3 class="box-title">Client Information</h3>
								  <div class="box-tools pull-right">
									<a href="viewclient?editprofile=<?php echo $clientid; ?>" data-toggle="modal" data-target="#editBox" class="btn btn-warning btn-sm btn-info" ><i class="ace-icon fa fa-pencil-square-o"></i> Edit Client</a>
								  </div>
								</div>
								<!-- /.box-header -->

								<div class="box-body"  style="overflow-x:auto;">

													<?php


														//EDIT CLIENT NOTIFICATION
														if (isset($_SESSION['clientUpdated'])) {
														echo '<div class="callout callout-success" id="propertyAdded">
														<i class="icon fa fa-check-square-o"></i> Client Profile Successfully Edited.

														</div>';
														}
														if (isset($_SESSION['clientUpdateFailed'])) {
														echo '<div class="callout callout-danger" id="propertyAdded">
														<i class="icon fa fa-exclamation-circle"></i> Client Profile Update Failed, Try Again.

														</div>';
														}

														unset($_SESSION['clientUpdated']);
														unset($_SESSION['clientUpdateFailed']);

														if(isset($_GET['details'])) {
															$clientid = $_GET['details'];
																$client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = '$clientid'"));

																$viewid = $client->id;
																//$_SESSION['editid'] =  $editid;

																$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
																$sex = strtolower($client->sex);

																	if ($sex == "male") {
																		$sexcolor = "blue";
																	} else {
																		$sexcolor = "#CF4191";
																	}
														}
													?>

													<table class="table no-border table-responsive" >
															<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>
															<tr><th width=30%>Email Address</th> <td><?php echo $client->email; ?></td> </tr>
															<!--
															<tr><th width=30%>File ID</th> <td><?php echo $client->fileid; ?></td> </tr>
															-->
															<tr><th width=30%>Sex</th> <td><?php echo $client->sex; ?></td> </tr>
															<tr><th width=30%>Birthdate</th> <td><?php echo $client->dob; ?></td> </tr>
															<tr><th width=30%>Telephone</th> <td><?php echo $client->phone.', '.$client->mobile; ?></td> </tr>
															<tr><th width=30%>Occupation</th> <td><?php echo $client->occupation; ?></td> </tr>
															<tr><th width=30%>Address</th> <td><?php echo $client->address; ?></td> </tr>
													</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- CLOSE BOX -->

				</div>

				<div class="col-md-4 col-xs-12">

								<div class="box-body"  style="overflow-x:auto;">
									  <div class="info-box">
										<span class="info-box-icon bg-aqua"><i class="fa fa-home" aria-hidden="true"></i></span>

										<div class="info-box-content">
										  <span class="info-box-text"><h4>Properties Owned</h4></span>
										  <span class="info-box-number count" style="font-size: 2em;"><?php echo $propertyCount;?></span>
										</div>
										<!-- /.info-box-content -->
									  </div>
									  <!-- /.info-box -->

									  <div class="info-box">
										<span class="info-box-icon bg-green"><i class="fa fa-money" aria-hidden="true"></i></span>

										<div class="info-box-content">
										  <span class="info-box-text"><h4>Amount Paid</h4></span>
										  <span class="info-box-number" style="font-size: 2em;"><?php echo $sign.'<span class="count">'.$amountPaid.'</span>';?></span>
										</div>
										<!-- /.info-box-content -->
									  </div>
									  <!-- /.info-box -->

									  <div class="info-box">
										<span class="info-box-icon bg-yellow"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>

										<div class="info-box-content">
										  <span class="info-box-text"><h4>Outstanding</h4></span>
										  <span class="info-box-number" style="font-size: 2em;"><?php echo $sign.'<span class="count">'.$outstanding.'</span>';?></span>

										</div>
										<!-- /.info-box-content -->
									  </div>
									  <!-- /.info-box -->
							</div>
							<!-- CLOSE BOX -->
				</div>

	 </div>


	 <!-- SECOND ROW | BUY PROPERTY ROW -->
 	<div class="row" id="buyProperty" hidden>

 					<div class="col-md-12 col-xs-12">

 							<!-- ASSIGN PROPERTY -->
 						  <div class="box  box-info">
 								<div class="box-header with-border">
 								  <h3 class="box-title">Buy Properties</h3>

 								  <div class="pull-right">
 									<button id="exitBuyPropertyBtn" class="btn btn-danger btn-sm" ><i class="ace-icon fa fa-times"></i> Hide</button>
 								  </div>
 								</div>
 							<!-- /.box-header -->

 							<div class="box-body"  style="overflow-x:auto;">

 								<form  method="POST" action="functions/fetchviewclient.php" id="assign_form">
 									<div class="col-md-4 col-xs-12">
 											 <select name="project" id="project" class="form-control">
 												<option value="">Select Project</option>
 												<?php echo load_projects(); ?>
 											</select>
 										<div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-4 col-xs-12">
 										<select name="property" id="property" class="form-control" required disabled>
 											<option value="">Property</option>
 										</select>
 										<div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-2 col-xs-12">
 									<input type="number" class="form-control" min="10000000" placeholder="Amount" name = "amount" id = "amount" disabled>
 										<div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-2 col-xs-12">
 										<input type="number" class="form-control" min="1" placeholder="Qty" name = "quantity" id = "quantity" required disabled>
 										<div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-4 col-xs-12">
 										<select name="category" id="category" class="form-control" required disabled>
 											<option value="">Investment Category</option>
 											<?php
 											$invcat = mysqli_query($conn,  "SELECT * FROM investment_category");
 											$categoryCount = $invcat->num_rows;
 											if($categoryCount > 0){
 												while ($investmentCategory = mysqli_fetch_object($invcat)){
 													echo '<option value="'.$investmentCategory->id.'">'.$investmentCategory->category.'</option>';
 												}
 											}else{
 												echo '<option value=""></option>';
 											}
 											?>
 										</select>
 										<div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-4 col-xs-12">
 										<select name="staff" id="staff" class="form-control" required disabled>
 											<option value="">Select Staff</option>
 											<?php
 											$stf = mysqli_query($conn,  "SELECT * FROM staff where status = 1 and role_id > 1 order by lastname");
 											$staffCount = $stf->num_rows;
 											if($staffCount > 0){
 												while ($staff = mysqli_fetch_object($stf)){
 													echo '<option value="'.$staff->id.'">'.$staff->lastname.' '.$staff->firstname.'</option>';
 												}
 											}else{
 												echo '<option value=""></option>';
 											}
 											?>
 										</select>
 										<div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-2 col-xs-12">
 									        <input type="number" class="form-control" placeholder="Discount" min="0" id="discount" name = "discount" disabled>
 									    <div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-2 col-xs-12">
 									        <input type="number" class="form-control" placeholder="Markup" min="0" id="markup" name = "markup" disabled>
 									    <div style="clear:both;">&nbsp;</div>
 									</div>

 									<div class="col-md-4 col-xs-12 text-center">
 									</div>
 									<div class="col-md-4 col-xs-12 text-center">
 										<center>
 											<button type="submit" name="buyproperty" id="buyproperty" class="btn btn-info btn-sm text-center" disabled><i class="ace-icon fa fa-floppy-o"></i> Buy Property</button>
 										</center>
 										<div style="clear: both;"></div>
 									</div>
 									<div class="col-md-4 col-xs-12 text-center">
 									</div>
 								</form>
 							</div>

 							<!-- /.box-body -->
 						  </div>
 						  <!-- CLOSE BOX -->
 					</div>

 	</div>


	<!-- THIRD ROW -->
	<div class="row noprint">

					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
								<div class="box-header with-border">
								  <h3 class="box-title">Client Properties</h3>

								  <div class="pull-right">
									<button id="buyPropertyBtn" class="btn btn-primary btn-sm" ><i class="ace-icon fa fa-plus"></i> Buy Property</button>
								  </div>
								</div>
							<!-- /.box-header -->

							<div class="box-body"  style="overflow-x:auto;">

								<?php
									//BUY NOTIFICATION
									if (isset($_SESSION['buyPropertyOk'])) {
										$buyPropertyOk = "";
										$buyPropertyOk = $_SESSION['buyPropertyOk'];
										echo '<div class="callout callout-success" id="propertyAdded">
										<i class="icon fa fa-check-square-o"></i> Property Successfully Assigned to Client.
										</div>';
									}
									if (isset($_SESSION['buyPropertyFailed'])) {
										$buyPropertyFailed = "";
										$buyPropertyFailed = $_SESSION['buyPropertyFailed'];
										echo '<div class="callout callout-danger" id="propertyAdded">
										<i class="icon fa fa-exclamation-circle"></i> Property Not Assigned to Client, Try Again.
										</div>';
									}
									if (isset($_SESSION['buyPropertyError'])) {
										$buyPropertyError = "";
										$buyPropertyError = $_SESSION['buyPropertyError'];
										echo '<div class="callout callout-warning" id="propertyAdded">
										<i class="icon fa fa-exclamation-circle"></i> Error, you have orderd more than the available units, Try Again.
										</div>';
									}

									//PAYMENT NOTIFICATION
									if (isset($_SESSION['paymentOk'])) {
									echo '<div class="callout callout-success" id="propertyAdded">
									<i class="icon fa fa-check-square-o"></i> Payment Successfully Updated.

									</div>';
									}
									if (isset($_SESSION['paymentFailed'])) {
									echo '<div class="callout callout-danger" id="propertyAdded">
									<i class="icon fa fa-exclamation-circle"></i> Payment was not successful, Try Again.

									</div>';
									}

									//DELETE NOTIFICATION
									if (isset($_SESSION['deletePropertyOk'])) {
									echo '<div class="callout callout-success" id="propertyAdded">
									<i class="icon fa fa-check-square-o"></i> Assigned Property Successfully Deleted.

									</div>';
									}
									if (isset($_SESSION['deletePropertyFailed'])) {
									echo '<div class="callout callout-danger" id="propertyAdded">
									<i class="icon fa fa-exclamation-circle"></i> Assigned Property Not Deleted, Try Again.

									</div>';
									}

									//FILE ID ERROR
									if (isset($_SESSION['fileIdError'])) {
									echo '<div class="callout callout-danger" id="propertyAdded">
									<i class="icon fa fa-exclamation-circle"></i> File ID not generated. Try again.

									</div>';
									}

									//REASSIGNMENT NOTIFICATION
									if (isset($_SESSION['ReassignmentOk'])) {
									echo '<div class="callout callout-success" id="propertyAdded">
									<i class="icon fa fa-check-square-o"></i> Property has been succefully reassigned.

									</div>';
									}
									if (isset($_SESSION['ReassignmentFailed'])) {
									echo '<div class="callout callout-danger" id="propertyAdded">
									<i class="icon fa fa-exclamation-circle"></i> Property Reassignment Failed. Try

									</div>';
									}

									//CLEAR SESSION VARIABLES
									unset($_SESSION['buyPropertyOk']);
									unset($_SESSION['buyPropertyFailed']);
									unset($_SESSION['buyPropertyError']);
									unset($_SESSION['paymentOk']);
									unset($_SESSION['paymentFailed']);
									unset($_SESSION['deletePropertyOk']);
									unset($_SESSION['deletePropertyFailed']);
									unset($_SESSION['fileIdError']);
									unset($_SESSION['ReassignmentOk']);
									unset($_SESSION['ReassignmentFailed']);
								?>

							<table id="myTable" class="table table-bordered table-striped"  style="padding-bottom: 50px">

									<thead><th>Action</th><th>Date</th> <th>File ID</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th>Paid</th> <th>Balance</th> <th><center>Sold by</center></th> </tr> </thead>

									<tbody>
										<?php

										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM client_property where client_id = '$clientid' and refund = 0 order by date asc");
										while($clientproperty = mysqli_fetch_object($all))
										{
											$fileid = $clientproperty->fileid;
											$investmentcategory_id = $clientproperty->investmentcategory_id;

											$getCat = mysqli_fetch_object(mysqli_query($conn, "select * from investment_category where id = $investmentcategory_id"));
											$category = $getCat->category;

											$propertyid = $clientproperty->property_id;
											$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from project_property where id = $propertyid"));
											$propertytype = $getppt->property_type;

											$projectid = $getppt->project_id;
											$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
											$project = $getpjt->name;

											$staffid = $clientproperty->staff_id;
											$getstf = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $staffid"));

											$date = $clientproperty->date;
											$date = strtotime($date);

											$amount = $clientproperty->amount;

											$clientPropertyId = $clientproperty->id;
											$account = mysqli_query($conn,  "SELECT id as accountid, SUM(amount) AS amountpaid FROM account where refund = 0 and client_property_id = $clientPropertyId GROUP BY client_property_id;");
											if (mysqli_num_rows($account)>0) {
												$getacc = mysqli_fetch_object($account);
												$amountpaid = $getacc->amountpaid;
												$balance = ($amount - $amountpaid);
												$accountid = $getacc->accountid;

											} else {
												$amountpaid = 0;
												$balance = ($amount - $amountpaid);
											}

											$delbutton = mysqli_query($conn,  "SELECT * FROM account where client_id = '$clientid' and refund = 0 and client_property_id = $clientPropertyId");

											echo '
												<tr>

														<td>
															<!-- DropDown Buttons -->
															<div class="btn-group pull-left">
															<!--<button type="button" class="btn btn-xs btn-danger">Action</button>-->
															<button type="button" class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown">
																<span class="caret"></span>
																<span class=""> Action</span>
															</button>
															<ul class="dropdown-menu" role="menu">
																<li><a href="#loadPlan" data-target="#loadPlan" data-id="'.$clientPropertyId.'" class="loadplan"><i class="ace-icon fa fa-calendar"></i> Payment Plan</a></li>';

																if (($balance) < 1) {

																} else {
																	echo '<li><a href="#payBox" data-toggle="modal" data-target="#payBox" data-id="'.$clientPropertyId.'" class="addpayment"><i class="ace-icon fa fa-cc-mastercard"></i> Pay</a></li>';
																}

																if (mysqli_num_rows($delbutton) > 0) {
																	echo '<li><a href="paymentdetail?id='.$accountid.'" ><i class="ace-icon fa fa-eye"></i> <span class="hidden-xs"> Payment History</span></a></li>';
																	if ($fileid <> NULL) {
																		echo '<li><a href="#reassign" data-toggle="modal" data-target="#reassign" data-id="'.$clientPropertyId.'" class="reassignstaff" ><i class="ion ion-person-stalker"></i> Reassign Staff</a></li>';
																	}

																} else {
																	echo '<li><a href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$clientPropertyId.'" class="deleteproperty"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>';
																}
															echo '
															</ul>
															</div>';

															if (($balance) < 1) {
																echo '<span class="btn btn-xs btn-info pull-right" disabled>PAID</span>';
															} else {

															} echo'
														</td>

														<td> '.date("Y-M-d",$date).'</td>

														<td>
															<center>';

																$thecount = mysqli_num_rows(mysqli_query($conn,  "SELECT * FROM client_property where fileid is not NULL and property_id = '$propertyid'"));

																if (mysqli_num_rows($delbutton) > 0) {
																	if ($fileid <> NULL) {
																		echo strtoupper($fileid);
																	} else {
																		echo '<a href="javascript:void(0)" id="generateId" data-id="'.$clientPropertyId.'" class="btn btn-xs btn-default" ><span class="hidden-xs">Generate</span></a>';
																	}
																} else {

																	echo "<b style='color: red;'>N/A</b>";

																}

																echo '
															</center>
														</td>

														<td> '.$project.'</td>
														<td> '.$propertytype.'<br/><span class="productcategory">('.$category.')</span></td>
														<td> '.$clientproperty->quantity.'</td>';?>
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td>
														<td><span class="pull-right"><?php echo $sign.number_format($amountpaid); ?></span></td>
														<td><span class="pull-right"><?php echo $sign.number_format($balance); ?></span></td>
														<td>
															<center>
																<?php
																	echo '<a href="viewstaff?details='.$getstf->id.'" class="btn btn-xs btn-info" >'.$getstf->email.'</a>';
																?>
															</center>
														</td>


													<?php echo '
												</tr>';
												//$counter++;
										};

										?>
									</tbody>
							</table>

							</div>
							<!-- /.box-body -->
						  </div>
						  <!-- CLOSE BOX -->
					</div>
	</div>


	<!-- FOURTH ROW | LOAD PLAN -->
	<div class="row plan-body noprint" id="loadPlan">


	</div>


    </section>
    <!-- /.content -->


	<!-- Add Plan Modal-->
	<div class="modal modal-success fade" id="addPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- Close Payment Modal-->


	<!-- Buy Property Modal-->
	<div class="modal modal-default fade" id="buyBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!--Close Buy Property MODAL -->


	<!-- Make Payment Modal-->
	<div class="modal modal-success fade" id="payBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- Close Payment Modal-->



	<!-- Delete Client Property Modal-->
	<div class="modal modal-danger fade" id="deleteBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- Close Delete Client Property Modal-->


	<!-- Reassign Property Modal-->
	<div class="modal modal-danger fade" id="reassign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- Close Reassign Property Modal-->


	<!-- Edit Profile -->
	<div class="modal modal-warning fade" id="editBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <!-- //Content Will show Here -->
			</div>
		</div>
	</div>
	<!-- Close Edit Profile -->


	<!-- View History Modal-->
	<div class="modal modal-success fade" id="viewBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- Close Modal-->






  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
		<?php include ("objects/footer.php"); 	?>
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3.1.1 -->
<script src="plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="styles/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="styles/js/demo.js"></script>

<script src="styles/js/jquery.dataTables.min.js"></script>
<script src="styles/js/dataTables.bootstrap.min.js"></script>

<script src="styles/js/bootstrap-datepicker.js"></script>

<script>

  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });

	$(document).ready(function(){
		$('#myTable').dataTable();
	});



	//BUY PROPERTY
	/*$('.buyproperty').click(function(){
		var buyproperty=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?buyproperty="+buyproperty,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});*/


	//LOAD PLAN
	$('.loadplan').click(function(){
		var plan=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?loadplan="+plan,cache:false,success:function(result){
			$(".plan-body").html(result);
		}});

	});/**/

	//ADD PLAN
	$('.addplan').click(function(){
		var addplan=$(this).attr('data-id');
		alert("no show");
		$.ajax({url:"functions/fetchviewclient.php?addplan="+addplan,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

	//MAKE PAYMENT
	$('.addpayment').click(function(){
		var addpayment=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?addpayment="+addpayment,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

		//DELETE CLIENT PROPERTY
	$('.deleteproperty').click(function(){
		var deleteproperty=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?deleteproperty="+deleteproperty,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

	//REASSIGN PROPERTY
	$('.reassignstaff').click(function(){
		var reassignstaff=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?reassignstaff="+reassignstaff,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

	//VIEW BOX
	$('.paymentdetail').click(function(){
		var paymentdetail=$(this).attr('data-id');

		$.ajax({url:"functions/fetchpayment.php?paymentdetail="+paymentdetail,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});


	$('.editprofile').click(function(){
		var editprofile=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?editprofile="+editprofile,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

	//COUNT
	$('.count').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 2000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});


/*function generate_id(clientPropertyId) {
    //var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "functions/ajaxScripts.php?generate_id=" +clientPropertyId, true);
    xmlhttp.send();

	location = window.location.href;
};
	*/


	// GENERATE FILE ID
	$(document).ready(function(){
	    $("#generateId").click(function(e) {

	        var clientPropertyId = $(this).attr("data-id");

	 	 	//e.preventDefault();

	 	 	//alert(clientPropertyId);
	        /*if (confirm("Sure you want to delete this post? This cannot be undone later.")) {
	        }  */
	            $.ajax({
	                type : 'GET',
	                url : 'functions/ajaxScripts.php', //URL to the delete php script
					data: {
					  	generate_id: clientPropertyId
					}
	            })
	 		    .done(function(data){

			     	location.reload();
			    })
			    .fail(function(){

			    });

	        return false;
	    });
	});


	    $("#buyPropertyBtn").click(function(e) {

	    	//document.getElementById("buyProperty").removeAttribute("hidden");
	    	$("#buyProperty").show();
 			return false;
	    });


	    $("#exitBuyPropertyBtn").click(function(e) {

	    	$("#buyProperty").hide();
 			return false;
	    });

	//PRINT
	function printFunction() {
		window.print();
	}

	$(document).ready(function(){
		$('#project').change(function(){
			var project_id = $(this).val();
			$.ajax ({
				url:'ajaxData.php',
				method:'POST',
				data:{projectId:project_id},
				dataType:'text',
				success:function(data) {
					$('#property').html(data);
					document.getElementById("property").removeAttribute("disabled");
				}
			});
		});
	});

	$(document).ready(function(){
		$('#property').change(function(){
			var property_id = $(this).val();
			$.ajax ({
				url:'ajaxData.php',
				method:'POST',
				data:{propertyId:property_id},
				dataType:'text',
				success:function(data) {
					//$('#amount').val(data);
					document.getElementById("amount").removeAttribute("disabled");
					document.getElementById("quantity").removeAttribute("disabled");
				}
			});
		});
	});

	$(document).ready(function(){
		$('#quantity').change(function(){
			document.getElementById("category").removeAttribute("disabled");
		});
	});

	$(document).ready(function(){
		$('#category').change(function(){
			document.getElementById("staff").removeAttribute("disabled");
		});
	});

	$(document).ready(function(){
		$('#staff').change(function(){
			document.getElementById("discount").removeAttribute("disabled");
			document.getElementById("markup").removeAttribute("disabled");
			document.getElementById("buyproperty").removeAttribute("disabled");
		});
	});


    //Date picker
    $('#datepicker').datepicker({
    });

	$(function() {
	    $("body").delegate("#datepicker", "focusin", function(){
	        $(this).datepicker();
	    });
	});

    //Date picker
    $('#plandate').datepicker({
    });

	$(function() {
	    $("body").delegate("#plandate", "focusin", function(){
	        $(this).datepicker();
	    });
	});



</script>

</body>
</html>
