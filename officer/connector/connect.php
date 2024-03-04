<?php 

clearstatcache();

//$conn = mysqli_connect("localhost","hallprom_dbadmin","0N#tkw;1#d=Q","hallprom_dbase");
$conn = mysqli_connect("localhost","root","","hall7new");

// Check connection
if (mysqli_connect_errno())
  {
  	//echo "<br/><center style='color: #f00; font-weight: bolder;'><h4>No Database Connection<h4/><center/>";
  	header("location: connection_error");
  }
  
	$sign	= '&#x20A6;';
  
	$url 	= 'http://localhost/hall7new';
	
?>