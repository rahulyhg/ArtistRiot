		

<div class="well" id="well">          

	<div class="row">
	
	<div class="col-md-4 col-xs-4" style="float:left;">
		<span style="float:left;"><h4>Photos</h4></span>
	</div>
	
	</div>
	
    
    <div class="row wrapper-parent " id="galleryImageSection" style="margin-left:0px;">
        <?php 
       
        if(!(is_null($userGalleryImageData)) && (sizeof($userGalleryImageData) > 0) && ($userGalleryImageData != '') ){

		foreach ( $userGalleryImageData as $imagedata ) {
		?>
        
        <div id="img_<?php echo $imagedata['image_id'] ?>" class="col-sm-3 col-lg-3 col-xs-12 col-md-3 gallery-image-div linespacer">
        
			
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

    <div class="loader_image row-centered"><img src="<?php echo base_url() ?>images/spinner.gif"></div>
    
    <script id="newImageTemplate" type="text/html">

	<div id="img_${image_id}" class="col-sm-3 col-lg-3 col-xs-12 col-md-3 gallery-image-div gallery-image-div linespacer">

            <a href="${image_path}" class="overlay" 
    			data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="${image_description}" >
            </a>
            	
			<div style="background-image: url(${image_path}); background-size: cover;display:block; background-position:center;" 
				class="img-thumbnail padding-0 img-responsive">
            </div>

			<div class="caption" style="display: none;">
                	${image_description} 
            </div>
			
     </div>
</script>	
</div>




