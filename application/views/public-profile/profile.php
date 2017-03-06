<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="">
        <link rel="stylesheet" media="all" href="<?php echo base_url() ?>css/style.css">
        <link rel="stylesheet" media="all" href="<?php echo base_url() ?>css/custom.css" >

        <title><?php echo $title ?></title>
        <?php $this->view('profile/header-content'); ?>
        <?php $this->view('includes/home/head_include'); ?>
        <script>
            var config ={
            baseurljs : "<?php echo base_url()?>"
        };

        </script>
        <?php 
        	$isMyProfile = false;
        	
        ?>
    </head>

    <body>
            
        <div class="container" style="box-shadow: 0 0 5px 1px #c7c7c7;  background-color: #fff;">
        <div class="row">
        	<div class="col-xs-12 col-md-12 col-sm-12">
        		<?php $this->view('profile/profile-nav-content'); ?>
          	</div>
        </div>
        
            <div class="well-mod">

				 <div class="row" style="margin-top:5px;">
                    <div class="col-xs-12 col-md-2 text-center">
                        <?php $this->view('public-profile/profilepic-section'); ?>
                       	 
                        <?php $this->view('public-profile/avgrating-section'); ?>
                        
                         <?php	if(!empty($userProfileData['fb_link'])){   ?>
                        <div class="form-group">
                        	<div class="fb-like" data-href="<?php echo $userProfileData['fb_link'];?>"
	   						data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                        </div>
                        <?php }?>
                        
                        <?php	if(!empty($userProfileData['twitter_link'])){   ?>
                        <div class="form-group">
                        	<a href="<?php echo $userProfileData['twitter_link'];?>" class="twitter-follow-button" 
                        	data-show-count="false" data-show-screen-name="false">Follow @twitter</a>
                        </div>
                        <?php }?>
                        
                        <div >
                        <?php  if(!empty($userProfileData) && !$isMyProfile){  ?>
                        	<div class=""><a id="reviewpagelink" href="<?php echo base_url().$role.'/'.$userName.'/review/'?>"
                        	  title="Add review and rating">Add review and rating</a></div>
            				<div class="">
            				<?php if($userProfileData['user_gallery_images'] == 0){?>
            					Photos(<?php echo $userProfileData['user_gallery_images'] ?>)
            				<?php } else{?>
            				<a href="<?php echo base_url().$role.'/'.$userName.'/images/'?>">
                				Photos(<?php echo $userProfileData['user_gallery_images'] ?>)</a>
                			<?php }?>
                			</div>
                			
                			<div class="">
                			<?php if($userProfileData['user_gallery_videos'] == 0){?>
                				Videos(<?php echo $userProfileData['user_gallery_videos'] ?>)
                			<?php } else{ ?>
                				<a href="<?php echo base_url().$role.'/'.$userName.'/videos/'?>" title="Follow our tweets">
                				Videos(<?php echo $userProfileData['user_gallery_videos'] ?>)
                			<?php }?>	
                			</a>
                			</div>
                			
            			<?php } ?>
        				</div>
                    </div>
                    <div class="col-xs-12 col-md-10">

                        <?php $this->view('public-profile/aboutme-section'); ?>
                        
        					<div class="col-md-9 col-md-offset-3">
            				<div id="messages"></div>
        					</div>
    					
                    </div>
                </div>
                <div class='row'>  
                    <div class="col-xs-12 col-md-5 ">
                        <?php $this->view('public-profile/artist-recent-photos'); ?>
					</div>
                    
                    <div class="col-xs-12 col-md-7">

                        <?php $this->view('profile/artist-description-section'); ?>

                    </div>
                	
                </div><!-- row -->
				
				<div class="row">
					<div class="col-xs-12 col-md-5 ">
                        <?php $this->view('public-profile/artist-recent-videos'); ?>
					</div>
					
					<div class="col-xs-12 col-md-7" id="artist_review">
						<?php $this->view('public-profile/testimonial-section'); ?>
					</div>
				</div>
				
				<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id?>">

               <!-- Tiles are not in scope of phase 1 --> 

            </div>
        </div>

        <footer>
		<?php
			$this->view ( 'includes/home/footer_include' );
		?>
	</footer>
	
<?php
	$this->view ( 'includes/home/tab_js' );
	$this->view ( 'includes/home/privacypolicy' );
?>

	<script type="text/javascript">

	$('#avgscore').raty({
		readOnly: true,
	    //half: true,
	    showHalf:  true,
	    path: config.baseurljs + 'images',
	    hints: ['bad', 'poor', 'average', 'good', 'awesome'],
	    score: <?php echo $userProfileData['rating']?>
	});
	
	</script>

</body>
</html>
