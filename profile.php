
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
		loadUpcomingEvents();


		$(".nav_btn").click((e)=>{
			//console.log(e)
			
				$(".infoPanel").removeClass("show");
				//var targerobject = $(e.target).attr("target-id");
				//$("#"+$(e.target).attr("target-id")).addClass("show");
				//console.log($(e.target).attr("target-id"));

				var target =  $(e.target).attr("target-id");
				$("#"+target).addClass("show");
			
			//alert(target);
		});
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
		      	console.log('<?php echo $id ?>');
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

	function loadUpcomingEvents(){


		

		fetch("./bank/getEvents.php")
		 .then(  
		    function(response) {  
		      if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		      }
		     
		      response.json().then((data)=>{
		      
		      	if(data.status === "true")
		      	{
		      		var events = data.data;


		      		console.log(events);

		      		events.forEach((value,index)=>{

		      			var d = value.edate;
		      			d = d.split("-");
		      			var ecard = "<div class='custom_card' style='width: 20rem;'>"+
							"<div class='edateStamp'><div class='edate'>"+d[2]+"</div><div class='emonth'>"+getMonth(d[1])+"</div></div>"+
						  "<img class='custom_card_img' src='"+value.src+"' alt='Card image cap' height='150px' >"+
						  "<div class='custom_card_content'>"+
						    "<h4 class='custom_card_title'>"+value.ename+"</h4>"+
						    "<div class='custom_card_description'>"+value.shortdesc+"</div>"+
						   "<div class='card_location'><i class='material-icons'>place</i><div class='location_namr'>"+value.venue+"</div></div>"+
						  "</div>"+
						"</div>";

						$("#event_cards").append(ecard);
		      		});
		      	}else if(data.status === "false"){
		      			$("#event_cards").append("<div>No upcoming events</div>");
		      	}
						      	


		      });
		     
		    }  
		  )  
		  .catch(function(err) {  
		    console.log('Fetch Error :-S', err);  
		  });
	}

	function getMonth(mon){
		var monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "DEP", "OCT", "NOV", "DEC"];

		return monthNames[(mon-1)];
	}
	var count =0;
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

		      //console.log(response.text());
		    
		      response.json().then((data)=>{
		      	 console.log(data);
		      	 data = data.data;
		      	 
		      	data.forEach((key,index)=>{

		      		count += parseInt(key.quantity);
		      		var newHtml = "<tr><td>"+key.location+"</td><td style='color: red'>"+key.quantity+"</td><td>"+key.date+"</td><tr>";

		      		$('#donationList').append(newHtml);
		      		
		      		
		      	});
		      	
				console.log(count);
				 $('#totalBlood').html("Total Donation : "+count+" ml");
				 var points = parseInt(count/1000);
				 $('#totalPoints').html(points);
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
		.csn{
			font-size: x-large;
		}
	</style>
</head>
<body style="background-color:  rgb(237, 237, 237);">
	<div class="container">
		<div class="row">
			<nav class="navbar navbar-inverse custom-nav-bar">
			  <div class="container-fluid">
			    <ul class="nav navbar-nav navbar-right">
			      <li><a class="csn" href="./auth/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			    </ul>
			  </div>
			</nav>
		</div>
	</div>
	<div class="container fullscreen">
	
		<div class="row fullscreen" style="padding-top: 0px;
    padding-bottom: 50px;">
			<div class="col-sm-3 fullscreen profileContainer">
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
						<div class="bloodDonated"><div class="totalPoints" id="totalPoints" >1</div></div>
					</div>
					<div class="row">
						<div class="bloodPintsContainer"><div class="totalBlood" id="totalBlood"></div></div>
					</div>
				</div>
			</div>
			<div class="col-sm-7 fullscreen ">
				<div id="donated" class="fullscreen infoPanel hide">
					<div class="tableContainer">
						<table class="table">
						    <thead>
						      <tr>
						        <th>Location</th>
						        <th>Quantity</th>
						        <th>Date</th>
						      </tr>
						    </thead>
						    <tbody id="donationList">
						     
						    </tbody>
						</table>
					</div>
				</div>
				<div id="events" class="fullscreen infoPanel events hide show">
					
					<div id="event_cards" class="event_cards">
						<!--
						<div class="custom_card" style="width: 20rem;">
							<div class="edateStamp"><div class="edate">20</div><div class="emonth">Nov</div></div>
						  <img class="custom_card_img" src="./img/dcard.jpg" alt="Card image cap" height="150px" >
						  <div class="custom_card_content">
						    <h4 class="custom_card_title">Card title</h4>
						    <div class="custom_card_description">Some quick example text to build on the card title and make up the bulk of the card's content.</div>
						    <div class="card_location"><i class="material-icons">place</i><div class="location_namr">Kormangala</div></div>
						    
						  </div>
						</div>-->
					</div>
					
				</div>
				<div id="contactus" class="fullscreen infoPanel events hide">
					
					
				</div>
			</div>
			<div class="col-sm-2 fullscreen navigations">
				<div class="navigation_container">
					<button target-id="events" id="nav_btn" class="btn btn-block nav_btn"><i target-id="events" class="material-icons">event</i><div target-id="events"class="nav_title" >Events</div></button>
					<button target-id="donated" id="nav_btn" class="btn btn-block nav_btn"><i target-id="donated" class="material-icons">playlist_add_check</i><div target-id="donated" class="nav_title">Donated</div></button>
					<button target-id="contactus" class="btn btn-block nav_btn"><i target-id="contactus" class="material-icons">perm_contact_calendar</i><div target-id="contactus" class="nav_title">Contact Us</div></button>
				</div>

			</div>
		</div>
	</div>

</body>
</html>
