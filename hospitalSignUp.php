<!DOCTYPE html>
<html lang="enUS">
<head>


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
			label.css({"z-index":"8","opacity": "1", "transform": "translateY(10px)","font-size":"11px","color":"red"});
			//alert("Clicked :"+label.attr("for"));
			

		});

		$("input,textarea").focus(function() {

			var label = $("[data='"+$(this).attr("target-label")+"']");
			$(this).attr('placeholder','');
			label.css({"z-index":"8","opacity": "1", "transform": "translateY(10px)","font-size":"11px","color":"red"});
			
			
			

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

		</script>
	<style>
		label{
	
    	z-index: 5;
    
		}

		.custom-form-control{

			z-index: 6;
			position: relative;
		}
	</style>
</head>

<body>
	<div class="fluid-container fullscreen">
		<div class="row fullscreen">
			<div class="col-sm-6 fullscreen posterParent">
				<div class="poster">
					<h1 class="center">JOIN</h1>
					<h3 class="center">AND</h3>
					<h1 class="center">SAVE</h1>
					<h1 class="center">MILLIONS</h1>
				</div> 
			</div>
			<div class="col-sm-6 fullscreen">
				<div class="dsu_formcontainer">
					<form name="donarSignUp" action="./hospital/add.php" method="post">
						 
						   <div class="form-group">
								    <label data="name">Name</label>
								    <input target-label="name" type="text" name="hname" class="form-control custom-form-control" id="name">
							    
							    </div>
						 
						    <div class="form-group">
								<label data="uname">Username</label>
								<input target-label="uname" type="text" name="uname" class="form-control custom-form-control" id="uname">								    
						    </div>


						      <div class="row">
						  	<div class="col-sm-6">
						  		<div class="form-group">
								    <label data="pword">Password</label>
								    <input target-label="pword" type="password" name="pword" class="form-control custom-form-control" id="pword">
								    
								</div>
								  
							</div>
							<div class="col-sm-6">
								  <div class="form-group">
								    <label data="repword">Confirm Password</label>
								    <input target-label="repword" type="password" name="pword" class="form-control custom-form-control" id="repword">
								    
								</div>
							</div>
						  </div>

						  <input type="submit" style="outline:none;border-radius: 200px; margin-top: 10px; width:100px;background-color: red" class="btn btn-danger" value="Sign Up"/>
						   
						   
					</form>
				</div> 
			</div>
		</div>
	</div>
</body>
</html>