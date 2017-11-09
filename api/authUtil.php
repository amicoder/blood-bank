<?php

include '/database/connection.php';


// Class that will manage creation and authorization of donar and hospital
class AuthObject {

	//function to create donar
	public function createDonar($dname,$age,$address,$bloodGroup,$weight,$uname,$pword,$gender){

		$sqlObj = new SQLConnection();

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				
				$pword = sha1($pword);

				$sql = "INSERT into donarprofile(dname,age,address,blood_group,weight,uname,pword,gender) values('".$dname."','".$age."','".$address."','".$bloodGroup."','".$weight."','".$uname."','".$pword."','".$gender."')";

				
				if($conn->query($sql) === true){
					echo "User Successfully added";
				}
				else{
					echo $conn->error;
				}
			}
			
		}
		else{

			echo "cannot create connection";
		}

	}

	//function to auth donar
	public function authDonar($uname,$pword){

		$sqlObj = new SQLConnection();

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				
				$pword = sha1($pword);

				$sql = "SELECT * from donarprofile WHERE uname = '".$uname."' AND pword = '".$pword."'";

				$result = $conn->query($sql);
				if($result->num_rows == 1){
					echo "Successfully Logged In";
				}
				else {
					echo "Invalid username and password";
				}

			}
			
		}
		else{

			echo "cannot create connection";
		}

	}

	//function to creat hospital
	public function createHospital(){

	}

	//function to auth hospital
	public function authHospital(){

	}
}



?>
