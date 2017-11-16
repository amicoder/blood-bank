
<form action="../processevent.php" method="post" enctype="multipart/form-data">
    

	<div class="custom_card" style="width: 20rem;">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label data="date">Date:</label>
										<input target-label="date" type="text" name="date" class="form-control custom-form-control" id="date">					    
									</div>
								</div>
								<div class="col-sm-8">
									<div class="form-group">
										<label >UPLOAD</label>
										<input type="file" name="fileToUpload" class="form-control custom-form-control" id="name">					    
									</div>
								</div>
							</div>
							
							
						    <div class="custom_card_content">
						    <div class="form-group">
								<label data="ename">Event Title:</label>
								<input target-label="ename" type="text" name="ename" class="form-control custom-form-control" id="name">					    
							</div>
						    <div class="custom_card_description">
						    	<div class="form-group">
							    	<label data="shortdesc">Short Description</label>
							    	<textarea target-label="shortdesc" type="text" name="shortdesc" class="form-control custom-form-control" id="address"></textarea>
						    	</div>

						    </div>
						    <div class="card_location"><i class="material-icons">place</i><div class="location_namr"><select name="locationid">
						    	<?php include '../api/getLocation.php' ?>
						    </select>
						     <button type="submit" value="Upload Image" name="submit" class="btn create_event"><i class="material-icons">add_circle</i></button>
						    </div></div>
						    
						  </div>
						</div>
   
</form>

