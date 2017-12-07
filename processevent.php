<?php

include "./api/classes.php";

$ename = $description = $locationid = $shortdesc = $src = $date =  "";
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$ename = test_input($_POST['ename']);
	$shortdesc = test_input($_POST['shortdesc']);
	$locationid = test_input($_POST['locationid']);
	$date = test_input($_POST['date']);

	$target_dir = "img/events/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}

	if($uploadOk){
		if(move_uploaded_file(($_FILES['fileToUpload']['tmp_name']), $target_file)){
			$src = $target_file;
			echo "upload Done";
		}else{
			echo "some error on upload";
		}
	}


	$event = new Events();
	$event->createEvents($ename,$locationid,$shortdesc,$src,$date);
	header("Location: ./bank/dashboard-bank.php");
}



function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
}



?>