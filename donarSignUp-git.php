<!DOCTYPE html>
<html lang="enUS">
<head>


	<!-- Latest compiled and minified CSS -->
	

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
	<link href="./css/style-git.css" rel="stylesheet">

	<script>
	$(document).ready(()=>{
		$("input").click(function() {

			var label = $("[data='"+$(this).attr("target-label")+"']");
			$(this).attr('value','');
			label.css({"z-index":"-1","opacity": "1", "transform": "translateY(10px)","font-size":"11px"});
			//alert("Clicked :"+label.attr("for"));
			

		});

		$("input").focus(function() {

			var label = $("[data='"+$(this).attr("target-label")+"']");
			$(this).attr('placeholder','');
			label.css({"z-index":"-1","opacity": "1", "transform": "translateY(10px)","font-size":"11px"});
			
			
			

			//alert("Clicked :"+label.attr("for"));
			
		});

		$("input").focusout(function() {

			if($(this).val() == ""){

				var label = $("[data='"+$(this).attr("target-label")+"']");
				
				label.css({"z-index":"-1","opacity": "1", "transform": "translateY(29px)","font-size":"13px"});
			}
			else{

			}
			
			//alert("Clicked :"+label.attr("for"));
			
		});

	});

	</script>

</head>

<body>
	<div class="fluid-container fullscreen">
		<div class="row fullscreen">
			
			<div class="col-sm-6 fullscreen">
				<div class="dsu_formcontainer">
					<form name="donarSignUp" action="donar/add.php" method="post">
						 
						    <div class="form-group">
							 	<label data="name" >Name</label>
								<input target-label="name" type="text" name="dname" class="form-control" id="name">	
									    
							</div>


						  <div class="row">
						  	<div class="col-sm-6">
								<div class="form-group">
								    <label class="form-label" for="gender">Gender</label>
								    <input type="text" name="gender" class="form-control" id="gender"  placeholder="Gender">
							    
							    </div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
								    <label for="bloodGroup">Blood Group</label>
								    <input type="txt" name="bloodGroup" class="form-control custom-from-control" id="bloodGroup" placeholder="Blood Group">	    
								</div>
							</div>
						  </div>
						  <div class="row">
						  	<div class="col-sm-6">
						  		<div class="form-group">
								    <label for="age">Age</label>
								    <input type="text" name="age" class="form-control custom-from-control" id="age" placeholder="Age">
								    
								</div>
								  
							</div>
							<div class="col-sm-6">
								  <div class="form-group">
								    <label for="weight">Weight</label>
								    <input type="txt" name="weight" class="form-control custom-from-control" id="weight" placeholder="Weight">
								    
								  </div>
							</div>
						  </div>

						   
						    <div class="form-group">
						    	<label for="address">Address</label>
						    	<textarea type="text" name="address" class="form-control custom-from-control" id="address"  placeholder="Enter address"></textarea>
						    </div>
						    <div class="form-group">
								<label for="uname">Username</label>
								<input type="text" name="uname" class="form-control custom-from-control" id="uname" placeholder="Username">								    
						    </div>


						      <div class="row">
						  	<div class="col-sm-6">
						  		<div class="form-group">
								    <label for="pword">Password</label>
								    <input type="password" name="pword" class="form-control custom-from-control" id="pword" placeholder="Password">
								    
								</div>
								  
							</div>
							<div class="col-sm-6">
								  <div class="form-group">
								    <label for="repword">Confirm Password</label>
								    <input type="password" name="pword" class="form-control custom-from-control" id="repword" placeholder="Confirm Password">
								    
								</div>
							</div>
						  </div>

						  <input type="submit" style="border-radius: 200px; margin-top: 10px; width:100px;background-color: red" class="btn btn-danger" value="Sign Up"/>
						   
						   
					</form>
				</div> 
			</div>
		</div>
	</div>
</body>
</html>