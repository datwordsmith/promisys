<?php
	clearstatcache();

	require_once ("../connector/connect.php");

	//Declare Page
	$prospects = "active";
	$pagename = "Prospect Details";

	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php");

	if(isset($_GET['details'])) {
		$prospectid = $_GET['details'];

		if (is_numeric($prospectid)) {
			$getconfam = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM prospects where id = $prospectid"));

			if ($getconfam) {
				//$confam = mysqli_fetch_object($getconfam);
				$_SESSION['prospectid'] = $prospectid;
			}
			else {
				header("location: prospects");
			}

		}
		else {
			header("location: prospects");
		}

	} else
	{
		header("location: prospects");
	}


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
        <i class="fa fa-users"></i> Prospect Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="prospects"><i class="fa fa-users"></i> Prospects</a></li>
        <li class="active">Prospect Details</li>
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

     <div class="row">

				<div class="col-md-12 col-xs-12">

							<!-- BIO -->
							<div class="box  box-warning">
								<div class="box-header with-border">
								  <h3 class="box-title">Prospect Information</h3>
								  <div class="box-tools pull-right">
									<!--
									<a href="viewprospect?deleteprospect=<?php echo $prospectid; ?>" data-toggle="modal" data-target="#editBox" class="btn btn-danger btn-sm btn-info" ><i class="ace-icon fa fa-trash"></i> Delete Prospect</a>-->
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
															$prospectid = $_GET['details'];
																$prospect = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospects WHERE id = '$prospectid'"));

																$viewid = $prospect->id;
																//$_SESSION['editid'] =  $editid;

																$fullname = $prospect->lastname.' '.$prospect->firstname.' '.$prospect->middlename.' ('.$prospect->title.')';
																$sex = strtolower($prospect->sex);

																	if ($sex == "male") {
																		$sexcolor = "blue";
																	} else {
																		$sexcolor = "#CF4191";
																	}
														}
													?>

													<table class="table no-border table-responsive" >
															<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>
															<tr><th width=30%>Email Address</th> <td><?php echo $prospect->email; ?></td> </tr>
															<!--
															<tr><th width=30%>File ID</th> <td><?php echo $client->fileid; ?></td> </tr>
															-->
															<tr><th width=30%>Sex</th> <td><?php echo $prospect->sex; ?></td> </tr>
															<tr><th width=30%>Birthdate</th> <td><?php echo $prospect->dob; ?></td> </tr>
															<tr><th width=30%>Telephone</th> <td><?php echo $prospect->phone.', '.$prospect->mobile; ?></td> </tr>
															<tr><th width=30%>Occupation</th> <td><?php echo $prospect->occupation; ?></td> </tr>
															<tr><th width=30%>Address</th> <td><?php echo $prospect->address; ?></td> </tr>
													</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- CLOSE BOX -->

				</div>


	 </div>


	<!-- SECOND ROW | BUY PROPERTY ROW -->
	<!--<div class="row" id="buyProperty" hidden>-->
	<div class="row" id="buyProperty" hidden>

					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
								<div class="box-header with-border">
								  <h3 class="box-title">Request Offer Letter</h3>

								  <div class="pull-right">
									<button id="exitBuyPropertyBtn" class="btn btn-danger btn-sm" ><i class="ace-icon fa fa-times"></i> Hide</button>
								  </div>
								</div>
							<!-- /.box-header -->

							<div class="box-body"  style="overflow-x:auto;">

								<form  method="POST" action="functions/fetchviewprospect.php" id="assign_form">
									<div class="row">
										<div class="col-md-10">
											<!-- ROW 1 -->
											<div class="row">
												<div class="col-md-3 col-xs-12">
														 <select name="project" id="project" class="form-control">
															<option value="">Select Project</option>
															<?php echo load_projects(); ?>
														</select>
													<div style="clear:both;">&nbsp;</div>
												</div>

												<div class="col-md-3 col-xs-12">
													<select name="property" id="property" class="form-control" required disabled>
														<option value="">Property</option>
													</select>
													<div style="clear:both;">&nbsp;</div>
												</div>

												<div class="col-md-3 col-xs-12">
												<input type="number" class="form-control" min="10000000" placeholder="Amount" name = "amount" id = "amount" disabled>
													<div style="clear:both;">&nbsp;</div>
												</div>

												<div class="col-md-3 col-xs-12">
													<input type="number" class="form-control" min="1" placeholder="Qty" name = "quantity" id = "quantity" required disabled>
													<div style="clear:both;">&nbsp;</div>
												</div>	
											</div>

											<!-- ROW 2-->
											<div class="row">
												<div class="col-md-3 col-xs-12">
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


												<div class="col-md-3 col-xs-12">
													<input type="number" class="form-control" placeholder="Tax (%)" min="0"  step=".01" id="tax" name = "tax" disabled>
													<small class="text-success">Enter Tax value in percentage (%)</small>
													<div style="clear:both;">&nbsp;</div>
												</div>

												<div class="col-md-3 col-xs-12">
												        <input type="number" class="form-control" placeholder="Tax Amount Payable" min="0" id="taxValue" name = "taxValue" disabled>
												        <small class="text-success">Tax Amount Payable.</small>
												    <div style="clear:both;">&nbsp;</div>
												</div>

												<div class="col-md-3 col-xs-12">
												        <input type="number" class="form-control" placeholder="Total Investment Amount" min="0" id="totalCost" name = "totalCost" disabled>
												        <small class="text-success">Total Investment Amount</small>
												    <div style="clear:both;">&nbsp;</div>
												</div>
											</div>
										
										</div>

										<div class="col-md-2">
											<div class="form-group">
											  <textarea class="form-control" rows="5" id="comment" name="comment" style="height: 115px !important;" disabled></textarea>
											  <small class="text-success" style="float: right;">Additional Notes</small>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="text-center" style="margin-top: 10px;">
											<center>
												<button type="submit" name="buyproperty" id="buyproperty" class="btn btn-info btn-sm text-center" disabled><i class="ace-icon fa fa-floppy-o"></i> Submit</button>
											</center>
											<div style="clear: both; margin-bottom: 20px;"></div>
										</div>
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
								  <h3 class="box-title">Prospect Investments</h3>

								  <div class="pull-right">
									<button id="buyPropertyBtn" class="btn btn-primary btn-sm" ><i class="ace-icon fa fa-plus"></i> Invest</button>
								  </div>
								</div>
							<!-- /.box-header -->

							<div class="box-body"  style="overflow-x:auto;">

								<?php

									if (isset($_SESSION['buyPropertyOk'])) {
										$buyPropertyOk = "";
										$buyPropertyOk = $_SESSION['buyPropertyOk'];
										echo '<div class="callout callout-success" id="propertyAdded">
										<i class="icon fa fa-check-square-o"></i> Saved! Please fill in the investment plan to continue
										</div>';
									}

									//BUY NOTIFICATION
									if (isset($_SESSION['paymentOk'])) {
										$paymentOk = "";
										$paymentOk = $_SESSION['paymentOk'];
										echo '<div class="callout callout-success" id="propertyAdded">
										<i class="icon fa fa-check-square-o"></i> Accounts Department is now notified. Please visit them with proof of payment.
										</div>';
									}									

									if (isset($_SESSION['buyPropertyFailed'])) {
										$buyPropertyFailed = "";
										$buyPropertyFailed = $_SESSION['buyPropertyFailed'];
										echo '<div class="callout callout-danger" id="success">
										<i class="icon fa fa-exclamation-circle"></i> Request failed, Try Again.
										</div>';
									}
									if (isset($_SESSION['buyPropertyError'])) {
										$buyPropertyError = "";
										$buyPropertyError = $_SESSION['buyPropertyError'];
										echo '<div class="callout callout-warning" id="propertyAdded">
										<i class="icon fa fa-exclamation-circle"></i> Error, you have orderd more than the available units, Try Again.
										</div>';
									}



									//CLEAR SESSION VARIABLES
									unset($_SESSION['buyPropertyOk']);
									unset($_SESSION['buyPropertyFailed']);
									unset($_SESSION['buyPropertyError']);
									unset($_SESSION['paymentOk']);

								?>

							<table id="myTable" class="table table-bordered table-striped"  style="padding-bottom: 50px">

									<thead><th>Action</th><th>Date</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th>Tax</th> <th width=20%>Comments</th> <th>Status</th><!--<th><center>Sold by</center></th>--> </tr> </thead>

									<tbody>
										<?php

										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM prospect_property where prospect_id = '$prospectid' order by date asc");
										while($prospectproperty = mysqli_fetch_object($all))
										{
											$fileid = $prospectproperty->fileid;
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

											$date = $prospectproperty->date;
											$date = strtotime($date);

											$amount = $prospectproperty->amount;
											$tax = $prospectproperty->tax;
											
											$payStatus = $prospectproperty->payStatus;

											$prospectPropertyId = $prospectproperty->id;
											
											$rfostatus = $prospectproperty->rfo;	

											if(is_nan($rfostatus)) {
												echo "NOT";
											} 



											//if ($getOffer) {
												/*$file = '<a class="btn btn-xs btn-success" href="../offerletters/'.$getOffer->file.'" download="Offer Letter"><i class="ace-icon fa fa-download"></i> <span class="hidden-xs">Offer Letter</span></a>';*/

												if ($rfostatus == 0) {
													$delete = '<a href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$prospectPropertyId.'" class="btn btn-xs btn-danger deleteproperty"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
													$stat = '';
													$plan = '<a href="#loadPlan" data-target="#loadPlan" data-id="'.$prospectPropertyId.'" class="btn btn-xs btn-info loadplan"><i class="fa fa-calendar" aria-hidden="true"></i> Plan</a>';
												} elseif ($rfostatus == 1) {
													$delete = '<a href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$prospectPropertyId.'" class="btn btn-xs btn-danger deleteproperty"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
													$stat = '<h5><span class="label label-warning"> AWAITIING PAYMENT CONFIRMATION </span></h5>';
													$plan = '<a href="#loadPlan" data-target="#loadPlan" data-id="'.$prospectPropertyId.'" class="btn btn-xs btn-info loadplan"><i class="fa fa-calendar" aria-hidden="true"></i> Plan</a>';													
												} else {
													if ($payStatus == 0 ) {
														$delete = '<button class="btn btn-xs btn-danger" disabled><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>';
														$stat = '<h5><span class="label label-warning"> AWAITIING PAYMENT CONFIRMATION </span></h5>';
														$plan = '<a href="#loadPlan" data-target="#loadPlan" data-id="'.$prospectPropertyId.'" class="btn btn-xs btn-info loadplan"><i class="fa fa-calendar" aria-hidden="true"></i> Plan</a>';	
													} else {
														$delete = '<button class="btn btn-xs btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i> Paid</button>';
														$stat = '<button class="btn btn-xs btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i> Payment Confirmed</button>';
														$plan = '<button class="btn btn-xs btn-info" disabled><i class="fa fa-calendar" aria-hidden="true"></i> Plan</button>';															
													}													
												}

											/*} else {
												$file = '';
												$delete = ' <a href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$prospectPropertyId.'" class="btn btn-xs btn-danger deleteproperty"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
												$stat = '';
											}	*/


											echo '
												<tr>

														<td>'.$plan.' '.$delete.'</td>

														<td> '.date("Y-M-d",$date).'</td>
														<td> '.$project.'</td>
														<td> '.$propertytype.'<br/><span class="productcategory">('.$category.')</span></td>
														<td> '.$prospectproperty->quantity.'</td>';?>
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td>
														<td><?php echo $tax.'%'; ?></td>
														<td><?php echo $prospectproperty->comment; ?></td>
														<td><?php echo $stat;?></td>

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


	<!-- Delete Prospect -->
	<div class="modal modal-warning fade" id="editBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <!-- //Content Will show Here -->
			</div>
		</div>
	</div>
	<!-- Close Delete Prospect -->


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

	//LOAD PLAN
	$('.loadplan').click(function(){
		var plan=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewprospect.php?loadplan="+plan,cache:false,success:function(result){
			$(".plan-body").html(result);
		}});

	});/**/

	//DELETE PROSPECT PROPERTY
	$('.deleteproperty').click(function(){
		var deleteproperty=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewprospect.php?deleteproperty="+deleteproperty,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

	//CONFIRM INITIAL INVESTMENT
	$('.confirmInvestment').click(function(){
		var confirmInvestment=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewprospect.php?confirmInvestment="+confirmInvestment,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});


	//DELETE PROSPECT
	$('.deleteprospect').click(function(){
		var prospectid=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewprospect.php?deleteprospect="+prospectid,cache:false,success:function(result){
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

	$(document).ready(function(){
		$(".rfoletter").click(function(){
			alert('CLICKED');
		})
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
			$("#category").focus();
		});
	});

	$(document).ready(function(){
		$('#category').change(function(){
			//document.getElementById("staff").removeAttribute("disabled");	
			document.getElementById("tax").removeAttribute("disabled");			
		});
	});

	$(document).ready(function(){
		$('#tax').change(function(){
			//document.getElementById("discount").removeAttribute("disabled");
			//document.getElementById("markup").removeAttribute("disabled");			
			var tax = $('#tax').val();
			var quantity = $('#quantity').val();
			var amount = $('#amount').val();
			var taxvalue = (tax/100)*(amount*quantity);
			var totalValue = (taxvalue)+(amount*quantity);
			$('#taxValue').val(taxvalue);
			$('#totalCost').val(totalValue);

			document.getElementById("comment").removeAttribute("disabled");	
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
