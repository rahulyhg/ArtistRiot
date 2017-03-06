		

<div class="well" id="well">          

	<div class="row">
	
	<div class="col-md-4 col-xs-4" style="float:left;">
		<span style="float:left;"><h4>Videos</h4></span>
	</div>
	
	</div>
    
    <div class="row wrapper-parent" id="galleryVideoSection">
        
        <?php 
        if(!(is_null($userGalleryVideoData)) && (sizeof($userGalleryVideoData) > 0) && ($userGalleryVideoData != '') ){

		foreach ( $userGalleryVideoData as $videoData ) {
		?>
        
       <div id="video_<?php echo $videoData['video_id'] ?>" class="col-sm-4 col-lg-4 col-xs-12 col-md-4 gallery-video-div linespacer">
          
          <div>
          <a href="<?php echo $videoData['video_url']?>" data-toggle="lightbox" data-title="<?php echo $videoData['video_description']?>">
            <img class="img-thumbnail playvideo" title="video" 
            src="<?php echo base_url() ?>images/play_button.png"
            border="0" style="background:URL(http://img.youtube.com/vi/<?php echo $videoData['youtube_video_id']?>/1.jpg) center center black no-repeat;">
           </a>
           </div>
           <div class="video-description" title="<?php echo $videoData['video_description']?>">
           		<?php echo $videoData['video_description']?>
           </div>
        </div>		
        <?php }
        }?>
        
        
    </div>
    
    <div class="loader_image row-centered"><img src="<?php echo base_url() ?>images/spinner.gif"></div>
    

    
<script id="newVideoTemplate" type="text/html">
	
		 <div id="video_${video_id}" class="col-sm-4 col-lg-4 col-xs-12 col-md-4 gallery-video-div linespacer">
          <div>
           <a href="${video_url}" data-toggle="lightbox" data-title="${video_description}">
            <img class="img-thumbnail playvideo"  title="video" 
            src="<?php echo base_url() ?>images/play_button.png"
            border="0" style="background:URL(http://img.youtube.com/vi/${youtube_video_id}/1.jpg) center center black no-repeat;">
           </a>
		   </div>

		   <div class="video-description" title="${video_description}">
           		${video_description}
           </div>
 		</div>
	
</script>		


</div> 
