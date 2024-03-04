<?php
	clearstatcache();

	require_once ("connector/connect.php");	

	//Declare Page
	$expectedincome = "active";		
	$pagename = "Expected Income";	
	
	// re-create session
	session_start();
	require_once ("objects/staffcontrol.php"); 
	
	$currentYear = date("Y");

	/*$getYear = mysqli_fetch_object(mysqli_query($conn, "SELECT YEAR(date) as year from plan where YEAR(date) = '$currentYear'"));
	$thisYear = $getYear->year;*/

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
	        <i class="fa fa-dot-circle-o"></i> Expected Inflow 
	        <small></small>
	      </h1>
	      <ol class="breadcrumb">
				<select id="selectYear" class="form-control select2">
					<option value="">Select Year</option>
					<?php
					$yr = mysqli_query($conn,  "SELECT YEAR(date) as year from plan group by year order by year");
						while ($getYr = mysqli_fetch_object($yr)){ 
							echo '<option value="'.$getYr->year.'">'.$getYr->year.'</option>';
						}
					?>
				</select>	      	
	        <li><a href="administrator"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Expected Inflow</li>
	      </ol>
	  <div style="clear: both;"></div>
	  <h1 id = "showYear" style="font-size: 3em; font-weight: bold; text-align: center;">
	  	<?php //echo $thisYear; ?>
	  </h1>
    </section>

    <!-- Main content -->
    <section class="content">

    <?php //include("functions/expectedincome.php"); ?>
    <div id = "incomeList">

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


$(document).ready(function(){
    $("#selectYear").change(function(e) {

    	//var selectedText = $(this).find("option:selected").text();
        var year = $(this).val();

 	 	e.preventDefault();

 	 	if (isNaN(year) || year < 1 || year.trim == '') {
			    $('#selectYear').focus();
			    return false;       
		} 
		else {
	 	 	$('#showYear').html(year);
	        /*if (confirm("Sure you want to delete this post? This cannot be undone later.")) {
	        } */              	
	            $.ajax({
	                type : 'POST',
	                url : 'functions/expectedincome.php', //URL to the delete php script
					data: {
					  	year: year
					}
	            })
	 		    .done(function(data){
			     	//alert('Ajax Submit Correct ...'); 
					$('#incomeList').fadeOut('slow', function(){
					    $('#incomeList').fadeIn('slow').html(data);		
					});		     		     	
			    })
			    .fail(function(){
			 		$("#deleteError").fadeIn(600).html('<div class="callout callout-danger" id ="success"><i class="icon fa fa-exclamation-triangle"></i> Error, Please try again!</div>');
						
						window.setTimeout(function() {
							$("#success").fadeTo(500, 0).slideUp(500, function(){
								$(this).remove(); 
							});
						}, 4000);		 		
			    });				
		}



        return false;
    });
});







</script>

</body>
</html>
