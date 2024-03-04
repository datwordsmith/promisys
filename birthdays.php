<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$birthdays = "active";
	$pagename = "Birthdays";	
	
	// re-create session
	session_start();
	//require_once ("objects/staffcontrol.php"); 
	

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
			window.history.pushState(stateObj, "", "projects");
		});
	}, 4000);
	
	window.setTimeout(function() {
		$("#success").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
			var stateObj = {};
			window.history.pushState(stateObj, "", "projects");
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
        <i class="fa fa-calendar-plus-o"></i> Birthdays
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Birthdays</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


    <div class="row">
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-aqua">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 1"));
									if ($all > 0) {

									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>January</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-yellow">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 2"));
									if ($all > 0) {
									
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>February</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>				
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-green">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 3"));
									if ($all > 0) {
								
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>March</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>		
				</div>
				
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-red">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 4"));
									if ($all > 0) {
									
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>April</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>				
	</div>

    <div class="row">
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-red">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 5"));
									if ($all > 0) {
								
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>May</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-green">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 6"));
									if ($all > 0) {
									
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>June</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>				
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-yellow">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 7"));
									if ($all > 0) {
										
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>July</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>		
				</div>
				
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-aqua">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 8"));
									if ($all > 0) {
										
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>August</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>				
	</div>

    <div class="row">
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-yellow">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 9"));
									if ($all > 0) {
								
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>September</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-aqua">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 10"));
									if ($all > 0) {
									
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>October</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>				
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-red">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 11"));
									if ($all > 0) {
										
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>November</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>		
				</div>
				
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-green">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = 12"));
									if ($all > 0) {
										
									} else { 
										$all = 0;
									}
									echo '<h3>'.$all.'</h3>';
								?>
								<p>December</p>
							</div>
							<div class="icon">
							  <i class="fa fa-birthday-cake"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>				
	</div>
	
	
     <div class="row">
 
				<div class="col-lg-12 col-xs-12">
				
				  <div class="box  box-warning">
					<!-- /.box-header -->
					<div class="box-body"  style="overflow-x:auto;">
							<table id="myTable" class="table table-striped table-bordered table-hover table-responsive" >
										<thead><tr><th>ID</th><th width=40%>Project Name</th> <th width=20%></th> <th></th></tr> </thead>  
										
										</tbody>  
							<?php									
									
									$counter = 1;
									$all = mysqli_query($conn,  "SELECT * FROM project");
									while($projects = mysqli_fetch_object($all))
									{
											echo '	
												<tr>
														<td>'.$counter.'</td> 														
														<td>'.$projects->name.'</td> 														
														
														<td>
																<center> 
																	<a href="#assignBox" data-toggle="modal" data-target="#assignBox" data-id="'.$projects->id.'" class="btn btn-xs btn-success assignproject" ><i class="ace-icon fa fa-home"></i> <span class="hidden-xs">Assign Properties</span></a>
																</center>	
														</td>
														
														<td>
																<center>
																	<a href="#viewBox" data-toggle="modal" data-target="#viewBox" data-id="'.$projects->id.'" class="btn btn-xs btn-info viewproject" ><i class="ace-icon fa fa-eye"></i> <span class="hidden-xs">View</span></a>
																	<span>&nbsp;</span>
																	<a href="#editBox" data-toggle="modal" data-target="#editBox" data-id="'.$projects->id.'" class="btn btn-xs btn-warning editproject" ><i class="ace-icon fa fa-pencil-square-o"></i> <span class="hidden-xs">Edit</span></a>
																	<span>&nbsp;&nbsp;</span>';
																	
																	$projectid = $projects->id;
																	$delbutton = mysqli_query($conn,  "SELECT * FROM property where project_id = '$projectid'");
																	if (mysqli_num_rows($delbutton) > 0) {
																		echo '<a href="#" class="btn btn-xs btn-danger" disabled><i class="ace-icon fa fa-times"></i> <span class="hidden-xs">Delete</span></a>';
																	} else {
																		echo '<a href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$projects->id.'" class="btn btn-xs btn-danger deleteproject" ><i class="ace-icon fa fa-times"></i> <span class="hidden-xs">Delete</span></a>';
																	}
																echo '
																</center>						
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
				</div>
	 </div>
	 
 
	 <!-- Add Projects -->
<div class="modal fade" id="addBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<!-- //Content Will show Here -->

			
			
        </div>
    </div>
</div>	 
	 
	 <!-- Edit Projects -->
<div class="modal modal-warning fade" id="editBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- //Content Will show Here -->
        </div>
    </div>
</div>
	 
	 <!-- View Projects -->
<div class="modal modal-primary fade" id="viewBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<!-- //Content Will show Here -->
        </div>
    </div>
</div>	 

	 <!-- Assign Projects -->
<div class="modal modal-success fade" id="assignBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- //Content Will show Here -->
        </div>
    </div>
</div>


	 <!-- Delete Projects -->
<div class="modal modal-danger fade" id="deleteBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- //Content Will show Here -->
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
                        exportOptions: {
							columns: [ 0, 1 ]
						}
                    }				
			]		
		});
	});  


$('.assignproject').click(function(){
    var assignproject=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?assignproject="+assignproject,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});


$('.viewproject').click(function(){
    var viewproject=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?viewproject="+viewproject,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});


$('.editproject').click(function(){
    var editproject=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?editproject="+editproject,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});


$('.deleteproject').click(function(){
    var deleteproject=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?deleteproject="+deleteproject,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});


</script>

</body>
</html>
