<?php

clearstatcache();

//$conn = mysqli_connect("localhost","hall7pro_pradmin","B7L2*Q@eCS-Q","hall7pro_promisys");

$conn = mysqli_connect("localhost","root","","promisys2");

// Check connection
if (mysqli_connect_errno())
  {
  	//echo "<br/><center style='color: #f00; font-weight: bolder;'><h4>No Database Connection<h4/><center/>";
  	header("location: connection_error");
  }

	$sign	= '&#x20A6;';

	$url 	= 'http://localhost/promisys2';
	//$url 	= 'https://hall7promisys.com.ng';

?>
