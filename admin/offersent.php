<?php
	clearstatcache();

	require_once ("../connector/connect.php");

	//Declare Page
	$offerletters = "active";
	$offersent = "active";
	$pagename = "Offers Sent";

	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php");


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
        <i class="fa fa-paper-plane-o"></i> Offer Letters Sent
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Offer Letters - Sent</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php
									if (isset($_GET['added'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-check-square-o"></i> Prospect Successfully Added.</h4>

									</div>';
									}
									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">
									<h4><i class="icon fa fa-exclamation-circle"></i> Oops</h4>
									Unsuccessful, Please try again.
									</div>';
									}
									if (isset($_GET['prospectexists'])) {
									echo '<div class="callout callout-warning" id="inactive-alert">
									<h4><i class="icon fa fa-info"></i> Error</h4>
									Prospect already exists with the same email!
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



	<!-- THIRD ROW -->
	<div class="row noprint" style="margin-top: 25px;">

					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
								<div class="box-header with-border">
								  <h3 class="box-title">Offer Letters - Sent</h3>

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

							<table id="myTable" class="table table-striped"  style="padding-bottom: 50px">

									<thead><th>Date</th> <th>Prospect</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th><center>Advised by</center></th> <th><center>Action</center></th></tr> </thead>

									<tbody>
										<?php

										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM prospect_property where rfo = 2 order by date asc");
										while($prospectproperty = mysqli_fetch_object($all))
										{
											$prospectid = $prospectproperty->prospect_id;
											$getProspect = mysqli_fetch_object(mysqli_query($conn, "select * from prospects where id = $prospectid"));
											if ((is_null($getProspect->middlename))||(empty($getProspect->middlename))) {
												$prospectname = $getProspect->lastname.' '.$getProspect->firstname;
											} else {
												$prospectname = $getProspect->lastname.' '.$getProspect->firstname.' '.$getProspect->middlename;
											}
											

											$investmentcategory_id = $prospectproperty->investmentcategory_id;

											$getCat = mysqli_fetch_object(mysqli_query($conn, "select * from investment_category where id = $investmentcategory_id"));
											$category = $getCat->category;

											$propertyid = $prospectproperty->property_id;
											$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from project_property where id = $propertyid"));
											$propertytype = $getppt->property_type;

											$projectid = $getppt->project_id;
											$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
											$project = $getpjt->name;

											$staffid = $prospectproperty->staff_id;
											$getstf = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $staffid"));

											$getstaff = mysqli_fetch_object(mysqli_query($conn, "select * from staff where id = $staffid"));
											$staffname = $getstaff->lastname.' '.$getstaff->firstname;


											$date = $prospectproperty->date;
											$date = strtotime($date);

											$amount = $prospectproperty->amount;

											$prospectPropertyId = $prospectproperty->id;

											echo '
												<tr>


														<td> '.date("Y-M-d",$date).'</td>';
														//<td> <a href="viewprospect?details='.$prospectid.'">'.$prospectname.'</a></td>
														echo'
														<td>'.$prospectname.'</td>
														<td> '.$project.'</td>
														<td> '.$propertytype.'<br/><small class="productcategory">('.$category.')</small></td>
														<td> '.$prospectproperty->quantity.'</td>';?>
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td>
														<!--<td><span class="pull-right"><?php echo $sign.number_format($amountpaid); ?></span></td>
														<td><span class="pull-right"><?php echo $sign.number_format($balance); ?></span></td>-->
														<td>
															<center>
																<?php
																	//echo '<button class="btn btn-xs btn-info" disabled>'.$staffname.'</button>';
																	echo '<span class="label label-default">'.$staffname.'</span>';
																?>
															</center>
														</td>

														<td>
															<center>
																<?php
																	echo '<a href="prospectinvestment?details='.$prospectPropertyId.'" class="btn btn-xs btn-info">View</a>';
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
    $('.sidebar-menu').tree();

    $('#myTable').dataTable();

	//PRINT
	function printFunction() {
		window.print();
	}


  });



</script>

</body>
</html>
