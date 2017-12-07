<?php
	require_once "../api/classes.php";
	

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$hid = $_POST['hid'];

		$hospital = new Hospital();

		$hospital->getOrders($hid);
	}
	

?>