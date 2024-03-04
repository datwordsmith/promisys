	echo "Today is " . date("Y-m-d") . "<br>";
	echo "Today is " . date("Y-m") . "<br>";
	$month = date("n");
	echo "Month is ".$month."<br/>";
	//$all = mysqli_query($conn, "SELECT email, MONTH(dob) AS month, DAY(dob) AS day from client order by  dob asc");
	$all = mysqli_query($conn, "SELECT * from client where MONTH(dob) = 7 order by dob sc");
	while($getclient = mysqli_fetch_object($all)) {
		echo $getclient->email.' - '.$getclient->dob.' - '.$getclient->occupation.'<br/>';
	}