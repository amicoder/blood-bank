<!DOCTYPE html>
<html>
<head>
	<title></title>

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

		$("input,textarea").click(function() {

			var label = $("[data='"+$(this).attr("target-label")+"']");
			$(this).attr('value','');
			label.css({"z-index":"1","opacity": "1", "transform": "translateY(10px)","font-size":"20px","color":"red"});
			//alert("Clicked :"+label.attr("for"));
			

		});

		$("input,textarea").focus(function() {

			var label = $("[data='"+$(this).attr("target-label")+"']");
			$(this).attr('placeholder','');
			label.css({"z-index":"1","opacity": "1", "transform": "translateY(10px)","font-size":"20px","color":"red"});
			
			
			

			//alert("Clicked :"+label.attr("for"));
			
		});

		$("input,textarea").focusout(function() {

			if($(this).val() == ""){

				var label = $("[data='"+$(this).attr("target-label")+"']");
				
				label.css({"z-index":"-1","opacity": "1", "transform": "translateY(29px)","font-size":"50px","color":"grey"});
			}
			else{

			}
			
			//alert("Clicked :"+label.attr("for"));
			
		});


	});

	function onClickBloodGroup(bg){

		$("#bloodGroup").val(bg);

	}
	function collectBlood(){
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

		
		fetch("./bank/collectBlood.php",{
			method:'POST',
			body:fdata
		})
		.then((response)=>{

			if (response.status !== 200) {  
		        console.log('Looks like there was a problem. Status Code: ' +  
		          response.status);  
		        return;  
		    }

		    
		   response.json().then(data=>{
		    	if(data.status === "true"){
		    		console.log("Succesfully collected blood");
		    		location.reload();
		    	}else{
		    		console.log("Error in collecting blood");
		    	}
		   });

		})
		.catch((err)=>{
			 console.log('Fetch Error :-S', err); 
		});


	
	}

	</script>
	<style>

	.custom-form-control{
		height: 100px;
		font-size: 50px;
	}

	label{
		font-size: 50px;
	}
	</style>

</head>
<body>
	<div class="container fullscreen">
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
