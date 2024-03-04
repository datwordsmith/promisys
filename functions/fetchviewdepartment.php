<?php
	require_once ("../connector/connect.php");	
	
	
	// re-create session
	session_start();


$editid = '';

//New Team Table
if(isset($_GET['loadTeam'])) {

	$departmentid = $_GET['loadTeam']; ?>

	<table class="table table-responsive" style="margin: 20px auto; width: 80%;">
		<thead>
			<tr>
				<th colspan=3 class="text-center">TEAM MEMBERS</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$leader = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM departments where id = '$departmentid'"));
				$hod = $leader->hod;

				$counter = 1;
				$getTeam = mysqli_query($conn, "SELECT * FROM staff where department_id = '$departmentid' and status <> 0 and id <> '$hod'");
				while ($team = mysqli_fetch_object($getTeam)) {

					$lastname = $team->lastname;
					$middlename = $team->middlename;
					$firstname = $team->firstname;												
					

					if ($middlename == "") {
						$fullname = $lastname.' '.$firstname;
					} else {
						$fullname = $lastname.' '.$firstname.' '.$middlename;
					}													
					echo '
					<tr>
					<td>'.$counter.'</td>
					<td class=""><a href="viewstaff?details='.$team->id.'">'.$fullname.'</a></td>
					<td class=""><a class="btn btn-sm btn-danger deletemember" href="#deleteBox" data-toggle="modal" data-target="#deleteBox" data-id="'.$team->id.'">Delist</a></td>

					</tr>';
					$counter++;

				}
			?>	
		</tbody>
	</table>	
	<?php	
}


//ADD DOCUMENT SCRIPT
if(isset($_POST['addfile'])) {

	$departmentid = $_SESSION['departmentid'];

	   	function getExtension($str) {
			$i = strrpos($str,".");
			if (!$i) { return ""; }
			$l = strlen($str) - $i;
			$ext = substr($str,$i+1,$l);
			return $ext;
	   	} 

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			return $data;
		}

	   	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$title = test_input($_POST["filetitle"]);
		}	   

	   $document=$_FILES['file']['name'];
   
	   if ($document) {
		   $filename = stripslashes($_FILES['file']['name']);
			 $extension = getExtension($filename);				
   
			   $doc = date("ymdHis").$_FILES['file']['name'];
				   $newname="../repository"."/".$doc;
				   $copied = copy($_FILES['file']['tmp_name'], $newname);
				   
				   $check = mysqli_query($conn, "SELECT * FROM departments WHERE id = '$departmentid'");
    
				   if ($check) {

						   	$add = "INSERT INTO repository (file, title, department_id) VALUES ('$doc', '$title', '$departmentid')";
							$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
												   
						   if ($added) {								
							   $added = "added";
							   $_SESSION['added'] = $added;
							   header("location: ../viewdepartment?details=".$departmentid);																
						   }
						   else {
							   $Failed = "Failed";
							   $_SESSION['Failed'] = $Failed;
							   header("location: ../viewdepartment?details=".$departmentid);	
						   }
				   }
			   
				   else {
							   $Failed = "Failed";
							   $_SESSION['Failed'] = $Failed;
							   header("location: ../viewdepartment?details=".$departmentid);	
				   }
   
	   } 
	   else {
   
	   }
}



//DELETE DOCUMENT SCRIPT
if(isset($_POST['deletedocument'])) {

	$documentid = $_SESSION['documentid'];
	$documentname = $_SESSION['documentname'];
	$departmentid = $_SESSION['departmentid'];


	if(unlink('../repository/'.$documentname)) {

		$delete = mysqli_query($conn, "DELETE FROM repository WHERE id = $documentid");

		if ($delete) {
			$deleted = "deleted";
			$_SESSION['deleted'] = $deleted;
			header("location: ../viewdepartment?details=".$departmentid);
		}
		else {
			$Failed = "Failed";
			$_SESSION['Failed'] = $Failed;
			header("location: ../viewdepartment?details=".$departmentid);
		}		
	} else {

		$Failed = "Failed";
		$_SESSION['Failed'] = $Failed;
		header("location: ../viewdepartment?details=".$departmentid);
		

	}					
}


//DELIST MEMBER
if(isset($_POST['deletemember'])) {

	$departmentid = $_SESSION['departmentid'];	
	$staffid = $_SESSION['staffid'];		

	$check = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff WHERE id = '$staffid'"));
	$departmentid = $check->department_id;

		
	$edit = "UPDATE staff set department_id = 0 WHERE id = '$staffid'";
	$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
	
	header("location: ../viewdepartment?details=".$departmentid);				
}


//ADD DOCUMENT MODAL

if(isset($_GET['adddocument'])) {
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Upload Document</h4>
	</div>
	<div class="modal-body">
		<form action="functions/fetchviewdepartment.php" method="POST" enctype="multipart/form-data">
			<div class="form-group col-md-12 col-xs-12">
				<input type="text" class="form-control" placeholder="File Title" name = "filetitle" value="" required>
			</div>

			<div class="form-group col-md-12 col-xs-12">
				<input type="file" class="form-control pull-right" placeholder="" name="file"  id="my_file" required>
				<!--<div style="clear: both;"></div>-->	
			</div>

			<div class="form-group col-md-12 col-xs-12">
				<span>&nbsp;</span>
				<button type="submit" name= "addfile" id="doc_upload" class="btn btn-default btn-block btn-flat"><i class="ace-icon fa fa-floppy-o"></i> Save File</button>
			</div>
		</form>		
	</div>
	<div style="clear: both; margin-bottom: 10px;"></div>
	<?php 
}




// DELETE DOCUMENT MODAL
if(isset($_GET['deletedocument'])) {
$documentid = $_GET["deletedocument"]; //escape the string if you like

	$document = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM repository WHERE id = $documentid"));

	$documentname = $document->file;
	$_SESSION['departmentid'] = $document->department_id;

	$_SESSION['documentid'] =  $documentid;
	$_SESSION['documentname'] =  $documentname;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $document->title; ?></h4>
</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">

		<p>Are you sure you want to delete this file?</p>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "deletedocument" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Delete</span></button>
              </div>
</form>
<?php
}



// DELETE TEAM MEMBER MODAL
if(isset($_GET['deletemember'])) {

			$staffid = $_GET["deletemember"]; //escape the string if you like


			$departmentid = $_SESSION['departmentid'];
			$_SESSION['staffid'] = $staffid;

			$department = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM departments WHERE id = $departmentid"));
			$department = $department->department;

			$getMember = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff where id = '$staffid'"));

				$lastname = $getMember->lastname;
				$middlename = $getMember->middlename;
				$firstname = $getMember->firstname;	

				if ($middlename == "") {
					$fullname = $lastname.' '.$firstname;
				} else {
					$fullname = $lastname.' '.$firstname.' '.$middlename;
				}	
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo $department.': '.$fullname; ?></h4>
	</div>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="modal-body">

			<p>Are you sure you want to delist <?php echo $fullname.' from '.$department; ?>?</p>

	</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "deletemember" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Delist</span></button>
              </div>
</form>
<?php
}
?>


<script src="styles/js/bootstrap-datepicker.js"></script>

<script>


    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

	var password = document.getElementById("password"), repeat = document.getElementById("repeat");

	function validatePassword(){
		if(password.value != repeat.value) {
			repeat.setCustomValidity("Passwords Don't Match");
		} else {	
			repeat.setCustomValidity('');
		}
	}

	password.onchange = validatePassword;
	repeat.onkeyup = validatePassword;	
	
</script>