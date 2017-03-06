		
<?php 
$firstName = $this->session->userdata('first_name');
$lastName = $this->session->userdata('last_name');
$subCategoryName = $this->session->userdata['sub_category_name'];
?>
<div class="well" id="well">          

	<div class="row" style="margin-left:0px;">
	
	<div class="col-md-4 col-xs-4" style="float:left;">
		<span style="float:left;"><h4>Photos</h4></span>
	</div>
	
	<?php  if(!empty($this->session->userdata('user_id'))){?>
	<div class="btn col-md-8 col-xs-4 add-buttons" >
		<button type="button" class="btn btn-success" style="float:right;" data-target="#addphotosmodal" data-toggle="modal" 
		name="addphotos" id="addphotos"><i class="glyphicon glyphicon-plus"></i> Add Photos</button>
	</div>
	
	<?php }?>
    </div>
    
    <div class="row wrapper-parent " id="galleryImageSection" style="margin-left:0px;">
        <?php 
       
        if(!(is_null($userGalleryImageData)) && (sizeof($userGalleryImageData) > 0) && ($userGalleryImageData != '') ){

		foreach ( $userGalleryImageData as $imagedata ) {
		?>
        
        <div id="img_<?php echo $imagedata['image_id'] ?>" class="col-sm-3 col-lg-3 col-xs-12 col-md-3 gallery-image-div linespacer">
        
        	<div class="img-wrap">
    			<button type="button" class="btn btn-default btn-xs delete-image" title="Delete image" >
      				<span class="glyphicon glyphicon-trash"></span>
      				<span class="image-id" style="display:none;"><?php echo $imagedata['image_id'] ?></span>
   				</button>
    		</div>
    		
    		<a href="<?php echo $imagedata['image_path'] ?>" class="overlay" 
    			data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="<?php echo $imagedata['image_description'] ?>" >
            </a>
            	
			<div style="background-image: url(<?php echo $imagedata['image_path'] ?>); background-size: cover;display:block; background-position:center;" 
				class="img-thumbnail padding-0 img-responsive">
            	
            </div>
            <div class="caption" style="display: none;">
                	<?php echo $imagedata['image_description'] ?> 
            </div>
             
        </div>
        
        <?php }
        }?>
        
        
    </div>
    
    <div class="loader_image row-centered"><img src="<?php echo base_url() ?>images/load.gif"></div>
    
    <div class="modal fade" id="addphotosmodal" tabindex="-1">
    	<div class="blocking-div"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">
                    	<span class="glyphicon glyphicon-remove-circle" style="color:black;"></span>
                    </button>

                    <h4 class="modal-title" id="myModalLabel">Add Photo</h4>
                </div>
                <div class="row">
                <?php
					$attributes = array (
							'id' => 'addphotoform',
							'data-toggle' => 'validator',
							'enctype' => 'multipart/form-data' 
					);
					echo form_open_multipart( base_url().'profile/managephotos/uploadgalleryimages', $attributes );
				?>
					
				
						<div class="col-md-12">
							
							<!--Image container that we will use to crop-->
							
							<div class="col-md-offset-3 col-md-6 spacer imagesection" style="display:none;">
								 <img id="galleryimage" name="galleryimage" src="" class="img-responsive img-thumbnail" />
							</div>
							<div class="col-md-offset-3 col-md-6 spacer imagesection" style="display:none;">
								<textarea class="form-control" id="imagedescription"
								name="imagedescription" rows="3" placeholder="Enter description."></textarea>
							</div>
							
							<div class="col-md-offset-3 col-md-6 spacer">
							<input type="file" name="galleryimageupload" id="galleryimageupload" class="btn" accept="image/jpeg,image/gif,image/png"/>
							</div>
							
							<div class="col-md-offset-3 col-md-6 spacer linespacer">
									<button type="submit" style="display: block; width: 100%;"
										class="btn btn-success next_btn"
										name="uploadimagebutton" id="uploadimagebutton">Upload Image</button>
							</div>
							<br>
							<br>
							<input type="hidden" name="photoname" value="" id="photoname" />
							<input type="hidden" name="imageheight" value="" id="imageheight" />
							<input type="hidden" name="imagewidth" value="" id="imagewidth" />
						</div>
						
						<div class="form-group edit_photo_error_message">
										<p  style="width: 160px;">
										<?php echo validation_errors (); ?></p>
						</div>
					
					<div class="form-group">
						
							<!--Image selection x,y position, with height and with input container-->
							
								<input type="hidden" name="addphotoname" value="" id="addphotoname" /> <br>

					</div>
					
					<?php
					echo form_close ();
					?>
				</div>		

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    

    
<script id="newImageTemplate" type="text/html">

	<div id="img_${image_id}" class="col-sm-3 col-lg-3 col-xs-12 col-md-3 gallery-image-div gallery-image-div linespacer">
			<div class="img-wrap">
    			<button type="button" class="btn btn-default btn-xs delete-image" title="Delete image" >
      				<span class="glyphicon glyphicon-trash"></span>
					<span class="image-id" style="display:none;">${image_id}</span>
   				</button>
    		</div>

			<a href="${image_path}" class="overlay" 
    			data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="${image_description}" >
            </a>
            	
			<div style="background-image: url(${image_path}); background-size: cover;display:block; background-position:center;" 
				class="img-thumbnail padding-0 img-responsive">
            </div>

			<div class="caption" style="display: none;">
                	<p>${image_description}</p> 
            </div>
			
     </div>
</script>	


</div> 
