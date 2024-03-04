<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$transfer = "active";
	$pagename = "Property Transfers";	
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 
		

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
        <i class="ace-icon fa fa-arrow-down"></i> Transfer Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transfer Details</li>
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

 
	<!-- ROW -->
	<div class="row">
	
					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-danger">

							
							<div class="box-body"  style="overflow-x:auto;">
								
								<?php

								?>
								
							<table id="myTable" class="table table-bordered table-striped" >
							
									<thead><tr><th>Transfer Date</th> <th>Client</th> <th>File ID</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th>Paid</th> <th>Balance</th> <th><center>Old Staff</center></th> <th><center>New Staff</center></th> <th><center>Tranfered By</center></th></tr> </thead>  
										
									<tbody>  
										<?php									
									
										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM assign order by id desc");
										while($transfer = mysqli_fetch_object($all))
										{
											
											$clientproperty_id = $transfer->clientproperty_id;

											$clientproperty = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM client_property where id = '$clientproperty_id'"));
									
											$fileid = $clientproperty->fileid;

											$propertyid = $clientproperty->property_id;
											$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from project_property where id = $propertyid"));
											$propertytype = $getppt->property_type;
											$projectid = $getppt->project_id;

											$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
											$project = $getpjt->name;

											$clientid = $clientproperty->client_id;
											//$getclient = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from client where id = $clientid"));								
											$getclient = mysqli_fetch_object(mysqli_query($conn, "select * from client where id = $clientid"));			
											$fullname = $getclient->lastname.' '.$getclient->firstname.' '.$getclient->middlename;	


											//Former Staff
											$formerstaff = $transfer->former_staff;
											$former = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $formerstaff"));

											//New Staff
											$newstaff = $transfer->new_staff;
											$new = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $newstaff"));

											//Tranfered By
											$assigner = $transfer->assignedby;
											$assigned = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $assigner"));
											
											$date = $transfer->date;
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
											
											echo '	
												<tr>													
														<td> '.date("Y-M-d",$date).'</td> 	
														<td> <a href="viewclient?details='.$clientid.'" class="btn btn-xs btn-default" >'.$fullname.'</a>
														</td> 
														<td> '.strtoupper($fileid).'</td> 	
														<td> '.$project.'</td> 														
														<td> '.$propertytype.'</td> 														
														<td> '.$clientproperty->quantity.'</td>';?> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amountpaid); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($balance); ?></span></td> 														
														<td>
															<center>
																<?php 
																	echo '<a href="viewstaff?details='.$former->id.'" class="btn btn-xs btn-danger" >'.$former->email.'</a>';
																	?>														
																	
															</center>
														</td> 														
														
														<td>
															<center>
																<?php 
																	echo '<a href="viewstaff?details='.$new->id.'" class="btn btn-xs btn-success" >'.$new->email.'</a>';
																	?>														
																	
															</center>					
														</td>	
														
														<td>
															<center>
																<?php 
																	echo '<a href="viewstaff?details='.$assigned->id.'" class="btn btn-xs btn-info" >'.$assigned->email.'</a>';
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
	 
	 
    </section>
    <!-- /.content -->
	

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

<script>
  
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });
  
	$(document).ready(function(){
		$('#myTable').dataTable();
	});  


function change_project() {
	var xmlhttp = new XMLHttpRequest ();
	xmlhttp.open("GET", "ajaxData?project="+document.getElementById("project").value, false);
	xmlhttp.send(null);
	document.getElementById("property").innerHTML=xmlhttp.responseText;
	document.getElementById("property").removeAttribute("disabled");
}

function change_property() {
	 document.getElementById("quantity").removeAttribute("disabled");	 
}

function choose_unit() {
	 document.getElementById("buyproperty").removeAttribute("disabled");
}

function choose_staff() {
	 document.getElementById("buyproperty").removeAttribute("disabled");
}

	//BUY PROPERTY
	$('.buyproperty').click(function(){
		var buyproperty=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?buyproperty="+buyproperty,cache:false,success:function(result){
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


function generate_id(clientPropertyId) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "functions/ajaxScripts.php?generate_id=" +clientPropertyId, true);
    xmlhttp.send();

	location = window.location.href;	
}
	
</script>


<!-- bootstrap datepicker -->
<script src="styles/js/bootstrap-datepicker.js"></script>

<script>
    //Date picker
    $('#datepicker').datepicker({
    });

	$(function() {
	    $("body").delegate("#datepicker", "focusin", function(){
	        $(this).datepicker();
	    });
	});
	
</script>

</body>
</html>
