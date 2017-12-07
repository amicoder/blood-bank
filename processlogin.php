<?php

		include "./api/classes.php";

		
		$request = new CustomHandleHttpRequest();
		

		if($request->donarLogin()){
			header("Location: ./profile.php");
		}
		else{

			echo "Invalid username and password";
		}
		

?>