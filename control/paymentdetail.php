<?php
	clearstatcache();

	require_once ("../connector/connect.php");	

	//Declare Page
	$payment = "active";
	$pagename = "Payment History";
	
	// re-create session
	session_start();

	require_once ("objects/staffcontrol.php"); 

    if(isset($_GET['id'])) {
		$accountid = $_GET['id'];

		if (is_numeric($accountid)) {
			$account = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM account where id = $accountid"));
			
			if ($account) {

			}
			else {
				header("location: payment");
			}			
			
		} 
		else {			
			header("location: payment");
		}

	} else 
	{
		header("location: payment");
	}


    $account = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM account where id = $accountid"));			
    $clientid = $account->client_id;	

       
    $client = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client WHERE id = $clientid"));
    $clientfullname = $client->lastname.' '.$client->firstname.' '.$client->middlename.' ('.$client->title.')';
        
    $clientpropertyid = $account->client_property_id;
    $clientproperty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property where id = '$clientpropertyid'"));

    $propertyid = $clientproperty->property_id;
    $investmentcategory_id = $clientproperty->investmentcategory_id;

    $getCat = mysqli_fetch_object(mysqli_query($conn, "select * from investment_category where id = $investmentcategory_id"));
    $category = $getCat->category;

    $getppt = mysqli_fetch_object(mysqli_query($conn, "select * from project_property where id = $propertyid"));
    $propertytype = $getppt->property_type;		

    $projectid = $getppt->project_id;
    $getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
    $project = $getpjt->name;    

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
        <i class="fa fa-money"></i> Payment History
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="payment"><i class="fa fa-money"></i> Payment</a></li>
        <li class="active">Payment History - <?php echo strtoupper($clientproperty->fileid);?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<!-- TABS -->
 
	<!-- SECOND ROW -->
	<div class="row" class="paymentHistory">
	
					<div class="col-md-9 col-xs-12">

							<!-- ASSIGN PROPERTY -->
						  <div class="box  box-info">
			  
							<!-- /.box-header -->
							
							<div class="box-body"  style="overflow-x:auto;">
								

                                <table id="myTable" class="table no-border table-responsive" >
                                    <tr><th width=30%>Client Email</th> <td><?php echo $client->email; ?></td> </tr>
                                    <tr><th width=30%>Fullname</th> <td><?php echo $clientfullname; ?></td> </tr>
                                    <tr><th width=30%>File ID</th> <td><?php echo strtoupper($clientproperty->fileid); ?></td> </tr>					
                                    <tr><th width=30%>Sex</th> <td><?php echo $client->sex; ?></td> </tr>
                                    <tr><th width=30%>Phone</th> <td><?php echo $client->phone.', '.$client->mobile; ?></td> </tr>
                                    <tr><th width=30%>Project</th> <td><?php echo $project; ?></td> </tr>
                                    <tr><th width=30%>Property Type</th> <td><?php echo $propertytype.'<span class="productcategory"> <b>('.$category.')</b></span>'; ?></td> </tr>
                                    <tr><th width=30%>Quantity</th> <td><?php echo $clientproperty->quantity; ?></td> </tr>
                                    <tr><th width=30%>Cost</th> <td><?php echo $sign.number_format($clientproperty->amount); ?></td> </tr>


                                </table>

                                <div style="clear: both; height: 20px;">
                                    &nbsp;
                                </div>

                                <table id="myTable" class="table table-responsive table-striped" >
                                            
                                    <thead><tr><th></th> <th width=40%>Date</th> <th width=25%><span style="float: right;">Amount Paid(<?php echo $sign; ?>)</span></th> <th> </th> <th width=25%><span style="float: right;">Balance (<?php echo $sign; ?>)</span></th> </tr> </thead>  
                                            
                                            <tbody> 
                                                <?php
                                                    $counter = 1;
                                                    $cost = $clientproperty->amount;
                                                    
                                                    $all = mysqli_query($conn,  "SELECT * FROM account where client_property_id = $clientpropertyid");
                                                    while($getaccount = mysqli_fetch_object($all))
                                                        {
                                                            $date = $getaccount->date;
                                                            $date = strtotime($date);
                                                            
                                                            $paid = $getaccount->amount;
                                                            $bal = ($cost - $paid);
                                                            if ($bal == 0) {
                                                                $status = '<span class=" btn-xs btn-danger" > COMPLETED </span>';
                                                            }
                                                            else {
                                                                $status = $sign.number_format($bal);
                                                            }
                                                                                                    
                                                            echo '	
                                                                <tr>
                                                                    <td>'.$counter.'</td> 														
                                                                    <td>'.date("Y-M-d",$date).'</td> 														
                                                                    <td><span style="float: right;">'.$sign.number_format($paid).'</span></td>
                                                                    <td></td>
                                                                    <td><span style="float: right;">'.$status.'</span></td> 														
                                                                                                                            

                                                                </tr>'; 
                                                                $counter++;
                                                                $cost = $bal;
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
    
    <div class="row noprint">
        <div class="col-md-9 col-xs-12">
            <button type="button" onclick="printFunction()" class="btn btn-success pull-right"><i class="ace-icon fa fa-print"></i> <span>Print</span></button>
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
                    {
                        extend: 'print',
						text:'<i class="fa fa-print" aria-hidden="true"></i> Print',
						className: 'btn btn-info btn-xs',
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
						}
                    },					
                    {
                        extend: 'excel',
						text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
						className: 'btn btn-success btn-xs tablebutton',						
                        exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
						}
                    }				
			]		
		});
	});  

	
//PRINT
function printFunction() {
	window.print();
}

 

//COUNT	
$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 2000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});	
	
</script>

</body>
</html>
