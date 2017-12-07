<?php

	require_once "../api/classes.php";

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		$oid = $_POST['oid'];


		$hos = new Hospital();

		$hos->approveOrder($oid);
	}



?>