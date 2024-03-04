<?php
	require_once ("../../connector/connect.php");

	// re-create session
	session_start();

$projectid = '';

//ADD STAFF SCRIPT
if(isset($_POST['addstaff'])) {

		function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
				return $data;
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$email = test_input($_POST["email"]);
				$lastname = test_input($_POST["lastname"]);
				$firstname = test_input($_POST["firstname"]);
				$middlename = test_input($_POST["middlename"]);
				$sex = test_input($_POST["gender"]);
				$dob = $_POST["dob"];
				$role = $_POST["role"];
		}

		$newdob = date("Y-m-d", strtotime($dob));

		$check = mysqli_query($conn, "SELECT * FROM staff WHERE email = '$email'");

		if (mysqli_num_rows($check) < 1) {

			$length = 6;
			$randomPassword = "";
			$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
			$max = count($characters) - 1;
			for ($i = 0; $i < $length; $i++) {
				$rand = mt_rand(0, $max);
				$randomPassword .= $characters[$rand];
				$password = md5($randomPassword);
			}

                    $receiver = $email;
                    $newpassword = $randomPassword;

                    $body = 'You have been added to the Hall7PROMiSYS with your email address - '.$receiver."\r\n".'Your password is '. $newpassword."\r\n".'Log in to www.hall7promisys.com.ng to continue';

                        $to = $email; //email
                        $subject = 'Staff Login';
                        $message = $body;

                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html\r\n";
                        $headers .= 'From: "HALL7PROMISYS" <info@hall7promisys.com.ng>';

                        $sentmail = mail($to, $subject, $message, $headers);


				    if ($sentmail) {



				    	$add = "INSERT INTO staff (email, password, lastname, firstname, middlename, sex, dob, role_id) VALUES ('$email', '$password', '$lastname', '$firstname', '$middlename', '$sex', '$newdob', '$role')";

						$added = mysqli_query($conn, $add) or die(mysqli_error($conn)); /**/

						header("location: ../staff?added");
				    }

					else {
							header("location: ../staff?failed");
					}
		}

		else {

				header("location: ../staff?exists");
		}

}


//CHANGE STAFF ROLE
if(isset($_POST['changerole'])) {

	$staffid = $_SESSION['changeroleid'];

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$newrole = test_input($_POST["staffrole"]);
}

				$check = mysqli_query($conn, "SELECT * FROM staff WHERE id = '$staffid'");

				if (mysqli_num_rows($check) > 0) {

						$edit = "UPDATE staff set role_id = '$newrole' WHERE id = '$staffid'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));

						if ($edited) {
								header("location: ../staff?rolechanged");
						}
						else {
								header("location: ../staff?failed");
						}
				}

				else {
						header("location: ../staff?failed");
				}
}

//ADD STAFF IMAGE ONLY
if(isset($_POST['addpic'])) {

	$staffid = $_SESSION['staffid'];

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
				   $newname="../photos"."/".$photo;
				   $copied = copy($_FILES['file']['tmp_name'], $newname);

				   $check = mysqli_query($conn, "SELECT * FROM staff WHERE id = '$staffid'");

				   if ($check) {

						   $update = "UPDATE staff set pic = '$photo' WHERE id = '$staffid'";
						   $updated = mysqli_query($conn, $update) or die(mysqli_error($conn));

						   if ($update) {
							   $edited = "edited";
							   $_SESSION['edited'] = $edited;
							   header("location: ../viewstaff?details=".$staffid);
							   //echo "Newname is ".$newname;
						   }
						   else {
							   $Failed = "Failed";
							   $_SESSION['Failed'] = $Failed;
							   header("location: ../viewstaff?details=".$staffid);
						   }
				   }

				   else {
							   $Failed = "Failed";
							   $_SESSION['Failed'] = $Failed;
							   header("location: ../viewstaff?details=".$staffid);
				   }

	   }
	   else {

	   }
   }

//===========================================================================================================================================>


//ADD STAFF MODAL

