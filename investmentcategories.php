<?php
	clearstatcache();

	require_once ("connector/connect.php");

	//Declare Page
	$investmentcategories = "active";
	$pagename = "Investment Categories";

	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php");


	if(isset($_GET['addinvestmentcategory'])) {
		$propertytypeid = $_GET["addinvestmentcategory"];
		header("location: functions/fetchinvestmentcategory.php?addinvestmentcategory");
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
			window.history.pushState(stateObj, "", "investmentcategories");
		});
	}, 4000);

	window.setTimeout(function() {
		$("#success").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			var stateObj = {};
			window.history.pushState(stateObj, "", "investmentcategories");
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
        <i class="fa fa-home"></i> Investment Categories
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Investment Categories</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php
									if (isset($_GET['added'])) {
									echo '<div class="alert alert-block alert-success" id="success">
									<h4><i class="icon fa fa-check-square-o"></i></h4>
									Investment Category Added.
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
									Category already exists with the same name!
									</div>';
									}
									if (isset($_GET['edited'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Category successfully edited!
									</div>';
									}
									if (isset($_GET['deleted'])) {
									echo '<div class="callout callout-success" id="success">
									<h4><i class="icon fa fa-pencil-square-o"></i></h4>
									Category successfully deleted!
									</div>';
									}
						?>

     <div class="row">
	<!--Project Menu -->
				<div class="col-lg-12 col-xs-12">

					<div style="float: right; margin-bottom: 10px;">
						<a href="investmentcategories?addinvestmentcategory" data-toggle="modal" data-target="#addBox" class="btn btn-primary btn-sm btn-info" ><i class="ace-icon fa fa-plus"></i> Add Investment Category</a>
					</div>

					<div style="clear: both;"></div>

					<div class="box  box-success">

						<!-- /.box-header -->
						<div class="box-body" style="overflow-x:auto;">
							<table id="myTable" class="table table-bordered table-striped table-hover table-responsive">
										<thead><tr>
															<th class="col-xs-1 col-md-1">S/N</th>
															<th class="col-xs-4 col-md-1"></th>
															<th class="col-xs-6 col-md-4">Investment Category</th>
															<th class="hidden-xs">Description</th>
														</tr>
										</thead>

										</tbody>
							<?php

									$counter = 1;
									$all = mysqli_query($conn,  "SELECT * FROM investment_category");
									while($investment_category = mysqli_fetch_object($all))
									{
											echo '
												<tr>
														<td>'.$counter.'</td>
														<td>
															<div class="btn-group">
															<button type="button" class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown">
																<span class="caret"></span>
																<span class=""> Action</span>
															</button>
															<ul class="dropdown-menu" role="menu">
																<li><a href="#editBox" data-toggle="modal" data-target="#editBox" data-id="'.$investment_category->id.'" class="editcategory">Edit</a></li>';

																$categoryid = $investment_category->id;
																$delbutton = mysqli_query($conn,  "SELECT * FROM client_property where investmentcategory_id = $categoryid");
																if (mysqli_num_rows($delbutton) > 0) {

																} else {
																	echo '<li><a href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$investment_category->id.'" class="deletecategory">Delete</a></li>';
																}
															echo '
															</ul>
															</div>
														</td>
														<td>'.$investment_category->category.'</td>
														<td class="hidden-xs">'.$investment_category->description.'</td>
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

<!-- Add Property Types -->
<div class="modal fade" id="addBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
			<!-- //Content Will show Here -->
        </div>
    </div>
</div>

<!-- Edit Property -->
<div class="modal modal-warning fade" id="editBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- //Content Will show Here -->
        </div>
    </div>
</div>

<!-- Delete Property -->
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
							columns: [ 0, 1, 2 ]
						}
                    }
			]
		});
	});

$('.editcategory').click(function(){
    var editcategory=$(this).attr('data-id');

    $.ajax({url:"functions/fetchinvestmentcategory.php?editinvestmentcategory="+editcategory,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});


$('.deletecategory').click(function(){
    var deletecategory=$(this).attr('data-id');

    $.ajax({url:"functions/fetchinvestmentcategory.php?deleteinvestmentcategory="+deletecategory,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});

</script>
</body>
</html>
