
<?php
	session_start();
	$hid = "";

	if(isset($_SESSION['hid'])){
		$hid = $_SESSION['hid'];
		//echo $_SESSION['hid']." ".$_SESSION['hname'];
	}

	if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
		echo '<div class="alert alert-danger alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong>ERROR!</strong> '.$_SESSION["error"].'
			</div>';

			$_SESSION['error'] = "";
	}
?>
<!DOCTYPE html>
<html>
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
			var cart = [];
			var products = [];
			$(document).ready(()=>{

				loadProduct();

				if('<?php echo $hid?>'===""){
					console.log("Not Login");
					$('.order_submit_button').css("display","none");
					$('.order_submit_button_login').css("display","flex");
					
				}
				else{
					$('.order_submit_button').css("display","flex");
					$('.order_submit_button_login').css("display","none");
				}
				$(".nav_btn_2").click((e)=>{
					//console.log(e)
						$(".nav_btn_2").removeClass("custom_active");
						$(e.target).addClass("custom_active")
						//$(e.target).css("width","200px");
						$(".orderPanel").removeClass("show");
						//var targerobject = $(e.target).attr("target-id");
						//$("#"+$(e.target).attr("target-id")).addClass("show");
						//console.log($(e.target).attr("target-id"));

						var target =  $(e.target).attr("target-id");
						$("#"+target).addClass("show");
					
					//alert(target);
				});


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
						
						label.css({"z-index":"2","opacity": "1", "transform": "translateY(29px)","font-size":"13px","color":"grey"});
					}
					else{

					}
					
					//alert("Clicked :"+label.attr("for"));
					
				});
				
				
			});

			

			function orderBuilder(pid,pname,bg){

				var q = $('#pid'+pid).val();
				var order = {"pid":pid,"pname":pname,"bg":bg,"quantity":q};
				cart.push(order);
				console.log(cart);

				refreshOrderList();

			}

			function deleteOrder(index){

				var newCart = [];

				cart.forEach((val,ind)=>{

					if(ind !== index){

						newCart.push(val);
					}

				});

				cart = newCart;
				refreshOrderList();
			}

			function loadMyOrders(){

				$("#myorders").html("");
				var fdata = new FormData();
				console.log("<?php echo $hid; ?>");
				fdata.append("hid","<?php echo $hid; ?>");
				fetch('./hospital/myorders.php',{
					method:'POST',
					body:fdata
				})
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
									'<h5>Date : '+val.odate+'</h5>'+
									'<h5>Blood Group : '+val.bloodGroup+'</h5>'+
									'<h5>quantity : '+val.quantity+'</h5>'+
									(val.status==0?'<h5 class="pending">pending</h5>':'<h5 class="com">completed</h5>')+
								'</div>'+
							'</div>';

				      			$("#myorders").append(p);
				      		})
				      	})
					})
					.catch(error=>{

					});
			}

			function refreshOrderList(){
				$('#order_list').html("");

				cart.forEach((item,index)=>{
					var hitem = '<div id="order_list">'+
								'<div class="order_item">'+
								'<table  class="table table-bordered custom_table">'+
								'<tr>'+
								'<td class="custom_td" style="border: 0px solid;padding: 15px;" >'+unescape(item.pname)+'</td>'+
								'<td class="custom_td" style="border: 0px solid;padding: 15px;" >'+item.bg+'</td>'+
								'<td class="custom_td" style="border: 0px solid;padding: 15px;" >'+item.quantity+'</td>'+
								'<td class="custom_td detete_item" style="border: 0px solid;padding: 15px;" onclick=deleteOrder('+index+')>X</td>'+
								'</tr>'+
								'</table>'+
								'</div>'+

							'</div>';
					$('#order_list').append(hitem);
				});
			}
			function orderSubmit(){

				if(cart == []) return;
				var d = new FormData();
				d.append( "hid" ,"<?php echo $hid ?>");
				var cartjson = JSON.stringify(cart);
				d.append( "orders" ,cartjson);

				
				console.log(cartjson);

				fetch('./bank/createorder.php',
					{ 
						method:'POST',
						dataType:'json',
						body:d
					})
					.then(response=>{

						if (response.status !== 200) {  
					        console.log('Looks like there was a problem. Status Code: ' +  
					          response.status);  
					        return;  
					    }

					    console.log(response.text());
						location.reload();
					})
					.catch(error=>{
						console.log(error);
					});
			}
			function loadProduct(){

				fetch('./bank/products.php')
					.then(response=>{
						if (response.status !== 200) {  
				          console.log('Looks like there was a problem. Status Code: ' +  
				          response.status);  
				          return;  
				      	}

				      	//console.log(response.text());

				      	response.json().then(data=>{
				      		products = data.data;
				      		console.log(products);
				      		data.data.forEach((val,index)=>{
				      			var p = '<div class="custom_card_2 bg_white" style="width: 25%;height: 32rem;">'+
								'<div class="custom_img_holder">'+
									'<img src="./img/blood_bag.png" height="170px" />'+
								'</div>'+
								'<div class="custom_card_bottom">'+
									'<h4>'+val.pname+'</h4>'+
									'<div class="custom_card_snippt">Availability '+val.quantity+' ml</div>'+
									'<div class="range_holder">'+
										'<input id="pid'+val.pid+'" class="form-control range" placeholder="Quantity" />'+
										"<button class=\"btn btn-success range_btn\" onClick=orderBuilder(\""+val.pid+"\",'"+escape(val.pname)+"',\""+val.bloodGroup+"\")><span class=\"glyphicon glyphicon-plus\"></span></button>"+
									'</div>'+
								'</div>'+
							'</div>';
				      			$("#prod").append(p);
				      		})
				      	})
						
						
					})
					.catch(error=>{

					});
			}

		</script>
		<style>
			label{
				z-index: 2
			}

			.custom_td{
    			border: 0px solid;
    			padding: 15px;
			}
		</style>
	</head>
	<body class="bg_whitesmoke">
		<div class="fluid-container custom-nav-bar-2">
			<div class="row">
				
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="container">
						<div class="custom-nav-bar-2">
						<div class="custom-nav-bar-2-front">

						</div>
						<div class="custom-nav-bar-2-last">
							<div class="nav-bar-open"></div>
							<button target-id="prod"  class="btn nav_btn_2 custom_active">ITEMS</button>
							<button target-id="myorders"  class="btn nav_btn_2 order_submit_button" onclick=loadMyOrders() >MY ORDERS</button>
							
							<button target-id="orderSummary" id="nav-btn-last" class="btn nav_btn_2">CART</button>
							<div class="donar_sign"><a class="donar_link" href="./Login.php">I WANT TO DONATE</a></div>
							<a  id="nav_btn" class="btn nav_btn_2 nav_logout order_submit_button" href="./hospital/logout.php"><span class="glyphicon glyphicon-log-out"></a>
							<button  target-id="login" class="btn nav_btn_2 nav_logout order_submit_button_login"><span target-id="login" class="glyphicon glyphicon-log-in"></button>
						</div>

					</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="fluid-container">
			<div class="row">
				<div class="container">
					<div class="row">
						<div id="prod" class="col-sm-12 orderPanel hide show">
						<!--
							<div class="custom_card bg_white" style="width: 25rem;height: 32rem;">
								<div class="custom_img_holder">
									<img src="./img/blood_bag.png" height="170px" />
								</div>
								<div class="custom_card_bottom">
									<h4>Blood Bag A+</h4>
									<div class="custom_card_snippt">Availability 5000 ml</div>
									<div class="range_holder">
										<input class="form-control range" placeholder="Quantity" />
										<button class="btn btn-success range_btn"><span class="glyphicon glyphicon-plus"></span></button>
									</div>
								</div>
							</div>
						-->
						</div>

						<div id="orderSummary" class="col-sm-12 orderPanel hide ">
							<div id="order_list">
								<!--
								<div class="order_item">
									<table  class="table table-bordered custom_table">
										  <tr>
										    <td class="custom_td" style="border: 0px solid;padding: 15px;" >A+ BAG</td>
										    <td class="custom_td" style="border: 0px solid;padding: 15px;" >A+</td> 
										    <td class="custom_td" style="border: 0px solid;padding: 15px;" >500</td>
										 </tr>
									</table>
								</div>-->

							</div>
							<div>
								<div id="order_submit_button" class="order_submit_button order_holder">
								<div class="form-group"><input class="form-control" type="text" placeholder="Phone No"/></div>
								<button  class="btn btn-success btn-block" onClick=orderSubmit()>ORDER</button>
								</div>
								<div class="order_submit_button_login order_holder">
								<button id="" target-id="login" class="nav_btn_2 nav_btn_mod btn btn-success  " >LOGIN TO ORDER</button>
								</div>
							</div>
						</div>
						<div id="myorders" class="col-sm-12 orderPanel hide ">
							<div class="custom_card_3 addpadding">
								<div class="strip"></div>
								<div class="custom_body">
									<h3>A+ Blood</h3>
									<h5>Date:2017-1-26</h5>
									<h5>Blood Group:A+</h5>
									<h5>quantity:150</h5>
									<h5 class="pending">pending</h5>

								</div>
							</div>
						</div>
						<div id="login" class="col-sm-12 orderPanel hide ">
							
							<div class="row row_l">
								
								<div class="col-sm-6">
									
									<form class="form_des" name="hospitalLogin" action="./hospital/processlogin.php" method="post">
						 				
									   <div class="hospital_login">HOSPITAL LOGIN</div>
									    <div class="form-group">
											<label data="uname">Username</label>
											<input target-label="uname" type="text" name="uname" class="form-control custom-form-control" id="uname" autocomplete="off">								    
									    </div>					  	
								  		<div class="form-group">
										    <label data="pword">Password</label>
										    <input target-label="pword" type="password" name="pword" class="form-control custom-form-control" id="pword">
										    
										</div>

									  <input type="submit" style="outline:none;border-radius: 0px; margin-top: 10px; width:100px;background-color: red;    height: 50px;" class="btn btn-danger" value="login">					   
									</form>
									<div class="hospital_signup"><a href="./hospitalSignUp.php">Sign Up</a></div>
									
								</div>
								
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>