
<div>
<div class="form-group linespacer">
    	<div class="aboutme-artist">Recent Photos</div>
		
        <div class="margin-top-10" id="artist-recent-photos-public" style="min-height: 100px;">
        
        <div id="recentphotosloader" class="divloader"></div>       
		
	    </div>
		
		<div class="clearfix"></div>
</div>

	<script id="artistRecentPhotosTemplate" type="text/html">
			
		<div id="img_${image_id}" class="col-sm-4 col-lg-4 col-xs-4 col-md-4 gallery-image-div">
    		
    		<a href="${image_path}" class="overlay" 
    			data-toggle="lightbox" data-gallery="columnwrappers" data-parent=".wrapper-parent" data-title="${image_description}" >
            </a>
            
            <div style="background-image: url(${image_path}); background-size: cover;display:block; background-position:center; 
            	height:150px;" class="img-thumbnail padding-0 img-responsive">
            	
            </div>
        </div>
			
	</script>	

</div>

