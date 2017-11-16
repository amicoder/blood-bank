<?php

class SQLConnection{

	const DB_SERVER_NAME = "localhost";
	const DB_USER_NAME = "root";
	const DB_PASSWORD = "";
	const DB_DATABASE = "bloodbank";

	public $conn = null;

	public function createConnection(){

		$this->conn = new mysqli(self::DB_SERVER_NAME,self::DB_USER_NAME,self::DB_PASSWORD,self::DB_DATABASE);

		if($this->conn->connect_error){
			echo "Connection Failed";
			die("Connection failed: " . $this->conn->connect_error);
		}

		return true;
	}

	public function closeConnection(){
		if($conn != NULL){
			$conn->close();
		}
	}
}

// Class that will manage creation and authorization of donar and hospital
class AuthObject {


	public $currentLoggedDonarId = null;

	//function To create session for donar

	public function createDonarSession($did){

		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		$_SESSION['id'] = $did;
		$currentLoggedDonarId = $_SESSION['id'];


	}

	public function createBankSession($did){

		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		$_SESSION['bid'] = $did;
		


	}
	public function checkCurrentSession(){

		session_start();

		if(isset($_SESSION['id']) && $_SESSION['id'] != null){
			$currentLoggedDonarId = $_SESSION['id'];
			return $_SESSION['id'];
			//session does not 
		}
	}
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

					$row = $result->fetch_assoc();

					$this->createDonarSession($row['did']);

					
					return true;
				}
				else {
					
					return false;
				}

			}
			
		}
		else{

			echo "cannot create connection";
		}

		return false;

	}

	public function authBank($uname,$pword){


				

				//$sql = "SELECT * from donarprofile WHERE uname = '".$uname."' AND pword = '".$pword."'";

				//$result = $conn->query($sql);
				if($uname === "admin" && $pword === "admin"){

					

					$this->createBankSession($uname);

					
					return true;
				}
				else {
					
					return false;
				}

	

	}


	//function to creat hospital
	public function createHospital(){

	}

	//function to auth hospital
	public function authHospital(){

	}

	public function logout(){
		session_destroy();
	}
}


class CustomHandleHttpRequest{


	public function donarSignup(){

		$dname = $age = $weight = $adderss = $bloodGroup = $uname = $pword = $gender = "";

		if($_SERVER["REQUEST_METHOD"] == "POST"){

			$dname = $this->test_input($_POST["dname"]);
			$age = $this->test_input($_POST["age"]);
			$weight = $this->test_input($_POST["weight"]);
			$adderss = $this->test_input($_POST["address"]);
			$bloodGroup = $this->test_input($_POST["bloodGroup"]);
			$uname = $this->test_input($_POST["uname"]);
			$pword = $this->test_input($_POST["pword"]);
			$gender = $this->test_input($_POST["gender"]);


			$ao = new AuthObject();
			$ao->createDonar($dname,$age,$adderss,$bloodGroup,$weight,$uname,$pword,$gender);

			//$ao->createDonar('Arya','21','Koramangla Sony','A+','75','arya12345','pass12345','male');

		}

	}

	public function donarLogin(){

		$uname = $pword = "";

		if($_SERVER["REQUEST_METHOD"] == "POST"){

			
			$uname = $this->test_input($_POST["uname"]);
			$pword = $this->test_input($_POST["pword"]);
		


			$ao = new AuthObject();
			if($ao->authDonar($uname,$pword) === true) return true;
			else return false;

			//$ao->createDonar('Arya','21','Koramangla Sony','A+','75','arya12345','pass12345','male');

		}

	}

	public function bankLogin(){

		$uname = $pword = "";

		if($_SERVER["REQUEST_METHOD"] == "POST"){

			
			$uname = $this->test_input($_POST["uname"]);
			$pword = $this->test_input($_POST["pword"]);
		


			$ao = new AuthObject();
			if($ao->authBank($uname,$pword) === true) return 2;
			else return 1;

			//$ao->createDonar('Arya','21','Koramangla Sony','A+','75','arya12345','pass12345','male');

		}
		else{
			return 0;
		}

	}
	public function collectBlood(){

		$did = $quantity = $bloodGroup = "";
		if($_SERVER["REQUEST_METHOD"] == "POST"){

			
			$did = $this->test_input($_POST["did"]);
			$quantity = $this->test_input($_POST["quantity"]);
			$bloodGroup = $this->test_input($_POST["bloodGroup"]);



			

			//$ao->createDonar('Arya','21','Koramangla Sony','A+','75','arya12345','pass12345','male');

		}

	}
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
}


