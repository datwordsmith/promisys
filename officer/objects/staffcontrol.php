<?php
	
	$loginid = $_SESSION['loginid'];
	
	if ($loginid == "") { 
		header("location: index");
	}
	else
	{
		
		$checkuser = mysqli_query($conn, "SELECT * FROM staff WHERE id = '$loginid'");
		if (mysqli_num_rows($checkuser) > 0) {
			
			if($loginid != "") {
				$logindata = mysqli_fetch_object($checkuser);
				$status = $logindata->status;
				$staffrole = $logindata->role_id;
				
				//echo $staffid;
				
				if ($status == 1) {
								
						if ($staffrole != 3) {
							header("location: ../index");
							
						} else {			
							// CONTINUE (DO NOTHING)
						}
				} 
				else 
				{
					header("location: ../index");
				} 
			} 
			
			else {
			
			header("location: ../index");
			
			
			}
		}
		
		else {
			
			header("location: ../index");	
		
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
		global $currentMonth, $conn;
		
		$clientday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from client where MONTH(dob) = '$currentMonth'"));
		$clientcount = $clientday->count;

		$staffday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from staff where MONTH(dob) = '$currentMonth'"));
		$staffcount = $staffday->count;

		$totalBirthdays = ($clientcount + $staffcount);

		if ($totalBirthdays == 0) {

		} else {
			echo $totalBirthdays." This Month";
		}
	}

	function clientBirthdays() {
		global $currentMonth, $conn;
		
		$clientday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from client where MONTH(dob) = '$currentMonth'"));
		$clientBirthdays = $clientday->count;

		$staffday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from staff where MONTH(dob) = '$currentMonth'"));
		$staffBirthdays = $staffday->count;

		$totalBirthdays = ($clientBirthdays + $staffBirthdays);

		if ($totalBirthdays < 1) {

		} else {
			echo $clientBirthdays;
		}
	}	


	function staffBirthdays() {
		global $currentMonth, $conn;
		
		$clientday = mysqli_fetch_object(mysqli_query($conn,  "select count(id) as count from client where MONTH(dob) = '$currentMonth'"));
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

?>