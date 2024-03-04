<?php

	require_once ("connector/connect.php");
    //bind to $name
    if ($stmt = mysqli_prepare($conn, "SELECT month FROM month")) {
        $stmt->bind_result($month);
        $OK = $stmt->execute();
    }
    //put all of the resulting names into a PHP array
    $result_array = Array();
    while($stmt->fetch()) {
        $result_array[] = $month;
    }
    //convert the PHP array into JSON format, so it works with javascript
    $json_array = json_encode($result_array);

	$getpptcount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertyCount FROM property where project_id = '$projectid';"));
	$propertyCount = $getpptcount->propertyCount;		
	
	$getsalecount = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS saleCount FROM client_property where project_id = '$projectid';"));
	$saleCount = $getsalecount->saleCount;


	
	$getclientcount = mysqli_fetch_object(mysqli_query($conn, "SELECT COUNT(DISTINCT client_id) as clientCount FROM client_property where staff_id = '$loginid';"));
	$clientCount = $getclientcount->clientCount;	
?>

<!DOCTYPE html>
<html>
<head>
	<?php
		//require_once ("objects/head.php"); 	
	?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://highcharts.github.io/export-csv/export-csv.js"></script>

<script>
    //now put it into the javascript
    var arrayObjects = <?php echo $json_array; ?>
</script>
	
</head>
<script>
	


	
</script>


<body class="hold-transition skin-blue sidebar-mini">
<div class="se-pre-con"></div>
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
	<?php //include ("objects/top_bar.php"); 	?>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
	<?php //include ("objects/sidebar.php"); 	?>
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


     <div class="row">
	<!--Project Menu -->
 
				<div class="col-lg-12 col-xs-12">
				
				  <div class="box  box-warning">
					<!-- /.box-header -->
					<div class="box-body"  style="overflow-x:auto;">

						<div id="container"></div>


						<h3>Exported CSV:</h3>
						<pre id="preview"></pre>					
					
					</div>
					<!-- /.box-body -->
				  </div>	
				</div>
	 </div>
	 
 

	 
	 
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
		<?php //include ("objects/footer.php"); 	?>
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



<script>

  
var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'container'
    },

    title: {
        text: 'Categorized chart'
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
