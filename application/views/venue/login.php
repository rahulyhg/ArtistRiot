
<div class="modal fade" id="reviewLoginModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		 	<div class="modal-header login_modal_header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h2 class="modal-title" id="review_myModalLabel">Login to <span id="review_accountType"></span> Account</h2>
			</div>
			<div class="modal-body login-modal">
				
				<div class="clearfix"></div>
				<div id='review-social-icons-conatainer'>
					<div class='modal-body-left'>

						<div class='form-group login_error_message'>
							<?php
							echo validation_errors ();
							?>
						</div>
						
						<?php
						$attributes = array (
								'id' => 'loginform',
								'data-toggle' => 'validator' 
						);
						echo form_open ( 'login/loginform/loginforreview', $attributes );
						?>
                    
                        <div class="form-group">
							<input type="email" id="guest_email" placeholder="Enter Email Address"
								name="email" class="form-control login-field"> <i
								class="fa fa-user login-field-icon"></i>
						</div>

                        <div class="form-group">
                            <input type="password" id="guest_password" placeholder="Password" name="password"
                                   class="form-control login-field"> <i
                                   class="fa fa-lock login-field-icon"></i>
                        </div>
						
                        <button type="submit" id="reviewloginbutton" class="btn btn-primary modal-login-btn" >Login</button> 
                        <div><a id="review_forget_password_link" href="#" class="login-link text-center pull-left">Forgot password?</a>
                            <a id="review_signup_link" href="<?php echo base_url()?>login/signupform" class="login-link text-center pull-right">New User Signup</a>	
                        </div>

                        <?php
                        echo form_close();
                        ?>


                        <div id="review_forget_password_section" style="display: none;">

                            <p style="font-size: 10px;"></br></br>Enter your Email
                                Address here to receive a link to change the password.</p>

                            <div class='forgot_password_error_message'>
                                <?php
                                echo validation_errors();
                                ?>
                            </div>

                            <?php
                            $attributes = array(
                                'id' => 'review_forgotpasswordform'
                            );
                            echo form_open('login/loginform/emailcheck', $attributes);
                            ?>
                            <div class="form-group">
                                <input type="email" id="review_forgot_password_email" placeholder="Enter Email Address"
                                       name="forgot_password_email" class="form-control login-field"> 
                            </div>
                            <!---->
                            <button type="submit" id="review_forgotpasswordbutton" class="btn btn-primary">Send Email</button> 

                            <?php
                            echo form_close();
                            ?>

                        </div>

                    </div>

                    <div class='modal-body-right'>
                        <div class="modal-social-icons">
                            <a href='#' class="btn btn-default facebook" id="review_fb-login"> <i
                                    class="fa fa-facebook modal-icons"></i> Sign In with Facebook
                            </a> <div id="review_gSignInWrapper">

                                <div class="g-signin"
                                     data-scope="email"
                                     data-clientid="review_710224545192-c4a1he6m1tc4e2br0gtte1njm4j67b16.apps.googleusercontent.com"
                                     data-callback="onSignInCallbackAfterReview"
                                     data-theme="dark"
                                     data-cookiepolicy="single_host_origin">
                                    <a href='#' class="btn btn-default google" id="review_google-login"> <i
                                            class="fa fa-google-plus modal-icons"></i> Sign In with Google
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--   <div id='center-line'>OR</div>-->
                </div>
                <div class="clearfix"></div>

				<div class="form-group modal-register-btn">
					<!-- <a href="'login/loginform/signupform'" class="btn btn-default">New User Please Register</a> 
					<a id="review_signup_link" href="login/loginform/signupform" class="login-link text-center">New User Please Register</a>-->
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="modal-footer login_modal_footer"></div>
		</div>
	</div>
</div>