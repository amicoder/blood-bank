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
		body{
			background-color: red;
		}

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
	<div class="fluid-container ">
		<div class="row ">
			<div class="col-sm-3 ">
				<div class="poster">
					
				</div> 
			</div>
			<div class="col-sm-6 ">

				<div class="dsu_formcontainer">
					<form name="donarLogin" action="processlogin.php" method="post">
						 
						   <div>Login</div>
						    <div class="form-group">
								<label data="uname">Username</label>
								<input target-label="uname" type="text" name="uname" class="form-control custom-form-control" id="uname" autocomplete="off">								    
						    </div>					  	
					  		<div class="form-group">
							    <label data="pword">Password</label>
							    <input target-label="pword" type="password" name="pword" class="form-control custom-form-control" id="pword">
							    
							</div>

						  <input type="submit" style="outline:none;border-radius: 200px; margin-top: 10px; width:100px;background-color: red" class="btn btn-danger" value="login">					   
					</form>
					<a class="btn" href="./donarSignUp.php">Signin</a>
				</div> 
			</div>
			<div class="col-sm-3 ">
				<div class="poster">
					
				</div> 
			</div>
		</div>
	</div>
</body>
</html>