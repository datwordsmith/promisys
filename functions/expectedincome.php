<?php
//Include database configuration file
	require_once ("../connector/connect.php");	
	
	if (isset($_POST['year'])) {

	function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			return $data;
	}		

	$year = test_input($_POST["year"]);

?>

    <div class="row">
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-primary">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 1 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 1 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>January</p>
							</div>
							
							<a href="expectedincomedetails?date=<?php echo $year;?>_January" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-info">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 2 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 2 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>February</p>
							</div>
							
						<a href="expectedincomedetails?date=<?php echo $year;?>_February" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
					  </div>				
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-green">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 3 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 3 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>March</p>
							</div>
							
						<a href="expectedincomedetails?date=<?php echo $year;?>_March" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
					  </div>		
				</div>
				
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-red">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 4 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 4 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>April</p>
							</div>
							
							<a href="expectedincomedetails?date=<?php echo $year;?>_April" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>				
	</div>

    <div class="row">
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-danger">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 5 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 5 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>May</p>
							</div>
							
							<a href="expectedincomedetails?date=<?php echo $year;?>_May" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-red">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 6 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 6 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>June</p>
							</div>
							
						<a href="expectedincomedetails?date=<?php echo $year;?>_June" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
					  </div>				
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-yellow">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 7 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 7 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>July</p>
							</div>
							
						<a href="expectedincomedetails?date=<?php echo $year;?>_July" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
					  </div>		
				</div>
				
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-aqua">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 8 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 8 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>August</p>
							</div>
							
							<a href="expectedincomedetails?date=<?php echo $year;?>_August" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>				
	</div>

    <div class="row">
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-yellow">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 9 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 9 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>September</p>
							</div>
							
							<a href="expectedincomedetails?date=<?php echo $year;?>_September" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-aqua">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 10 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 10 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>October</p>
							</div>
							
						<a href="expectedincomedetails?date=<?php echo $year;?>_October" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
					  </div>				
				</div>

				<div class="col-lg-3 col-xs-12">
					  <div class="small-box bg-success">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 11 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 11 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>November</p>
							</div>
							
						<a href="expectedincomedetails?date=<?php echo $year;?>_November" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
					  </div>		
				</div>
				
				<div class="col-lg-3 col-xs-12">
					   <div class="small-box bg-green">
							<div class="inner">
								<?php
									$all = mysqli_num_rows(mysqli_query($conn, "SELECT * from plan where MONTH(date) = 12 and YEAR(date) = $year"));
									if ($all > 0) {
										$getAmt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as amount from plan where MONTH(date) = 12 and YEAR(date) = $year"));
										$amount = $getAmt->amount;
									} else { 
										$amount = 0;
									}								
									
									echo '<h2>'.$sign.number_format($amount).'</h2>';
								?>
								<p>December</p>
							</div>
							
							<a href="expectedincomedetails?date=<?php echo $year;?>_December" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
						</div>		
				</div>				
	</div>	

<?php

}

?>