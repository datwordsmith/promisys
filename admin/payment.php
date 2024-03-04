<?php
	clearstatcache();

	require_once ("../connector/connect.php");	

	//Declare Page
	$payment = "active";
	$pagename = "Payment History";
	
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
        <i class="fa fa-money"></i> Payment History
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payment History</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->


     <div class="row">
					  
						  
	 </div>

	 
	<!-- SECOND ROW -->
	<div class="row" class="noprint">
	
					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
			  
							<!-- /.box-header -->
							
							<div class="box-body"  style="overflow-x:auto;">
								
							<table id="myTable" class="table table-bordered table-striped" >
							
									<thead><tr><th>Date</th> <th>Client</th> <th>File ID</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Paid</th> <th><center>Sold by</center></th> <th><center>Updated by</center></th> <th></th> </tr> </thead>  
										
									<tbody>  
										<?php									
									
										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM account where refund = 0");
										while($account = mysqli_fetch_object($all))
										{
											$accountid = $account->id;
											$amntpd = $account->amount;

											$updater = $account->staff_id;
											$getupd = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $updater"));
											
											$clientpropertyid = $account->client_property_id;
											$clientproperty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property where id = '$clientpropertyid'"));

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
											
											$date = $account->date;
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
														<td> '.$fullname.'</td> 
														<td> '.strtoupper($clientproperty->fileid).'</td> 
														<td> '.$project.'</td> 														
														<td> '.$propertytype.'<br/><span class="productcategory">('.$category.')</span></td> 														
														<td><span class="pull-right">'.$clientproperty->quantity.'</span></td>';?> 																												
														<td><span class="pull-right"><?php echo $sign.number_format($amntpd); ?></span></td> 																												
														<td>
															<center>
																<?php //echo '<a href="viewstaff?details='.$getstf->id.'" class="btn btn-xs btn-info" >'.$getstf->email.'</span></a>'; ?>
																<?php echo '<span class=" btn-xs btn-info" >'.$getstf->email.'</span>'; ?>
																	
															</center>
														</td> 														

														<td>
															<center>

																<?php echo '<span class=" btn-xs btn-info" >'.$getupd->email.'</span>'; ?>
																	
															</center>
														</td> 	

														
														<td>
																<center>
																	<!--<a href="#viewBox" data-toggle="modal" data-target="#viewBox" data-id="'.$accountid.'" class="btn btn-xs btn-success paymentdetail" ><i class="ace-icon fa fa-eye"></i> <span class="hidden-xs"> More</span></a>-->
																	<a href="paymentdetail?id=<?php echo $accountid; ?>" class="btn btn-xs btn-success paymentdetail" ><i class="ace-icon fa fa-eye"></i> <span class="hidden-xs"> More</span></a>
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
	

	<!-- View Client Modal-->
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
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
						}
                    },					
                    {
                        extend: 'excel',
						text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
						className: 'btn btn-success btn-xs tablebutton',						
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
						}
                    }				
			]		
		});
	});  

	//VIEW BOX
	$('.paymentdetail').click(function(){
		var paymentdetail=$(this).attr('data-id');

		$.ajax({url:"functions/fetchpayment.php?paymentdetail="+paymentdetail,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});
	
//PRINT
function printFunction() {
	window.print();
}

 

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

</body>
</html>
