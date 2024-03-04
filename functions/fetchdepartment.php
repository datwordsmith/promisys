<?php
	require_once ("../connector/connect.php");

	// re-create session
	session_start();


//ADD DEPARTMENT SCRIPT
if(isset($_POST['adddepartment'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$department = test_input($_POST["department"]);
		$hod_id = ($_POST["staff"]);
}

				$check = mysqli_query($conn, "SELECT * FROM departments WHERE department = '$department'");

				if (mysqli_num_rows($check) < 1) {

						$add = "INSERT INTO departments (department, hod) VALUES ('$department', '$hod_id')";
						$added = mysqli_query($conn, $add) or die(mysqli_error($conn));

						$getDept = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM departments WHERE hod = '$hod_id'"));
						$deptid = $getDept->id;

						if ($added) {
							$edit = "UPDATE staff set department_id = '$deptid' WHERE id = '$hod_id'";
							$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));							
							header("location: ../departments?added");
						}
						else {
								header("location: ../departments?failed");
						}
				}

				else {
						header("location: ../departments?exists");
				}
}


// EDIT DEPARTMENT SCRIPT
if(isset($_POST['editdepartment'])) {

	$editid = $_SESSION['editid'];

	function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			return $data;
	}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$hod_id = ($_POST["staff"]);

}

		$check = mysqli_query($conn, "SELECT * FROM departments WHERE id = '$editid'");

		if (mysqli_num_rows($check) > 0) {

				$edit = "UPDATE departments set hod = '$hod_id' WHERE id = '$editid'";
				$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));

				if ($edited) {
						header("location: ../departments?edited");
				}
				else {
						//header("location: ../departments?failed");
						echo "Fail Here";
				}
		}

		else {
				header("location: ../departments?failed");
		}
}

//DELETE DEPARTMENT SCRIPT
if(isset($_POST['deletedepartment'])) {

		$departmentid = $_SESSION['deleteid'];

		$delete = mysqli_query($conn, "DELETE FROM departments WHERE id = $departmentid");

		if ($delete) {
				header("location: ../departments?deleted");
		}
		else {
				header("location: ../departments?failed");
		}

}


//==================================================================================================================================

//ADD DEPARTMENT MODAL
if(isset($_GET['adddepartment'])) {
?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Department</h4>
					</div>
					<div class="modal-body">

						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							  <div class="form-group">
								<input type="text" class="form-control" placeholder="Department" name = "department" required>
							  </div>

							<div class="form-group">
									<select name="staff" id="staff" class="form-control" required>
										<option value="">Select Staff</option>
										<?php
										$stf = mysqli_query($conn,  "SELECT * FROM staff where status = 1 and role_id > 1 and department_id = 0 order by lastname");
										$staffCount = $stf->num_rows;
										if($staffCount > 0){
											while ($staff = mysqli_fetch_object($stf)){
												echo '<option value="'.$staff->id.'">'.$staff->lastname.' '.$staff->firstname.'</option>';
											}
										}else{
											echo '<option value=""></option>';
										}
										?>
									</select>
							</div>

							<div>
							  <button type="submit" name= "adddepartment" class="btn btn-default btn-block btn-flat">Submit</button>
							</div>

						</form>
					</div>
<?php
}


// EDIT DEPARTMENT MODAL
if(isset($_GET['editdepartment'])) {
$departmentid = $_GET["editdepartment"]; //escape the string if you like

			$department = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM departments where id = $departmentid"));
			$editid = $department->id;
			$_SESSION['editid'] =  $editid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Department - <?php echo $department->department; ?></h4>
</div>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
<div class="modal-body">

			<div class="form-group">
				<h4>Change Head of Department</h4>
			</div>

		<div class="form-group">
			<select name="staff" id="staff" class="form-control" required>
				<option value="">Select Staff</option>
				<?php
				$stf = mysqli_query($conn,  "SELECT * FROM staff where status = 1 and role_id > 1 and department_id = 0 order by lastname");
				$staffCount = $stf->num_rows;
				if($staffCount > 0){
					while ($staff = mysqli_fetch_object($stf)){
						echo '<option value="'.$staff->id.'">'.$staff->lastname.' '.$staff->firstname.'</option>';
					}
				}else{
					echo '<option value=""></option>';
				}
				?>
			</select>
		</div>

</div>
              <div class="modal-footer">
				<button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>
        <button type="submit" name= "editdepartment" class="btn btn-info btn-outline pull-left"><i class="ace-icon fa fa-floppy-o"></i> Save</button>
              </div>
</form>
<?php
}


// DELETE INVESTMENT CATEGORY MODAL
if(isset($_GET['deletedepartment'])) {
	$departmentid = $_GET["deletedepartment"]; //escape the string if you like

			$department = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM departments WHERE id = $departmentid"));

			$deleteid = $department->id;
			$department = $department->department;
			$_SESSION['deleteid'] =  $deleteid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $department; ?></h4>
</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">

		<p>Are you sure you want to delete <?php echo $department; ?>?</p>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "deletedepartment" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Delete</span></button>
              </div>
</form>
<?php
}
?>
