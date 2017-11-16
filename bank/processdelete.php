<?php

	require_once "../api/classes.php";

	if($_SERVER['RQUEST_METHOD'] == "POST"){
		$eid = $_POST['eid'];


		$event = new Events();

		$event->deleteEvent($eid);
	}

?>