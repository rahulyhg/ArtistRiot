
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="">
        <link rel="stylesheet" media="all" href="<?php echo base_url() ?>css/v2/style.css"/>
        <link rel="stylesheet" media="all" href="<?php echo base_url() ?>css/comments.css"/>
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
                        <?php $this->view('new/profile/artistname-section'); ?>
                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php $this->view('new/profile/event-description'); ?>
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
<script src="<?php echo base_url() ?>js/ekko-lightbox.min.js"></script>
<script src="<?php echo base_url() ?>js/moveform.js"></script>
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
