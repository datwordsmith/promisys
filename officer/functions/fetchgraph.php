<?php
//Include database configuration file
	//require_once ("../connector/connect.php");	
	
    //GET MONTHS
    //bind to $name
    if ($mnt = mysqli_prepare($conn, "SELECT month from month where id in (SELECT month(date) FROM account where year(date) = $currentYear group by month(date)) order by id asc")) {
        $mnt->bind_result($month);
        $OK = $mnt->execute();
    }
    //put all of the resulting names into a PHP array
    $result_array = Array();
    while($mnt->fetch()) {
        $result_array[] = substr($month, 0, 3);
    }
    //convert the PHP array into JSON format, so it works with javascript
    $month_array = json_encode($result_array);	


    //GET MONTHS
    //bind to $name
    if ($amt = mysqli_prepare($conn, "SELECT sum(amount) as mtot FROM account where year(date) = $currentYear group by month(date) order by month(date) asc")) {
        $amt->bind_result($mtot);
        $OK = $amt->execute();
    }
    //put all of the resulting names into a PHP array
    $amt_array = [];
    while($amt->fetch()) {
        $amt_array[] = (float)$mtot;
    }
    //convert the PHP array into JSON format, so it works with javascript
    $amount_array = json_encode($amt_array);
	

?>