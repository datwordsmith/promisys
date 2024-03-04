<?php
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();

$projectid = '';

//ADD PROSPECT SCRIPT
if(isset($_POST['addprospect'])) {

		function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
				return $data;
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$email = test_input($_POST["email"]);
				$title = test_input($_POST["title"]);
				$lastname = test_input($_POST["lastname"]);
				$firstname = test_input($_POST["firstname"]);
				$middlename = test_input($_POST["middlename"]);
				$sex = test_input($_POST["gender"]);
				$dob = $_POST["dob"];
				$phone = test_input($_POST["phone"]);
				$mobile = test_input($_POST["mobile"]);
				$occupation = test_input($_POST["occupation"]);
				$address = $_POST["address"];
					
		}

		$newdob = date("Y-m-d", strtotime($dob));

		/**/$check = mysqli_query($conn, "SELECT * FROM prospects WHERE email = '$email'");				

		if (mysqli_num_rows($check) < 1) {
				
				$add = "INSERT INTO prospects (email, title, lastname, firstname, middlename, sex, dob, phone, mobile, occupation, address) VALUES ('$email', '$title', '$lastname', '$firstname', '$middlename', '$sex', '$newdob', '$phone', '$mobile', '$occupation', '$address')";
				$added = mysqli_query($conn, $add) or die(mysqli_error($conn));
										
				if ($added) {								
						header("location: ../prospects?added");																	
				}
				else {
						header("location: ../prospects?failed");			
				}
		}
	
		else {
				
				header("location: ../prospects?prospectexists");	
		}	
}

//===========================================================================================================================================>


//ADD CLIENT MODAL

if(isset($_GET['addprospect'])) {	
?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Prospect</h4>
		</div>
		<div class="modal-body">

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				  <div class="form-group">
						  <div class="col-md-12 col-xs-12">
								<input type="email" class="form-control" placeholder="Prospect Email" name = "email" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required>														
						  </div>
					<div style="clear: both;"></div>																											  
				  </div>

				  <div class="form-group">
						<div class="col-md-3 col-xs-12">										  
								<input type="text" class="form-control" placeholder="Title" name = "title" required>
								<div style="clear: both;">&nbsp;</div>														
						</div>		

						<div class="col-md-9 col-xs-12">
								<input type="text" class="form-control" placeholder="Lastname" name = "lastname" required>
								<div style="clear: both;">&nbsp;</div>																				
						</div>	
				  </div>

				  <div class="form-group">			
						<div class="col-md-6 col-xs-12">
								<input type="text" class="form-control" placeholder="Firstname" name = "firstname" required>
								<div style="clear: both;">&nbsp;</div>	
						</div>

						<div class="col-md-6 col-xs-12">
								<input type="text" class="form-control" placeholder="Middlename" name = "middlename" >
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
								<div style="clear: both;">&nbsp;</div>														  
						</div>		
						  
						<div class="col-md-6 col-xs-12">
								  <div class="input-group date">
									  <div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									  </div>
									  <input type="text" placeholder="Date of Birth" class="form-control pull-right" id="datepicker" name="dob" required>
								  </div>
								
								<div style="clear: both;">&nbsp;</div>														  
						</div>																	
				  </div>					  												

				  <div class="form-group">
						<div class="col-md-6 col-xs-12">										  
								<input type="text" class="form-control " placeholder="Telephone #1" name = "phone" required>
								<div style="clear: both;">&nbsp;</div>																
						</div>			

						<div class="col-md-6 col-xs-12">										  
								<input type="text" class="form-control" placeholder="Telephone #2" name = "mobile">
								<div style="clear: both;">&nbsp;</div>																	
						</div>																				
				  </div>


				  <div class="form-group">
						  <div class="col-md-12 col-xs-12">												  
								<input type="text" class="form-control col-md-6" placeholder="Occupation" name = "occupation" required>
								<div style="clear: both;">&nbsp;</div>															
						  </div>																
				  </div>
				  
				<div class="form-group">
						  <div class="col-md-12 col-xs-12">											
								<textarea class="form-control" rows="3" name="address" placeholder="Address" ></textarea>
						  </div>	
						<div style="clear: both;">&nbsp;</div>														  
				</div>

				<div>
				  <button type="submit" name= "addprospect" class="btn btn-default btn-flat btn-block ">Submit</button>
				</div>

			</form>
		</div>
<?php
}

// VIEW CLIENT MODAL
if(isset($_GET['viewprospect'])) {	
$prospectid = $_GET["viewprospect"]; //escape the string if you like
				
			$prospect = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospects WHERE id = '$prospectid'"));

			$viewid = $prospect->id;
			//$_SESSION['editid'] =  $editid;
			
			$fullname = $prospect->lastname.' '.$prospect->firstname.' '.$prospect->middlename.' ('.$prospect->title.')';
			$sex = strtolower($prospect->sex);
				
				if ($sex == "male") {
					$sexcolor = "blue";
				} else {
					$sexcolor = "pink";
				}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Client Details</h4>
</div>
<div class="modal-body">

			<table id="myTable" class="table " >
					<tr><th width=30%>Fullname</th> <td><?php echo $fullname; ?></td> </tr>
					<tr><th width=30%>Email Address</th> <td><?php echo $prospect->email; ?></td> </tr>
					<tr><th width=30%>Sex</th> <td><?php echo $prospect->sex; ?></td> </tr>
					<tr><th width=30%>Birthdate</th> <td><?php echo $prospect->dob; ?></td> </tr>
					<tr><th width=30%>Telephone</th> <td><?php echo $prospect->phone.', '.$prospect->mobile; ?></td> </tr>
					<tr><th width=30%>Occupation</th> <td><?php echo $prospect->occupation; ?></td> </tr>
					<tr><th width=30%>Address</th> <td><?php echo $prospect->address; ?></td> </tr>
			</table>

<div class="modal-header">
    <h4 class="modal-title">Client Properties</h4>
</div>
							<table id="myTable" class="table table-bordered table-responsive" >
										<thead><tr><th width=70%>Property Types</th> <th>Quantity</th> </tr> </thead>  
										
										</tbody>  
											<?php
													
													$all = mysqli_query($conn,  "SELECT * FROM property where project_id = '$projectid'");
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
?>


<!-- bootstrap datepicker -->
<script src="styles/js/bootstrap-datepicker.js"></script>

<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
</script>