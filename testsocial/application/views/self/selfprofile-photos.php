<!DOCTYPE html>
<html lang="en">
    <head>
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
                        <?php $this->view('profile/media-section'); ?>
                        </br>
                        <?php $this->view('profile/availablefor-section', $is_my_profile); ?>
                    </div>
                    <div class="col-xs-12 col-md-9">

                        <?php $this->view('profile/gallery-section', $is_my_profile); ?>
                    </div>
                </div>
                <div class='row'>  
                    <div class="col-xs-12 col-md-3">
                        
                        
                      
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
<script src="<?php echo base_url() ?>js/ekko-lightbox.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery.raty.js"></script>
<script>
    $(document).ready(function() {

        //$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
        $('[data-toggle="popover"]').popover({trigger: 'hover', 'placement': 'top', content: 'content-popover'});
        $('[data-toggle="tooltip"]').tooltip({'placement': 'right'});
        $('#star').raty({
            half: true,
            path: '<?php echo base_url(); ?>images',
            hints: ['bad', 'poor', 'average', 'good', 'awesome'],
            target: '#reviewScore',
            targetType: 'number',
            targetKeep: true
        });


        $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    });
</script>


</body>
</html>