class Donar {

	
	public function getDonarProfile($did){

		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				

				$sql = "SELECT * from donarprofile WHERE did = '".$did."'";

				$result = $conn->query($sql);

				if($result->num_rows == 1){

					$data = "[";
					while($row = $result->fetch_assoc()){
						//echo "Location :".$row['locationid']." Quantity :".$row['quantity'];

						$data = $data."{\"did\":\"".$row['did']."\",\"dname\":\"".$row['dname']."\",\"age\":\"".$row['age']."\",\"address\":\"".$row['address']."\",\"bloodGroup\":\"".$row['blood_group']."\",\"weight\":\"".$row['weight']."\",\"uname\":\"".$row['uname']."\",\"gender\":\"".$row['gender']."\"},";
					}


					$data = substr($data, 0, -1)."]";
					echo $data;
				}
				else{
					$data = "[]";
					echo $data;
				}
				
				

			}else{
				echo "Some Error ".$sqlObj->conn->error;
			}
			
		}
		else{

			echo "cannot create connection";
		}

	}
	public function getDonations($did){
		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				

				$sql = "SELECT * from modifieddonation WHERE did = '".$did."'";

				$result = $conn->query($sql);

				if($result->num_rows > 0){

					$data = "{\"status\":\"true\",\"data\":[";
					while($row = $result->fetch_assoc()){
						//echo "Location :".$row['locationid']." Quantity :".$row['quantity'];

						$data = $data."{\"location\":\"".$row['venue']."\",\"quantity\":\"".$row['quantity']."\",\"date\":\"".$row['rdate']."\"},";
					}


					$data = substr($data, 0, -1)."]}";
					echo $data;
				}
				else{
					$data = "{\"status\":\"false\",\"data\":[]}";
					echo $data;
				}
				
				

			}else{
				echo "Some Error ".$sqlObj->conn->error;
			}
			
		}
		else{

			echo "cannot create connection";
		}
	}

	public function submitDonation($did,$quantity,$bloodGroup,$eid){
		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				$currentDate = date("Y-m-d");				
				$sql = "INSERT into donation(did,quantity,rdate,blood_group,eid) values('".$did."','".$quantity."','".$currentDate."','".$bloodGroup."','".$eid."')";

				
				if($conn->query($sql) === true){
					echo "{\"status\":\"true\"}";
				}
				else{
					echo "{\"status\":\"".$conn->error."\"}";
				}
				
				

			}else{
				echo "Some Error ".$sqlObj->conn->error;
			}
			
		}
		else{

			echo "cannot create connection";
		}
	}



}


class Events {
	
