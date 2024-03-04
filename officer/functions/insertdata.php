<?php
//Include database configuration file
	require_once ("../connector/connect.php");	
	
	if (isset($_POST['cpId'])) {

		$cpId = $_POST['cpId'];
		$amount = $_POST['amount'];
		$date = $_POST['date'];

		$plandate = date("Y-m-d", strtotime($date));

		$add = "INSERT INTO plan (clientproperty_id, date, amount) VALUES ('$cpId', '$plandate', '$amount')";
		$added = mysqli_query($conn, $add) or die(mysqli_error($conn));	

	    // Send email
	    if ($added){
	        $status = 'ok';
	    }else{
	        $status = 'err';
	    }			
	}

?>
	


					    <div class="callout callout-success" id="success">
					      <i class="icon fa fa-check-square-o"></i> Investment Plan Added
					    </div>

						<table id="myTable" class="table" >
									
							<thead><tr><th>Investment</th> <th width=25%>Date</th> <th><span style="float: right;">Amount (<?php echo $sign; ?>)</span></th> <th><center>Action</center></th> </tr> </thead>   
									
									<tbody id="exbody"> 
										<?php
											$counter = 1;
											
											$all = mysqli_query($conn,  "SELECT * FROM plan where clientproperty_id = '$cpId' order by id asc");
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

																	<td>
																		<center>
																		<button type="button" id="'.$row->id.'" class="deletePlan btn btn-xs btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Delete</button>
																		</center>
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

</script>