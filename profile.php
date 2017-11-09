
<?php 
	session_start();
	$id = $_SESSION['id'];

/*
	include "./api/classes.php";

	$donar = new Donar();

	if($id != null)
	$donar->getDonarProfile(''.$id);

*/
?>
<!DOCTYPE html>
<html lang="enUS">
<head>

	<title>Welcome </title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
	<link href="./css/style.css" rel="stylesheet">

	<script>

	$(document).ready(()=>{
		//Load informations
		loadDonarInformation();
		loadDonationInformation();
	});
	 
	function loadDonarInformation(){


			var data = new FormData();
			data.append( "id", '<?php echo $id ?>' );

		fetch("./donar/getDonarProfile.php",{
			method:'POST',
			body: data
		})
		 .then(  
		    function(response) {  
		      if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		      }
		     
		      response.json().then((data)=>{
		      	var donar= data[0];

		      	$('#donarName').html(donar.dname);
		      	$('#donarAge').html("Age : "+donar.age);
		      	$('#donarWeight').html("Weight : "+donar.weight);
		      	$('#donarBG').html(donar.bloodGroup);
		      	$('#donarGender').html("Gender : "+donar.gender);
		      	 console.log(data);
		      	
		      	


		      });
		     
		    }  
		  )  
		  .catch(function(err) {  
		    console.log('Fetch Error :-S', err);  
		  });
	}
	function loadDonationInformation(){


			var data = new FormData();
			data.append( "id", '<?php echo $id ?>' );

		fetch("./donar/getDonationInfo.php",{
			method:'POST',
			body: data
		})
		 .then(  
		    function(response) {  
		      if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		      }
		     
		      response.json().then((data)=>{
		      	 console.log(data);
		      	 data = data.data;
		      	data.forEach((key,index)=>{

		      		var newHtml = "<tr><td>"+key.location+"</td><td style='color: red'>"+key.quantity+"</td><td>"+key.date+"</td><tr>";

		      		$('#donationList').append(newHtml);
		      	});
		      	


		      });
		     
		    }  
		  )  
		  .catch(function(err) {  
		    console.log('Fetch Error :-S', err);  
		  });
	}



	</script>
	<style>
		h5{
			color: grey;

		}

		.bloodGroup{

			font-size: 80px;
		}
	</style>
</head>
<body style="background-color:  rgb(237, 237, 237);">

	<div class="container fullscreen">

		<div class="row fullscreen" style="padding-top: 50px;
    padding-bottom: 50px;">
			<div class="col-sm-4 fullscreen profileContainer">
				<div class="donarTitle" id="donarTitle">

					<img src="./img/profile.png" class="donarImage img-circle" height="50px" width="50px"/>
					<div class="donarName" id="donarName"></div> 
				</div>
				<div id="donarId" class="donarProfile">

					<div class="row">
						<div class="col-sm-6" style="display: flex;justify-content: space-evenly;flex-direction: column;">
							<h5 id="donarAge">Age : 20</h5>
							<h5 id="donarGender">Gender : Male</h5>
							<h5 id="donarWeight">Weight : 45</h5>
						</div>
						<div class="col-sm-6">
							<h1 style='color: red' class="bloodGroup" id="donarGroup">A+</h1> 
						</div>
					</div>	
					<div class="row">
						<div class="bloodDonated"><div class="totalPoints">1</div></div>
					</div>
					<div class="row">
						<div class="bloodPintsContainer"><div class="totalBlood">TD : 15412</div></div>
					</div>
				</div>
			</div>
			<div class="col-sm-8 fullscreen ">
				<div class="fullscreen infoPanel">
					<div class="tableContainer">
						<table class="table">
						    <thead>
						      <tr>
						        <th>Event</th>
						        <th>Quantity</th>
						        <th>Date</th>
						      </tr>
						    </thead>
						    <tbody id="donationList">
						     
						    </tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-8 fullscreen " hidden>

			</div>
		</div>
	</div>

</body>
</html>
