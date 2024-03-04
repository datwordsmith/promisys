<?php
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();


$projectid = '';

//ADD PROJECT SCRIPT
if(isset($_POST['addproject'])) {

	function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			return $data;
	}

	function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	} 

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$projectname = test_input($_POST["projectname"]);
			$projectcode = strtolower(test_input($_POST["projectcode"]));
			$projectstate = test_input($_POST["projectstate"]);
			$description = ($_POST["description"]);
			if(!isset($_FILES['file']) || $_FILES['file']['error'] == UPLOAD_ERR_NO_FILE) {

			} else {
				$image=$_FILES['file']['name'];
			}			
	}
	global $image;

	if ($image) {
		$filename = stripslashes($_FILES['file']['name']);
	  	$extension = getExtension($filename);				

			$photo = date("ymdHis").$_FILES['file']['name'];
				$newname="../images"."/".$photo;
				$copied = copy($_FILES['file']['tmp_name'], $newname);
				
				$check = mysqli_query($conn, "SELECT * FROM project WHERE name = '$projectname'");

				if (mysqli_num_rows($check) < 1) {

					$checkcode = mysqli_query($conn, "SELECT * FROM project WHERE code = '$projectcode'");
					
					if (mysqli_num_rows($checkcode) < 1) {

						// sql to create table
						$codetable = "CREATE TABLE $projectcode (
						id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						client_property_id int(10) NOT NULL
						)";
						$codetablecheck = mysqli_query($conn, $codetable) or die(mysqli_error($conn));	
						
						if ($codetablecheck) {

							$add = "INSERT INTO project (name, state, description, logo, code) VALUES ('$projectname', '$projectstate', '$description', '$photo', '$projectcode')";
							$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
													
							if ($added) {								
									header("location: ../projects?added");																	
							}
							else {
									header("location: ../projects?failed");			
							}
						}
						else {
								header("location: ../projects?failed");			
						}						
					} 

					else {
						header("location: ../projects?codeexists");
					}
				}
			
				else {
						header("location: ../projects?exists");		
				}

	} else {

				$check = mysqli_query($conn, "SELECT * FROM project WHERE name = '$projectname'");

				if (mysqli_num_rows($check) < 1) {

						$checkcode = mysqli_query($conn, "SELECT * FROM project WHERE code = '$projectcode'");

						if (mysqli_num_rows($checkcode) < 1) { 

							// sql to create table
							$codetable = "CREATE TABLE $projectcode(
							id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
							client_property_id int(10) NOT NULL
							)";
							$codetablecheck = mysqli_query($conn, $codetable) or die(mysqli_error($conn));

							if ($codetablecheck) {
								$add = "INSERT INTO project (name, state, description, logo, code) VALUES ('$projectname', '$projectstate', '$description', '$photo', '$projectcode')";
								$added = mysqli_query($conn, $add) or die(mysqli_error($conn));

								if ($added) {								
										header("location: ../projects?added");							
								}
								else {
										header("location: ../projects?failed");			
								}													
							}
							else {
									header("location: ../projects?failed");			
							}	
						} else {

							header("location: ../projects?codeexists");	
						}
				}
			
				else {
						header("location: ../projects?exists");		
				}

	}


}


//ADD PROJECT IMAGE ONLY
if(isset($_POST['addimage'])) {

 $projectid = $_SESSION['projectid'];

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
				$newname="../images"."/".$photo;
				$copied = copy($_FILES['file']['tmp_name'], $newname);
				
				$check = mysqli_query($conn, "SELECT * FROM project WHERE id = '$projectid'");

				if ($check) {
				
						$update = "UPDATE project set logo = '$photo' WHERE id = '$projectid'";
						$updated = mysqli_query($conn, $update) or die(mysqli_error($conn));
												
						if ($update) {								
							$projectUpdated = "projectUpdated";
							$_SESSION['projectUpdated'] = $projectUpdated;
							header("location: ../viewproject?details=".$projectid);																	
						}
						else {
							$Failed = "Failed";
							$_SESSION['Failed'] = $Failed;
							header("location: ../viewproject?details=".$projectid);	
						}
				}
			
				else {
							$Failed = "Failed";
							$_SESSION['Failed'] = $Failed;
							header("location: ../viewproject?details=".$projectid);	
				}

	} 
	else {

	}
}


