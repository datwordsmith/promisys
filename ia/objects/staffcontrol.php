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
								
						if ($staffrole != 5) {
							header("location: ../index");
							
						} else {			
							// CONTINUE (DO NOTHING)
							$getdeptid = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff WHERE id = '$loginid'"));
							$department_id = $getdeptid->department_id;

							if ($department_id == 0) {
								$department = '';
							} else {
								$getdept = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM departments WHERE id = '$department_id'"));
								$department = $getdept->department;
							}
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

?>