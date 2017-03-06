<?php
	
	$firstName = $userProfileData['first_name'];
	$lastName = $userProfileData['last_name'];
	$subCategoryName = $userProfileData['sub_category_name'];
	
?>

<div class="panel panel-profile" style="border:0px;background: rgb(102, 101, 99);">

	<div id="personalinfo" class="wrap"
		style="overflow: hidden; height: 370px; cursor: -webkit-grab;">
			
		
		<?php
      	if(!empty($userProfileData['user_cover_image'])){ 
       		echo '<img src="' . $userProfileData['user_cover_image']. '" class="dropdown-toggle profile-links cover-image" 
						data-toggle="dropdown" style="top:'.$userProfileData['image_position'].';" id="coverimage" name="coverimage"/>';
       }	
       else{
       		echo '<img src="' . base_url().'images/uploads/singer.jpg" class="dropdown-toggle profile-links cover-image"
						data-toggle="dropdown" style="height: 600px;" id="coverimage" name="coverimage"/>';
       }
       ?>
       
       <div id="coverimagename" style="position: absolute; top:60%;  font-weight: bold;  font-size: 2em;;margin-left: 20px;color:white;">
			<div class="col-md-10"><?php if(!empty($firstName) && !empty($lastName)){
					echo $firstName.' '.$lastName;
			}?>
			</div>
			<div class="col-md-10"><span style="color:#c2c2c2;font-size: 0.7em;;"><?php if(!empty($subCategoryName)){
					echo $subCategoryName;
			}?></span>
			</div>
			
		</div>
		
		<input type="text" name="coverimagetop" id="coverimagetop" value="0" style="display:none;"/>
		<input type="hidden" name="coverimagefilename" value="" id="coverimagefilename" />
		<input type="hidden" name="coverimageheight" value="" id="coverimageheight" />
		<input type="hidden" name="coverimagewidth" value="" id="coverimagewidth" />
	</div>
	

</div>
	