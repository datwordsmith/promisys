<?php
		$getconfam = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM staff where id = $loginid"));
		$pic = $getconfam->pic;

		if ($pic != null) {
			echo '<div class ="staffpic" style = "width: 100px; height: 100px; margin: 0 auto;">				
				<center>					
					<img src="photos/'.$pic.'" width=100% />
				</center> 
				</div>
				<center>
				<br/>
				<a href="javascript:void(0)" onclick="delete_pic('.$loginid.')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Photo"><i class="ace-icon fa fa-times"></i> Delete Photo</a>
				</center>
				';
		} 
	
		else { ?>
				<form action="functions/fetchmyprofile.php" method="POST" enctype="multipart/form-data">
				  	<div class="form-group col-md-12 col-xs-12">
						<b style=""><center>Upload Staff Photo (PNG, JPG, JPEG)</center></b><br/>
						<input type="file" class="form-control pull-right" placeholder="" name="file"  id="my_file" required>
						<!--<div style="clear: both;"></div>-->	
				  	</div>
					<div>
						<p id="error1" style="display:none; color:#FF0000;">
							Invalid Image Format! Image Format Must Be JPG, JPEG or PNG.
						</p>
						
						<p id="error2" style="display:none; color:#FF0000;">
							Maximum File Size Limit is 1MB.
						</p>
						<!---->				
					</div>
					<div class="form-group col-md-12 col-xs-12">
						<span>&nbsp;</span>
					  <button type="submit" name= "addpic" id="img_upload" class="btn btn-default btn-block btn-flat"><i class="ace-icon fa fa-floppy-o"></i> Save Photo</button>
					</div>
			</form>																	
		<?php
		}
?>