//EDIT PROJECT SCRIPT
if(isset($_POST['editproject'])) {

	$editid = $_SESSION['editid'];

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$projectname = test_input($_POST["projectname"]);
		$projectstate = test_input($_POST["projectstate"]);
		$description = ($_POST["description"]);
}

				$check = mysqli_query($conn, "SELECT * FROM project WHERE id = '$editid'");

				if (mysqli_num_rows($check) > 0) {
				
						$edit = "UPDATE project set name = '$projectname', state = '$projectstate', description = '$description' WHERE id = '$editid'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));
												
						if ($edited) {								
								header("location: ../projects?edited");																	
						}
						else {
								header("location: ../projects?failed");			
						}
				}
			
				else {
						header("location: ../projects?failed");		
				}
}


//ASSIGN PROPERTY SCRIPT
if(isset($_POST['assignproperty'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$propertytype = test_input($_POST["propertytype"]);
		$quantity = test_input($_POST["quantity"]);
		//$amount = test_input($_POST["amount"]);
}
		$projectid = $_SESSION['assignid'];
		
				$check = mysqli_query($conn, "SELECT * FROM project_property WHERE project_id = $projectid and property_type = '$propertytype'");				

				if (mysqli_num_rows($check) < 1) {
				
						$add = "INSERT INTO project_property (project_id, property_type, quantity) VALUES ('$projectid', '$propertytype', '$quantity')";
						$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
												
						if ($added) {								

							$propertyAdded = "propertyAdded";
							$_SESSION['propertyAdded'] = $propertyAdded;
							header("location: ../viewproject?details=".$projectid) ;																	
						}
						else {

							$Failed = "Failed";
							$_SESSION['Failed'] = $Failed;
							header("location: ../viewproject?details=".$projectid);											
						}
				}
			
				else {
						/*$edit = "UPDATE property set type_id = '$propertytype', quantity = '$quantity' WHERE project_id = '$projectid' and type_id = '$propertytype'";
						$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));*/

						$propertyExists = "propertyExists";
						$_SESSION['propertyExists'] = $propertyExists;
						header("location: ../viewproject?details=".$propertyExists);							
				}		

}


//EDIT PRICE SCRIPT
if(isset($_POST['editprice'])) {

function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		return $data;
}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$amount = test_input($_POST["amount"]);
	}


		$propertyId = $_SESSION['editPropertyId'];
		$projectid = $_SESSION['projectid'];
		
		//$edit = "UPDATE property set amount = '$amount' WHERE project_id = '$projectid' and type_id = '$type_id'";		
		$edit = "UPDATE property set amount = '$amount' WHERE id = '$propertyId'";
		$edited = mysqli_query($conn, $edit) or die(mysqli_error($conn));						

		if ($edited) {
			$propertyEdited = "propertyEdited";
			$_SESSION['propertyEdited'] = $propertyEdited;
			header("location: ../viewproject?details=".$projectid);	
		}
		else {
			$Failed = "Failed";
			$_SESSION['Failed'] = $Failed;
			header("location: ../viewproject?details=".$projectid);	
		}					

}


//DELETE PROJECT SCRIPT
if(isset($_POST['deleteproject'])) {

		$projectid = $_SESSION['deleteid'];

		$getpjcode = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project where id = $projectid"));
		$projectCode = $getpjcode->code;
						
		$droptable = mysqli_query($conn, "DROP TABLE IF EXISTS $projectCode") or die(mysql_error());

		if ($droptable) {
			$delete = mysqli_query($conn, "DELETE FROM project WHERE id = $projectid");
									
			if ($delete) {								
					header("location: ../projects?deleted");																	
			}
			else {
					header("location: ../projects?failed");			
			}				
		} else {
			header("location: ../projects?failed");
		}


}

