<div>
<div class="form-group linespacer">
    	<div class="aboutme-artist">Recent Videos</div>
		
        <div class="margin-top-10" id="artist-recent-videos" style="min-height: 100px;">
        
        <div id="recentvideosloader" class="divloader"></div>
        
        </div>
		
		<div class="clearfix"></div>
</div>
	
	<script id="artistRecentVideosTemplate" type="text/html">
			
		<div id="video_${video_id}" class="col-sm-4 col-lg-4 col-xs-4 col-md-4 gallery-video-div"
		style="padding-left: 1px;">
    		
    		<div>
          	<a href="${video_url}" data-toggle="lightbox" data-title="${video_description}">
           	 <img class="img-thumbnail playvideo" title="video" 
            	src="<?php echo base_url() ?>images/play_button.png"
            	border="0" style="background:URL(http://img.youtube.com/vi/${youtube_video_id}/1.jpg) center center black no-repeat;">
          	 </a>
           </div>
           
        </div>

			
	</script>	
	
</div>
