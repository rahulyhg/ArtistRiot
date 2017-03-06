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
        
    </head>

    <body>
            
        <div class="container">
        <div class="row">
        	<div class="col-xs-12 col-md-12 col-sm-12">
        		<?php $this->view('venue/profile-nav-content'); ?>
          	</div>
        </div>
        
            <div class="well">

                <div class="row">
                    <div class="col-xs-12 col-md-3 text-center">
                        <?php $this->view('venue/profilepic-section'); ?>
                       	
                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('venue/venuedetails-section'); ?>
                        
                    </div>
                </div>
                <div class='row'>  
                    <!-- ?php $this->view('venue/tiles-section'); ?-->
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


</body>
</html>
