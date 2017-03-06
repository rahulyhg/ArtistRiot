<!DOCTYPE html>
<html lang="en">
	
	
    <head>
    	<meta Http-Equiv="Cache-Control" Content="no-cache">
		<meta Http-Equiv="Pragma" Content="no-cache">
		<meta Http-Equiv="Expires" Content="0"> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="">
        <link rel="stylesheet" media="all" href="<?php echo base_url() ?>css/style.css">
        <link rel="stylesheet" media="all" href="<?php echo base_url() ?>css/custom.css" >

        <title><?php echo $title ?></title>
        <?php $this->view('profile/header-content'); ?>
        
        <script>
            var config ={
            baseurljs : "<?php echo base_url()?>"
        };

        </script>
        
    </head>

    <body>
            
        <div class="container" style="border: 1px #e4e4e4 solid;  padding-left: 30px; box-shadow: 0 0 5px 1px #c7c7c7;  background-color: #fff;">
        <div class="row">
        	<div class="col-xs-12 col-md-12 col-sm-12">
        		<?php $this->view('profile/profile-nav-content'); ?>
          	</div>
        </div>
        
            <div>
   
                <div class="row" style="margin-top:5px;">
                    <div class="col-xs-12 col-md-2 text-center">
                        <?php $this->view('profile/profilepic-section'); ?>
                       	 
                        <?php $this->view('profile/avgrating-section'); ?>
                        
                        <?php	if(!empty($userProfileData['fb_link'])){   ?>
                        <div class="form-group linespacer">
                        	<div class="fb-like" data-href="<?php echo $userProfileData['fb_link'];?>"
	   						data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                        </div>
                        <?php }?>
                        
                        <?php	if(!empty($userProfileData['twitter_link'])){   ?>
                        <div class="form-group linespacer">
                        	<a href="https://twitter.com/share" class="twitter-share-button" 
                        	data-url="<?php echo $userProfileData['twitter_link'];?>" data-text="">Tweet</a>
                        	
                        </div>
                        <?php }?>

                    </div>
                    <div class="col-xs-12 col-md-10">

                        <?php $this->view('profile/aboutme-section'); ?>
                        
        					<div class="col-md-9 col-md-offset-3">
            					<div id="messages"></div>
        					</div>
    					
                    </div>
                </div>
                <div class='row'>  
                    <div class="col-xs-12 col-md-5 ">
                        <?php $this->view('profile/artist-recent-photos'); ?>
					</div>
                    <div class="col-xs-12 col-md-7">
						<?php $this->view('profile/artist-description-section'); ?>
					</div>
                 </div>
                 
                 <div class='row'>     
                    <div class="col-xs-12 col-md-5 ">
                        <?php $this->view('profile/artist-recent-videos'); ?>
					</div>
					<div class="col-xs-12 col-md-7" id="artist_review">
						<?php $this->view('profile/testimonial-section'); ?>
					</div>
                 </div>
				
                <!-- tiles/events is not in scope of phase 1-->

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
