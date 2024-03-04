<?php
	clearstatcache();

	require_once ("../connector/connect.php");

	//Declare Page
	$offerletters = "active";
	//$offerpending = "active";
	$pagename = "Pending Request";

	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php");

	if(isset($_GET['details'])) {
		$prospectPropertyId = $_GET['details'];

		if (is_numeric($prospectPropertyId)) {
			$getconfam = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM prospect_property where id = $prospectPropertyId"));
			$prospectid = $getconfam->prospect_id;
			$payStatus = $getconfam->payStatus;

			if ($getconfam) {

				//$confam = mysqli_fetch_object($getconfam);
				$_SESSION['prospectPropertyId'] = $prospectPropertyId;
			}
			else {
				header("location: initialinvestment");
			}

		}
		else {
			header("location: initialinvestment");
		}

	} else
	{
		header("location: initialinvestment");
	}



?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once ("objects/head.php");
	?>
	  <!-- iCheck -->
  	<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  	<style type="text/css">
  		input[type="checkbox"]{
		  width: 30px; /*Desired width*/
		  height: 30px; /*Desired height*/
		}
  	</style>
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

     			<!-- PROSPECT INFO -->
				<div class="col-md-4 col-xs-12">

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

														//if(isset($_GET['details'])) {
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
														//}
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
															<tr><th width=30%>&nbsp;</th> <td></td> </tr>
															<tr><th width=30%>&nbsp;</th> <td></td> </tr>
													</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- CLOSE BOX -->

				</div>


				<!-- INVESTMENT DETAILS -->
				<div class="col-md-4 col-xs-12">

							<!-- BIO -->
							<div class="box  box-info">
								<div class="box-header with-border">
								  <h3 class="box-title">Investment Details</h3>
								  <div class="box-tools pull-right">
									<!--
									<a href="viewprospect?deleteprospect=<?php echo $prospectid; ?>" data-toggle="modal" data-target="#editBox" class="btn btn-danger btn-sm btn-info" ><i class="ace-icon fa fa-trash"></i> Delete Prospect</a>-->
								  </div>
								</div>
								<!-- /.box-header -->

								<div class="box-body"  style="overflow-x:auto;">

									<?php 

										$prospectproperty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospect_property where id = '$prospectPropertyId'"));

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
										$date = date("Y-M-d", $date);

										$amount = $prospectproperty->amount;

									?>

									<table class="table no-border table-responsive" >
											<tr><th width=30%>Date</th> <td><?php echo $date; ?></td> </tr>
											<tr><th width=30%>Project</th> <td><?php echo $project; ?></td> </tr>
											<!--
											<tr><th width=30%>File ID</th> <td><?php echo $client->fileid; ?></td> </tr>
											-->
											<tr><th width=30%>Property</th> <td><?php echo $propertytype; ?></td> </tr>
											<tr><th width=30%>Category</th> <td><?php echo $category; ?></td> </tr>
											<tr><th width=30%>Units</th> <td><?php echo $prospectproperty->quantity; ?></td> </tr>
											<tr><th width=30%>Tax</th> <td><?php echo $prospectproperty->tax; ?></td> </tr>															
											<tr><th width=30%>Amount Due</th> <td><?php echo $sign.number_format($amount); ?></td> </tr>
											<tr><th width=30%>Advisor</th> <td><?php echo $staffname; ?></td> </tr>	
											<tr><th width=30%>Comments</th> <td><?php echo $prospectproperty->comment; ?></td> </tr>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- CLOSE BOX -->

				</div>


				<!-- INVESTMENT PLAN -->
				<div class="col-md-4 col-xs-12">

							<!-- BIO -->
							<div class="box  box-success">
								<div class="box-header with-border">
								  <h3 class="box-title">Investment Plan</h3>
								  <div class="box-tools pull-right">
									<!--
									<a href="viewprospect?deleteprospect=<?php echo $prospectid; ?>" data-toggle="modal" data-target="#editBox" class="btn btn-danger btn-sm btn-info" ><i class="ace-icon fa fa-trash"></i> Delete Prospect</a>-->
								  </div>
								</div>
								<!-- /.box-header -->

								<div class="box-body"  style="overflow-x:auto;">

									<table id="" class="table" >
												
										<thead><tr><th>Investment</th> <th width=25%>Date</th> <th><span style="float: right;">Amount (<?php echo $sign; ?>)</span></th> </tr> </thead>   
												
												<tbody id="exbody"> 
													<?php
														$counter = 1;
														
														$all = mysqli_query($conn,  "SELECT * FROM prospectplan where prospectproperty_id = '$prospectPropertyId' order by date asc");
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
								<!-- /.box-body -->
							</div>
							<!-- CLOSE BOX -->

				</div>				

	 </div>


	 <div class="row">

	 	<div class="col-md-12" style="padding: 20px;">


			 <?php 
				$getplan = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospectplan where prospectproperty_id = '$prospectPropertyId' order by date asc LIMIT 1"));
				
				$amountdue = $getplan->amount;



		 		if($payStatus == 1){
		 			echo '
				  	<div>
				  		<p class="text-success" style="font-size: 2em; ">You have confirmed Initial Investment Due: <span class="label label-success">'.$sign.number_format($amountdue).'</span></p>
				  	</div>';
		 		} else {
					echo '
					<div class="checkbox" style="font-size: 2em;">
					    <label>
					      <input type="checkbox" class="confirm" > <span style="margin-left: 20px;">Confirm receipt of Initial Investment Due: <span class="label label-info">'.$sign.number_format($amountdue).'</span></span> 
					    </label>
					</div>

				  	<div>
				  		<button type="button" class="btn btn-success confirmbtn" data-id="'.$prospectPropertyId.'" style="display: none;">Confirm Payment</button>
				  	</div>';
				}

	 		?>
	 		
	 	</div>
 	
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
    $('.sidebar-menu').tree()
  });

	$(document).ready(function(){
		$('#myTable').dataTable();
	});


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


	//PRINT
	function printFunction() {
		window.print();
	}

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

		$('.confirm').click(function(){
			if($('.confirm').prop("checked") == true){
				$('.confirmbtn').fadeIn('slow');

			} else {
				$('.confirmbtn').fadeOut('slow');
			}						
		});


		$('.confirmbtn').click(function(){
			
			var prospectPropertyId = $(this).attr("data-id");
			$.ajax ({
				url:'functions/fetchviewprospect.php',
				method:'POST',
				data:{confirm: prospectPropertyId},
				dataType:'text',
				success:function(data) {
					location.reload(true);
					//console.log(data);
				}
			});
		});


	});




</script>

</body>
</html>