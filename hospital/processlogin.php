<?php


		include "../api/classes.php";

		
		$request = new CustomHandleHttpRequest();
		

		if($request->hospitalLogin()){
			header("Location: ../index.php");
		}
		else{

			session_start();
			$_SESSION['error'] = "Invalid username and password";
			header("Location: ../index.php");
			echo "Invalid username and password";
		}
		


?>