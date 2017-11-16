<?php

	require_once "../api/classes.php";

	$did = $quantity = $bloodGroup = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		
		$did = test_input($_POST["did"]);
		$quantity = test_input($_POST["quantity"]);
		$bloodGroup = test_input($_POST["bloodGroup"]);
		$eid = test_input($_POST['eid']);


		$donar = new Donar();

		$donar->submitDonation($did,$quantity,$bloodGroup,$eid);

		//$ao->createDonar('Arya','21','Koramangla Sony','A+','75','arya12345','pass12345','male');

	}

	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>