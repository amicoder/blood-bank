<?php
	
	include "../api/classes.php";

	$donar = new Donar();

	$id=  $_POST['id'];

	if($id != null)
	$donar->getDonations(''.$id);

?>