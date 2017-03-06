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

	<div class="container">
		<br />
		<div class='row'>
			<div class='col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12  form-horizontal'>

				<fieldset id="first" style="width: 100%">
					<legend class="pagedescription">Create account</legend>

					<div class="form-group signup_error_message">
					<p class="col-md-6 col-sd-8  col-md-offset-4 ">
					<?php echo validation_errors (); ?></p>
					</div>
					
					<?php
					$attributes = array (
							'id' => 'signupform',
							'data-toggle' => 'validator' 
					);
					echo form_open ( 'login/signup/createuser', $attributes );
					?>
					
					<!-- Select Basic -->
					<div class="form-group">
						<label class="col-md-4 col-sm-5 col-xs-4 control-label" for="user_role">Sign up as:
						</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<select id="user_role" name="user_role" class="form-control">
								<option value="artist">Artist</option>
								<option value="venue">Venue</option>
							</select>
						</div>
					</div>
					
					<div class="form-group" id="firstnamediv">
						<label for="firstname" class="col-md-4 col-sm-5 col-xs-4 control-label control-label">First Name *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="text" class="form-control" id="firstname"
								name="firstname" placeholder="Enter First Name">
							<p class="help-block"></p>
						</div>
					</div>
					<div class="form-group" id="lastnamediv">
						<label for="lastname" class="col-md-4 col-sm-5 col-xs-4 control-label control-label">Last Name *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="text" class="form-control" id="lastname"
								name="lastname" placeholder="Enter Last Name">
						</div>
					</div>
					
					<div class="form-group" id="venuenamediv" style="display:none;">
						<label for="venue_name" class="col-md-4 col-sm-5 col-xs-4 control-label control-label">Venue Name *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="text" class="form-control" id="venue_name"
								name="venue_name" placeholder="Enter Venue Name">
						</div>
					</div>
					
					<div class="form-group">
						<label for="signup_email" class="col-md-4 col-sm-5 col-xs-4 control-label control-label">Email *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="email" class="form-control" id="signup_email"
								name="signup_email" placeholder="Enter Email Address">

						</div>
					</div>

					<div class="form-group">
						<label for="signup_email_confirm" class="col-md-4 col-sm-5 col-xs-4 control-label control-label">Re-enter
							Email *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="text" class="form-control" id="signup_email_confirm"
								name="signup_email_confirm" placeholder="Re-enter Email Address">

						</div>
					</div>


					<div class="form-group">
						<label for="password" class="col-md-4 col-sm-5 col-xs-4 control-label control-label">Password *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="password" class="form-control" id="password"
								name="password" placeholder="Password">
						</div>
					</div>

					<div class="form-group">
						<label for="mobile" class="col-md-4 col-sm-5 col-xs-4 control-label control-label">Mobile *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="tel" class="form-control" id="mobile" name="mobile"
								placeholder="10 digit mobile number.">
						</div>
					</div>


					<div class="form-group" style="display: none;">
						<label class="col-md-4 col-sm-5 col-xs-4 control-label control-label" for="artist_category">Categories:
						</label>
						<div class="col-md-6 col-sm-7 col-xs-8">

							<select id="artist_category" name="artist_category"
								class="form-control">
								<option selected disabled value="-1">Please select a category</option>
							<?php
							foreach ( $categories as $categoryarray ) {
								echo '<option value="' . $categoryarray [0] . '">' . $categoryarray [1] . '</option>';
							}
							?>
							</select>
						</div>
					</div>

					<div class="form-group" style="display: none;">
						<label class="col-md-4 col-sm-5 col-xs-4 control-label control-label" for="artist_sub_category">Sub
							Categories: </label>
						<div class="col-md-6 col-sm-7 col-xs-8">

							<select id="artist_sub_category" name="artist_sub_category"
								class="form-control">

							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-4 col-md-6">
							<button type="submit" id="sigupbutton" style="display: block; width: 100%;"
								class="btn btn-default btn-primary col-md-6">Sign Up</button>
						</div>
					</div>

				</fieldset>
				
		
		<?php
		echo form_close ();
		?>	
			
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
	
	<script type="text/javascript">

		getSubCategories('<?php echo $sub_categories;?>');

	</script>
<!-- Login Modal -->
		<?php
			$this->view('login/login.php');
		?>
</body>
</html>


