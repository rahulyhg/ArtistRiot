
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
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php //$this->view('profile/artistname-section'); 
                        ?>
                        <?= $artist_name ?>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <?php $this->view('profile/profilepic-section'); ?>
                        <?php $this->view('profile/avgrating-section'); ?>
                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('profile/aboutme-section'); ?>
                    </div>
                </div>
                <div class='row'>  
                    <div class="col-xs-12 col-md-3">
                        <?php $this->view('profile/availablefor-section'); ?>
                        <?php //$this->view('profile/availability-section'); ?>


                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('profile/testimonial-section'); ?>

                    </div>
                </div><!-- row -->


                <?php $this->view('profile/tiles-section'); ?>

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

