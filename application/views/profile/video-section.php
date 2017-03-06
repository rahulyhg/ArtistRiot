		

<div class="well" id="well">          

	<div class="row" style="margin-left:0px;">
	
	<div class="col-md-4 col-xs-4" style="float:left;">
		<span style="float:left;"><h4>Videos</h4></span>
	</div>
	<?php  if(!empty($this->session->userdata('user_id'))){?>
	<div class="btn col-md-8 col-xs-4 add-buttons" >
		<button type="button" class="btn btn-success" style="float:right;" data-target="#addvideosmodal" data-toggle="modal" 
		name="addvideos" id="addvideos"><i class="glyphicon glyphicon-plus"></i> Add Videos</button>
		</div>
	</div>
	<?php } ?>
    
    <div class="row wrapper-parent" id="galleryVideoSection">
        
        <?php 
        if(!(is_null($userGalleryVideoData)) && (sizeof($userGalleryVideoData) > 0) && ($userGalleryVideoData != '') ){

		foreach ( $userGalleryVideoData as $videoData ) {
		?>
        
       <div id="video_<?php echo $videoData['video_id'] ?>" class="col-sm-4 col-lg-4 col-xs-12 col-md-4 gallery-video-div linespacer">
          
          <div class="video-wrap">
    			<button type="button" class="btn btn-default btn-xs delete-video" title="Delete video" >
      				<span class="glyphicon glyphicon-trash"></span>
      				<span class="video-id"  style="display:none;"><?php echo $videoData['video_id'] ?></span>
   				</button>
    	  </div>
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
    <div class="loader_image row-centered"><img src="<?php echo base_url() ?>images/load.gif"></div>
    
    <div class="modal fade" id="addvideosmodal" tabindex="-1">
    <div class="blocking-div"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">
                    	<span class="glyphicon glyphicon-remove-circle" style="color:black;"></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Add Video</h4>
				</div>
                
                <div class="row">
                <?php
					$attributes = array (
							'id' => 'addvideoform',
							'data-toggle' => 'validator' 
					);
					echo form_open_multipart( 'profile/addvideos/uploadvideos', $attributes );
				?>
				<div class="col-md-12">
							
							<!--Image container that we will use to crop-->
							
							
							<div class="col-md-offset-2 col-md-8 spacer">
								<input type="text" placeholder="Enter youtube video URL." name="videourl" id="videourl" style="display: block; width: 100%;"/>
							</div>
							
							<div class="col-md-offset-2 col-md-8 spacer">
								<textarea class="form-control" id="videodescription"
								name="videodescription" rows="2" placeholder="Enter video description."></textarea>
							</div>
							
							<div class="col-md-offset-2 col-md-8 spacer linespacer">
									<button type="submit" style="display: block; width: 100%;"
										class="btn btn-success next_btn"
										name="uploadvideobutton" id="uploadvideobutton">Upload Video</button>
							</div>
						</div>
						
						<div class="form-group edit_photo_error_message">
										<p  style="width: 160px;">
										<?php echo validation_errors (); ?></p>
						</div>
						<input type="hidden" name="youtubevideoid" value="" id="youtubevideoid" />
					<?php
					echo form_close ();
					?>
				</div>		

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    

    
<script id="newVideoTemplate" type="text/html">
	
		 <div id="video_${video_id}" class="col-sm-4 col-lg-4 col-xs-12 col-md-4 gallery-video-div linespacer">
           <div class="video-wrap">
    			<button type="button" class="btn btn-default btn-xs delete-video" title="Delete video" >
      				<span class="glyphicon glyphicon-trash"></span>
      				<span class="video-id"  style="display:none;">${video_id}</span>
   				</button>
    	  </div>
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
