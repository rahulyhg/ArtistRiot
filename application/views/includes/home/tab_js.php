<script>
            var config ={
            baseurljs : "<?php echo base_url()?>"
        };

</script>

<!-- jQuery Version 1.11.0 -->
<script src="<?php echo base_url() ?>js/jquery-1.11.0.js"></script>
<script src="<?php echo base_url() ?>js/jquery.tmpl.min.js"></script>
<!-- script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script-->
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>js/jqBootstrapValidation.js"></script>
<script src="<?php echo base_url() ?>js/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery.imagedrag.js"></script>
<script src="<?php echo base_url() ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url() ?>js/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url() ?>js/jstorage.js"></script>
<script src="<?php echo base_url() ?>js/searchloader.js"></script>
<script src="<?php echo base_url() ?>js/search.js"></script>
<script src="<?php echo base_url() ?>js/utils.js"></script>
<script src="<?php echo base_url() ?>js/browse.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo base_url() ?>js/classie.js"></script> 

<!-- Google API for getting cities -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

<!-- Contact Form JavaScript -->

<script src="<?php echo base_url() ?>js/contact_me.js"></script>

<script src="<?php echo base_url() ?>js/classie.js"></script>

<!-- Profile JS files -->

<script src="<?php echo base_url() ?>js/jquery.raty.js"></script>
<script src="<?php echo base_url() ?>js/profile.js"></script>
<script src="<?php echo base_url() ?>js/ekko-lightbox.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/social.js"></script>
<!-- Login form  -->

<script src="<?php echo base_url() ?>js/jquery.imgareaselect.pack.js"></script>
<script src="<?php echo base_url() ?>js/signup.js"></script>
<script src="<?php echo base_url() ?>js/imagecrop.js"></script>
<!-- Slick Slider NOt used in phase 1 -->
<!--<script src="< ?>js/slick.min.js"></script>-->

<!-- Bootstrap Editable -->
<script src="<?php echo base_url() ?>js/bootstrap-editable.min.js"></script>

<!-- Custom Theme JavaScript -->
<script>
        $(document).ready(function() {
        <?php if(!empty($tab)){ ?>
			var tab = '<?php echo $tab; ?>';
			if((tab != null) && (tab != 'undefined')){
				$("#<?php echo $tab; ?>").addClass("active");
			}
           		
        <?php }?>
        });
</script>
