<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8" />
<meta name="keywords" content="reset password" />
<meta name="description" content="password reset" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ArtistRiot | Reset Password Page</title>
        <?php $this->view('includes/home/head_include'); ?>
</head>

<body id="page-top" class="index">

 
    <div class="container">
     
        <div class="row">
        	<div class="col-xs-12 col-md-12 col-sm-12">
        		<?php $this->view('profile/profile-nav-content'); ?>
          	</div>
        </div>
        
		<div class='row' style="margin-top: 100px;">
			<fieldset id="first" class="reset-password-fieldset" style="padding: 0px;">

			<legend class="pagedescription marginleft10 ">Reset Password</legend>
			<div class='col-md-7  form-horizontal'>
		
		<?php 
		$attributes = array (
				'id' => 'resetpasswordform',
				'data-toggle' => 'validator'
		);
		echo form_open('auth/reset_password/'. $code, $attributes);?>
	
	<div class="form-group">
		<label for="new_password" class="col-md-7 control-label"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
		<div class="col-md-5">
			<input type="password" name="new_password" value="" id="new_password"  style="width: 100%;">
		</div>
	</div>

	<div class="form-group">
	<label for="new_password_confirm" class="col-md-7 control-label">
		<?php echo sprintf(lang('reset_password_new_password_confirm_label', 'new_password_confirm'));?> 
	</label>
	<div class="col-md-5">	
		<input type="password" name="new_password_confirm" value="" id="new_password_confirm" style="width: 100%;">
	</div>	
	</div>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>
	
	<div class="form-group">
	<div class="col-md-offset-7 col-md-5">
	<button type="submit" style="width: 100%;" name="resetpasswordsubmit"
	class="btn btn-default btn-primary">Reset Password</button>
		
	</div>
	</div>
	<?php echo form_close();?>

	</div>
	</fieldset>
	</div>
	
	
</div>



<footer>
		<?php
			$this->view ( 'includes/home/footer_include' );
		?>
</footer>

	<!-- Load js files in the end----->
	<?php
		$this->view('includes/home/js_include');
		$this->view ( 'includes/home/privacypolicy' );
	?>
        
</body>
</html>