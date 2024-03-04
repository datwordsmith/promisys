<?php
	clearstatcache();

	require_once ("connector/connect.php");

	//Declare Page
	$departments = "active";
	$pagename = "Departments";

	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php");


	if(isset($_GET['adddepartment'])) {
		$propertytypeid = $_GET["adddepartment"];
		header("location: functions/fetchdepartment.php?adddepartment");
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
			window.history.pushState(stateObj, "", "departments");
		});
	}, 4000);

	window.setTimeout(function() {
		$("#success").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			var stateObj = {};
			window.history.pushState(stateObj, "", "departments");
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
        <i class="fa fa-home"></i> Departments
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Departments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php
									if (isset($_GET['added'])) {
									echo '<div class="alert alert-block alert-success" id="success">
									<h4><i class="icon fa fa-check-square-o"></i></h4>
									Department Added.
									</div>';
									unset($_GET['added']);
									}
									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">
									<h4><i class="icon fa fa-exclamation-circle"></i> Oops</h4>
									Unsuccessful, Please try again.
									</div>';
									}
									if (isset($_GET['exists'])) {
									echo '<div class="callout callout-warning" id="inactive-alert">
									<h4><i class="icon fa fa-info"></i> Error</h4>
									Department already exists with the same name!
									</div>';
									}
									if (isset($_GET['edited'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Department successfully edited!
									</div>';
									}
									if (isset($_GET['deleted'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Department successfully deleted!
									</div>';
									}
						?>

     <div class="row">
	<!--Project Menu -->
				<div class="col-lg-12 col-xs-12">

					<div style="float: right; margin-bottom: 10px;">
						<a href="departments?adddepartment" data-toggle="modal" data-target="#addBox" class="btn btn-primary btn-sm btn-info" ><i class="ace-icon fa fa-plus"></i> Add Department</a>
					</div>

					<div style="clear: both;"></div>

					<div class="box  box-success">

						<!-- /.box-header -->
						<div class="box-body" style="overflow-x:auto;">
							<table id="myTable" class="table table-bordered table-striped table-hover display nowrap" style="width:100%">
							        <thead class='thead-dark'>
							            <tr>
														<th>S/N</th>
														<th>Departments</th>
														<th>H.O.D</th>
														<th>Action</th>
							            </tr>
							        </thead>
							        <tbody>
												<?php
										        $counter = 1;
										        $all = mysqli_query($conn,  "SELECT * FROM departments");
										        while($department = mysqli_fetch_object($all))
										        {

															$HODid = $department->hod;
															$getHOD = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff where id = '$HODid';"));
															$HODName = $getHOD->lastname.' '.$getHOD->firstname;

										            echo '
										              <tr>
										                  <td>'.$counter.'</td>
										                  <td><a href="viewdepartment?details='.$department->id.'">'.$department->department.'</a></td>
										                  <td>'.$HODName.'</td>
																			<td>
										                    <div class="inline pull-left">
																<a class="btn btn-sm btn-primary" href="viewdepartment?details='.$department->id.'">View</a>
																<a class="btn btn-sm btn-warning editdepartment" href="#editBox" data-toggle="modal" data-target="#editBox" data-id="'.$department->id.'" >Edit</a>';
																
																$checkStaff = mysqli_query($conn, "SELECT * FROM staff where department_id = '$department->id' and id <> '$HODid'");
																if(mysqli_num_rows($checkStaff) > 0) {																	
																	echo ' <button class="btn btn-sm btn-danger" disabled>Delete</button>';
																} else {
																	echo '
																	<a class="btn btn-sm btn-danger deletedepartment" href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$department->id.'">Delete</a>';
																}																															
																echo '
										                    </div>
										                  </td>
										              </tr>';
										              $counter++;
										          };

										    ?>
							        </tbody>
							        <tfoot class="thead-dark">
							            <tr>
														<th>S/N</th>
														<th>Departments</th>
														<th>H.O.D</th>
														<th>Action</th>
							            </tr>
							        </tfoot>
							    </table>

						</div>
						<!-- /.box-body -->
					</div>
				</div>
	 </div>

<!-- Add Department -->
<div class="modal fade" id="addBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<!-- //Content Will show Here -->
        </div>
    </div>
</div>

<!-- Edit Department -->
<div class="modal modal-warning fade" id="editBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- //Content Will show Here -->
        </div>
    </div>
</div>


<!-- Delete Department -->
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

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="styles/js/dataTables.bootstrap.min.js"></script>
<!--<script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>-->
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>

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


	$(document).ready(function() {
	    var table = $('#myTable').DataTable( {
	        // rowReorder: {
	        //     selector: 'td:nth-child(2)'
	        // },
	        responsive: true
	    } );
	} );



	$('.editdepartment').click(function(){
		var editdepartment=$(this).attr('data-id');


		$.ajax({url:"functions/fetchdepartment.php?editdepartment="+editdepartment,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});


	$('.deletedepartment').click(function(){
		var deletedepartment=$(this).attr('data-id');

		$.ajax({url:"functions/fetchdepartment.php?deletedepartment="+deletedepartment,cache:false,success:function(result){
			$(".modal-content").html(result);
		}});
	});

</script>
</body>
</html>
