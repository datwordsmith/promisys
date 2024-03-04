<?php
	
	$loginid = $_SESSION['loginid'];
	
	if ($loginid == "") { 
		header("location: ../index");
	}
	else
	{
		
		$checkuser = mysqli_query($conn, "SELECT * FROM hod WHERE id = '$loginid'");
		if (mysqli_num_rows($checkuser) > 0) {
			
			if($loginid != "") {
				$logindata = mysqli_fetch_object($checkuser);
				//$status = $logindata->status;
				$department = $logindata->department; 
				
				//echo $staffid;								
				if ($department != "accounts") {
					header("location: ../hod");
					//echo "NOT ACCOUNTS";
				} else {			
					// CONTINUE (DO NOTHING)
				}
			} 
			
			else {
			
			header("location: ../hod");
			
			
			}
		}
		
		else {
			
			header("location: ../hod");	
		
		}
	}
	
	//echo "expire Session = ".$_SESSION['expire'];
	
	if(isset($_SESSION['expire'])) {	
		if(time() > $_SESSION['expire']){
			unset($_SESSION['expire']);			
			header("location: ../index?session_expired");	
			//Echo "Session has Expired";
		}
		else { 
			$now =  time();
			$sessionWindow = ($now + (30*60));
			$_SESSION['expire'] = $sessionWindow;
		}
	}



//BIRTHDAY FUNCTIONS
	$currentMonth = date("n");
	$monthText = date("F");	
	$currentYear = date("Y");



	function totalBirthdays() {
		global $currentMonth, $conn, $loginid;
		
		$clientday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from client where MONTH(dob) = '$currentMonth' and id in (SELECT client_id from client_property where staff_id = '$loginid')"));
		$clientcount = $clientday->count;

		$staffday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from staff where MONTH(dob) = '$currentMonth'"));
		$staffcount = $staffday->count;

		$totalBirthdays = ($clientcount + $staffcount);

		if ($totalBirthdays == 0) {
			echo $totalBirthdays." This Month";
		} else {
			echo $totalBirthdays." This Month";
		}
	}

	function clientBirthdays() {
		global $currentMonth, $conn, $loginid;
		
		$clientday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from client where MONTH(dob) = '$currentMonth' and id in (SELECT client_id from client_property where staff_id = '$loginid')"));
		$clientBirthdays = $clientday->count;

		$staffday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from staff where MONTH(dob) = '$currentMonth' and id in (SELECT client_id from client_property where staff_id = '$loginid')"));
		$staffBirthdays = $staffday->count;

		$totalBirthdays = ($clientBirthdays + $staffBirthdays);

		if ($totalBirthdays == 0) {

		} else {
			echo $totalBirthdays." This Month";
		}
	}	


	function staffBirthdays() {
		global $currentMonth, $conn, $loginid;
		
		$clientday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from client where MONTH(dob) = '$currentMonth' and id in (SELECT client_id from client_property where staff_id = '$loginid')"));
		$clientBirthdays = $clientday->count;

		$staffday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from staff where MONTH(dob) = '$currentMonth'"));
		$staffBirthdays = $staffday->count;

		$totalBirthdays = ($clientBirthdays + $staffBirthdays);

		if ($totalBirthdays < 1) {

		} else {
			echo $staffBirthdays;
		}
	}	


	//Monthly Payment
	$mpmnt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as total from account where month(date) = $currentMonth and year(date) = $currentYear"));
	$monthlyPayment = number_format($mpmnt->total);
	if ($monthlyPayment > 0) {

	} else { 
		$monthlyPayment = 0;
	}		

	//Annual Payment
	$ypmnt = mysqli_fetch_object(mysqli_query($conn, "SELECT sum(amount) as total from account where year(date) = $currentYear"));
	$annualPayment = number_format($ypmnt->total);
	if ($annualPayment > 0) {

	} else { 
		$annualPayment = 0;
	}

	function pendingConfirmation() {
		global $conn;

		$payStatCount = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from prospect_property where rfo = 2 and payStatus = 0"));
		$payConfCount = $payStatCount->count;

		echo $payConfCount;
	}

?>