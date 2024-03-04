<?php

	$currentMonth = date("n");
	$monthText = date("F");	
	$currentYear = date("Y");

	//Client Birthdays
	$clientBirthdays = mysqli_num_rows(mysqli_query($conn, "SELECT * from client where MONTH(dob) = $currentMonth"));
	if ($clientBirthdays > 0) {

	} else { 
		$clientBirthdays = 0;
	}	

	//Staff Birthdays
	$staffBirthdays = mysqli_num_rows(mysqli_query($conn, "SELECT * from staff where MONTH(dob) = $currentMonth"));
	if ($staffBirthdays > 0) {

	} else { 
		$staffBirthdays = 0;
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