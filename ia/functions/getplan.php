<?php
//Include database configuration file
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();	
	
	if (isset($_GET['planid'])) {	

		$planid = $_GET['planid'];
			
		$GLOBALS['planid'] = $planid;
		$_SESSION['paymentFailed'] = $paymentFailed;

		echo $planid;
	} 

?>
