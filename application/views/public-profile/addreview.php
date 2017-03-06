<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="">

        <title><?php echo $title ?></title>
        <?php $this->view('profile/header-content'); ?>
        
        <script>
            var config ={
            baseurljs : "<?php echo base_url()?>"
        };

        </script>
        
    </head>

    <body>
        <!-- nav-content -->
        <?php $this->view('profile/profile-nav-content'); ?>
        <!-- ****************** -->       
        <div class="container">
            <div class="well">
				
                <div class="row">
                    
                    <div class="col-xs-12 col-md-2 text-center">
                        <?php $this->view('public-profile/profilepic-section'); ?>
                       	 
                        <?php $this->view('public-profile/artistname-section'); ?>
                        
                        <div>
                        <?php  if(!isEmpty($userProfileData)){  ?>
                        	<div class=""><a href="<?php echo base_url().$role.'/'.$userName.'/images/'?>">
                			Photos(<?php echo $userProfileData['user_gallery_images'] ?>)</a></div>
                			<div class="linespacer"><a href="<?php echo base_url().$role.'/'.$userName.'/videos/'?>" title="Follow our tweets">
                			Videos(<?php echo $userProfileData['user_gallery_videos'] ?>)</a></div>
                			
            			<?php } ?>
        				</div>
                    </div>
                    <div class="col-xs-12 col-md-10 col-sm-12">
						<?php $this->view('public-profile/review-section', $artist_id); ?>
                    </div>
                    
                </div>

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

	$('#star').raty({
	    half: true,
	    path: config.baseurljs + 'images',
	    hints: ['bad', 'poor', 'average', 'good', 'awesome'],
	    target: '#rating_score',
	    targetType: 'number',
	    targetKeep: true,
	    click: function(score, evt) {
	        $("#rating_score").val(score).trigger('change');
	      }
	});
	
	</script>
	
	<!-- Login Modal -->
		<?php
			$this->view('public-profile/login.php');
		?>
</body>
</html>

