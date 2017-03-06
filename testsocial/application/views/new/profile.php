
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="">
        <link rel="stylesheet" media="all" href="<?php echo base_url() ?>css/v2/style.css">
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
        <?php $this->view('profile/nav-content'); ?>
        <!-- ****************** -->       
        <div class="container">
            <div class="well">

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php $this->view('new/profile/artistname-section'); ?>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <?php $this->view('new/profile/profilepic-section'); ?>
                        <?php $this->view('new/profile/avgrating-section'); ?>
                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('new/profile/aboutme-section'); ?>
                    </div>
                </div>
                <div class='row'>  
                    <div class="col-xs-12 col-md-3">
                        <?php $this->view('new/profile/availablefor-section'); ?>
                        <?php //$this->view('profile/availability-section'); ?>


                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('new/profile/testimonial-section'); ?>

                    </div>
                </div><!-- row -->


                <?php $this->view('new/profile/tiles-section'); ?>

            </div>
        </div>
    </div>
</div>

</body>
</html>

<hr>

</div> <!-- /container -->
<footer>

</footer>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url() ?>js/jquery.js"></script>
<script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery.raty.js"></script>
<script src="<?php echo base_url() ?>js/profile.js"></script>
<script src="<?php echo base_url() ?>js/ekko-lightbox.min.js"></script>
<!-- required plugin for ajax file upload -->
<script src="<?php echo base_url() ?>js/fileuploader.js" type="text/javascript"></script>
<!-- resizing image -->
<script src="<?php echo base_url() ?>js/jquery.imgareaselect.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
</body>
</html>
