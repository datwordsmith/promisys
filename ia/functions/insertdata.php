<?php
//Include database configuration file
	require_once ("../../connector/connect.php");	
	
	if (isset($_POST['ppId'])) {

		$ppId = $_POST['ppId'];
		$amount = $_POST['amount'];
		$date = $_POST['date'];

		$plandate = date("Y-m-d", strtotime($date));

		$add = "INSERT INTO prospectplan (prospectproperty_id, date, amount) VALUES ('$ppId', '$plandate', '$amount')";
		$added = mysqli_query($conn, $add) or die(mysqli_error($conn));	

		$update = "UPDATE prospect_property set rfo = 0 where id = '$ppId'";
		$Updated = mysqli_query($conn, $update) or die(mysqli_error($conn));

	    // Send email
	    if ($added){
	        $status = 'ok';
	    }else{
	        $status = 'err';
	    }			
	}

	$checkletter = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM prospect_property where id = '$prospectPropertyId'"));
	$rfostatus = $checkletter->rfo;	
?>
	


					    <div class="callout callout-success" id="success">
					      <i class="icon fa fa-check-square-o"></i> Investment Plan Added
					    </div>

						<table id="myTable" class="table" >
									
							<thead><tr><th>Investment</th> <th width=25%>Date</th> <th><span style="float: right;">Amount (<?php echo $sign; ?>)</span></th> <th><center>Action</center></th> </tr> </thead>   
									
									<tbody id="exbody"> 
										<?php
											$counter = 1;
											
											$all = mysqli_query($conn,  "SELECT * FROM prospectplan where prospectproperty_id = '$ppId' order by id asc");
											while($row = mysqli_fetch_object($all))
												{
													$date = $row->date;
													$date = strtotime($date);														
														ob_start();

														echo '
																<tr>
																	<td>#'.$counter.'</td> 														
																	<td>'.date("Y-M-d",$date).'</td> 														
																	<td><span style="float: right;">'.$sign.number_format($row->amount).'</span></td>

																	<td>';
																		if ($rfostatus == 2) {																		
																			echo '
																			<center>
																			-
																			</center>';
																		} else {
																			echo '
																			<center>
																			<button type="button" id="'.$row->id.'" class="deletePlan btn btn-xs btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Delete</button>
																			</center>';
																		}
																	echo '
																	</td>															

																</tr>
															';		
														$GLOBALS['exbox'] = ob_get_contents();	
														
														ob_end_clean();

														echo $exbox;														
				
													$counter++;
												}							
										?>		
									</tbody>  

									<tbody class="getbody"> 

									</tbody>	

						</table>

				<div class="" style="margin-top: 20px; margin-bottom: 20px;">
						<?php
							$detail = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM prospect_property WHERE id = '$ppId'"));

							$getplantotal =  mysqli_fetch_object(mysqli_query($conn,  "SELECT SUM(amount) as totalplan FROM prospectplan where prospectproperty_id = '$ppId' order by id asc"));

							$totalplan = $getplantotal->totalplan;
							$totalcost = $detail->amount;


							if ($totalcost > $totalplan) {
								echo '
									<center>
										<button type="button" class="btn btn-sm btn-warning disabled">Total Amount Payable is not yet covered in the payment plan</button>	
										<div class="text-danger"><h3>'.$sign.number_format($totalcost - $totalplan).'</h3><small>Outstanding</small></div>
									</center>
								';
							} elseif ($totalcost < $totalplan) {
								echo '
									<center>
										<button type="button" class="btn btn-sm btn-info disabled">Payment Plan exceeds Total Amount Payable</button>	
										<div class="text-success"><h3>'.$sign.number_format($totalplan - $totalcost).'</h3><small>Excess</small></div>
									</center>
								';
							} else {
								if ($rfostatus == 0) {
									echo '
									<center>
										<button type="button" id="'.$prospectPropertyId.'" class="btn btn-sm btn-success rfoletter"><i class="fa fa-file-text-o"></i> Request Offer Letter</button>
										<div class="text-success requestconfirm"></div>
									</center>';
								} else if ($rfostatus == 1) {
									echo '
									<center>
										<button type="button" class="btn btn-sm btn-default" disabled><i class="fa fa-file-text-o"></i> REQUESTED</button>
										<div class="text-success"><small>You have requested offer letter</small></div>
									</center>';
								} else {
									echo '
									<center>
										<button type="button" class="btn btn-sm btn-default" disabled><i class="fa fa-file-text-o"></i> OFFER LETTER IS READY</button>
										<div class="text-success"><small>Pick up the Offer Letter from Admin</small></div>
									</center>';											
								}
							}

						?>										
				</div>

	
<script>																	

// DELETE PLAN
$(document).ready(function(){
    $(".deletePlan").click(function(e) {

        var planid = $(this).attr("id");

 	 	e.preventDefault();

        /*if (confirm("Sure you want to delete this post? This cannot be undone later.")) {
        } */              	
            $.ajax({
                type : 'POST',
                url : 'functions/deleteplan.php', //URL to the delete php script
				data: {
				  	planid: planid
				}
            })
 		    .done(function(data){
		     	//alert('Ajax Submit Correct ...'); 
				$('#planList').fadeOut('slow', function(){
				    $('#planList').fadeIn('slow').html(data);

					window.setTimeout(function() {
						$("#success").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove(); 
						});
					}, 4000);				    
				});		     		     	
		    })
		    .fail(function(){
		 		$("#deleteError").fadeIn(600).html('<div class="callout callout-danger" id ="success"><i class="icon fa fa-exclamation-triangle"></i> Error, Please try again!</div>');
					
					window.setTimeout(function() {
						$("#success").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove(); 
						});
					}, 4000);		 		
		    });	

        return false;
    });
});


	//RFOL
	$(document).ready(function(){
		$(".rfoletter").click(function(){
		
			var rfol = $(this).attr("id");

            $.ajax({
                type : 'POST',
                url : 'functions/fetchviewprospect.php', //URL to the delete php script
				data: {
				  	rfol: rfol
				}
            })
 		    .done(function(data){
		     	//alert('Ajax Submit Correct ...'); 	
				$('.rfoletter').prop('disabled', true);
		     	$('.requestconfirm').fadeIn('slow').html('You request for Offer Letter has been sent to the appropriate quarters.');		     	     		     	
		    })
		    .fail(function(){
		 		
		    });				
		})
	});

</script>