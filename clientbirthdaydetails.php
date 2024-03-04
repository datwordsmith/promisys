<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$birthdays = "active";	
	$clientbirthdays = "active";
	$pagename = "Client Birthdays";	
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 
	
	if(isset($_GET['month'])) {	
		$month = $_GET['month'];
		$getmonthid = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM month where month = '$month'"));
		$monthid = $getmonthid->id;

		if ($monthid == "") {
			header("location: clientBirthdays");
		} else {
			$_SESSION['monthid'] = $monthid;
		}
		
	} else 
	{
		header("location: clientBirthdays");
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
        <i class="fa fa-calendar-plus-o"></i> Client Birthdays - <?php echo $month;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Client Birthdays</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

	
	
     <div class="row">
 
				<div class="col-lg-12 col-xs-12">
				
				  <div class="box  box-warning">
					<!-- /.box-header -->
					<div class="box-body"  style="overflow-x:auto;">
							<table id="myTable" class="table table-striped table-bordered table-hover table-responsive" >
										<thead><tr><th>Date</th><th>Fullname</th> <th>Email</th> <th>Phone</th> <th>Address</th></tr> </thead>   
										
										</tbody>  
							<?php									
									
									$counter = 1;
									$all = mysqli_query($conn, "SELECT * from client where MONTH(dob) = $monthid order by dob desc");
									while($client = mysqli_fetch_object($all))
									{
											$fullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
											$sex = strtolower($client->sex);
												
												if ($sex == "male") {
													$sexcolor = "blue";
												} else {
													$sexcolor = "#CF4191";
												}
												
												$date = strtotime($client->dob);
												$date  = date("M, d", $date);
												
											echo '	
												<tr>
														<td> '.$date.'</td> 														
														<td> <i class="fa fa-'.strtolower($client->sex).'" style="color: '.$sexcolor.'"></i> '.$fullname.'</td> 														
														<td> '.$client->email.'</td> 														
														<td> '.$client->phone.', '.$client->mobile.'</td>
														<td> '.$client->address.'</td>
																											
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
						text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
						className: 'btn btn-success btn-xs',						
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
