<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ArtistRiot</title>
        
        <?php $this->view('includes/home/head_include'); ?>

</head>

<body id="page-top" class="index">
	
	<div class="page-header">
		<?php  $this->load->view('includes/home/tab_header'); ?>
	</div>

	<br>
	<br>
	
	<div class="container">
		<div class='row'>
			<div class='col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12  form-horizontal'>
				<fieldset id="first" style="width:100%;">
					<div class="align-center">
						An activation email has been sent to your Email address. Please click on the link to verify your email address. 
					</div>
				</fieldset>
                        </div>
		
		</div>

	</div>

	<!-- Load js files in the end----->

	
	<footer>
		
		<?php $this->view('includes/home/footer_include');
		 ?>
	</footer>
	
	<?php $this->view('includes/home/tab_js'); 
	$this->view('includes/home/privacypolicy');?>
	
	

</body>
</html>


