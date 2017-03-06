
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
        <?php $this->view('profile/nav-content'); ?>
        <!-- ****************** -->       
        <div class="container">
            <div class="well">

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php $this->view('profile/artistname-section'); ?>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <?php $this->view('profile/profilepic-section', $is_my_profile); ?>
                        <?php $this->view('profile/media-section', array('is_my_profile' => $is_my_profile)); ?>

                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('profile/aboutme-section', $is_my_profile); ?>
                    </div>
                </div>
                <div class="row" >  
                    <div class="col-xs-12 col-md-3">
                        <?php $this->view('profile/availablefor-section', $is_my_profile); ?>
                        <?php //$this->view('profile/availability-section'); ?>


                    </div>
                    <div class="col-xs-12 col-md-8 text-center">

                        <?php $this->view('profile/wall-section', $is_my_profile); ?>

                    </div>
                </div><!-- row -->

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
<script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery.raty.js"></script>
<script src="<?php echo base_url() ?>js/selfprofile.js"></script>

</body>
</html>
