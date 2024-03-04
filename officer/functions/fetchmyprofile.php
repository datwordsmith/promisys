<?php
	require_once ("../../connector/connect.php");	
	
	
	// re-create session
	session_start();


$editid = '';


//ADD IMAGE ONLY
if(isset($_POST['addpic'])) {

	$loginid = $_SESSION['loginid'];
   
	   function getExtension($str) {
			$i = strrpos($str,".");
			if (!$i) { return ""; }
			$l = strlen($str) - $i;
			$ext = substr($str,$i+1,$l);
			return $ext;
	   } 
   
	   $image=$_FILES['file']['name'];
   
	   if ($image) {
		   $filename = stripslashes($_FILES['file']['name']);
			 $extension = getExtension($filename);				
   
			   $photo = date("ymdHis").$_FILES['file']['name'];
				   $newname="../../photos"."/".$photo;
				   $copied = copy($_FILES['file']['tmp_name'], $newname);
				   
				   $check = mysqli_query($conn, "SELECT * FROM staff WHERE id = '$loginid'");
   
				if ($copied) {
					if ($check) {
				   
						$update = "UPDATE staff set pic = '$photo' WHERE id = '$loginid'";
						$updated = mysqli_query($conn, $update) or die(mysqli_error($conn));
												
						if ($update) {								
							$edited = "edited";
							$_SESSION['edited'] = $edited;
							header("location: ../index");
							//echo "Newname is ".$newname;																	
						}
						else {
							$Failed = "Failed";
							$_SESSION['Failed'] = $Failed;
							header("location: ../index");	
						}
					}
			
					else {
							$Failed = "Failed";
							$_SESSION['Failed'] = $Failed;
							header("location: ../index");	
					}
				} else {

				}
   
	   } 
	   else {
   
	   }
   }


//EDIT PROFILE SCRIPT
if(isset($_POST['editprofile'])) {
$editid = $_SESSION["editprofile"];


function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$lastname = test_input($_POST["lastname"]);
		$firstname = test_input($_POST["firstname"]);
		$middlename = test_input($_POST["middlename"]);
		$dob = $_POST["dob"];
		$sex = test_input($_POST["gender"]);

}

		$newdob = date("Y-m-d", strtotime($dob));

				$check = mysqli_query($conn, "SELECT * FROM staff WHERE id = '$editid'");

				if (mysqli_num_rows($check) > 0) {
				
						$edit = "UPDATE staff set lastname = '$lastname', firstname = '$firstname', middlename = '$middlename', sex = '$sex', dob = '$newdob' WHERE id = '$editid'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
												
						if ($edited) {								
								header("location: ../index?edited");																	
						}
						else {
								header("location: ../index?failed");			
						}
				}
			
				else {
						header("location: ../index?failed");		
				}
}

//CHANGE PASSWORD SCRIPT
if(isset($_POST['changepassword'])) {
$editid = $_SESSION["changepassword"]; 


function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$old = md5(test_input($_POST["oldpassword"]));
		$new = md5(test_input($_POST["newpassword"]));
}

		$newdob = date("Y-m-d", strtotime($dob));

				$check = mysqli_query($conn, "SELECT * FROM staff WHERE id = '$editid'");

				if (mysqli_num_rows($check) > 0) {
						
					$getPassword = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff WHERE id = '$editid'"));
					$existingPassword = $getPassword->password;
					
					if ($old == $existingPassword) {
						$edit = "UPDATE staff set password = '$new' WHERE id = '$editid'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
												
						if ($edited) {								
								header("location: ../index?changed");																	
						}					
						else {
								header("location: ../index?failed");			
						}
					} else {
								header("location: ../index?failed");
					}
				}
			
				else {
						header("location: ../index?failed");		
				}
}

//===========================================================================================================================================>

// EDIT PROFILE	MODAL
if(isset($_GET['editprofile'])) {	
$editid = $_SESSION["editprofile"]; //escape the string if you like
	
	$staff = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = '$editid'"));

			//$viewid = $staff->id;
			//$_SESSION['editid'] =  $editid;
			
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Profile - <?php echo $staff->email; ?></h4>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div class="modal-body">
							
			<div class="form-group">	
				<div class="col-md-4 col-xs-12">
						<input type="text" class="form-control" placeholder="Lastname" name = "lastname" value="<?php echo $staff->lastname; ?>" required>
						<div style="clear: both;">&nbsp;</div>																				
				</div>	

				<div class="col-md-4 col-xs-12">
						<input type="text" class="form-control" placeholder="Firstname" name = "firstname" value="<?php echo $staff->firstname; ?>" required>
						<div style="clear: both;">&nbsp;</div>	
				</div>

				<div class="col-md-4 col-xs-12">
						<input type="text" class="form-control" placeholder="Middlename" name = "middlename" value="<?php echo $staff->middlename; ?>">
						<div style="clear: both;">&nbsp;</div>	
				</div>		
		  
			</div>

			<div class="form-group">
				<div class="col-md-6 col-xs-12">									
					<select class="form-control" placeholder="Gender" name="gender" required>
						<option value="" selected>Gender</option>												
						<option value="Male">Male</option>												
						<option value="Female">Female</option>												
					</select>
					<div style="clear: both;"></div>
				</div>
				
				<div class="col-md-6 col-xs-12">									
					<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" placeholder="Date of Birth" class="form-control pull-right" id="datepicker" name="dob" required>
					</div>
					
					<div style="clear: both;"></div>	
				</div>	

					<div style="clear: both;"></div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>
			<button type="submit" name= "editprofile" class="btn btn-info btn-outline pull-left"><i class="ace-icon fa fa-floppy-o"></i> Save</button>
		</div>		
</form>					



<?php
}


// CHANGE PASSWORD MODAL
if(isset($_GET['changepassword'])) {	
$editid = $_SESSION["changepassword"]; //escape the string if you like
	
	$staff = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = '$editid'"));

			//$viewid = $staff->id;
			//$_SESSION['editid'] =  $editid;
			
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Profile - <?php echo $staff->email; ?></h4>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div class="modal-body">
								
			<div class="form-group">	
				<div class="col-md-4 col-xs-12">
						<input type="password" class="form-control" placeholder="Old Password" name = "oldpassword" value="" required>
						<div style="clear: both;">&nbsp;</div>																				
				</div>	

				<div class="col-md-4 col-xs-12">
						<input type="password" class="form-control" placeholder="New Password" name = "newpassword" pattern=".{6,}" title="Six or more characters required" value="" id="password" required>
						<div style="clear: both;">&nbsp;</div>	
				</div>

				<div class="col-md-4 col-xs-12">
						<input type="password" class="form-control" placeholder="Repeat Password" name = "repeat" id="repeat" value="">
						<div style="clear: both;">&nbsp;</div>	
				</div>		
			</div>
		<div style="clear: both;"></div>	
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>
			<button type="submit" name= "changepassword" class="btn btn-info btn-outline pull-left"><i class="ace-icon fa fa-floppy-o"></i> Save</button>
		</div>		
</form>					



<?php
}

?>

<!-- bootstrap datepicker -->
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