	public function getLocation(){
		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				$currentDate = date("Y-m-d");				
				
				$sql = "SELECT lname,locationid  from locations ";
				//echo $sql;
				
				$result = $conn->query($sql);
				if($result->num_rows >0){
					$data = "";
					while($row = $result->fetch_assoc()){
						//echo "Location :".$row['locationid']." Quantity :".$row['quantity'];

						$data = '<option value="'.$row['locationid'].'">'.$row['lname'].'</option>';
					}


					
					echo $data;
				}
				else{
					$data = '<option value="null">Error</option>';
					echo $data;
				}
					
			}else{
				$data = "{\"status\":\"error\",\"data\":[]}";
				echo $data;

			}
				
			
		}
		else{

			echo "cannot create connection";
		}
	}

	public function deleteEvent($eid){

		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				//$currentDate = date("Y-m-d");				
				
				$sql = "DELETE from donationevent where eid=".eid;
				//echo $sql;
				
				if($conn->query($sql)){
					echo '{"status:":"true"}';
				}else{
					echo '{"status:":"'.$conn->error.'"}';
				}
				
					
			}else{
				
				echo '{"status:":"false"}';

			}
				
			
		}
		else{

			echo "cannot create connection";
		}
	}

	public function createEvents($ename,$locationid,$shortdesc,$src,$date){
		

		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				//$currentDate = date("Y-m-d");				
				
				$sql = "INSERT INTO donationevent(ename,locationid,shortdesc,imgsrc,edate) VALUES('".$ename."','".$locationid."','".$shortdesc."','".$src."','".$date."')";
				//echo $sql;
				
				if($conn->query($sql)){
					echo "DONE";
				}else{
					echo "error :".$conn->error;
				}
				
					
			}else{
				$data = "{\"status\":\"error\",\"data\":[]}";
				echo $data;

			}
				
			
		}
		else{

			echo "cannot create connection";
		}
		
	}

	public function getUpcomingEvents(){
		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				$currentDate = date("Y-m-d");				
				
				$sql = "SELECT E.eid,E.ename,E.shortdesc,E.edate,E.imgsrc as src,L.lname as venue from donationevent E, locations L where E.locationid = L.locationid and E.edate >=".$currentDate." order by E.edate";
				//echo $sql;
				
				$result = $conn->query($sql);
				if($result->num_rows >0){
					$data = "{\"status\":\"true\",\"data\":[";
					while($row = $result->fetch_assoc()){
						//echo "Location :".$row['locationid']." Quantity :".$row['quantity'];

						$data = $data."{\"eid\":\"".$row['eid']."\",\"ename\":\"".$row['ename']."\",\"edate\":\"".$row['edate']."\",\"src\":\"".$row['src']."\",\"venue\":\"".$row['venue']."\",\"shortdesc\":\"".$row['shortdesc']."\",\"canstart\":\"".($row['edate']==$currentDate? 'true':'false')."\"},";
					}


					$data = substr($data, 0, -1)."]}";
					echo $data;
				}
				else{
					$data = "{\"status\":\"false\",\"data\":[]}";
					echo $data;
				}
					
			}else{
				$data = "{\"status\":\"error\",\"data\":[]}";
				echo $data;

			}
				
			
		}
		else{

			echo "cannot create connection";
		}
	}

	public function getAllEvents(){
		$sqlObj = new SQLConnection();
		

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				$currentDate = date("Y-m-d");				
				
				$sql = "SELECT E.eid,E.ename,E.shortdesc,E.edate,E.imgsrc as src,L.lname as venue from donationevent E, locations L where E.locationid = L.locationid and E.edate >=".$currentDate." order by E.edate";
				//echo $sql;
				
				$result = $conn->query($sql);
				if($result->num_rows >0){
					$data = "{\"status\":\"true\",\"data\":[";
					while($row = $result->fetch_assoc()){
						//echo "Location :".$row['locationid']." Quantity :".$row['quantity'];

						$data = $data."{\"eid\":\"".$row['eid']."\",\"ename\":\"".$row['ename']."\",\"edate\":\"".$row['edate']."\",\"src\":\"".$row['src']."\",\"venue\":\"".$row['venue']."\",\"shortdesc\":\"".$row['shortdesc']."\",\"canstart\":\"".($row['edate']==$currentDate? 'true':'false')."\"},";
					}


					$data = substr($data, 0, -1)."]}";
					echo $data;
				}
				else{
					$data = "{\"status\":\"false\",\"data\":[]}";
					echo $data;
				}
					
			}else{
				$data = "{\"status\":\"error\",\"data\":[]}";
				echo $data;

			}
				
			
		}
		else{

			echo "cannot create connection";
		}
	}
}

class Bank{

	public function getProducts(){

		$sqlObj = new SQLConnection();

		if($sqlObj->createConnection()){

			if($sqlObj->conn != null){


				$conn = $sqlObj->conn;
				

				$currentDate = date("Y-m-d");				
				
				$sql = "SELECT * from product where product";
				//echo $sql;
				
				$result = $conn->query($sql);
				if($result->num_rows >0){
					$data = "{\"status\":\"true\",\"data\":[";
					while($row = $result->fetch_assoc()){
						//echo "Location :".$row['locationid']." Quantity :".$row['quantity'];

						$data = $data."{\"pid\":\"".$row['pid']."\",\"pname\":\"".$row['pname']."\",\"ptype\":\"".$row['ptype']."\",\"bloodGroup\":\"".$row['blood_group']."\",\"quantity\":\"".$row['aquantity']."\"},";
					}


					$data = substr($data, 0, -1)."]}";
					echo $data;
				}
				else{
					$data = "{\"status\":\"false\",\"data\":[]}";
					echo $data;
				}
					
			}else{
				$data = "{\"status\":\"error\",\"data\":[]}";
				echo $data;

			}
				
			
		}
		else{

		
		}
	}
}
?>

