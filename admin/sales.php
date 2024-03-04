<?php
	clearstatcache();

	require_once ("../connector/connect.php");	

	//Declare Page
	$sales = "active";
	$pagename = "Sales";
	
	// re-create session
	session_start();

	require_once ("objects/staffcontrol.php"); 

	if(isset($_GET['addpayment'])) {	
		$clientPropertyId = $_GET["addpayment"];
		$_SESSION["clientpropertyid"] = $clientPropertyId;

		header("location: functions/fetchsales.php?addpayment");
	}	

	/* $getpptcount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertyCount FROM client_property where client_id = $clientid;"));
	$propertyCount = $getpptcount->propertyCount;

	$gettotalcost = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(amount) AS totalCost FROM client_property where client_id = $clientid;"));
	$totalCost = $gettotalcost->totalCost;	
	
	$getamountpaid = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(amount) AS amountPaid FROM account where client_id = $clientid;"));
	$amountPaid = $getamountpaid->amountPaid;
	
	$outstanding = ($totalCost - $amountPaid); */
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

<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>

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
        <i class="fa fa-money"></i> Sales
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sales</li>
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
					  
						  
	 </div>

	 
	<!-- SECOND ROW -->
	<div class="row">
	
					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
								<div class="box-header with-border">
								  <h3 class="box-title">All Transactions</h3>
								  <!--
								  <div class="pull-right">
									<a href="#buyBox" data-toggle="modal" data-target="#buyBox" data-id="'.$clientemail.'" class="btn btn-primary btn-sm btn-info buyproperty" ><i class="ace-icon fa fa-plus"></i> Buy Property</a>						
								  </div>
								  -->
								</div>				  
							<!-- /.box-header -->
							
							<div class="box-body"  style="overflow-x:auto;">
								
								<?php
									
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

									
									//CLEAR SESSION VARIABLES
									unset($_SESSION['paymentOk']);
									unset($_SESSION['paymentFailed']);										
								
								?>
								
							<table id="myTable" class="table table-bordered table-striped" >
							
									<thead><tr><th>Date</th> <th>Client</th> <th>File ID</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th>Paid</th> <th>Balance</th> <th><center>Sold by</center></th> <th></th> </tr> </thead>  
										
									<tbody>  
										<?php									
									
										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM client_property where refund = 0 order by id asc");
										while($clientproperty = mysqli_fetch_object($all))
										{
											$propertyid = $clientproperty->property_id;
											$investmentcategory_id = $clientproperty->investmentcategory_id;

											$getCat = mysqli_fetch_object(mysqli_query($conn, "select * from investment_category where id = $investmentcategory_id"));
											$category = $getCat->category;
																						
											$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from project_property where id = $propertyid"));
											$propertytype = $getppt->property_type;
											$projectid = $getppt->project_id;
											

											$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
											$project = $getpjt->name;

											$clientid = $clientproperty->client_id;
											$_SESSION['clientid'] = $clientid;
											//$getclient = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from client where id = $clientid"));											
											$getclient = mysqli_fetch_object(mysqli_query($conn, "select * from client where id = $clientid"));			
											$fullname = $getclient->lastname.' '.$getclient->firstname.' '.$getclient->middlename;								
											
											$staffid = $clientproperty->staff_id;
											$getstf = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $staffid"));
											
											$date = $clientproperty->date;
											$date = strtotime($date);
											
											$amount = $clientproperty->amount;

											$clientPropertyId = $clientproperty->id;
											$account = mysqli_query($conn,  "SELECT SUM(amount) AS amountpaid FROM account where client_property_id = $clientPropertyId GROUP BY client_property_id;");
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
														<td>

															<a href="#viewBox" data-toggle="modal" data-target="#viewBox" data-id="'.$clientid.'" class="pull-left viewclient">'.$fullname.'</a> 													
																	
														</td> 
														<td> '.strtoupper($clientproperty->fileid).'</td> 	
														<td> '.$project.'</td> 														
														<td> '.$propertytype.'<br/><span class="productcategory">('.$category.')</span></td> 														
														<td> '.$clientproperty->quantity.'</td>';?> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amountpaid); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($balance); ?></span></td> 														
														<td>
															<center>
																<?php //echo '<a href="viewstaff?details='.$getstf->id.'" class="btn btn-xs btn-info" >'.$getstf->email.'</span></a>'; ?>
																<?php echo '<span class=" btn-xs btn-info" >'.$getstf->email.'</span>'; ?>
																	
															</center>
														</td> 														
														
														<?php echo '
														<td>
																<center>';

																	$clientPropertyId = $clientproperty->id;
																	$delbutton = mysqli_query($conn,  "SELECT * FROM account where client_id = '$clientid' and id = $clientPropertyId");
																	if (($balance) < 1) {
																		echo '<span class="btn-xs btn-info">PAID</span>';
																	} else {
																		echo '<a href="#payBox" data-toggle="modal" data-target="#payBox" data-id="'.$clientPropertyId.'" class="btn btn-xs btn-success addpayment" ><i class="ace-icon fa fa-cc-mastercard"></i> <span class="hidden-xs">Pay</span></a>';

																		/*echo '<a href="javascript:void(0)" onclick="addpayment('.$clientPropertyId.')" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Delete Logo"><i class="ace-icon fa fa-cc-mastercard"></i> <span class="hidden-xs">Pay</span></a>';*/
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

	<!-- View Client Modal-->
	<div class="modal modal-success fade" id="viewBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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


<!-- DOWNLOAD DATATABLE -->
<script src="styles/datatables/js/dataTables.buttons.min.js"></script>
<script src="styles/datatables/js/buttons.flash.min.js"></script>
<script src="styles/datatables/js/buttons.html5.min.js"></script>
<script src="styles/datatables/js/buttons.print.min.js"></script>
<script src="styles/datatables/js/jszip.min.js"></script>

<script>
  
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });
  
	$(document).ready(function(){
		$('#myTable').dataTable({
			dom: 'Bfrtip',
			buttons: [
				//'copy', 'csv', 'excel', 'pdf', 'print'
                    {
                        extend: 'print',
						text:'<i class="fa fa-print" aria-hidden="true"></i> Print',
						className: 'btn btn-info btn-xs',						
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
						}
                    },
                    {
                        extend: 'excel',
						text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
						className: 'btn btn-success btn-xs tablebutton',						
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
						}
                    }				
			]		
		});
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


	
	//MAKE PAYMENT
	$('.addpayment').click(function(){
		var addpayment=$(this).attr('data-id');

		$.ajax({url:"functions/fetchsales.php?addpayment="+addpayment,cache:true,success:function(result){
			$(".modal-content").html(result);
		}});
	});



	//VIEW CLIENT
	$('.viewclient').click(function(){
		var viewclient=$(this).attr('data-id');

		$.ajax({url:"functions/fetchsales.php?viewclient="+viewclient,cache:false,success:function(result){
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
