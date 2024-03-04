<?php

	clearstatcache();

	require_once ("../connector/connect.php");	

	//Declare Page
	$staff = "active";
	$pagename = "Staff";
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 
	
	if(isset($_GET['addstaff'])) {	
		header("location: functions/fetchstaff.php?addstaff");
	}

	
	//ACTIVATE STAFF SCRIPT
	if(isset($_GET['activate'])) {

		$staffid = $_GET['activate'];		

			$edit = "UPDATE staff set status = 1 WHERE id = '$staffid'";
			$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
									
			if ($edited) {								
					header("location: staff?activated");																	
			}
			else {
					header("location: staff?failed");			
			}
	}

	//DEACTIVATE STAFF SCRIPT
	if(isset($_GET['deactivate'])) {

		$staffid = $_GET['deactivate'];
					
			$edit = "UPDATE staff set status = 0 WHERE id = '$staffid'";
			$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
									
			if ($edited) {								
					header("location: staff?deactivated");																	
			}
			else {
					header("location: staff?failed");			
			}
	}	

	//BIRTHDAY NOTIFICATION SCRIPT
	if(isset($_GET['notify'])) {

		$staffemail = $_GET['notify'];

		$checkcomms = mysqli_query($conn, "SELECT * FROM comms where email = '$staffemail'");

		if (mysqli_num_rows($checkcomms) > 0) {
			
			$edit = "UPDATE comms set status = 1 WHERE email = '$staffemail'";
			$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));

			$changestat = "UPDATE comms set status = 0 WHERE email <> '$staffemail'";
			$changed = mysqli_query($conn, $changestat) or die(mysqli_error($conn));	

			if ($edited && $changed) {								
					header("location: staff?notifications");																	
			}
			else {
					header("location: staff?failed");			
			}

		} else {

			$add = "INSERT INTO comms (email) VALUES ('$staffemail')";
			$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
									
			if ($added) {								
				$edit = "UPDATE comms set status = 1 WHERE email = '$staffemail'";
				$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));

				$changestat = "UPDATE comms set status = 0 WHERE email <> '$staffemail'";
				$changed = mysqli_query($conn, $changestat) or die(mysqli_error($conn));				

				if ($edited && $changed) {								
						header("location: staff?notifications");																	
				}
				else {
						header("location: staff?failed");			
				}

			}
			else {
					header("location: staff?failed");			
			}

		}
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
		$("#inactive-alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 	
			var stateObj = {};
			window.history.pushState(stateObj, "", "staff");
		});
	}, 4000);
	
	window.setTimeout(function() {
		$("#success").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
			var stateObj = {};
			window.history.pushState(stateObj, "", "staff");
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
        <i class="ion ion-person-stalker"></i> Staff
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Staff</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php 
									if (isset($_GET['added'])) {
									echo '<div class="callout callout-success" id="success">	
									<h4><i class="icon fa fa-check-square-o"></i> Staff Added.</h4>									
									</div>';	
									}
									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">	
									<i class="icon fa fa-exclamation-circle"></i> Oops! Unsuccessful, Please try again.
									</div>';	
									}
									if (isset($_GET['exists'])) {
									echo '<div class="callout callout-warning" id="inactive-alert">
									<i class="icon fa fa-info"></i> Error! Staff already exists with the same email!
									</div>';	
									}			
									if (isset($_GET['edited'])) {
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Staff successfully edited!
									</div>';	
									}
									if (isset($_GET['rolechanged'])) {
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Staff Role is successfully changed!
									</div>';	
									}										
									if (isset($_GET['notifications'])) {																			
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Staff will now receive emails for Birthdays!
									</div>';	
									}											
									if (isset($_GET['activated'])) {																			
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Staff successfully Activated!
									</div>';	
									}	
									if (isset($_GET['deactivated'])) {																			
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Staff successfully Deactivated!
									</div>';	
									}									
						?>

     <div class="row">
	<!--Project Menu -->
 
				<div class="col-lg-12 col-xs-12">

					<div style="float: right; margin-bottom: 10px;">
						<a href="staff?addstaff" data-toggle="modal" data-target="#addBox" class="btn btn-primary btn-sm btn-info" ><i class="ace-icon fa fa-plus"></i> Add New Staff</a>
					</div>
				
				<div style="clear: both;"></div>
				
				  <div class="box  box-warning">
					<!-- /.box-header -->
					<div class="box-body"  style="overflow-x:auto;">
							<table id="myTable" class="table table-striped table-bordered table-hover table-responsive" >
										<thead><tr><th width=2>#</th> <!--<th></th>--> <th>Staff Name</th> <th class="hidden-xs">Email</th> <th>Sex</th> <th class="hidden-xs">Birthdate</th> <th>Department</th> <!--<th><i class="fa fa-bell" aria-hidden="true"></i></th>--> </tr> </thead>  
										
										<tbody>  
							<?php									
									
									$counter = 1;
									$all = mysqli_query($conn,  "SELECT * FROM staff where role_id > 1 order by lastname");
									while($staff = mysqli_fetch_object($all))
									{
											$role = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM role WHERE id = '$staff->role_id'"));
											$department = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM departments WHERE id = '$staff->department_id'"));
											/* if ((is_null($department->department))||(empty($department->department))) {
												$dept = "";
											} else {
												$dept = $department->department;
											} */
											
											$fullname = $staff->lastname.' '.$staff->firstname.' '.$staff->middlename;
											
											$sex = strtolower($staff->sex);
											$date = strtotime($staff->dob);
											$staffemail = $staff->email;
											

												if ($sex == "male") {
													$sexcolor = "blue";
												} else {
													$sexcolor = "#CF4191";
												}
												
											echo '	
												<tr>
														<td>';																	
																	$status = $staff->status;
																	if ($status == 0) {
																		echo '<i class="ace-icon fa fa-circle" style="color: red;"></i>';
																	} else {
																		echo '<i class="ace-icon fa fa-circle" style="color: green;"></i>';
																	}
																echo '
																						
														</td>											
																										
														<td><span class="pull-left"><a href="viewstaff?details='.$staff->id.'">'.$fullname.'</a></span></td> 														
														<td class="hidden-xs"><span class="pull-left">'.$staffemail.'</span></td> 														
														<td><i class="fa fa-'.strtolower($staff->sex).'" style="color: '.$sexcolor.'"> <span class="hidden-xs">'.$staff->sex.'</span></i> </td> 														
														<td class="hidden-xs">'.date("Y-M-d",$date).'</td> 														
														<td>'.$department->department.'</td>'
														; ?>
														<!--
														<td>
															<center>
																<?php
																	$getcomms = mysqli_query($conn,  "SELECT * FROM comms WHERE email = '$staffemail' and status = 1");

																	if (mysqli_num_rows($getcomms) > 0) {
																		echo '<span class="btn btn-xs btn-warning" data-toggle="tooltip" title="Birthday Notifications" disabled><i class="ace-icon fa fa-calendar-check-o"></i></span>';
																	} else {
																		$comms = mysqli_fetch_object($getcomms);
																		echo '<a href="staff?notify='.$staffemail.'" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Receive Birthday Notifications"><i class="ace-icon fa fa-calendar-plus-o"></i></a>';																		
																	}
																?>																
															</center>
														</td>
														-->
														<?php
														echo ' 													
												</tr>'; 
												$counter++;
										};
									
							?>
									</tbody>  
							</table>
					</div>
					<!-- /.box-body -->
				  </div>	
				</div>
	 </div>
	 
 
	 <!-- Add Staff -->
<div class="modal fade" id="addBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<!-- //Content Will show Here -->
        </div>
    </div>
</div>	 
	 
	 <!-- Edit Staff -->
<div class="modal modal-warning fade" id="editBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- //Content Will show Here -->
        </div>
    </div>
</div>
	 
	<!-- Change Role Modal-->
	<div class="modal modal-warning fade" id="changeBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

			</div>
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
    $('[data-toggle="tooltip"]').tooltip(); 
});  

	$(document).ready(function(){
		$('#myTable').dataTable({
			dom: 'Bfrtip',
			buttons: [
				//'copy', 'csv', 'excel', 'pdf', 'print'
                    /* {
                        extend: 'print',
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5 ]
						}
                    }, */
                    {
                        extend: 'excel',
						text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
						className: 'btn btn-success btn-xs',							
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5 ]
						}
                    }				
			]		
		});
	});   


$('.editproject').click(function(){
    var editproject=$(this).attr('data-id');

    $.ajax({url:"functions/fetchstaff.php?editstaff="+editproject,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});


//MAKE PAYMENT
$('.changerole').click(function(){
	var changerole=$(this).attr('data-id');

	$.ajax({url:"functions/fetchstaff.php?changerole="+changerole,cache:true,success:function(result){
		$(".modal-content").html(result);
	}});
});

</script>

</body>
</html>