//UNASSIGN PROPERTY SCRIPT
if(isset($_GET['unassignproject'])) {

		$projectid = $_SESSION['projectid'];
		$propertyId = $_SESSION['unassignproject'];

						$delete = mysqli_query($conn, "DELETE FROM project_property WHERE id = $propertyId");
												
						if ($delete) {	

							$propertyDeleted = "propertyDeleted";
							$_SESSION['propertyDeleted'] = $propertyDeleted;
							header("location: ../viewproject?details=".$projectid);																							
						}
						else {

							$Failed = "Failed";
							$_SESSION['Failed'] = $Failed;
							header("location: ../viewproject?details=".$projectid);		
							
						}

}

//===========================================================================================================================================>


//ADD PROJECT MODAL

if(isset($_GET['addproject'])) {	
?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Project</h4>
					</div>
					<div class="modal-body">

								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
									<div class="form-group col-md-8 col-xs-12">
										<input type="text" class="form-control" placeholder="Project Name" name = "projectname" value="" required>
									</div>

									<div class="form-group col-md-4 col-xs-12">
										<select class="form-control" name="projectstate" data-placeholder="Project Location" required>
												<option value="" selected>Project Location</option>												
											<?php
												$state = mysqli_query($conn, "SELECT * FROM state order by id asc");
												while($row = mysqli_fetch_object($state))
												{ 
												echo '<option value="'.$row->state.'">'.$row->state.'</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group col-md-8 col-xs-12">
										Upload Project Logo (.png, .jpg)
										<input type="file" class="form-control pull-right" placeholder="Project Name" name="file"  id="my_file" > 
										<div style="clear: both;"></div>	
									</div>

									<div class="form-group col-md-4 col-xs-12">
										&nbsp;
										<input type="text" class="form-control" placeholder="Project Code" name = "projectcode" value="" pattern="[A-Z]{3}" required>
									</div>

									<div class="form-group col-md-12 col-xs-12">
									  <textarea class="form-control" rows="3" name="description" placeholder="Project Description" ></textarea>
									</div>

										<div>
										  <button type="submit" name= "addproject" id="img_upload" class="btn btn-default btn-block btn-flat">Submit</button>
										</div>

								</form>	
					</div>
<?php
}



// EDIT PROJECT	MODAL
if(isset($_GET['editproject'])) {	
$projectid = $_GET["editproject"]; //escape the string if you like
									
			$project = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project where id = $projectid"));
			$editid = $project->id;
			$_SESSION['editid'] =  $editid;
			
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Project - <?php echo $project->name; ?></h4>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">

									
									  <div class="form-group">
										<input type="text" class="form-control" placeholder="Project Name" name = "projectname" value="<?php echo $project->name; ?>" required>
									  </div>

									<div class="form-group">
										<select class="form-control" name="projectstate" data-placeholder="Select Project Location" required>
												<option value="" selected>Select Project Location</option>												
											<?php
												$state = mysqli_query($conn, "SELECT * FROM state order by id asc");
												while($row = mysqli_fetch_object($state))
												{ 
												echo '<option value="'.$row->state.'">'.$row->state.'</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group">
									  <textarea class="form-control" rows="3" name="description" placeholder="Project Description" ><?php echo $project->description; ?></textarea>
									</div>
</div>
              <div class="modal-footer">
				<button type="button" class="btn btn-outline " data-dismiss="modal">Close</button>
                <button type="submit" name= "editproject" class="btn btn-info btn-outline pull-left"><i class="ace-icon fa fa-floppy-o"></i> Save</button>
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
					<tr><th width=30%>Project</th> <td><?php echo $project->name; ?></td> </tr>
					<tr><th width=30%>Location</th> <td><?php echo $project->state; ?></td> </tr>
					<tr><th width=30%>Description</th> <td><?php echo $project->description; ?></td> </tr>
			</table>


								 
											<?php
													
													$all = mysqli_query($conn,  "SELECT * FROM property where project_id = $projectid");
													while($properties = mysqli_fetch_object($all))														
													{		
															$typeId = $properties->type_id;
															$quantity = $properties->quantity;
															
															$pty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property_type where id = $typeId"));
															
															$sold = mysqli_query($conn,  "SELECT SUM(quantity) AS qtysold FROM client_property where project_id = $projectid and property_id = $typeId");

															if (mysqli_num_rows($sold)>0) {
																$getqty = mysqli_fetch_object($sold);
																$qtysold = $getqty->qtysold;
																if ($qtysold == ""){
																	$qtysold = 0;
																} else {
																	$balance = ($quantity - $qtysold);
																}
																
															} else {
																$qtysold = 0;
																$balance = ($quantity - $qtysold);
															}
															
															$percent = ($qtysold/$quantity)*100;
															
															echo '	

																			  <div class="progress-group">
																				<span class="progress-text">'.$pty->propertytype.'</span>
																				<span class="progress-number"><b>Sold: '.$qtysold.'</b> out of '.$quantity.'</span>

																				<div class="progress sm">
																				  <div class="progress-bar progress-bar-red" style="width: '.$percent.'%"></div>
																				</div>
																			  </div>';
														}
													
											?>

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

<div id="assign" class="modal-body">

									<form  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="assign_form">
										<div class="form-group">
											<table id="myTable" class="table " >
													<thead><tr><th width=80%>Property Type</th>  <!--<th>Unit Cost (<?php echo $sign; ?>)</th>--> <th>Quantity</th> <th></th></tr> </thead>
													<tr>														
														<td>
															<!--<select class="form-control" name="propertytype" id ="propertytype" data-placeholder="Select Property Type" required>
																	<option value="" selected>Select Property Type</option>												
																<?php
																	$propertytype = mysqli_query($conn, "SELECT * FROM property_type where id not in (select type_id from property where project_id = '$projectid')order by propertytype");
																	while($row = mysqli_fetch_object($propertytype))
																	{ 
																	echo '<option value="'.$row->id.'">'.$row->propertytype.'</option>';
																	}
																?>
															</select>-->
															<input type="text" class="form-control" placeholder="Property Type" name = "propertytype" id="" value="" required>													
														</td>
														<!--<td width=40%><input type="number" class="form-control" min="100000" placeholder="Unit Cost" name = "amount" id="amount" value="" required></td>-->
														<td width=20%><input type="number" class="form-control" min="1" placeholder="Units" name = "quantity" id="quantity" value="" required></td>
														<td><button onclick="submitAssignForm()" type="submit" name= "assignproperty" class="btn btn-info btn-outline pull-right form-control"><i class="ace-icon fa fa-floppy-o"></i></button></td>
													</tr>
											</table>											
										</div>
									</form>	

							<table id="myTable" class="table" >
										<thead><tr><th width=65%>Property Type</th> <!--<th>Unit Cost (<?php echo $sign; ?>)</th>--> <th>Quantity</th> <th>Available</th> <th></th> </tr> </thead>  
										
										<tbody>  
											<?php
													
													$all = mysqli_query($conn,  "SELECT * FROM project_property where project_id = '$assignid'");
													while($properties = mysqli_fetch_object($all))														
													{	
															$propertyId = $properties->id;
															$property_type = $properties->property_type;
															$quantity = $properties->quantity;
															
															//PROPERTY COUNT
															$getpptcount = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property where project_id = $assignid and id = $propertyId"));
															$propertyCount = $getpptcount->quantity;
															$propertyCount = (int)$propertyCount;
															
															//QUANTITY SOLD
															$getpptsold = mysqli_fetch_object(mysqli_query($conn, "SELECT SUM(quantity) AS propertySold FROM client_property where project_id = $assignid and property_id = $propertyId"));
															$propertySold = $getpptsold->propertySold;
															$propertySold = (int)$propertySold;
															
															//CHECK DIFFERENCE

															$balance = ($propertyCount - $propertySold);
															$balance = (int)$balance;
															//echo "Balance is ".$balance;
												
															$pty = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project_property where id = '$propertyId'"));
															
															echo '	
																<tr>
																		<td>'.$pty->property_type.'</td> 																																
																		
																		<td>'.$quantity.' Units</td>
																		<td>';
																			if ($balance == 0) {
																				echo '
																					<span class="btn btn-xs btn-warning">SOLD OUT</span>
																				';
																			} 
																			elseif ($balance <= $quantity) {
																				echo $balance.' units';
																			} 																			
																		echo '
																		</td>
																		
																		<td>';
																			if ($balance == $quantity) {
																				echo '
																				<center>
																					<a href="viewproject?delete='.$propertyId.'" class="btn btn-xs btn-danger" ><i class="ace-icon fa fa-times"></i></a>
																				</center>
																				';
																			} 
																			elseif ($balance <= $quantity) {
																				echo '
																				<center>
																					<a href="#" class="btn btn-xs btn-danger" disabled><i class="ace-icon fa fa-times"></i></a>
																				</center>
																				';
																			} 
																			else {
																				echo '
																				<center>
																					<a href="viewproject?delete='.$propertyId.'" class="btn btn-xs btn-danger" disabled><i class="ace-icon fa fa-times"></i></a>
																				</center>
																				';
																			}
																		echo '
																		</td>
																
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


// EDIT PRICE MODAL
if(isset($_GET['editprice'])) {	
$propertyId = $_GET["editprice"]; //escape the string if you like

$_SESSION['editPropertyId'] = $propertyId;

//echo $propertyId;

		$property = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property where id = $propertyId"));
		$project = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project where id = $property->project_id"));
		$gettype = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM property_type where id = $property->type_id"));


?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Property Price</h4>
</div>

<div id="assign" class="modal-body">
<span style="font-size: 18px; ">
	<?php echo $project->name.' - '.$gettype->propertytype;?>
</span>
									<form  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="assign_form">
										<div class="form-group">
											<table id="myTable" class="table " >
													<thead><tr><th width=45%><center>Current Price</center></th>  <th width=45%><center>New Price (<?php echo $sign; ?>)</center></th> <th></th></tr> 
													</thead>
													<tr>														
														<td>
															<input type="text" class="form-control" style="text-align: right;" value="<?php echo $sign.$property->amount; ?>" disabled>
														</td>
														<td width=40%><input type="number" class="form-control" min="100000" placeholder="New Price" name = "amount" id="amount" value="" required></td>

														<td><button type="submit" name= "editprice" class="btn btn-info btn-outline pull-right form-control"><i class="ace-icon fa fa-floppy-o"></i></button></td>
													</tr>
											</table>											
										</div>
									</form>	

</div>
              <div class="modal-footer">
				<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>                
              </div>


<?php
}


// DELETE PROJECT MODAL
if(isset($_GET['deleteproject'])) {	
$projectid = $_GET["deleteproject"]; //escape the string if you like
				
			$project = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM project WHERE id = $projectid"));

			$deleteid = $project->id;
			$projectname = $project->name;
			$_SESSION['deleteid'] =  $deleteid;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $projectname; ?></h4>
</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">
	
		<p>Are you sure you want to delete <?php echo $projectname; ?>?</p>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "deleteproject" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Delete</span></button>
              </div>
</form>
<?php
}
?>

<script type="text/javascript">

	$('#img_upload').click(function(){
      var file = $('input[type=file]#my_file').val();
      var exts = ['png','jpg','jpeg'];//extensions
      //the file has any value?
      if ( file ) {
        // split file name at dot
        var get_ext = file.split('.');
        // reverse name to check extension
        get_ext = get_ext.reverse();
        // check file type is valid as given in 'exts' array
        if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
          
        } else {
          alert( 'Invalid file type!' );
		  return false;
        }
      }
    });
</script>