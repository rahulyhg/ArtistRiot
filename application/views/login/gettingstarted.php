<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php $this->view('includes/home/head_include'); ?>

<title>ArtistRiot</title>

<script>
	var config ={
            		baseurljs : "<?php echo base_url()?>"
        		};

</script>
</head>
<?php 
	$profile = '';
	$role = $this->session->userdata('role');
	
	if ($role == 'artist'){
		$profile = 'Artist Profile';
	} else if($role == 'venue'){
		$profile = 'Venue Profile';
	}?>

<body id="page-top" class="index">

	<div class="page-header">
		<?php  $this->load->view('includes/home/tab_header'); ?>
	</div>

	<br>
	<br>

	<div class="container">
	<div class="well">

		<div class="row">
			<div class='col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-3 hidden-xs'>
				<ul id="progressbar" class="list-inline col-md-12">
					<li id="active1" class="active col-md-4"><?php echo $profile;?></li>
					<li id="active2" class=" col-md-4">Social pages</li>
					<li id="active3" class=" col-md-4">Upload photos</li>
				</ul>
			</div>
		</div>

		<br />
		<div class='row'>
			<div class='col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12  form-horizontal'>

				<fieldset id="first" style="width: 100%;">

					<legend class="pagedescription marginleft10"><?php echo $profile;?></legend>

					<?php
					$attributes = array (
							'id' => 'artistprofileform',
							'data-toggle' => 'validator' 
					);
					echo form_open ( 'login/signup/artistprofile', $attributes );
					?>
					
					<div class="form-group signup_error_message">
						<p class="col-md-6 col-sd-8  col-md-offset-4 ">
					<?php echo validation_errors (); ?></p>
					</div>
					<?php if($role == 'artist'){?>
					
					<div class="form-group">
						<label class="col-md-4 col-sm-5 col-xs-4 control-label" for="artist_category">Type
							of Artist * </label>
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

					<div class="form-group">
						<label class="col-md-4 col-sm-5 col-xs-4 control-label" for="artist_sub_category">Speciality
							*</label>
						<div class="col-md-6 col-sm-7 col-xs-8">

							<select id="artist_sub_category" name="artist_sub_category"
								class="form-control">

							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="description" class="col-md-4 col-sm-5 col-xs-4 control-label">Artist
							Description *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<textarea class="form-control" id="description"
								name="description" rows="6"></textarea>
							<span id="text_counter"></span>
						</div>
					</div>
					
					<div class="form-group" id="genderdiv">
						<label class="col-md-4 col-sm-5 col-xs-4 control-label" for="gender">Gender *</label>
						<div class="col-md-6 col-sm-7 col-xs-8 radio">
							<label class="checkbox-inline"> <input type="radio" name="gender"
								id="male" value="male"> Male
							</label> <label class="checkbox-inline"> <input type="radio"
								name="gender" id="female" value="female"> Female
							</label>
						</div>
					</div>
					
					<?php }?>
					
					<?php if($role == 'venue'){?>
						
					<div class="form-group">
						<label for="venue_description" class="col-md-4 col-sm-5 col-xs-4 control-label">Venue
							Description *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<textarea class="form-control" id="venue_description"
								name="venue_description" rows="6" placeholder="Tell us about this venue."></textarea>
							<span id="text_counter"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 col-sm-5 col-xs-4 control-label" for="events_category">Type
							of Events * </label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							
							<select multiple="multiple" id="events_category" name="events_category"
								class="form-control">
							
							<?php
							foreach ( $venueCategories as $venueCategoryArray ) {
								echo '<option value="' . $venueCategoryArray [0] . '">' . $venueCategoryArray [1] . '</option>';
							}
							?>
							
							</select>
						</div>
					</div>
					
					<?php }?>
					
					
					<div class="form-group">
						<label for="facebookpage" class="col-md-4 col-sm-5 col-xs-4 control-label">City *</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="text" class="form-control" id="city"
								name="city" placeholder="City">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2 pull-right control-group">

							<button type="submit" id="artistprofilebutton"
								name="artistprofilebutton"
								class="btn btn-success next_btn signupbuttons">Next</button>
						</div>

					</div>
					
					<?php
						echo form_close ();
					?>	

				</fieldset>


                            <fieldset id="second" style="width:100%">
					<legend class="pagedescription marginleft10">Social Media</legend>
					
					<?php
					$attributes = array (
							'id' => 'socialmediaform',
							'data-toggle' => 'validator' 
					);
					echo form_open ( 'login/signup/socialprofile', $attributes );
					?>
					
					<div class="form-group">
						<label for="facebookpage" class="col-md-4 col-sm-5 col-xs-4 control-label">Facebook
							Fan Page</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="text" class="form-control" id="facebookpage"
								name="facebookpage" placeholder="Facebook Fan Page">
						</div>
					</div>

					<div class="form-group">
						<label for="twitterpage" class="col-md-4 col-sm-5 col-xs-4 control-label">Twitter
							Fan Page</label>
						<div class="col-md-6 col-sm-7 col-xs-8">
							<input type="text" class="form-control" id="twitterpage"
								name="twitterpage" placeholder="Twitter Fan Page">
						</div>
					</div>

					
					<div class="row">
						<div class="col-md-2 pull-left control-group">
							<button type="button"
								class="btn btn-danger pre_btn signupbuttons "
								onclick="prev_step1()">Previous</button>
						</div>
						<div  class="col-md-2 control-group pull-right">
							<button type="submit"
								class="btn btn-success next_btn signupbuttons"
								name="socialmediabutton" id="socialmediabutton">Next</button>
						</div>
					</div>
					
					
					<?php
					echo form_close ();
					?>	
					
				</fieldset>

                            <fieldset id="third" style="width:100%">
					<legend class="pagedescription marginleft10">Upload Photo</legend>
					
					<div class="row">
					
					<div class="col-md-4 col-lg-4" style="margin-left: 25px;">
						<p><span class="boldtext bmargin10">Image upload instructions.</span></p>
						<ol>
							<li>Image format must be jpg, png or gif</li>
							<li>Image must be of atleast 300px in width and 300px in height.</li>
							<li>Image size must be less than 8 MB.</li>
						</ol>	
				
					<div class="linespacer">
						<button name="selectfilebutton" id="selectfilebutton" class="btn" style="width: 100%;">Upload photo</button>
						<button name="changeimagebutton" id="changeimagebutton" class="btn" style="width: 100%;display:none;">
						Change photo</button>
						<input type="file" name="profileimageupload" id="profileimageupload" class="btn" style="display:none;"/>
					</div>
						
					
					<div class="linespacer imagesavebuttons">
					
					<button style="width: 45%;"
								class="btn"
								name="cancelupload" id="cancelupload">Cancel</button>
								
					<button style="width: 45%;"
								class="btn btn-success next_btn signupbuttons"
								name="imageuploadbutton" id="imageuploadbutton">Crop and Save</button>					
					
					</div>
					
					</div>
					
					<div class="col-md-offset-1 col-lg-offset-1 col-md-6 col-lg-6 center-horizontal" style="margin-left: 25px;">
						<div class="form-group text-center">
							<p class="instructions">Crop image. </p>
							<!--Image container that we will use to crop-->

							<div id="profile-image-div" class="text-center center-horizontal" style="width: 300px; overflow: hidden; border: 1px solid">
								 <img id="profile-image" 
									src="<?php echo base_url() ?>images/avatar.png"
									style="width: 300px;" />
							</div>
							
						</div>
						
						
					</div>
					</div>

					<div class="row">
						<div class="col-md-2 pull-left">
							<button type="button"
								class="btn btn-danger pre_btn signupbuttons "
								onclick="prev_step2()">Previous</button>
						</div>
						<div class="col-md-offset-8 col-md-2 pull-right">
							<button type="button"
								class="btn btn-success next_btn signupbuttons"
								name="createprofilebutton" id="createprofilebutton">Create Profile</button>
							<div class="form-group profilecreatedmessage">
								<p class="col-md-offset-8 col-md-2">
								
							</div>	
						</div>
					</div>
					

					<div class="form-group">
						
							<!--Image selection x,y position, with height and with input container-->
							
							<input type="text" id="x1" name="x1" value="0" style="display:none;" /> 
							<input type="text" name="w" value="0" id="w" style="display:none;" /> 
							<input type="text" id="y1" name="y1" value="0" style="display:none;" /> 
							<input type="text" id="h" name="h" value="0" style="display:none;" /> 
							<input type="text" name="x2" id="x2" value="0" style="display:none;"/>
							<input type="text" name="y2" id="y2" value="0" style="display:none;"/>
							<input type="hidden" name="filename" value="" id="filename" /> <br>

					</div>
					
					
				</fieldset>

			</div>
		</div>
	</div>
	</div>

	<!-- Load js files in the end----->


	<footer>
		
		<?php
		
		$this->view ( 'includes/home/footer_include' );
		?>
	</footer>
	
	<?php
	
	$this->view ( 'includes/home/tab_js' );
	$this->view ( 'includes/home/privacypolicy' );
	?>
	
	<script type="text/javascript">

		getSubCategories('<?php echo $sub_categories;?>');

	</script>

</body>
</html>


