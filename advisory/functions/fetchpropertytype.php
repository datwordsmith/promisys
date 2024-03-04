<?php
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();


//ADD PROPERTY TYPE SCRIPT
if(isset($_POST['addpropertytype'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$propertytype = test_input($_POST["propertytype"]);
		$description = ($_POST["description"]);
}


				$check = mysqli_query($conn, "SELECT * FROM property_type WHERE propertytype = '$propertytype'");

				if (mysqli_num_rows($check) < 1) {
				
						$add = "INSERT INTO property_type (propertytype, description) VALUES ('$propertytype', '$description')";
						$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
												
						if ($added) {								
								header("location: ../propertytypes?added");																	
						}
						else {
								header("location: ../propertytypes?failed");			
						}
				}
			
				else {
						header("location: ../propertytypes?exists");		
				}
}


// EDIT PROPERTY TYPE SCRIPT
if(isset($_POST['editpropertytype'])) {

	$editid = $_SESSION['editid'];

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$propertytype = test_input($_POST["propertytype"]);
		$description = $_POST["description"];
}

			

				$check = mysqli_query($conn, "SELECT * FROM property_type WHERE id = '$editid'");

				if (mysqli_num_rows($check) > 0) {
				
						$edit = "UPDATE property_type set propertytype = '$propertytype', description = '$description' WHERE id = '$editid'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
												
						if ($edited) {								
								header("location: ../propertytypes?edited");																	
						}
						else {
								header("location: ../propertytypes?failed");			
						}
				}
			
				else {
						header("location: ../propertytypes?failed");		
				}
}

//DELETE PROPERTY TYPE SCRIPT
if(isset($_POST['deleteproperty'])) {

		$propertytypeid = $_SESSION['deleteid'];
					
						$delete = mysqli_query($conn, "DELETE FROM property_type WHERE id = $propertytypeid");
												
						if ($delete) {								
								header("location: ../propertytypes?deleted");																	
						}
						else {
								header("location: ../propertytypes?failed");			
						}

}


//==================================================================================================================================

//ADD PROPERTY TYPE MODAL
if(isset($_GET['addproperty'])) {	
?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Property Type</h4>
					</div>
					<div class="modal-body">

						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							  <div class="form-group">
								<input type="text" class="form-control" placeholder="Property Type" name = "propertytype" required>
							  </div>

							<div class="form-group">
							  <textarea class="form-control" rows="3" name="description" placeholder="Description" ></textarea>
							</div>

							<div>
							  <button type="submit" name= "addpropertytype" class="btn btn-default btn-block btn-flat">Submit</button>
							</div>

						</form>
					</div>
<?php
}


// EDIT PROPERTY TYPE MODAL
if(isset($_GET['editproperty'])) {	
$propertytypeid = $_GET["editproperty"]; //escape the string if you like
				
			$propertytype = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property_type where id = $propertytypeid"));
			$editid = $propertytype->id;
			$_SESSION['editid'] =  $editid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Property Type - <?php echo $propertytype->propertytype; ?></h4>
</div>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
<div class="modal-body">

									
									  <div class="form-group">
										<input type="text" class="form-control" placeholder="Property Type" name = "propertytype" value="<?php echo $propertytype->propertytype; ?>" required>
									  </div>

									<div class="form-group">
									  <textarea class="form-control" rows="3" name="description" placeholder="Project Description" ><?php echo $propertytype->description; ?></textarea>
									</div>
</div>
              <div class="modal-footer">
				<button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>
                <button type="submit" name= "editpropertytype" class="btn btn-info btn-outline pull-left"><i class="ace-icon fa fa-floppy-o"></i> Save</button>
              </div>
</form>	

<?php
}

