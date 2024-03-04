<?php
//Include database configuration file
	require_once ("../../connector/connect.php");	
	
	if(isset($_GET['change_status'])) {
		
		$staffid  = $_GET["change_status"];
		
		$check = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff WHERE id = '$staffid'"));
		$stat = $check->status;
		
		if ($stat == 1) {
			
			$edit = "UPDATE staff set status = 0 WHERE id = '$staffid'";
			$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
			
		} else {
			
			$edit = "UPDATE staff set status = 1 WHERE id = '$staffid'";
			$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));					
		
		}
		
		header("location: ../viewstaff?details=".$staffid);
	}


	//GENERATE FILE ID 
	if(isset($_GET['generate_id'])) {
		
		$clientPropertyId  = $_GET["generate_id"];

		$getpj = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property WHERE id = '$clientPropertyId'"));
		$property = $getpj->property_id;		

		$getppt = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property WHERE id = '$property'"));
		$projectid = $getppt->project_id;

		$getpjcode = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project WHERE id = '$projectid'"));
		$projectCode = $getpjcode->code;		
		
		$add = "INSERT INTO $projectCode (client_property_id) VALUES ('$clientPropertyId')";
		$added = mysqli_query($conn, $add) or die(mysqli_error($conn));	

		if ($added)	 {
			$getcount = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM $projectCode WHERE client_property_id = '$clientPropertyId'"));
			$thecount = $getcount->id;

			$codecount = str_pad($thecount, 5, "0", STR_PAD_LEFT);		
			
			$fileid = $projectCode.$codecount;	

			$confirm = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM client_property where fileid = '$fileid'"));

			if (($confirm) > 0) {

				$fileIdError = "fileIdError";
				$_SESSION['fileIdError'] = $fileIdError;
				header("location: ../viewclient?details=".$client);

			} else {
				$edit = "UPDATE client_property set fileid = '$fileid' where id = '$clientPropertyId'";
				$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
				
				header("location: ../viewclient?details=".$client);
			}			
		}

				$fileIdError = "fileIdError";
				$_SESSION['fileIdError'] = $fileIdError;
				header("location: ../viewclient?details=".$client);

	}


	if(isset($_GET['delete_logo'])) {
		
		$projectid  = $_GET["delete_logo"];
		
		$check = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM project WHERE id = '$projectid'"));

		$file = $check->logo;
		unlink('../images/'.$file);
			
			$edit = "UPDATE project set logo = NULL WHERE id = '$projectid'";
			$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
					
		header("location: ../viewproject?details=".$projectid);
	}
	

	if(isset($_POST['delist'])) {
		
		//$staffid  = $_GET["delist"];	

		$staffid = $_POST['delist'];
		$deptid = $_POST['deptid'];		

		$check = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff WHERE id = '$staffid'"));
		$departmentid = $check->department_id;

			
		$edit = "UPDATE staff set department_id = 0 WHERE id = '$staffid'";
		$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
		
		header("location: ../viewdepartment?details=".$departmentid);
	}

	if(isset($_GET['delete_pic'])) {
		
		$loginid  = $_GET["delete_pic"];
		
		$check = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff WHERE id = '$loginid'"));

		$file = $check->pic;
		unlink('../photos/'.$file);
			
			$edit = "UPDATE staff set pic = NULL WHERE id = '$loginid'";
			$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
					
		header("location: ../index");
	}


	//
	if( isset( $_POST['fileid'] ) )
	{

		$fileid = $_POST['fileid'];

		echo "File ID is = ".$fileid;

		/*$insertdata=" INSERT INTO user_info VALUES( '$name','$age','$course' ) ";
		mysql_query($insertdata);
*/
	}


?>