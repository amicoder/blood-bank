<?php
	header("Content-Type: application/json; charset=UTF-8");
	require_once "../api/classes.php";

	$hos = new Hospital();


	if($_SERVER["REQUEST_METHOD"] = "post"){

		$hid = 	test_input($_POST["hid"]);
		$orders = $_POST["orders"];

		//print_r(json_decode($orders));
		$hos->createOrder($hid,json_decode($orders));

	}

	//$hos->createOrder(1,1,200);


	function test_input($data) {
	    $data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}
?>