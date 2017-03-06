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
    </head>

    <body>
        <!-- nav-content -->
        <?php $this->view('venue/profile-nav-content'); ?>
        <!-- ****************** -->       
        <div class="container">
            <div class="well">
				
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php $this->view('venue/venuename-section'); ?>
                    </div>
                    <div class="col-xs-12 col-md-2 text-center">
                        <?php $this->view('venue/profilepic-small'); ?>
                       	
                        <span>
            			<ul id="socialbar">
                			<li><a href="http://www.facebook.com"  title="Become a fan"><img src="<?php echo base_url(); ?>images/social/facebook_32.png"  alt="Facebook" /></a></li>
                			<li><a href="http://www.twitter.com" title="Follow our tweets"><img src="<?php echo base_url(); ?>images/social/twitter_32.png"  alt="Twitter" /></a></li>
                			<li><a href="http://www.google.com"  title="Add to the circle"><img src="<?php echo base_url(); ?>images/social/google_plus_32.png" alt="Google Plus" /></a></li>
            			</ul>

        				</span>
                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('venue/video-section'); ?>
                    </div>
                </div>
                <div class='row'>  
                    <div class="col-xs-12 col-md-3">



                    </div>
                </div><!-- row -->

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
	<script src="<?php echo base_url() ?>js/galleryvideos.js"></script>
</body>
</html>

