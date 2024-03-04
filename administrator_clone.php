<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$administrator = "active";
	$pagename = "Administrator";	
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 

	if(isset($_GET['changepassword'])) {	
		$_SESSION['changepassword'] = $_GET['changepassword'];
		header("location: functions/fetchmyprofile.php?changepassword");
	}

	require_once ("functions/fetchgraph.php"); 	
	
?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once ("objects/head.php"); 	
	?>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://highcharts.github.io/export-csv/export-csv.js"></script>	
	
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
			window.history.pushState(stateObj, "", "administrator");			
		});
	}, 4000);
	
	window.setTimeout(function() {
		$("#success").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
			//window.location = "index";
			var stateObj = {};
			window.history.pushState(stateObj, "", "administrator");			
		});
	}, 4000);

    //now put it into the javascript
    var arrayObjects = <?php echo $json_array; ?>
	
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
        Administrator
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Administrator Dashboard</li>
      </ol>
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
				<div class="col-lg-12 col-xs-12">

					<div style="float: right; margin-bottom: 10px;">
						<a href="administrator?changepassword=<?php echo $loginid; ?>" data-toggle="modal" data-target="#changePassword" class="btn btn-warning btn-sm " ><i class="ace-icon fa fa-plus"></i> Change Password</a>
					</div>
				
				<div style="clear: both;"></div>
				</div>
				
				<div class="col-lg-4 col-xs-6">
					   <div class="small-box bg-aqua">
							<div class="inner">
							<?php 
								$projectcount = mysqli_fetch_object(mysqli_query($conn,  "SELECT count(id) as count FROM project"));								
							  
							  echo '<h3>'.$projectcount->count.'</h3>';
							?>
							  <p>Projects</p>
							</div>
							<div class="icon">
							  <i class="ion ion-android-pin"></i>
							</div>
							<a href="projects" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>

				<div class="col-lg-4 col-xs-6">
					  <div class="small-box bg-yellow">
						<div class="inner">
							<?php 
								$staffcount = mysqli_fetch_object(mysqli_query($conn,  "SELECT count(id) as count FROM staff"));								
							  
							  echo '<h3>'.$staffcount->count.'</h3>';
							?>

						  <p>Staff Members</p>
						</div>
						<div class="icon">
						  <i class="ion ion-person-stalker"></i>
						</div>
						<a href="staff" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>				
				</div>

				<div class="col-lg-4 col-xs-12">
					  <div class="small-box bg-green">
						<div class="inner">
							<?php 
								$clientcount = mysqli_fetch_object(mysqli_query($conn,  "SELECT count(id) as count FROM client"));								
							  
							  echo '<h3>'.$clientcount->count.'</h3>';
							?>
						  <p>Clients</p>
						</div>
						<div class="icon">
						  <i class="ion ion-ios-people"></i>
						</div>
						<a href="clients" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>		
				</div>
	</div>

     <div class="row">

			<div class="col-lg-8 col-xs-12">
			  <div class="box">				
				<div class="box-header">
				  <h3 class="box-title">Sales Chart</h3>
				</div>	
					
				<div class="box-body ">
					<div id="salesChart"></div>
				</div>
			  </div>						
			</div>

			<div class="col-lg-4 col-xs-12">
			  <div class="box box-danger">
				<div class="box-header">
				  <h3 class="box-title">Projects</h3>

				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
				  <table class="table table-striped">
					
					<tr> <th style="width: 10px">#</th> <th>Project</th>  <th>Sale Progress</th>   <th style="width: 40px"></th> </tr>
					
					<?php
						$counter = 1;
						$all = mysqli_query($conn,  "SELECT * FROM project order by name asc limit 0, 5");
						while($projects = mysqli_fetch_object($all))
						{
							$projectid = $projects->id;
							$getpptcount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertyCount FROM property where project_id = '$projectid';"));
							$propertyCount = $getpptcount->propertyCount;		
							
							$getsalecount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS saleCount FROM client_property where project_id = '$projectid';"));
							$saleCount = $getsalecount->saleCount;

							if ($propertyCount == 0) {
								$salePercent = 0;
							} else {
								$salePercent = (($saleCount/$propertyCount) * 100);
							}
							
								if (in_array($salePercent, range(75 , 100))) {
										$progress = "progress-bar-success";
								}
								elseif (in_array($salePercent, range(51 , 75))) {
										$progress = "progress-bar-info";
								}
								elseif (in_array($salePercent, range(26 , 50))) {
										$progress = "progress-bar-warning";
								}																				
								else {
										$progress = "progress-bar-danger";
								}
							
							
							echo '
							<tr>
								<td>'.$counter.'</td>
								<td>'.$projects->name.'</td>
								<td>
									<div class="progress progress-xs progress-striped active">
									  <div class="progress-bar '.$progress.'" style="width: '.$salePercent.'%"></div>
									</div>
								</td>
								<td><span class="badge bg-red">'.round($salePercent, 2).'%</span></td>
							</tr>';
							$counter++;
						}
					?>

				  </table>
				</div>
				<!-- /.box-body -->			
			  </div>
			</div>
	 </div>	
	
	<!--
	<div class="row">
	
				<div class="col-lg-12 col-xs-12">
				  <div class="box box-success">				
					<div class="box-header">
					  <h3 class="box-title">Latest Payments</h3>
					</div>	

					<div class="box-body">
							<table class="table table-striped" >
							
									<tr><th>Date</th> <th>Client</th> <th>Project</th> <th>Property</th> <th>Units</th> <th><span class="pull-right">Amount</span></th> </tr>  
									 
										<?php									
									
										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM account order by date desc limit 0, 5");
										while($account = mysqli_fetch_object($all))
										{
											$accountid = $account->id;
											
											$clientpropertyid = $account->client_property_id;
											$clientproperty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property where id = '$clientpropertyid'"));
											
											$projectid = $clientproperty->project_id;
											$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
											$project = $getpjt->name;

											$propertyid = $clientproperty->property_id;
											$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from property_type where id = $propertyid"));
											$propertytype = $getppt->propertytype;										

											$clientid = $clientproperty->client_id;
											$_SESSION['clientid'] = $clientid;
											//$getclient = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from client where id = $clientid"));											
											$getclient = mysqli_fetch_object(mysqli_query($conn, "select id, email from client where id = $clientid"));											
											
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
														<td> '.$getclient->email.'</td> 
														
														<td> '.$project.'</td> 														
														<td> '.$propertytype.'</td> 														
														<td><center>'.$clientproperty->quantity.'</center></td>';?> 																												
														<td><span class="pull-right"><?php echo $sign.$amountpaid; ?></span></td> 																																									
														<?php echo '																											
														
												</tr>'; 
												//$counter++;
										};
									
										?>
									  
							</table>
					</div>
				  </div>						
				</div>		

			
	</div>
	-->
	 
    </section>
    <!-- /.content -->
	
	<!-- Change Password -->
	<div class="modal modal-warning fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<!-- AdminLTE for demo purposes -->
<script src="styles/js/demo.js"></script>

<script src="styles/js/jquery.dataTables.min.js"></script>
<script src="styles/js/dataTables.bootstrap.min.js"></script>



<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
  
$('.changepassword').click(function(){
    var changepassword=$(this).attr('data-id');

    $.ajax({url:"functions/fetchmyprofile.php?changepassword="+changepassword,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});	


var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'salesChart'
    },

    title: {
        text: ''
    },
    
    xAxis: {

		categories: arrayObjects
    },

    series: [{
        data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
    }]

});

$('#preview').html(chart.getCSV());
  
</script>

</body>
</html>
