<?php

	require_once ("../connector/connect.php");	

	//Declare Page
	$myprofile = "active";
	$pagename = "My Profile";		
	
	// re-create session
	session_start();

	require_once ("objects/staffcontrol.php"); 


	if(isset($_GET['changepassword'])) {	
		$_SESSION['changepassword'] = $_GET['changepassword'];
		header("location: functions/fetchmyprofile.php?changepassword");
	}
	
	if(isset($_GET['editprofile'])) {	
		$_SESSION['editprofile'] = $_GET['editprofile'];
		header("location: functions/fetchmyprofile.php?editprofile");
	}
	
	$getpptcount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertyCount FROM client_property where staff_id = '$loginid';"));
	$propertyCount = $getpptcount->propertyCount;

	$getclientcount = mysqli_fetch_object(mysqli_query($conn, "SELECT COUNT(DISTINCT client_id) as clientCount FROM client_property where staff_id = '$loginid';"));
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
		$("#inactive-alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
			//window.location = "index";
			var stateObj = {};
			window.history.pushState(stateObj, "", "index");			
		});
	}, 4000);
	
	window.setTimeout(function() {
		$("#success").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
			//window.location = "index";
			var stateObj = {};
			window.history.pushState(stateObj, "", "index");			
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
        <i class="ion ion-person-stalker"></i> My Profile
        <small></small>
      </h1>
      <!--
	  <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="staff"><i class="ion ion-person-stalker"></i> Staff</a></li>
        <li class="active">Staff Details</li>
      </ol>
	  -->
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php 

									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">	
									<i class="icon fa fa-exclamation-circle"></i> Oops! Unsuccessful, Please try again.
									</div>';	
									}	
		
									if (isset($_GET['edited'])) {
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Profile successfully edited!
									</div>';	
									}			
									if (isset($_GET['changed'])) {
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Password successfully changed!
									</div>';	
									}				
						?>

     <div class="row">

				<div class="col-md-12 col-xs-12">	
 					<div style="margin-bottom: 10px;">
						<a href="myprofile?changepassword=<?php echo $loginid; ?>" data-toggle="modal" data-target="#changeBox" class="btn btn-success btn-sm pull-right" ><i class="ace-icon fa fa-lock"></i> Change Password</a>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				
					
				<div class="col-md-8 col-xs-12">

							<!-- BIO -->
							<div class="box  box-warning">
								<div class="box-header with-border">
								  <h3 class="box-title">Staff Information</h3>
								  <div class="box-tools pull-right">
									<a href="myprofile?editprofile=<?php echo $loginid; ?>" data-toggle="modal" data-target="#editBox" class="btn btn-warning btn-sm btn-info" ><i class="ace-icon fa fa-pencil-square-o"></i> Edit My Profile</a>
								  </div>
								</div>				  
								<!-- /.box-header -->
							
								<div class="box-body"  style="overflow-x:auto;">
													<?php
													
																$staff = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = '$loginid'"));
																
																$fullname = $staff->lastname.' '.$staff->firstname.' '.$staff->middlename;
																$sex = strtolower($staff->sex);
																$status = (int)($staff->status);
																
																$role = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM role WHERE id = '$staff->role_id'"));
																
																	if ($sex == "male") {
																		$sexcolor = "blue";
																	} else {
																		$sexcolor = "#CF4191";
																	}
																	
																	if ($status = 0) {
																		$stat = "Inactive";
																	} else {
																		$stat = "Active";
																	}																													
													?>
													
											<table class="table no-border table-responsive" >
													<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> <td rowspan=5><div><?php include ("objects/mypic.php"); ?></div></td> </tr>
													<tr><th width=30%>Email Address</th> <td><?php echo $staff->email; ?></td> </tr>
													<tr><th width=30%>Sex</th> <td><?php echo $staff->sex; ?></td> </tr>
													<tr><th width=30%>Birthdate</th> <td><?php echo $staff->dob; ?></td> </tr>
													<tr><th width=30%>Role</th> <td><?php echo $role->role; ?></td> </tr>
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
										$all = mysqli_query($conn,  "SELECT * FROM client_property where staff_id = '$loginid' order by id asc");
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
														<td> '.$propertytype.'<br/><span class="productcategory">('.$category.')</span></td> 														
														<td> '.$clientproperty->quantity.'</td>';?> 														
														<td><span class="pull-right"><?php echo $sign.$amount; ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.$amountpaid; ?></span></td> 														
														<td><span class="pull-right"><?php echo $sign.$balance; ?></span></td> 														
														
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
	


	<!-- Change Password -->
	<div class="modal modal-warning fade" id="changeBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <!-- //Content Will show Here -->
			</div>
		</div>
	</div>

	<!-- Edit Profile -->
	<div class="modal modal-warning fade" id="editBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <!-- //Content Will show Here -->
			</div>
		</div>
	</div>	
	
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
                    /* {
                        extend: 'print',
                        exportOptions: {
							columns: [ 0, 1 ]
						}
                    }, */
                    {
                        extend: 'excel',
						text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
						className: 'btn btn-success btn-xs',						
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
						}
                    }				
			]		
		});
	});	

function delete_pic(loginid) {
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.open("GET", "functions/ajaxScripts.php?delete_pic=" +loginid, true);
	xmlhttp.send();

	location = window.location.href;	
	/*alert(loginid);*/
}


	
$('.changepassword').click(function(){
    var changepassword=$(this).attr('data-id');

    $.ajax({url:"functions/fetchmyprofile.php?changepassword="+changepassword,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});

$('.editprofile').click(function(){
    var editprofile=$(this).attr('data-id');

    $.ajax({url:"functions/fetchmyprofile.php?editprofile="+editprofile,cache:false,success:function(result){
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
