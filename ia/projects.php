<?php
	clearstatcache();

	require_once ("../connector/connect.php");	

	//Declare Page
	$projects = "active";
	$pagename = "Projects";
	
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
        <i class="fa fa-map-marker"></i> Projects
        <small></small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php 
									if (isset($_GET['added'])) {
									echo '<div class="callout callout-success" id="success">	
									<h4><i class="icon fa fa-check-square-o"></i> Project Added.</h4>
									
									</div>';	
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
									Project already exists with the same name!
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
									if (isset($_GET['unassigned'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Property successfully deleted!
									</div>';	
									}									
						?>

     <div class="row">
 
				<div class="col-lg-12 col-xs-12">
				
				<div style="clear: both;"></div>
				
				  <div class="box  box-warning">
					<!-- /.box-header -->
					<div class="box-body"  style="overflow-x:auto;">
							<table id="myTable" class="table table-striped table-bordered table-hover table-responsive" >
										<thead><tr><th>ID</th><th>Project Name</th> <th>Code</th> <th>Location (State)</th> <th>Logo</th> <th width=30%>Description</th> <!--<th width=9%></th>--> </tr> </thead>  
										
										</tbody>  
							<?php									
									
									$counter = 1;
									$all = mysqli_query($conn,  "SELECT * FROM project");
									while($projects = mysqli_fetch_object($all))
									{
											$logo = $projects->logo;
											if ($logo == NULL) {
												$image = '';
											}
											else {
												$image = '<i class="fa fa-check-square" style="color:green"></i>';
											}
											echo '	
												<tr>
														<td>'.$counter.' </td> 														
														<td><a href="viewproject?details='.$projects->id.'">'.$projects->name.'</a></td> 												
														<td>'.strtoupper($projects->code).'</td>		
														<td>'.$projects->state.'</td> 
														<td><center>'.$image.'</center></td> 
														<td>'.$projects->description.'</td> 
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
	 
	 
	 <!-- View Projects -->
<div class="modal modal-primary fade" id="viewBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
						text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export',
						className: 'btn btn-success btn-xs',
                        exportOptions: {
							columns: [ 0, 1 , 2, 3, 5]
						}
                    }				
			]		
		});
	});  


$('.viewproject').click(function(){
    var viewproject=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?viewproject="+viewproject,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});


</script>

</body>
</html>
