
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

        <script>
            var config = {
                baseurljs: "<?php echo base_url() ?>"
            };

        </script>

    </head>

    <body>
        <!-- nav-content -->
        
        <!-- ****************** -->       
        <div class="container">
        
        <div class="row">
        	<div class="col-xs-12 col-md-12 col-sm-12">
        		<?php $this->view('profile/profile-nav-content'); ?>
          	</div>
        </div>
        
        <div class="well">

                <div class="row">
                    
                    <div class="col-xs-12 col-sm-2 col-md-2 text-center">
                        <?php $this->view('profile/profilepic-section'); ?>
						<?php $this->view('profile/artistname-section'); ?>
                        <div>
                            <?php
                            if (!empty($userProfileData))
                            {
                                ?>
                               
                                <div class="linespacer"><a href=""  title="Add to the circle"></a></div>
							<?php } ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-9 col-sm-10">
						<?php $this->view('profile/editProfile-section'); ?>
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
            $this->view('includes/home/footer_include');
            ?>
        </footer>

        <?php
        $this->view('includes/home/tab_js');
        $this->view('includes/home/privacypolicy');
        ?>

    <script type="text/javascript">

        loadSubCategories('<?php echo $sub_categories; ?>', '<?php echo $userProfileData['category_id']; ?>');
        loadCategories('<?php echo $categoriesList; ?>');
        currentvalues = {
            firstname: '<?php echo $this->session->userdata['first_name']; ?>',
            lastname: '<?php echo $this->session->userdata['last_name']; ?>',
            mobile: '<?php echo $userProfileData['phone'] ?>',
            category: '<?php echo $userProfileData['category_id'] ?>',
            subcategory: '<?php echo $userProfileData['sub_category_id'] ?>',
            fblink: '<?php echo $userProfileData['fb_link'] ?>',
            twitterlink: '<?php echo $userProfileData['twitter_link'] ?>'
        }

        $('#star').raty({
            half: true,
            path: config.baseurljs + 'images',
            hints: ['bad', 'poor', 'average', 'good', 'awesome'],
            target: '#rating_score',
            targetType: 'number',
            targetKeep: true,
            click: function(score, evt) {
                $("#rating_score").val(score).trigger('change');
            }
        });


    </script>
</body>
</html>


