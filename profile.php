<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$staff = "active";
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 
	
	$staffid = $_SESSION['staffid'];
	
	
	if(isset($_GET['details'])) {
		$staffid = $_GET['details'];
	
		if ($staffid == "") {
			header("location: staff");
		} else {			
			$_SESSION['staffid'] = $staffid;
		}
	} else 
	{
		header("location: staff");
	}

	$getpptcount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertyCount FROM client_property where staff_id = $staffid;"));
	$propertyCount = $getpptcount->propertyCount;

	$getclientcount = mysqli_fetch_object(mysqli_query($conn, "SELECT COUNT(DISTINCT client_id) as clientCount FROM client_property where staff_id = $staffid;"));
	$clientCount = $getclientcount->clientCount;	
	
	
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
        <i class="ion ion-person-stalker"></i> Staff Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="staff"><i class="ion ion-person-stalker"></i> Staff</a></li>
        <li class="active">Staff Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php 

									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">	
									<h4><i class="icon fa fa-exclamation-circle"></i> Oops</h4>
									Unsuccessful, Please try again.
									</div>';	
									}
		
									if (isset($_GET['edited'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Project successfully edited!
									</div>';	
									}						
						?>

     <div class="row">
	<!--Project Menu -->

				<div class="col-md-12 col-xs-12">	
 					<div style="float: right; margin-bottom: 10px;">
						<a href="projects?addproject" data-toggle="modal" data-target="#addBox" class="btn btn-primary btn-sm btn-info" ><i class="ace-icon fa fa-plus"></i> Add New Project</a>
					</div>
				</div>
					
				<div class="col-md-8 col-xs-12">

							<!-- BIO -->
							<div class="box  box-warning">
								<div class="box-header with-border">
								  <h3 class="box-title">Staff Information</h3>
								  <div class="box-tools pull-right">
									<!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
								  </div>
								</div>				  
								<!-- /.box-header -->
							
								<div class="box-body"  style="overflow-x:auto;">
													<?php
														if(isset($_GET['details'])) {	
															$staffid = $_GET['details'];
																$staff = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = '$staffid'"));
																
																$fullname = $staff->lastname.' '.$staff->firstname.' '.$staff->middlename;
																$sex = strtolower($staff->sex);
																$status = (int)($staff->status);
																	
																	if ($sex == "male") {
																		$sexcolor = "blue";
																	} else {
																		$sexcolor = "#CF4191";
																	}
																	
																	if ($status == 0) {
																		$stat = "Inactive";
																	} else {
																		$stat = "Active";
																	}																	
														}													
													?>
													
													<table class="table no-border table-responsive" >
															<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>
															<tr><th width=30%>Email Address</th> <td><?php echo $staff->email; ?></td> </tr>
															<tr><th width=30%>Sex</th> <td><?php echo $staff->sex; ?></td> </tr>
															<tr><th width=30%>Birthdate</th> <td><?php echo $staff->dob; ?></td> </tr>
															<?php 
															if ($status == 0) {
															
															echo '<tr class="danger"><th width=30%>Status</th> <td>'.$stat.' <a href="javascript:void(0)" onclick="change_status('.$staffid.')" class="btn btn-xs btn-success pull-right"><i class="ace-icon fa fa-check-circle-o"></i> <span class="hidden-xs">Activate</span></a></td> </tr>';
															/*echo '<tr><td> <button onclick="change_status('.$staff_id.')" >'.$stat.'</button> </td> </tr>';*/
															
															} else {
															
															?>

															<tr class="success"><th width=30%>Status</th> <td> <?php echo $stat; ?> <a href="javascript:void(0)" onclick="change_status('<?php echo $staffid; ?>')" class="btn btn-xs btn-danger pull-right"><i class="ace-icon fa fa-times"></i> <span class="hidden-xs">Deactivate</span></a></td> </tr>
															
															<?php
															}
														
															?>
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
										  <span class="info-box-text"><h4>Properties Sold</h4></span>
										  <span class="info-box-number" style="font-size: 2em;"><?php echo '<span class="count">'.$propertyCount.'</span>';?></span>
										</div>
										<!-- /.info-box-content -->
									  </div>
									  <!-- /.info-box -->						

									  <div class="info-box">
										<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people" aria-hidden="true"></i></span>

										<div class="info-box-content">
										  <span class="info-box-text"><h4>Clients</h4></span>
										  <span class="info-box-number" style="font-size: 2em;"><?php echo '<span class="count">'.$clientCount.'</span>';?></span>
										</div>
										<!-- /.info-box-content -->
									  </div>
									  <!-- /.info-box -->				
							</div>	
							<!-- CLOSE BOX -->							  					  
				</div>						  

				
	 </div>

	 
	<!-- SECOND ROW -->
	<div class="row">
	
					<div class="col-md-12 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
								<div class="box-header with-border">
								  <h3 class="box-title">Sales</h3>
								</div>				  
							<!-- /.box-header -->
							
							<div class="box-body"  style="overflow-x:auto;">
								
								
							<table id="myTable" class="table table-bordered table-striped" >
							
									<thead><tr><th>Date</th> <th>Client</th> <th>Project</th> <th>Property</th> <th>Units</th> <th>Amount</th> <th>Paid</th> <th>Balance</th> <!--<th><center>Sold by</center></th>-->  </tr> </thead>  
										
									<tbody>  
										<?php									
									
										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM client_property where staff_id = '$staffid' order by id asc");
										while($clientproperty = mysqli_fetch_object($all))
										{
											$projectid = $clientproperty->project_id;
											$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
											$project = $getpjt->name;

											$propertyid = $clientproperty->property_id;
											$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from property_type where id = $propertyid"));
											$propertytype = $getppt->propertytype;

											$clientid = $clientproperty->client_id;
											$client = mysqli_fetch_object(mysqli_query($conn, "select * from client where id = $clientid"));
											$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
											
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
														<td> '.$fullname.'</td> 														
														<td> '.$project.'</td> 														
														<td> '.$propertytype.'</td> 														
														<td> '.$clientproperty->quantity.'</td>';?> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amount); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($amountpaid); ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.number_format($balance); ?></span></td> 														
														<!--
														<td>
															<center>
																<?php echo '<a href="viewstaff?details='.$getstf->id.'" class="btn btn-xs btn-info" >'.$getstf->email.'</span></a>'; ?>
																	
															</center>
														</td> 
														-->
														
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
	$('.makepayment').click(function(){
		var makepayment=$(this).attr('data-id');

		$.ajax({url:"functions/fetchviewclient.php?makepayment="+makepayment,cache:false,success:function(result){
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
	

	//BUY PROPERTY 
	$(document).ready(function(){
	$("#buyproperty").click(function(){
	
	
		document.getElementById("buyproperty").innerHTML='<i class="fa fa-spinner fa-spin"></i>';

		
		var project = $("#project").val();
		var property = $("#property").val();
		var quantity = $("#quantity").val();
		var staff = $("#staff").val();

		// Returns successful data submission message when the entered information is stored in database.
		var dataString = 'pjt='+ project + '&ppt='+ property + '&qty='+ quantity + '&stf='+ staff;

			// AJAX Code To Submit Form.
			$.ajax({
			type: "POST",
			url: "buyproperty.php",
			data: dataString,
			cache: false,
			success: function(result){
			//alert(result);
			document.getElementById("buyResult").innerHTML=(result);
					
					window.setTimeout(function() {
						$("#buyResult").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove(); 
							
				
				location.reload();
						});
					}, 4000);				
			}
			});

				document.getElementById("buyproperty").innerHTML='<i class="fa fa-floppy-o"></i>';							
					
		return false;

	});
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
	

function change_status(staffid) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "functions/ajaxScripts.php?change_status=" +staffid, true);
    xmlhttp.send();

	location = window.location.href;	
}
	

</script>

</body>
</html>
