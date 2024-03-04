<?php

	require_once ("../connector/connect.php");	

	//require_once ("functions/adminfunctions.php"); 	

	//Declare Page
	$dashboard = "active";
	$pagename = "Strategic Communications";		
	
	// re-create session
	session_start();

	require_once ("objects/staffcontrol.php"); 

	if(isset($_GET['changepassword'])) {	
		$_SESSION['changepassword'] = $_GET['changepassword'];
		header("location: functions/fetchmyprofile.php?changepassword");
	}

	
	$department = "Strategic Communications";

	$theDept = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM departments where department = '$department'"));
	$departmentid = $theDept->id;
	$_SESSION['departmentid'] = $departmentid;

	if(isset($_GET['adddocument'])) {
		$_SESSION['departmentid'] = $_GET["adddocument"];
		header("location: functions/fetchviewdepartment.php?adddocument");
	}



	if(isset($_GET['delete'])) {
		$_SESSION['unassignproject'] = $_GET['delete'];
		header("location: functions/fetchproject.php?unassignproject");
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once ("objects/head.php"); 	
	?>
	<script src="https://code.highcharts.com/highcharts.js"></script>
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
        <i class="fa fa-briefcase"></i> <?php echo " Department: ".ucfirst($department); ?>
        <small></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

	<?php 

									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">	
									<i class="icon fa fa-exclamation-circle"></i> Oops! Unsuccessful, Please try again.
									</div>';	
									}	
		
									if (isset($_GET['changed'])) {
									echo '<div class="callout callout-success" id="success">
									<i class="icon fa fa-pencil-square-o"></i> Password successfully changed!
									</div>';	
									}							
		
								unset($_SESSION['changed']);																
								unset($_SESSION['Failed']);									
						?>
	<div class="row">
				
				<div class="col-lg-12 col-xs-12">	
					<div class="pull-right">
						<a href="viewdepartment?adddocument=<?php echo $departmentid; ?>" data-toggle="modal" data-target="#addBox" class="btn btn-sm btn-success"><i class="ace-icon fa fa-upload"></i> Upload File</a>
						<a href="index?changepassword=<?php echo $loginid; ?>" data-toggle="modal" data-target="#changeBox" class="btn btn-success btn-sm" ><i class="ace-icon fa fa-lock"></i> Change Password</a>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>	
	</div>


     <div class="row">
	<!--Project Menu -->
				
				<div class="col-md-4 col-xs-12">

					<!-- MEMBERS -->
					<div class="box  box-warning">
						<div class="box-header">
							<h3 class="box-title" style="padding-top: 10px;">Members</h3>
							<div class="box-tools pull-right">
							<!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
								<form method="POST" id="teamForm" class="form-inline" style="margin-top: 10px;">
									<select name="staff" id="staff" class="form-control" required>
										<option value="">Add Team Member</option>
										<?php
										$stf = mysqli_query($conn,  "SELECT * FROM staff where status = 1 and department_id = 0 and department_id <> $departmentid and role_id > 1  and id not in (select hod from departments) order by lastname");
										$staffCount = $stf->num_rows;
										if($staffCount > 0){
											while ($staff = mysqli_fetch_object($stf)){
												echo '<option value="'.$staff->id.'">'.$staff->lastname.' '.$staff->firstname.'</option>';
											}
										}else{
											echo '<option value=""></option>';
										}
										?>
									</select>
									<input type="hidden" id="deptid" class="form-control" value="<?php echo $departmentid; ?>">
									<button type="submit" name= "addTeam" id="addTeam" class="btn btn-success form-control"><i class="ace-icon fa fa-user-plus"></i> Save</button>
								</form>
							</div>
						</div>				  
						<!-- /.box-header -->
						
						
						<div class="box-body"  style="overflow-x:auto; margin-top: 20px;">
							<!-- HOD -->
							<table class="table no-border table-responsive" >
								<thead>
									<tr>
										<th class="text-center">LED BY</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$leader = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM departments where id = '$departmentid'"));
										$hod = $leader->hod;


										$getLeader = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff where id = '$hod'"));
										$lastname = $getLeader->lastname;
										$middlename = $getLeader->middlename;
										$firstname = $getLeader->firstname;												
										

										if ($middlename == "") {
											$fullname = $lastname.' '.$firstname;
										} else {
											$fullname = $lastname.' '.$firstname.' '.$middlename;
										}

									?>
									<tr>
										<td class="text-center"><?php echo '<a href="viewstaff?details='.$getLeader->id.'">'.$fullname.'</a>'; ?></td>
										<!--<td class="text-center"><?php echo $fullname; ?></td> -->
									</tr>										
								</tbody>
							</table>
							
							<!-- TEAM MEMBERS -->
							<div id="teamTable">
								<table class="table table-responsive" style="margin: 20px auto; width: 80%;">
									<thead>
										<tr>
											<th colspan=3 class="text-center">TEAM MEMBERS</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$leader = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM departments where id = '$departmentid'"));
											$hod = $leader->hod;

											$counter = 1;
											$getTeam = mysqli_query($conn, "SELECT * FROM staff where department_id = '$departmentid' and status <> 0 and id <> '$hod'");
											while ($team = mysqli_fetch_object($getTeam)) {

												$lastname = $team->lastname;
												$middlename = $team->middlename;
												$firstname = $team->firstname;												
												

												if ($middlename == "") {
													$fullname = $lastname.' '.$firstname;
												} else {
													$fullname = $lastname.' '.$firstname.' '.$middlename;
												}													
												echo '
												<tr>
												<td>'.$counter.'</td>
												<td class=""><a href="viewstaff?details='.$team->id.'">'.$fullname.'</a></td>
												<td class=""><a class="btn btn-sm btn-danger deletemember" href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$team->id.'">Delist</a></td>
												</tr>';
												$counter++;

											}
										?>	
									</tbody>
								</table>	
							</div>

							<div id="newTeamTable">

							</div>
													
						</div>
						<!-- /.box-body -->
					</div>	
					<!-- CLOSE BOX -->

				</div>

				<div class="col-md-8 col-xs-12">											

						<div class="box  box-info">		  
							<!-- /.box-header -->
							
							<div class="box-body"  style="overflow-x:auto;">
								
							<table id="fileTable" class="table table-striped table-bordered table-hover table-responsive" >
								<thead><tr><th>ID</th><th>File</th> <th>Date Uploaded</th> <th></th></tr> </thead>

								<tbody>
										<?php
											$counter = 1;
											$all = mysqli_query($conn,  "SELECT * FROM repository where department_id = '$departmentid'");
											while($document = mysqli_fetch_object($all))
											{
												echo '
													<tr>
														<td> '.$counter.'</td>
														<td> '.$document->title.'</a></td>
														<td> '.$document->date_added.'</td>
														<td>
															<div class="inline">
																<a class="btn btn-xs btn-primary" href="../repository/'.$document->file.'" download="'.$document->title.'"><i class="ace-icon fa fa-download"></i> <span class="hidden-xs">Download</span></a>
																<a class="btn btn-xs btn-danger deletedocument" href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$document->id.'"><i class="ace-icon fa fa-trash"></i> <span class="hidden-xs">Delete</span></a>
															</div>
														</td>
													</tr>';
													$counter++;
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

		<!-- Add Document -->
		<div class="modal fade" id="addBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<!-- //Content Will show Here -->
				</div>
			</div>
		</div>

		<!-- Delete Team Member -->
		<div class="modal modal-danger fade" id="deleteBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
	
$('.changepassword').click(function(){
    var changepassword=$(this).attr('data-id');

    $.ajax({url:"functions/fetchmyprofile.php?changepassword="+changepassword,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});

$(document).ready(function () {
$('.sidebar-menu').tree()
});
  
$(document).ready(function(){
	$('#myTable').dataTable();
});  


$(document).ready(function(){
	$('#fileTable').dataTable({
		rowReorder: {
				selector: 'td:nth-child(2)'
		},
		responsive: true,
		dom: 'Bfrtip',
		buttons: [
			//'copy', 'csv', 'excel', 'pdf', 'print'
				/* {
					extend: 'print',
					exportOptions: {
						columns: [ 0, 1, 2, 3 ]
					}
				}, */
				{
					extend: 'excel',
					text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
					className: 'btn btn-success btn-xs',
					exportOptions: {
						columns: [ 0, 1, 2, 3 ]
					}
				}
		]
	});
});

$(document).ready(function(){
	$("#addTeam").click(function(e){

		e.preventDefault();

		var staffid = document.getElementById( "staff").value;
		var deptid = document.getElementById( "deptid").value;

		//alert(staffid);

		if (staffid == '' ){
			$('#staff').focus();
			return false;
		}
		else {

			$.ajax({
				type: 'post',
				url: 'functions/insertdata.php',
				data: {
					teammember: staffid,
					deptid: deptid

				}
			})

			.done(function(data){

				$('#teamTable').hide();
				$.ajax({url:"functions/fetchviewdepartment.php?loadTeam="+deptid,cache:false,success:function(result){
					$("#newTeamTable").html(result);
				}});

			})

			.fail(function(){

			});

			$('#staffid').val('');

		}  /* */
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

$('#doc_upload').click(function(){
	var file = $('input[type=file]#my_file').val();
	var exts = ['png','jpg','jpeg'];//extensions
	//the file has any value?
	if ( file ) {
	// split file name at dot
	var get_ext = file.split('.');
	// reverse name to check extension
	get_ext = get_ext.reverse();
	// check file type is valid as given in 'exts' array
		if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
			
		} else {
			/* alert( 'Invalid file type!' );
			return false; */
		}
	}
});	

$('.deletedocument').click(function(){
    var documentid=$(this).attr('data-id');

    $.ajax({url:"functions/fetchviewdepartment.php?deletedocument="+documentid,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});

$('.deletemember').click(function(){
	var deletemember=$(this).attr('data-id');
	var deptid = document.getElementById("deptid").value;

	$.ajax({url:"functions/fetchviewdepartment.php?deletemember="+deletemember,cache:false,success:function(result){
		$(".modal-content").html(result);
	}});
});


</script>

</body>
</html>