if(isset($_GET['addstaff'])) {
?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Staff</h4>
					</div>
					<div class="modal-body">

														<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
															  <div class="form-group">
																	  <div class="col-md-12 col-xs-12">
																			<input type="email" class="form-control" placeholder="Staff Email - (Eg. johndoe@hall7projects.com)" name = "email" pattern="^([\w-]+(?:\.[\w-]+)*)@hall7projects.com" required>

										<!--									<input type="email" class="form-control" placeholder="Staff Email - (Eg. johndoe@hall7projects.com)" name = "email" required>-->
																	  </div>
																<div style="clear: both;"></div>
															  </div>

															  <div class="form-group">
																	<div class="col-md-4 col-xs-12">
																			<input type="text" class="form-control" placeholder="Lastname" name = "lastname" required>
																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-4 col-xs-12">
																			<input type="text" class="form-control" placeholder="Firstname" name = "firstname" required>
																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-4 col-xs-12">
																			<input type="text" class="form-control" placeholder="Middlename" name = "middlename" >
																			<div style="clear: both;">&nbsp;</div>
																	</div>

															  </div>

															  <div class="form-group">
																	<div class="col-md-4 col-xs-12">
																		  <select class="form-control" placeholder="Gender" name="gender" required>
																				<option value="" selected>Gender</option>
																				<option value="Male">Male</option>
																				<option value="Female">Female</option>
																		  </select>
																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-4 col-xs-12">
																			  <div class="input-group date">
																				  <div class="input-group-addon">
																					<i class="fa fa-calendar"></i>
																				  </div>
																				  <input type="text" placeholder="Date of Birth" class="form-control pull-right" id="datepicker" name="dob" required>
																			  </div>

																			<div style="clear: both;">&nbsp;</div>
																	</div>

																	<div class="col-md-4 col-xs-12">
																			<select class="form-control" placeholder="Staff Role" name="role" required>
																				<option value="" selected>Staff Role</option>
																				<?php
																					$role = mysqli_query($conn, "SELECT * FROM role where id > 1 order by id asc");
																					while($row = mysqli_fetch_object($role))
																					{
																					echo '<option value="'.$row->id.'">'.$row->role.'</option>';
																					}
																				?>
																			</select>
																			<div style="clear: both;">&nbsp;</div>
																	</div>
															  </div>


															<div>
															  <button type="submit" name= "addstaff" class="btn btn-default btn-flat btn-block ">Submit</button>
															</div>

												</form>
					</div>
<?php
}


//VIEW PHOTO MODAL
/*
if(isset($_GET['addstaff'])) {	
	?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Staff</h4>
					</div>
					<div class="modal-body">


					</div>
	<?php
}
*/


// CHANGE ROLE MODAL
if(isset($_GET['changerole'])) {

		$staffid = $_GET['changerole'];
		$staff = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = '$staffid'"));

		$fullname = $staff->lastname.' '.$staff->firstname.' '.$staff->middlename;
		$sex = strtolower($staff->sex);
		$status = (int)($staff->status);

		$role = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM role WHERE id = '$staff->role_id'"));

			if ($sex == "male") {
				$sexcolor = "blue";
			} else {
				$sexcolor = "#CF4191";
			}

			$_SESSION['changeroleid'] =  $staffid;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Change Role</h4>
</div>
    <script>
      $(document).on("click", ".modal-body", function () {
       $("#datepicker").datepicker({
         dateFormat: 'yy-mm-dd'
         });
          });
    </script>
<div class="modal-body">

			<table id="myTable" class="table " >
					<tr><th width=30%>Staff Email</th> <td><?php echo $staff->email; ?></td> </tr>
					<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>
					<tr><th width=30%>Sex</th> <td><?php echo $sex; ?></td> </tr>
					<tr><th width=30%>Birthdate</th> <td><?php echo $staff->dob; ?></td> </tr>
					<tr><th width=30%>Role</th> <td><?php echo $role->role; ?></td> </tr>

			</table>

			<hr/>

			<form  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="assign_form">
				<div class="col-md-4 col-xs-12">
					<h4>Change Role <i class="fa fa-hand-o-right" aria-hidden="true"></i></h4>
				</div>

				<div class="form-group col-md-6 col-xs-12">
					<select class="form-control" name="staffrole" data-placeholder="Staff Role" required>
							<!--<option value="" selected>Staff Role</option>-->
						<?php
							$role = mysqli_query($conn, "SELECT * FROM role where id > 1 order by id asc");
							while($row = mysqli_fetch_object($role))
							{
							echo '<option value="'.$row->id.'">'.$row->role.'</option>';
							}
						?>
					</select>

				</div>


				<div class="col-md-2 col-xs-12 pull-right">
					<button type="submit" name= "changerole" id="changerole" class="form-control btn btn-default"><i class="ace-icon fa fa-floppy-o"></i></button>
				</div>

				<div style="clear: both;"></div>
			</form>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
              </div>

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
</script>
