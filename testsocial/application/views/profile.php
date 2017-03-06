
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
                <div class="row text-center">
                    <div class="col-xs-12 col-sm-offset-2 col-md-8 col-md-offset-2 col-sm-8 ">
                        <ul class="nav nav-tabs">
                            <li class="<?php echo $wallclass ?>">
                                <a href="<?php echo base_url() ?>artist/index/false#well">Wall</a>
                            </li>

                            <li class="<?php echo $photosclass ?>">
                                <a href="<?php echo base_url() ?>artist/photos/false#well">Photos</a>
                            </li>

                            <li class="<?php echo $videosclass ?>">
                                <a href="<?php echo base_url() ?>artist/videos/false#well">Videos</a>
                            </li>
                        </ul>
                        <h1><?php echo $heading ?></h1>
                        <?php $this->view('profile/wall-section'); ?>
                    </div>
                </div>
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
<script src="<?php echo base_url() ?>js/profile.js"></script>
<script>
    $(document).ready(function() {

        
        $('#star').raty({
            half: true,
            path: '<?php echo base_url(); ?>images',
            hints: ['bad', 'poor', 'average', 'good', 'awesome'],
            target: '#reviewScore',
            targetType: 'number',
            targetKeep: true,
        });

        $('#avgscore').raty({
            readOnly: true,
            score: 3,
            path: '<?php echo base_url(); ?>images'

        });

    });
</script>

</body>
</html>
