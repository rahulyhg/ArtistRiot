<div class="panel panel-profile" style="border:0px;background: rgb(102, 101, 99);">

    <!-- form start for edit option -->

	<!-- Modal -->


	<!--       Ending the form  --->
	<?php
	
	$firstName = $this->session->userdata('first_name');
	$lastName = $this->session->userdata('last_name');
	$subCategoryName = $this->session->userdata['sub_category_name'];
	
	?>
	<div id="personalinfo" class="wrap"
		style="overflow: hidden; height: 370px; cursor: -webkit-grab;">
		<div class="col-md-2">
			<button type="button" id="editcoverimage" class="btn btn-default dropdown-toggle profile-links edit-coverimage-button" data-toggle="dropdown" 
			style="position: absolute; z-index: 1;margin-top: 5px;">
          		<span class="glyphicon glyphicon-camera"></span> Edit <span class="caret"></span>
        	</button>
			<ul class="dropdown-menu"  aria-labelledby="editcoverimage" style="margin-left: 18px;margin-top: 37px;">
				<li><a href="#" id="uploadcoverphoto"><span class="glyphicon glyphicon-upload" style="color:rgb(60, 144, 60);"></span> Upload New Photo</a></li>
				<?php if(!empty( $this->session->userdata('user_cover_image'))){?>
				<li><a href="#" id="repositioncoverphoto"><span class="glyphicon glyphicon-move"></span> Reposition</a></li>
				<li><a href="#" id="deletecoverphoto"><span class="glyphicon glyphicon-remove" style="color:rgb(190, 13, 13);"></span> Remove</a></li>
				<?php }?>
			</ul>
		</div>
		
		
		
	<!--  	<div id="repo-text"
			style="right: 50%; left: 50%; top: 155px; display: none; position: absolute; z-index: 1;">
			Reposition</div> -->
		
		<div id="coverimagebuttons" class="btn-group col-md-offset-9 col-xs-offset-4 col-md-3 col-xs-8" style="top: 290px; position:absolute; z-index: 1; display:none;">
			
			<button type="button" id="canceledit" name="canceledit" class="btn btn-danger pre_btn signupbuttons " >Cancel</button>
			
			<button type="button" class="btn btn-success next_btn signupbuttons" 
				name="savecoverimage" id="savecoverimage">Save</button>
			
			<button type="button" class="btn btn-success next_btn signupbuttons" 
				name="repositioncoverimage" id="repositioncoverimage" style="display: none;">Save Changes</button>	
		</div>
		
		<input type="file" id="uploadcoverimagebutton" name="uploadbutton" 
		accept="image/jpeg,image/gif,image/png" style="top: 100px; position:absolute; z-index: -1;" />
		
		
	<?php
      if(!empty($userProfileData['cover_image_id'])){
      	logException('user_cover_image::'.$userProfileData['user_cover_image']) ;
       		echo '<img src="' . $userProfileData['user_cover_image']. '" class="dropdown-toggle profile-links cover-image img-responsive" 
						data-toggle="dropdown" style="top:'.$userProfileData['image_position'].';" id="coverimage" name="coverimage"/>';
       }	
       else{
       		echo '<img src="' . base_url().'images/uploads/singer.jpg" class="dropdown-toggle profile-links cover-image img-responsive"
						data-toggle="dropdown" style="height: 600px;" id="coverimage" name="coverimage"/>';
       }
    ?>
    	<div id="reposition-text" style="display:none;position: absolute; top:44%;font-size: 1.4em;left: 38%; background-color: rgb(229, 227, 227);opacity: 0.5;">
    		<span class="glyphicon glyphicon-align-justify"></span>Drag image to reposition
    	</div>
    	
    	<div id="coverimagename" style="position: absolute; top:60%;  font-weight: bold;  font-size: 2em;margin-left: 20px;color:white;">
			<div class="col-md-10"><?php if(!empty($firstName) && !empty($lastName)){
					echo $firstName.' '.$lastName;
			}?>
			</div>
			
			<div class="col-md-10"><span style="color:#c2c2c2;font-size: 0.7em;;"><?php if(!empty($subCategoryName)){
					echo $subCategoryName;
			}?></span>
			</div>
			
		</div>
		
		<!-- <div class="loader" style="position: absolute; top:50%;left:50%;width: 16px; height: 10px;display:none;
			background-image:url(<?php echo base_url()?>images/ajax-loader.gif);">
    			
    	</div> -->
			
       
		<input type="text" name="coverimagetop" id="coverimagetop" value="0" style="display:none;"/>
		<input type="hidden" name="coverimagefilename" value="" id="coverimagefilename" />
		<input type="hidden" name="coverimageheight" value="" id="coverimageheight" />
		<input type="hidden" name="coverimagewidth" value="" id="coverimagewidth" />
	</div>
	
</div>
	