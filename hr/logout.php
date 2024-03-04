<?php


session_start();

session_destroy();
session_write_close();
session_unset();
$_SESSION=array();
	
header("location: ../");	

 ?>