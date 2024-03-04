<?php
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();


//ADD PROPERTY TYPE SCRIPT
if(isset($_POST['addinvestmentcategory'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$investmentcategory = test_input($_POST["investmentcategory"]);
		$description = ($_POST["description"]);
}


				$check = mysqli_query($conn, "SELECT * FROM investment_category WHERE category = '$investmentcategory'");

				if (mysqli_num_rows($check) < 1) {
				
						$add = "INSERT INTO investment_category (category, description) VALUES ('$investmentcategory', '$description')";
						$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
												
						if ($added) {								
								header("location: ../investmentcategories?added");																	
						}
						else {
								header("location: ../investmentcategories?failed");			
						}
				}
			
				else {
						header("location: ../investmentcategories?exists");		
				}
}


// EDIT PROPERTY TYPE SCRIPT
if(isset($_POST['editinvestmentcategory'])) {

	$editid = $_SESSION['editid'];

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$investmentcategory = test_input($_POST["investmentcategory"]);
		$description = $_POST["description"];
}

			

				$check = mysqli_query($conn, "SELECT * FROM property_type WHERE id = '$editid'");

				if (mysqli_num_rows($check) > 0) {
				
						$edit = "UPDATE investment_category set category = '$investmentcategory', description = '$description' WHERE id = '$editid'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
												
						if ($edited) {								
								header("location: ../investmentcategories?edited");																	
						}
						else {
								header("location: ../investmentcategories?failed");			
						}
				}
			
				else {
						header("location: ../investmentcategories?failed");		
				}
}

//DELETE PROPERTY TYPE SCRIPT
if(isset($_POST['deleteinvestmentcategory'])) {

		$investmentcategoryid = $_SESSION['deleteid'];
					
						$delete = mysqli_query($conn, "DELETE FROM investment_category WHERE id = $investmentcategoryid");
												
						if ($delete) {								
								header("location: ../investmentcategories?deleted");																	
						}
						else {
								header("location: ../investmentcategories?failed");			
						}

}


//==================================================================================================================================

//ADD INVESTMENT CATEGORY MODAL
if(isset($_GET['addinvestmentcategory'])) {	
?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Investment Category</h4>
					</div>
					<div class="modal-body">

						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							  <div class="form-group">
								<input type="text" class="form-control" placeholder="Investment Category" name = "investmentcategory" required>
							  </div>

							<div class="form-group">
							  <textarea class="form-control" rows="3" name="description" placeholder="Description" ></textarea>
							</div>

							<div>
							  <button type="submit" name= "addinvestmentcategory" class="btn btn-default btn-block btn-flat">Submit</button>
							</div>

						</form>
					</div>
<?php
}


// EDIT INVESTMENT CATEGORY MODAL
if(isset($_GET['editinvestmentcategory'])) {	
$investmentcategoryid = $_GET["editinvestmentcategory"]; //escape the string if you like
				
			$investmentcategory = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM investment_category where id = $investmentcategoryid"));
			$editid = $investmentcategory->id;
			$_SESSION['editid'] =  $editid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Investment Category - <?php echo $investmentcategory->category; ?></h4>
</div>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
<div class="modal-body">

									
									  <div class="form-group">
										<input type="text" class="form-control" placeholder="Investment Category" name = "investmentcategory" value="<?php echo $investmentcategory->category; ?>" required>
									  </div>

									<div class="form-group">
									  <textarea class="form-control" rows="3" name="description" placeholder="Description" ><?php echo $investmentcategory->description; ?></textarea>
									</div>
</div>
              <div class="modal-footer">
				<button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>
                <button type="submit" name= "editinvestmentcategory" class="btn btn-info btn-outline pull-left"><i class="ace-icon fa fa-floppy-o"></i> Save</button>
              </div>
</form>	
<?php
}


// DELETE INVESTMENT CATEGORY MODAL
if(isset($_GET['deleteinvestmentcategory'])) {	
$investmentcategoryid = $_GET["deleteinvestmentcategory"]; //escape the string if you like
				
			$category = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM investment_category WHERE id = $investmentcategoryid"));

			$deleteid = $category->id;
			$investmentcategory = $category->category;
			$_SESSION['deleteid'] =  $deleteid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $investmentcategory; ?></h4>
</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">
	
		<p>Are you sure you want to delete <?php echo $investmentcategory; ?>?</p>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "deleteinvestmentcategory" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Delete</span></button>
              </div>
</form>
<?php
}
?>