// VIEW PROJECT MODAL
if(isset($_GET['viewproject'])) {	
$projectid = $_GET["viewproject"]; //escape the string if you like
				
			$project = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project WHERE id = $projectid"));

			$viewid = $project->id;
			//$_SESSION['editid'] =  $editid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Project Details</h4>
</div>
<div class="modal-body">

			<table id="myTable" class="table " >
					<tr><th width=30%>Project Name</th> <td><?php echo $project->name; ?></td> </tr>
					<tr><th width=30%>Project Location</th> <td><?php echo $project->state; ?></td> </tr>
					<tr><th width=30%>Description</th> <td><?php echo $project->description; ?></td> </tr>
			</table>


							<table id="myTable" class="table table-bordered table-responsive" >
										<thead><tr><th width=70%>Property Types</th> <th>Quantity</th> </tr> </thead>  
										
										</tbody>  
											<?php
													
													$all = mysqli_query($conn,  "SELECT * FROM property where project_id = $projectid");
													while($properties = mysqli_fetch_object($all))														
													{		
															$typeId = $properties->type_id;
															$pty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property_type where id = $typeId"));
															echo '	
																<tr>
																		<td>'.$pty->propertytype.'</td> 																																
																		<td>'.$properties->quantity.' Units</td>
																		
																</tr>';
														}
													
											?>
									</tbody>  
							</table>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
              </div>

<?php
}



// ASSIGN PROJECT MODAL
if(isset($_GET['assignproject'])) {	
$projectid = $_GET["assignproject"]; //escape the string if you like
									
			$project = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project where id = $projectid"));
			$assignid = $project->id;
			$_SESSION['assignid'] =  $assignid;

			$GLOBALS['project_name'] = $project->name;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Assign Properties to <?php echo $project_name; ?></h4>
</div>

<div class="modal-body">

									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
										<div class="form-group">
											<table id="myTable" class="table " >
													<thead><tr><th width=70%>Property Type</th> <th>Quantity</th> <th></th></tr> </thead>
													<tr>														
														<td>
															<select class="form-control" name="propertytype" data-placeholder="Select Property Type" required>
																	<option value="" selected>Select Property Type</option>												
																<?php
																	$propertytype = mysqli_query($conn, "SELECT * FROM property_type order by propertytype");
																	while($row = mysqli_fetch_object($propertytype))
																	{ 
																	echo '<option value="'.$row->id.'">'.$row->propertytype.'</option>';
																	}
																?>
															</select>														
														</td>
														<td width=20%><input type="number" class="form-control" min="1" placeholder="Number" name = "quantity" value="" required></td>
														<td><button type="submit" name= "assignproperty" class="btn btn-info btn-outline pull-right"><i class="ace-icon fa fa-floppy-o"></i></button></td>
													</tr>
											</table>											
										</div>
									</form>	

							<table id="myTable" class="table" >
										<thead><tr><th width=70%>Property Type</th> <th>Quantity</th> <th></th></tr> </thead>  
										
										</tbody>  
											<?php
													
													$all = mysqli_query($conn,  "SELECT * FROM property where project_id = '$assignid'");
													while($properties = mysqli_fetch_object($all))														
													{		
															$typeId = $properties->type_id;
															$pty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property_type where id = '$typeId'"));
															echo '	
																<tr>
																		<td>'.$pty->propertytype.'</td> 																																
																		<td>'.$properties->quantity.' Units</td>
																		
																		<td></td>
																</tr>';
														}
													
											?>
									</tbody>  
							</table>

</div>
              <div class="modal-footer">
				<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>                
              </div>


<?php
}

// DELETE PROPERTY MODAL
if(isset($_GET['deleteproperty'])) {	
$propertytypeid = $_GET["deleteproperty"]; //escape the string if you like
				
			$property = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property_type WHERE id = $propertytypeid"));

			$deleteid = $property->id;
			$propertytype = $property->propertytype;
			$_SESSION['deleteid'] =  $deleteid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $propertytype; ?></h4>
</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">
	
		<p>Are you sure you want to delete <?php echo $propertytype; ?>?</p>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "deleteproperty" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Delete</span></button>
              </div>
</form>
<?php
}
?>