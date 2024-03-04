<?php
	require_once ("../../connector/connect.php");	

	// re-create session
	session_start();


$FileId = '';

//SEARCH CLIENT SCRIPT
if(isset($_POST['getFileId'])) {

	function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			return $data;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$fileid = test_input($_POST["FileId"]);
			
			$check = mysqli_num_rows(mysqli_query($conn,  "SELECT * FROM client_property where fileid = '$fileid' and refund = 0"));

			if ($check > 0) {

				$getId = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property where fileid = '$fileid'"));
				$clientproperty_id = $getId->id;						
				header("location: ../refund?fileid=".$fileid);	
				//echo "HERE".$fileid;																
			}
			else {
				$_SESSION['wrongId'] = $fileid;	
				header("location: ../refund");		
			}
						
	}

	else {
		header("location: ../refund");	
	}
	

}


//DELETE PROJECT SCRIPT
if(isset($_POST['revokeproperty'])) {

		$clientPropertyId = $_SESSION['clientPropertyId'];
		$fileid = $_SESSION['fileid'];
					
		$cp_edit = "UPDATE client_property set refund = 1 WHERE id = '$clientPropertyId'";
		$clientProperty_edited = mysqli_query($conn, $cp_edit) or die(mysqli_error($conn));	

		$acc_edit = "UPDATE account set refund = 1 WHERE client_property_id = '$clientPropertyId'";
		$account_edited = mysqli_query($conn, $acc_edit) or die(mysqli_error($conn));			
												
			if (($clientProperty_edited)&&($account_edited)) {	
					$propertyRevoked = "propertyRevoked";
					$_SESSION['propertyRevoked'] = $propertyRevoked;										
					header("location: ../refund");																	
			}
			else {
					$Failed = "Failed";
					$_SESSION['Failed'] = $Failed;				
					header("location: ../refund?fileid=".$clientid);			
			}

}

//UNASSIGN PROPERTY SCRIPT
if(isset($_GET['unassignproject'])) {

		$projectid = $_SESSION['projectid'];
		$propertyId = $_SESSION['unassignproject'];

						$delete = mysqli_query($conn, "DELETE FROM property WHERE id = $propertyId");
												
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



// DELETE PROJECT MODAL
if(isset($_GET['revokeproperty'])) {	
$clientPropertyId = $_GET["revokeproperty"]; //escape the string if you like

	$all = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM client_property where id = '$clientPropertyId'"));

	$clientid = $all->client_id;

	$fileid = $all->fileid;
	$_SESSION['fileid'] = $fileid;
		$bio = mysqli_fetch_object(mysqli_query($conn, "select * from client where id = $clientid"));
		$fullname = $bio->lastname.' '.$bio->firstname.' '.$bio->middlename;

	$projectid = $all->project_id;
		$getpjt = mysqli_fetch_object(mysqli_query($conn, "select * from project where id = $projectid"));
		$project = $getpjt->name;
	
	$propertyid = $all->property_id;
		$getppt = mysqli_fetch_object(mysqli_query($conn, "select * from property_type where id = $propertyid"));
		$propertytype = $getppt->propertytype;

	$staffid = $all->staff_id;
		$getstf = mysqli_fetch_object(mysqli_query($conn, "select id, substring_index(email, '@', 1) as email from staff where id = $staffid"));
		$staff = $getstf->email;

	$date = $all->date;
		$date = strtotime($date);

	$amount = $all->amount;

	$account = mysqli_query($conn,  "SELECT SUM(amount) AS amountpaid FROM account where client_property_id = $clientPropertyId GROUP BY client_property_id;");
		if (mysqli_num_rows($account)>0) {
			$getacc = mysqli_fetch_object($account);
			$amountpaid = $getacc->amountpaid;
			$balance = ($amount - $amountpaid);
			
		} else {
			$amountpaid = 0;
			$balance = ($amount - $amountpaid);
		}

	$quantity = $all->quantity;

	$_SESSION['clientPropertyId'] =  $clientPropertyId;

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Revoke &amp; Refund - <?php echo $fileid;?></h4>
</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="modal-body">

		<?php echo '
		<table class="table">
			
			<tr><td>Client</td> <td>'.$fullname.' ('.$bio->email.')</td></tr>		
			<tr><td>Date</td> <td>'.date("Y-M-d",$date).'</td></tr>
			<tr><td>Project</td> <td>'.$project.'</td></tr>
			<tr><td>Property Type</td> <td>'.$propertytype.'</td></tr>
			<tr><td>No. of Units</td> <td>'.$quantity.'</td></tr>
			<tr><td>Cost</td> <td>'.$amount.'</td></tr>
			<tr><td>Amount Paid</td> <td>'.$amountpaid.'</td></tr>
			<tr><td>Balance</td> <td>'.$balance.'</td></tr>
			<tr><td>Sold By</td> <td>'.$staff.'</td></tr>

			
		</table>
		';
		?>
		<p style="font-size: 1.5em;">Are you sure you want to revoke this item?</p>

</div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
				<button type="submit" name= "revokeproperty" class="btn btn-outline pull-left"><i class="ace-icon fa fa-times"></i> <span>Revoke</span></button>
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