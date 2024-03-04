<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$projects = "active";
	$pagename = "Projects";	
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 
	
	if(isset($_GET['details'])) {
		$projectid = $_GET['details'];
	
		if (is_numeric($projectid)) {
			$getconfam = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM project where id = $projectid"));
			
			if ($getconfam) {

				$_SESSION['projectid'] = $projectid;
			}
			else {
				header("location: projects");
			}			
			
		} 
		else {			
			header("location: projects");
		}

	} else {
		header("location: projects");
	}

	if(isset($_GET['delete'])) {
		$_SESSION['unassignproject'] = $_GET['delete'];
		header("location: functions/fetchproject.php?unassignproject");
	}

	$getpptcount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertyCount FROM client_property where property_id in (select id from project_property where project_id = $projectid);"));
	$propertyCount = $getpptcount->propertyCount;

	/*$getclientcount = mysqli_fetch_object(mysqli_query($conn, "SELECT COUNT(DISTINCT client_id) as clientCount FROM client_property where staff_id = $staffid;"));
	$clientCount = $getclientcount->clientCount;	*/

	if(isset($_GET['addproperty'])) {	
		$propertytypeid = $_GET["addproperty"];
		header("location: functions/fetchpropertytype.php?addproperty");
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
        <i class="fa fa-map-marker"></i> Project Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="projects"><i class="fa fa-map-marker"></i> Projects</a></li>
        <li class="active">Project Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->

						<?php 
								if (isset($_SESSION['propertyAdded'])) {
									$propertyAdded = "";
									$propertyAdded = $_SESSION['propertyAdded'];
									echo '<div class="callout callout-success" id="propertyAdded">	
									<i class="icon fa fa-exclamation-circle"></i> Property Successfully Added.										
									</div>';	
								}						
								if (isset($_SESSION['propertyExists'])) {
									$propertyExists = "";
									$propertyExists = $_SESSION['propertyExists'];
									echo '<div class="callout callout-warning" id="propertyAdded">	
									<i class="icon fa fa-exclamation-circle"></i> Property Exists in this Project.										
									</div>';	
								}								
								if (isset($_SESSION['propertyEdited'])) {
									$propertyEdited = "";
									$propertyEdited = $_SESSION['propertyEdited'];
									echo '<div class="callout callout-success" id="propertyAdded">	
									<i class="icon fa fa-exclamation-circle"></i> Property Successfully Edited.										
									</div>';	
								}
								if (isset($_SESSION['propertyDeleted'])) {
									$propertyDeleted = "";
									$propertyDeleted = $_SESSION['propertyDeleted'];
									echo '<div class="callout callout-success" id="propertyAdded">	
									<i class="icon fa fa-exclamation-circle"></i> Property Successfully Deleted.										
									</div>';	
								}								
								if (isset($_SESSION['Failed'])) {
									echo '<div class="callout callout-danger" id="propertyAdded">	
									<i class="icon fa fa-exclamation-circle"></i> Operation Failed, Try Again.
								
									</div>';	
								}	



								if (isset($_SESSION['projectUpdated'])) {
									echo '<div class="callout callout-success" id="propertyAdded">	
									<i class="icon fa fa-check-square-o"></i> Project Image Uploaded.
								
									</div>';	
								}							

								unset($_SESSION['projectUpdated']);								
								unset($_SESSION['propertyAdded']);			
								unset($_SESSION['propertyEdited']);									
								unset($_SESSION['propertyDeleted']);									
								unset($_SESSION['Failed']);									
						?>
	<div class="row">
				
				<div class="col-lg-12 col-xs-12">	
					<div class="pull-right">
						<a href="#assignBox" data-toggle="modal" data-target="#assignBox" data-id="<?php echo $projectid; ?>" class="btn btn-sm btn-success assignproject" ><i class="ace-icon fa fa-home"></i> <span class="hidden-xs">Add Properties</span></a>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>	
	</div>


     <div class="row">
	<!--Project Menu -->

				<!--
				<div class="col-md-12 col-xs-12">	
 					<div style="float: right; margin-bottom: 10px;">
						<a href="projects?addproject" data-toggle="modal" data-target="#addBox" class="btn btn-primary btn-sm btn-info" ><i class="ace-icon fa fa-plus"></i> Add New Project</a>
					</div>
				</div>
				-->
				
				<div class="col-md-4 col-xs-12">

							<!-- BIO -->
							<div class="box  box-warning">
								<div class="box-header with-border">
								  <h3 class="box-title">Project Information</h3>
								  <div class="box-tools pull-right">
									<!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
								  </div>
								</div>				  
								<!-- /.box-header -->
							
								<div class="box-body"  style="overflow-x:auto;">
													<?php
														if(isset($_GET['details'])) {	
															$projectid = $_GET['details'];
																$project = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project WHERE id = '$projectid'"));	
																$logo = $project->logo;											
														}													


														if ($logo != null) {
															echo '<div style = " width: 280px; margin: 0 auto;">
															<a href="javascript:void(0)" onclick="delete_logo('.$projectid.')" class="btn btn-xs btn-danger pull-right" data-toggle="tooltip" data-placement="top" title="Delete Logo"><i class="ace-icon fa fa-times"></i></a>

																<center><img src="images/'.$logo.'" width=170px /></center> 
																</div>';
														} 

														else { ?>
																<form action="functions/fetchproject.php" method="POST" enctype="multipart/form-data">

																  <div class="form-group col-md-9 col-xs-12">
																	<span>Upload Project Logo (.png, .jpg)</span>
																	<input type="file" class="form-control pull-right" placeholder="Project Name" name="file"  id="my_file" required> 
																	<div style="clear: both;"></div>	
																  </div>

																	<div class="form-group col-md-3 col-xs-12">
																		<span>&nbsp;</span>
																	  <button type="submit" name= "addimage" id="img_upload" class="btn btn-default btn-block btn-flat"><i class="ace-icon fa fa-floppy-o"></i></button>
																	</div>

															</form>																	
													<?php
														}
													?>	

													
													<table class="table no-border table-responsive" >
															<tr><th width=50%>Project Name</th> <td><?php echo $project->name; ?></td> </tr>
															<tr><th width=50%>Project Location</th> <td><?php echo $project->state; ?></td> </tr>
															<tr><th width=50%>Description</th> <td><?php echo $project->description; ?></td> </tr>
													</table>
								</div>
								<!-- /.box-body -->
							</div>	
							<!-- CLOSE BOX -->

				</div>

				<div class="col-md-8 col-xs-12">											

						  <div class="box  box-info">		  
							<!-- /.box-header -->
							
							<div class="box-body"  style="overflow-x:auto;">
								
								
							<table id="" class="table table-striped table-responsive" >
							
									<thead><tr><th>Property Type</th> <th>Current Price</th> <th>Total Units</th> <th>Units Sold</th> <th>Units Left</th> <th></th> <th></th>  </tr> </thead>  
										
									<tbody>  
										<?php									
									
										//$counter = 1;
										$all = mysqli_query($conn,  "SELECT * FROM project_property where project_id = '$projectid'");
										while($property = mysqli_fetch_object($all))
										{
											$propertyId = $property->id;
											$property_type = $property->property_type;

											$quantity = $property->quantity;
											$amount = $property->amount;

											/* $propertytype_id = $property->type_id;											
											$gettype = mysqli_fetch_object(mysqli_query($conn, "select * from property_type where id = $propertytype_id"));
											$propertytype = $gettype->propertytype; */											

											$getsalecount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS saleCount FROM client_property where property_id = $propertyId;"));
											$saleCount = $getsalecount->saleCount;											
											
											if ($saleCount == ""){
												$saleCount = 0;
												$balance = ($quantity - $saleCount);
											} else {
												$balance = ($quantity - $saleCount);
											}

											echo '	
												<tr>													
														<td><span class="pull-left">'.$property_type.'</span></td> 														
																												
														<td><span class="pull-right">'.$sign.number_format($amount).'</span></td> 														
														<td><span class="pull-right">'.$quantity.'</span></td> 														
														<td><span class="pull-right">'.$saleCount.'</span></td> 														
														<td><span class="pull-right">'.$balance.'</span></td>
														
														<td>
															<center>
																<a href="#editPrice" data-toggle="modal" data-target="#editPrice" data-id="'.$propertyId.'" class="btn btn-xs btn-warning editprice" >Edit Price</a>
															</center>
														</td>

														<td>
															<center>
																<a href="#editUnits" data-toggle="modal" data-target="#editUnits" data-id="'.$propertyId.'" class="btn btn-xs btn-info editunits" >Edit Units</a>
															</center>
														</td>														

														<td>
															<center>';
																if ($balance == $quantity) {
																	echo '<a href="viewproject?delete='.$propertyId.'" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-times"></i> Delete</a>';
																} else {
																	echo '<a href="#" class="btn btn-xs btn-danger disabled"><i class="ace-icon fa fa-times"></i> Delete</a>';
																}
															  echo '															  
															</center>														
														</td> 
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

	 
	<!-- SECOND ROW -->
	<div class="row">
						  
	</div>
	 
	 
    </section>
    <!-- /.content -->
	

		<!-- Assign Projects -->
		<div class="modal modal-success fade" id="assignBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		          <!-- //Content Will show Here -->
		        </div>
		    </div>
		</div>

		<!-- Edit Price -->
		<div class="modal modal-warning fade" id="editPrice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		          <!-- //Content Will show Here -->
		        </div>
		    </div>
		</div>


		<!-- Edit Units -->
		<div class="modal modal-info fade" id="editUnits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
  });
  
	$(document).ready(function(){
		$('#myTable').dataTable();
	});  


$('.assignproject').click(function(){
    var assignproject=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?assignproject="+assignproject,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});
	

$('.editprice').click(function(){
    var editprice=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?editprice="+editprice,cache:false,success:function(result){
        $(".modal-content").html(result);
    }});
});

$('.editunits').click(function(){
    var editunits=$(this).attr('data-id');

    $.ajax({url:"functions/fetchproject.php?editunits="+editunits,cache:false,success:function(result){
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

	$('#img_upload').click(function(){
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
          alert( 'Invalid file type!' );
		  return false;
        }
      }
    });	

function delete_logo(projectid) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "functions/ajaxScripts.php?delete_logo=" +projectid, true);
    xmlhttp.send();

	location = window.location.href;	 
}
</script>

</body>
</html>
