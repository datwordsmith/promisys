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
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Prospect Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php
									if (isset($_GET['added'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-check-square-o"></i> Offer Letter Successfully uploaded.</h4>

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



	<!-- THIRD ROW -->
	<div class="row noprint">

					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
								<div class="box-header with-border">
								  <h3 class="box-title">Prospect Investments</h3>

								  <div class="pull-right">
									<!--<button id="buyPropertyBtn" class="btn btn-primary btn-sm" ><i class="ace-icon fa fa-plus"></i> Invest</button>-->
								  </div>
								</div>
							<!-- /.box-header -->

							<div class="box-body"  style="overflow-x:auto;">

								<?php
									//BUY NOTIFICATION
									if (isset($_SESSION['added'])) {
										$added = "";
										$added = $_SESSION['added'];
										echo '<div class="callout callout-success" id="success">
										<i class="icon fa fa-check-square-o"></i> Offer Letter Successfully Uploaded.
										</div>';
									}
									if (isset($_SESSION['failed'])) {
										$failed = "";
										$failed = $_SESSION['failed'];
										echo '<div class="callout callout-danger" id="success">
										<i class="icon fa fa-exclamation-circle"></i> Failed, Please try again.
										</div>';
									}

									//CLEAR SESSION VARIABLES
									unset($_SESSION['added']);
									unset($_SESSION['failed']);

								?>

							<table id="myTable" class="table table-striped"  style="padding-bottom: 50px">

									<thead><th>Date</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th><center>Sold by</center></th> <th>Action</th></tr> </thead>

									<tbody>
										<?php

										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM prospect_property where prospect_id = '$prospectid' and payStatus = 1 order by rfo, date asc");
										while($prospectproperty = mysqli_fetch_object($all))
										{
											$prospectProperty_id = $prospectproperty->id;

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
											
											$payStatus = $prospectproperty->payStatus;

											if ($payStatus == 1) {
												$action = '<button href="#payBox" data-toggle="modal" data-target="#payBox" data-id="'.$prospectPropertyId.'" class="btn btn-xs btn-success confirmPay"><i class="fa fa-check" aria-hidden="true"></i> Confirm Investment</button>';
											} else {
												$action = '<button class="btn btn-xs btn-success"><i class="fa fa-check" aria-hidden="true"></i> Confirm Investment</button>';
											}											

											echo '
												<tr>

														<td> '.date("Y-M-d",$date).'</td>'; ?>

														<?php 
														echo '
														<td> '.$project.'</td>
														<td> '.$propertytype.'<br/><span class="productcategory">('.$category.')</span></td>
														<td> '.$prospectproperty->quantity.'</td>';?>
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td>
														<!--<td><span class="pull-right"><?php echo $sign.number_format($amountpaid); ?></span></td>
														<td><span class="pull-right"><?php echo $sign.number_format($balance); ?></span></td>-->
														<td>
															<center>
																<?php
																	echo '<button class="btn btn-xs btn-info" disabled>'.$staffname.'</button>';
																?>
															</center>
														</td>

														<td>
															<center>
																<?php
																	echo $action;
																?>
															</center>
														</td>													
												</tr>
												<?php
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


	<!-- Add Document -->
	<div class="modal fade" id="addBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<!-- //Content Will show Here -->
			</div>
		</div>
	</div>


	<!-- Confirm Payment Modal-->
	<div class="modal modal-primary fade" id="payBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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



	//BUY PROPERTY
	/*$('.buyproperty').click(function(){
		var buyproperty=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?buyproperty="+buyproperty,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});*/


	//LOAD PLAN
	$('.uploaddoc').click(function(){
		var prospectProperty_id = $(this).attr('data-id');
		//alert(prospectProperty_id);
		$.ajax({url:"functions/fetchviewprospect.php?addofferletter="+prospectProperty_id, cache:false,success:function(result){
			$(".modal-content").html(result);
		}});

	});/**/


	//CONFIRM PAYMENT
	$('.confirmPay').click(function(){
		var prospectProperty_id=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewprospect.php?confirmpayment="+prospectProperty_id,cache:false,success:function(result){
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
			//document.getElementById("staff").removeAttribute("disabled");
			document.getElementById("buyproperty").removeAttribute("disabled");			
		});
	});

	$(document).ready(function(){
		$('#staff').change(function(){
			document.getElementById("discount").removeAttribute("disabled");
			document.getElementById("markup").removeAttribute("disabled");
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
