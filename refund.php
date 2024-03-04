<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$refund = "active";
	$pagename = "Refunds";	
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 
	

	if(isset($_GET['delete'])) {
		$_SESSION['unassignproject'] = $_GET['delete'];
		header("location: functions/fetchproject.php?unassignproject");
	}	

	//REDIRECT
	if(isset($_GET['fileid'])) {	
		$fileid = $_GET['fileid'];
		
		if ($fileid) {
			$getconfam = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM client_property where fileid = '$fileid' and refund = 0"));
			
			if ($getconfam) {
				//$confam = mysqli_fetch_object($getconfam);
				$_SESSION['fileid'] = $fileid;
				//header("location: refund?fileid=".$fileid);
				
			}
			else {
				header("location: refund");
			}			
			
		} 
		else {			
			header("location: refund");
		}	

	}


	
?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once ("objects/head.php"); 	
	?>

  <style>
    .flatmodal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .flatmodal {
      background: transparent !important;
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
        <i class="fa fa-undo"></i> Refund Client
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Refund</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

		<div class="row">
								<?php
									//BUY NOTIFICATION
									if (isset($_SESSION['propertyRevoked'])) {
										echo '<div class="callout callout-success" id="propertyAdded">	
										<i class="icon fa fa-check-square-o"></i> Property Successfully Revoked.									
										</div>';									
									}

									if (isset($_SESSION['Failed'])) {
									echo '<div class="callout callout-danger" id="propertyAdded">	
									<i class="icon fa fa-exclamation-circle"></i> Operation not successful, Try Again.
									
									</div>';	
									}									
									//CLEAR SESSION VARIABLES
									unset($_SESSION['propertyDeleted']);
									unset($_SESSION['Failed']);
									unset($_SESSION['propertyRevoked']);
		
								?>

			<?php 
			if (isset($_GET['fileid'])){		?>
				<div class="col-lg-12 col-md-12 col-xs-12">  
					<div class="alert alert-danger col-md-12 col-xs-12" >	
						<p><i class="fa fa-ban"></i> WARNING: You are about to revoke property/properties assigned to a client. If you do not wish to continue, <a href="administrator" type="button" class="btn btn-info" >CANCEL NOW</a></p>

					</div>
				</div>
			<?php
			}

			else {	?>		
		    	<!-- POP UP MODAL -->
				<div class="modal modal-danger flatmodal" id="refundModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
				    <div class="modal-dialog" role="document">
				      <div class="modal-content">	    	
				      <!-- Modal content-->
				        <div class="modal-header">
				          <h4 class="modal-title"><i class="fa fa-ban"></i> WARNING!</h4>
				        </div>
				        <div class="modal-body">
				         <h5>
				         	<center>
				         		<h4>
					         		<p>You are about to revoke property/properties assigned to a client.</p>			         	
					         		<p>If you do not wish to continue</p>
					         		<p><a href="administrator" type="button" class="btn btn-info" >CANCEL NOW</a></p>
					         		<p>OR</p>
					         	</h4>			         				         	
				         	</center>
				         </h5>
				        </div>
				        <div class="modal-footer">
				          <!-- CLIENT FILE ID SEARCH FIELD -->

									<?php
										if (isset($_SESSION['wrongId'])) {
											$fileid = "";
											$fileid = $_SESSION['wrongId'];
											echo '<div class="alert alert-warning" id="success">	
												<center><i class="fa fa-ban"></i> Wrong/Invalid File ID.</center>
											</div>';	
										}	

										//CLEAR SESSION VARIABLES
										unset($_SESSION['wrongId']);							
									?>

							<form method="POST" action="functions/fetchrefund.php">
								<div class="col-md-4 col-xs-12">
									<center><h4>Enter Client File ID </h4></center>
								</div>	

								<div class="col-md-6 col-xs-12">
						              <div class="input-group input-group-sm">
						                <input type="text" class="form-control" name="FileId" required >
						                    <span class="input-group-btn">
						                      <button type="submit" class="btn btn-info btn-flat form-control" name="getFileId"><i class="fa fa-search"></i></button>
						                    </span>
						              </div>
								
									<div style="clear: both;">&nbsp;</div>	
								</div>	
							</form>	         
				        </div>


				      </div>	
				    </div>
				</div>
			<?php
			}
			?>

		</div>


	     
		 
		<!-- SECOND ROW -->
		<div class="row">
			<?php
			if (isset($_GET['fileid'])){

				$fileid = $_GET['fileid'];

				$clientproperty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property where fileid = '$fileid'"));
				$clientid = $clientproperty->client_id;

				$bio = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client where id = '$clientid'"));
				$fullname = $bio->lastname.' '.$bio->firstname.' '.$bio->middlename;
			?>

					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
								<div class="box-header with-border">
								  <h2 class="box-title"><?php echo $fullname.' - '.$bio->email;?></h2>
								  <div class="pull-right">
									<h2 class="box-title"><?php echo 'File ID - '.strtoupper($fileid);?></h2>				
								  </div>
								</div>				  
							<!-- /.box-header -->
							
							<div class="box-body"  style="overflow-x:auto;">
								
								
							<table id="myTable" class="table table-bordered table-striped" >
							
									<thead><tr><th>Date</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th>Paid</th> <th>Balance</th> <th><center>Sold by</center></th> <th></th> </tr> </thead>  
										
									<tbody>  
										<?php									
									
										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM client_property where fileid = '$fileid'  and refund = 0 order by id asc");
										while($clientproperty = mysqli_fetch_object($all))
										{
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
											$account = mysqli_query($conn,  "SELECT SUM(amount) AS amountpaid FROM account where client_property_id = $clientPropertyId  and refund = 0 GROUP BY client_property_id;");
											if (mysqli_num_rows($account)>0) {
												$getacc = mysqli_fetch_object($account);
												$amountpaid = $getacc->amountpaid;
												$balance = ($amount - $amountpaid);
												
											} else {
												$amountpaid = 0;
												$balance = ($amount - $amountpaid);
											}
											
											echo '	
												<tr>													
														<td> '.date("Y-M-d",$date).'</td> 														
														<td> '.$project.'</td> 														
														<td> '.$propertytype.'</td> 														
														<td> '.$clientproperty->quantity.'</td>';?> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amountpaid); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($balance); ?></span></td> 														
														<td>
															<center>
																<?php echo '<a href="viewstaff?details='.$getstf->id.'" class="btn btn-xs btn-info" >'.$getstf->email.'</span></a>'; ?>
																	
															</center>
														</td> 														
														
														<?php echo '
														<td>
																<center>';

																	$clientPropertyId = $clientproperty->id;
																	$delbutton = mysqli_query($conn,  "SELECT * FROM account where client_id = '$clientid' and id = $clientPropertyId and refund = 0");
																	if (($balance) < 1) {
																		echo '<span class="btn-xs btn-success">PAID</span>';
																	} else {
																		echo '<a href="#revokeBox" data-toggle="modal" data-target="#revokeBox" data-id="'.$clientPropertyId.'" class="btn btn-xs btn-danger revokeproperty" ><i class="fa fa-undo"></i> <span class="hidden-xs">Revoke</span></a>';
																	}
																	echo '
																
																</center>						
														</td>																			
														
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

			<?php
			} 
			?>							  
		</div>
	 
	 
    </section>
    <!-- /.content -->

	<!-- Revoke Property Modal-->
	<div class="modal modal-danger fade" id="revokeBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>	
	<!-- Close Payment Modal-->


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

<script>
  
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });
  
	$(document).ready(function(){
		$('#myTable').dataTable();
	});  

	//REVOKE PROPERTY
	$('.revokeproperty').click(function(){
		var revokeproperty=$(this).attr('data-id');

		$.ajax({url:"functions/fetchrefund.php?revokeproperty="+revokeproperty,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

//COUNT	
$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 1000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});




</script>

</body>
</html>
