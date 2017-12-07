<?php


	require_once "../api/classes.php";
	$hos = new Hospital();
	
	$hos->geCurrentOrders();

?>