<?php 
	//session_start();
	
		include "../api/classes.php";
		session_start();
		if(!isset($_SESSION['bid'])){
			//echo "Bid not set";
			
				
				$request = new CustomHandleHttpRequest();

				if($request->bankLogin() == 2){
					//echo "POST METHOD";
					$_SESSION['bid'] = 'admin';
				}else if($request->bankLogin() == 1){
					$_SESSION["error"] = 1;

					header('Location: ./');
				}
				else{
					header('Location: ./');
				}
			
		}
		else{
			//echo "Bid is set";
		}
		/*
		$request = new CustomHandleHttpRequest();

		if($request->bankLogin()){

		}else{

		}*/


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
	<link href="../css/style.css" rel="stylesheet">

	<script>

	$(document).ready(()=>{
		//Load informations
		
		loadUpcomingEvents();
		loadProducts();
		loadCurrentOrders();
		loadDontions();
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
	 
	function deleteEvent(eid){

		var formdata = new FormData();
		formdata.append( "eid", ""+eid );

		fetch("./processdelete.php",{
			method: 'post',
			body : formdata
		})
			.then((response)=>{

					console.log(response.text());
				loadUpcomingEvents();
			})
			.catch(e=>{

			});
	}
	function loadUpcomingEvents(){

		$("#event_cards").html("");

		fetch("./getEvents.php")
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
		      			var ecard = "<div class='custom_card' >"+
		      			"<button class='edateStamp delete' onClick=deleteEvent("+value.eid+")>X</button>"+
							"<div class='edateStamp'><div class='edate'>"+d[2]+"</div><div class='emonth'>"+getMonth(d[1])+"</div></div>"+
						  "<img class='custom_card_img' src='../"+value.src+"' alt='Card image cap' height='150px' >"+
						  "<div class='comingsoon'>COMING SOON</div>"+
						  "<div class='custom_card_content'>"+
						    "<h4 class='custom_card_title'>"+value.ename+"</h4>"+
						    "<div class='custom_card_description'>"+value.shortdesc+"</div>"+
						   "<div class='card_location'><i class='material-icons'>place</i><div class='location_namr'>"+value.venue+"</div></div>"+
						   (value.canstart == 'true'?"<div class='card_start'><button class='btn btn-success' onclick=startEvent("+value.eid+")>START EVENT</div>" :"")+
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
	function onClickChange(from,to){
		$('.'+from+'').removeClass('show');
		$('.'+to+'').addClass('show');
	}
	function onClickBloodGroup(bg){

		$("#bloodGroup").val(bg);

	}
	var eid = "";
	function startEvent(id){

		eid = id;
		alert("Staring Event For eid :"+eid);

		$('.main-pane').removeClass('show');
		$('.collet-pane').addClass('show');

	}

	function approve(oid){

		var fdata = new FormData();

		fdata.append("oid",oid);

		fetch("./approveorder.php",{
			method:'POST',
			body:fdata
		})
		.then(response=>{
			if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		    }

		    response.json().then(data=>{
		    	if(data.status === "true"){
		    		console.log("Succesfully placed order");
		    		loadCurrentOrders();
		    		//location.reload();
		    	}else{
		    		console.log("Error in collecting blood");
		    	}
		   });

		})
		.catch((er)=>{

		});
	}
	function collectBlood(){

		if(eid != ""){
			if($("#donarcode").val()=="" && $("#qunatity").val()=="" && $("#bloodGroup").val()=="") return;
		var fdata = new FormData();
		/*
			data.append( "did", ""+$("donarcode").val() );
			data.append( "quantity", ""+$("#qunatity").val());
			data.append( "bloodGroup",""+$("#bloodGroup").val());
	    */
			fdata.append( "did", ""+$("#donarcode").val());
			fdata.append( "quantity", ""+$("#qunatity").val());
			fdata.append( "bloodGroup",""+$("#bloodGroup").val());
			fdata.append( "eid",""+eid);

		
		fetch("./processcollection.php",{
			method:'POST',
			body:fdata
		})
		.then((response)=>{

			if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		    }

		    //console.log(response.text());
		   response.json().then(data=>{
		    	if(data.status === "true"){
		    		console.log("Succesfully collected blood");
		    		//location.reload();
		    	}else{
		    		console.log("Error in collecting blood");
		    	}
		   });

		})
		.catch((err)=>{
			 console.log('Fetch Error :-S', err); 
		});
		}
		
	
	}


	function getMonth(mon){
		var monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "DEP", "OCT", "NOV", "DEC"];

		return monthNames[(mon-1)];
	}
	var count =0;
	
	$(document).ready(()=>{

		$("input,textarea").click(function() {

			var label = $("[data='"+$(this).attr("target-label")+"']");
			$(this).attr('value','');
			label.css({"z-index":"5","opacity": "1", "transform": "translateY(10px)","font-size":"11px","color":"red"});
			//alert("Clicked :"+label.attr("for"));
			

		});

		$("input,textarea").focus(function() {

			var label = $("[data='"+$(this).attr("target-label")+"']");
			$(this).attr('placeholder','');
			label.css({"z-index":"5","opacity": "1", "transform": "translateY(10px)","font-size":"11px","color":"red"});
			
			
			

			//alert("Clicked :"+label.attr("for"));
			
		});

		$("input,textarea").focusout(function() {

			if($(this).val() == ""){

				var label = $("[data='"+$(this).attr("target-label")+"']");
				
				label.css({"z-index":"5","opacity": "1", "transform": "translateY(29px)","font-size":"13px","color":"grey"});
			}
			else{

			}
			
			//alert("Clicked :"+label.attr("for"));
			
		});


	});

	function loadDontions(){


		fetch("./alldonations.php")
		 .then(  
		    function(response) {  
		      if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		      }
		     
		      response.json().then((data)=>{
		      	
		      	
		      	data.data.forEach((key,index)=>{

		      		
		      		var newHtml = "<tr><td>"+key.dname+"</td><td>"+key.ename+"</td><td style='color: red'>"+key.quantity+"</td><td>"+key.date+"</td><tr>";

		      		$('#donationList').append(newHtml);
		      		
		      		
		      	});


		      });
		     
		    }  
		  )  
		  .catch(function(err) {  
		    console.log('Fetch Error :-S', err);  
		  });
	}

	function loadCurrentOrders(){

				$("#orders").html("");
				
				fetch('./currentorders.php')
					.then(response=>{
						if (response.status !== 200) {  
				          console.log('Looks like there was a problem. Status Code: ' +  
				          response.status);  
				          return;  
				      	}

				      	//console.log(response.text());

				      	response.json().then(data=>{
				      		var myorders = data.data;
				      		console.log(myorders);

				      		data.data.forEach((val,index)=>{
				      			var p ='<div class="custom_card_3 addpadding whitebg">'+
								'<div class="strip"></div>'+
								'<div class="custom_body">'+
									'<h3>'+val.pname+'</h3>'+
									'<h5>Order By : '+val.hname+'</h5>'+
									'<h5>Date : '+val.odate+'</h5>'+
									'<h5>Blood Group : '+val.bloodGroup+'</h5>'+
									'<h5>quantity : '+val.quantity+'</h5>'+
									(val.status==0?'<button class="btn btn-success" onclick=approve('+val.oid+')>APPROVE</button>':'<h5 class="com">completed</h5>')+
								'</div>'+
							'</div>';

				      			$("#orders").append(p);
				      		})
				      	})
					})
					.catch(error=>{

					});
			}

		function loadProducts(){


		fetch("./products.php")
		 .then(  
		    function(response) {  
		      if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		      }
		     
		      response.json().then((data)=>{
		      	
		      	console.log(data);
		      	data.data.forEach((value,index)=>{
		      		var item = '<div class="custom_card_3 whitebg" style="width: 20rem;">'+
						   //'<img class="custom_card_img" src="../img/dcard.jpg" alt="Card image cap" height="150px" >'+
						    '<div class="custom_card_desc">'+
					    	'<h4>'+value.pname+'</h4>'+
					    	'<h5>BG : '+value.bloodGroup+'</h5>'+
					    	'<h5>QUANTITY : '+value.quantity+'</h5>'+
						    '</div>	'+ 
							'</div>';

					$('#products').append(item);
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
		.csn{
			font-size: x-large;
		}

		label{
	
    	z-index: 5;
    
		}

		.custom-form-control{

			z-index: 6;
			position: relative;

		}
		.create_event{
			position: absolute;
		    bottom: 0px;
		    right: 2px;
		}
		input[type=file] {
			opacity: 0;
		}
	</style>
</head>
<body style="background-color:  rgb(237, 237, 237);">
	<div class="container">
		<div class="row">
			<nav class="navbar navbar-inverse custom-nav-bar">
			  <div class="container-fluid">
			  	<h2>WELCOME ADMIN</h2>
			  	 <ul class="nav navbar-nav hide collet-pane">
			      <li class="active "><a href="#" onClick="onClickChange('collet-pane','main-pane')" ><span class="glyphicon glyphicon-chevron-left"></span>Back</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
			      <li><a class="csn" href="./logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			    </ul>
			  </div>
			</nav>
		</div>
	</div>

	<div  class="container fullscreen hide show main-pane">
	
		<div class="row fullscreen" style="padding-top: 0px; padding-bottom: 50px;">
			<div class="col-sm-2  profileContainer">
				<div class="navigation_container">
					<button target-id="events" id="nav_btn" class="btn btn-block nav_btn"><i target-id="events" class="material-icons">event</i><div target-id="events"class="nav_title" >Events</div></button>
					<button target-id="donated" id="nav_btn" class="btn btn-block nav_btn"><i target-id="donated" class="material-icons">playlist_add_check</i><div target-id="donated" class="nav_title">Donated</div></button>
					<button target-id="orders" id="nav_btn" class="btn btn-block nav_btn"><i target-id="orders" onclick=loadCurrentOrders() class="material-icons">playlist_add_check</i><div target-id="orders" class="nav_title">Orders</div></button>
					<button target-id="products" class="btn btn-block nav_btn"><i target-id="products" class="material-icons">perm_contact_calendar</i><div target-id="products" class="nav_title">Products</div></button>
					<button target-id="create" class="btn btn-block nav_btn"><i target-id="create" class="material-icons">perm_contact_calendar</i><div target-id="contactus" class="nav_title">Create Event</div></button>
				</div>
			</div>

			<div class="col-sm-10 fullscreen ">
				<div id="donated" class="fullscreen infoPanel hide">
					<div class="tableContainer">
						<table class="table">
						    <thead>
						      <tr>
						        <th>Donar Name</th>
						        <th>Event Name</th>
						        <th>Quantity</th>
						        <th>Date</th>
						      </tr>
						    </thead>
						    <tbody id="donationList">
						     
						    </tbody>
						</table>
					</div>
				</div>
				<div id="products" class="infoPanel events hide">
					<!--
					<div class="custom_card" style="width: 20rem;">
						    <img class="custom_card_img" src="../img/dcard.jpg" alt="Card image cap" height="150px" >
						    <div class="custom_card_desc">
						    	<h4>A+BLOOD</h4>
						    	<h5>BG</h5>
						    	<h5>QUANTITY:</h5>
						    </div>	 
					</div>
				-->
				</div>
				<div id="orders" class="infoPanel events hide ">
				</div>
				<div id="events" class=" infoPanel events hide show">
					
					<div id='event_cards' class="event_cards">
						
						<div class="custom_card" style="width: 20rem;">
							<button class="edateStamp delete" onClick=deleteEvent()>X</button>
							<div class="edateStamp"><div class="edate">20</div><div class="emonth">Nov</div></div>
						    <img class="custom_card_img" src="./img/dcard.jpg" alt="Card image cap" height="150px" >
						    <div class="custom_card_content">
						    <h4 class="custom_card_title">Card title</h4>
						    <div class="custom_card_description">Some quick example text to build on the card title and make up the bulk of the card's content.</div>
						    <div class="custom_card_description">Some quick example text to build on the card title and make up the bulk of the card's content.</div>
						    <div class="custom_card_description">Some quick example text to build on the card title and make up the bulk of the card's content.</div>
						    <div class="card_location"><i class="material-icons">place</i><div class="location_namr">Kormangala</div></div>
						    
						  </div>
						</div>
					</div>
					
				</div>
				<div id="product" class="productpanel hide">
					<div class="circle">
						<div class="group">A+</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_a+">4000</div>
					</div>
					<div class="circle">
						<div class="group">B+</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_b+">250</div>
					</div>
					<div class="circle">
						<div class="group">O+</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_o+">654</div>
					</div>
					<div class="circle">
						<div class="group">AB+</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_ab+">4000</div>
					</div>
					<div class="circle">
						<div class="group">A-</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_a-"> 250</div>
					</div>
					<div class="circle">
						<div class="group">B-</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_b-">654</div>
					</div>
					<div class="circle">
						<div class="group">O-</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_o-">250</div>
					</div>
					<div class="circle">
						<div class="group">AB-</div>
						<img src="../img/blood_bag.png" class="circle_img">
						<div class="circle_item" id="g_ab-">654</div>
					</div>
				</div>
				<div id="create" class=" infoPanel  hide ">
					<?php include '../createEvent.php'; ?>
				</div>
			</div>

		</div>
	</div>

	<div class="container fullscreen hide collet-pane">
		<dir class="row fullscreen startCollection" hidden>
			<dir class="col-sm-12 fullscreen">
				
				<button class="btn btn-danger" style="background-color: red"> START COLLECTING BLOOD </button>
			</dir>
		</dir>
		<dir class="row fullscreen collectInfo" >
			<dir class="col-sm-12 fullscreen">
				<div class="form-group">
					<label data="donarcode">Donar Code</label>
					<input target-label="donarcode" type="text" name="uname" class="form-control custom-form-control" id="donarcode" autocomplete="off">								    
				</div>
				<div class="donarBloodInfo">
					<div class="form-group">
						<label data="qunatity">Quantity</label>
						<input target-label="qunatity" type="text" name="uname" class="form-control custom-form-control" id="qunatity" autocomplete="off">								    
					</div>

					<div class="row">
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('A+')>A+</button></dir>
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('O+')>O+</button></dir>
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('B+')>B+</button></dir>
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('AB+')>AB+</button></dir>
					</div>
					<div class="row">
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('A-')>A-</button></dir>
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('O-')>O-</button></dir>
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('B-')>B-</button></dir>
						<dir class="col-sm-3"><button class="btn btn-danger" onClick=onClickBloodGroup('AB-')>AB-</button></dir>
					</div>
					<div class="form-group">
						<label data="bloodGroup">Blood Group</label>
						<input target-label="bloodGroup" type="text" name="bloodGroup" class="form-control custom-form-control" id="bloodGroup" autocomplete="off" readonly>
					</div>
					<div class="row">
						<button class="btn btn-danger"  onClick=collectBlood()> COLLECT </button>
					</div>
				</div>
			</dir>
		</dir>
	</div>

</body>
</html>
