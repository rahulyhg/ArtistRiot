
<?php
if (!empty($this->session->userdata('user_id')))
{
    ?>
	<div id="changeprofilepic">
    <a id="user-profile-pic" href="<?php  echo base_url().'profile/artist' ?>">
           <?php
      
       $userImageName = $this->session->userdata('user_image');
       
       if(!empty($userImageName)){  
       		echo '<img src="' . base_url() .$userImageName. '" id="profile-pic" class="img-thumbnail padding-0" width="275px" height="275px" />';
       }	
       else{
       		echo '<img src="' . base_url() . 'images/uploads/p.jpg" id="profile-pic" class="img-thumbnail padding-0" width="275px" height="275px" />';
       }
       ?>
       </a>
     
	 
	 <div class="edit-profile-pic" style="text-align:center;">
                	<a data-target="#editProfilePic" data-toggle="modal"><p><span class="glyphicon glyphicon-camera" style="color:white;">
                	Update profile picture</span></p></a> 
     </div>
     </div>
	 
     <?php } ?>
    <!-- Modal -->
    <div class="modal fade col-md-12" id="editProfilePic" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button"><span class="glyphicon glyphicon-remove-circle" 
                    style="color:black;"></span></button>

                    <h4 class="modal-title" id="myModalLabel">Choose Your best
                        picture for your Profile.</h4>
                </div>
                
                <div class="row">
					
					<div class="col-md-4 col-lg-4 col-centered" style="margin-left: 25px;">
						<p><span class="boldtext bmargin10">Image upload instructions.</span></p>
						<ol>
							<li>Image format must be jpg, png or gif</li>
							<li>Image must be of atleast 300px in width and 300px in height.</li>
							<li>Image size must be less than 8 MB.</li>
						</ol>	
				
					<div class="linespacer">
						<button name="uploadbutton" id="uploadbutton" class="btn" style="width: 100%;">Upload photo</button>
						<input type="file" name="editprofileimageupload" id="editprofileimageupload" class="btn" style="display:none;"/>
					</div>
						
					
					<div class="linespacer profileimagesavebuttons row-centered">
					
					<button style="width: 45%;"
								class="btn"
								name="cancelimageupload" id="cancelimageupload">Cancel</button>
								
					<button style="width: 45%;"
								class="btn btn-success next_btn signupbuttons"
								name="saveimagebutton" id="saveimagebutton">Crop and Save</button>					
					
					</div>
					
					</div>
					
					<div class="col-md-offset-1 col-lg-offset-1 col-md-6 col-lg-6 center-horizontal" style="margin-left: 25px;">
						<div class="form-group text-center row-centered">
							<p class="instructions">Crop image. </p>
							<!--Image container that we will use to crop-->

							<div id="profile-image-div" class="text-center center-horizontal row-centered" style="display: inline-block;width: 300px; overflow: hidden; border: 1px solid">
								 <img id="edit-profile-image" 
									src="<?php echo base_url() ?>images/avatar.png"
									style="width: 300px;" />
							</div>
							
						</div>
						
						
					</div>
					</div>
					
					<div class="form-group">
						
							<!--Image selection x,y position, with height and with input container-->
							<input type="text" id="x1" name="x1" value="0" style="display:none;" /> 
							<input type="text" name="w" value="0" id="w" style="display:none;" /> 
							<input type="text" id="y1" name="y1" value="0" style="display:none;" /> 
							<input type="text" id="h" name="h" value="0" style="display:none;" /> 
							<input type="text" name="x2" id="x2" value="0" style="display:none;"/>
							<input type="text" name="y2" id="y2" value="0" style="display:none;"/>
							<input type="hidden" name="filename" value="" id="filename" /> <br>

					</div>	

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
