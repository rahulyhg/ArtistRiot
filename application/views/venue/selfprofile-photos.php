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
        <div class="container" id="galleryImageContainer">
            <div class="well">
				
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php $this->view('venue/venuename-section'); ?>
                    </div>
                    <div class="col-xs-12 col-md-2 text-center">
                        <?php $this->view('venue/profilepic-small'); ?>
                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('venue/gallery-section'); ?>
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
	<script src="<?php echo base_url() ?>js/galleryimages.js"></script>
</body>
</html>

