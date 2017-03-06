<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author snigam
 *
 */
class LoginForm extends CI_Controller {

	var $data;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('login/signupmodel','signupmodel');
		$this->lang->load('auth','english');
		$this->load->model('profile/venuedetailsmodel', 'venuedetailsmodel');
		$this->load->model('utils/utilsmodel','utilsmodel');
	
	}
	
	public function index()
	{
		$this->load->view('home', $this->data);
		
	}
	
	public function logout(){
	  //Kill user session
	  
	  $this->output->set_header("Cache-Control", "no-cache, no-store, must-revalidate");
	  
	  $this->session->unset_userdata('user_id');
	  $this->session->sess_destroy();
	  //delete the remember me cookies if they exist
	  if (get_cookie($this->config->item('identity_cookie_name', 'ion_auth')))
	  {
	  	delete_cookie($this->config->item('identity_cookie_name', 'ion_auth'));
	  }
	  if (get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
	  {
	  	delete_cookie($this->config->item('remember_cookie_name', 'ion_auth'));
	  }
	  
	  
	  //Destroy the session
	  $this->session->sess_destroy();
	  
	  //Recreate the session
	  if (substr(CI_VERSION, 0, 1) == '2')
	  {
	  	$this->session->sess_create();
	  }
	  else
	  {
	  	$this->session->sess_regenerate(TRUE);
	  }
	  
	  $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "";
   	
      //$this->load->view('homepage',$data);
      //redirect(base_url(), 'refresh');

      header("Location: ".base_url());
	}
	
	/** Login method for artists and venue. This method is not for social network login.
	 * @return boolean
	 */
	public function login(){
		
		// Setting the response data
			
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		$this->form_validation->set_rules('login_email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('user_role', 'Role', 'trim|required');
		
		if ($this->form_validation->run() == true)
		{
			$login_email = $this->input->post('login_email');
			$password = $this->input->post('password');
			$role = $this->input->post('user_role');
			
			logException('Inside login() method. Parameters are: login_email'.$login_email .'. role is:' . $role );
			
			if($role == 'artist'){
				$this->loginWithArtist($login_email, $password, $role);
			}
			else if($role == 'venue'){
				$this->loginWithVenue($login_email, $password, $role);
			}
			
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$errorMessage = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			logException('Username/Password is incorrect for the user. Error is:' . $errorMessage);
			
			$response = $this->utilsmodel->getResponseData(false, '', 'Username/Password is incorrect.');
			echo json_encode($response);
			return true;
		}
		
	}
	
	
	/** Method to login only artist 
	 * @param unknown $login_email
	 * @param unknown $password
	 * @param unknown $role
	 * @return boolean
	 */
	private function loginWithArtist($login_email, $password, $role){
		
		logException('Inside loginWithArtist() method. Parameters are: login_email: '.$login_email .'. role: ' . $role );
		
		//login artist. Validate user name and password. 
		
		if ($this->ion_auth->login($login_email, $password, $role, false))
		{
			//if the login is successful
			//redirect them back to the home page
			$user_id = $this->session->userdata('user_id');
			$this->session->set_flashdata('message', $this->ion_auth->messages());
		
			try{
				//get user profile data and save it in session
				$isProfileCreated = $this->session->userdata('profile_created');
		
				// Check if the user profile is alredy created
		
				if(($isProfileCreated != null) && ($isProfileCreated == 1)){
					//echo 'profile created';
					$userProfileData = $this->signupmodel->getUserProfileData($user_id);
						
					if(!empty($userProfileData)){
						$this->session->set_userdata($userProfileData);
					}
					else{
						logException('Error in getting user profile for user id' . $user_id);
						$response = $this->utilsmodel->getResponseData(false, '', 'Error in getting user profile.');
						echo json_encode($response);
						return true;
					}
						
					$responseArray['profileUrl'] = base_url().'profile/artist';
					$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return true;
				}
				else{
					$responseArray['profileCreateUrl'] = base_url().'login/signup/gettingstarted';
					$response = $this->utilsmodel->getResponseData(false, $responseArray, 'profile not created');
					echo json_encode($response);
					return true;
						
				}
			}
			catch (Exception $e){
				logException('Error in getting user profile for email' . $login_email . '. Error is:->' . $e->getMessage () );
				echo false;
				return false;
			}
		
		}
		else
		{
			//if the login was un-successful
			//redirect them back to the login page
			logException('Username/Password is incorrect for the email: ' . $login_email);
			logException($this->ion_auth->messages());
		
			$response = $this->utilsmodel->getResponseData(false, '', 'Username/Password is incorrect.');
			echo json_encode($response);
			return true;
		
		}
		
	}
	
	private function loginWithVenue($login_email, $password, $role){
	
		logException('Inside loginWithVenue() method. Parameters are: login_email: '.$login_email .'. role: ' . $role );
	
		//login artist. Validate user name and password.
	
		if ($this->ion_auth->login($login_email, $password, $role, false))
		{
			//if the login is successful
			//redirect them back to the home page
			$user_id = $this->session->userdata('user_id');
	
			try{
				//get user profile data and save it in session
				$isProfileCreated = $this->session->userdata('profile_created');
	
				// Check if the user profile is alredy created
	
				if(($isProfileCreated != null) && ($isProfileCreated == 1)){
					//echo 'profile created';
					$venueProfileData = $this->venuedetailsmodel->getVenueProfileData($user_id);
					logException('after getVenueProfileData');
					if(!isEmpty($venueProfileData)){
						$this->session->set_userdata($venueProfileData);
					}
					else{
						logException('Error in getting user profile for user id' . $user_id);
						$response = $this->utilsmodel->getResponseData(false, '', 'Error in getting user profile.');
						echo json_encode($response);
						return;
					}
	
					$responseArray['profileUrl'] = base_url().'profile/venue';
					$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return;
				}
				else{
					$responseArray['profileCreateUrl'] = base_url().'login/signup/gettingstarted';
					$response = $this->utilsmodel->getResponseData(false, $responseArray, 'profile not created');
					echo json_encode($response);
					return;
	
				}
			}
			catch (Exception $e){
				logException('Error in getting user profile for email' . $login_email . '. Error is:->' . $e->getMessage () );
				echo false;
				return false;
			}
	
		}
		else
		{
			//if the login was un-successful
			//redirect them back to the login page
			logException('Username/Password is incorrect for the email: ' . $login_email);
			logException($this->ion_auth->messages());
	
			$response = $this->utilsmodel->getResponseData(false, '', 'Username/Password is incorrect.');
			echo json_encode($response);
			return true;
	
		}
	
	}
	
	public function loginWithSocialNetwork(){
	
		//Response data
		
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		//Validate the parameters
		
		$this->form_validation->set_rules('login_email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_role', 'User Role', 'trim|required|xss_clean');
		
		
		//$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == true)
		{
			// Check if user already has an account with this email 
			$email = $this->input->post('login_email');
			
			if (!$this->ion_auth->email_check($email)){
				// create a new user for facebook login.
				$email = $this->input->post('login_email');
				$password = '';
				$firstname = $this->input->post('first_name');
				$lastname = $this->input->post('last_name');
				$gender = $this->input->post('gender');
				$user_role = $this->input->post('user_role');
				
				$additional_data = array(
						'first_name' => $firstname,
						'last_name' => $lastname,
						'active' => 1,
						'role' => $user_role,
						//'gender' => $gender,
						'profile_created' => 0
				);
				
				$result = $this->createFacebookUser($email, $password, $additional_data);
				
				// If user is created then redirect it to profile creation page.
				if($result){
					//echo 'profile not created';
					$responseArray['gettingStartedUrl'] = base_url().'login/signup/gettingstarted';
					$response = $this->utilsmodel->getResponseData(false, $responseArray, 'profile not created');
					echo json_encode($response);
					return true;
				}
				else{ 
					//echo "Error in facebook login";
					
					$response = $this->utilsmodel->getResponseData(false, '', 'Error in facebook login.');
					echo json_encode($response);
					
					return true;
				}
				 
			}
			else{
				
				// email exists
				//if user exists, then check if the user profile is created or not. If not then redirect it to profile create page.
				
				if ($this->ion_auth->facebookUserLogin($this->input->post('login_email'), false))
				{
					//if the login is successful
					//redirect them back to the home page
				
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					
					try{
						//get user profile data and save it in session
						$isProfileCreated = $this->session->userdata('profile_created');
						
						// Check if the user profile is alredy created
				
						if(($isProfileCreated != null) && ($isProfileCreated == 1)){
							//echo 'profile created';
							$userProfileData = $this->signupmodel->getUserProfileData($this->session->userdata('user_id'));
							$this->session->set_userdata($userProfileData);
								
							//echo 'login success';
							
							$responseArray['profileUrl'] = base_url().'profile/artist';
							$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
							echo json_encode($response);
							return true;
						}
						else{
							// Profile is not created. Redirect to the profile creation page.
							$responseArray['gettingStartedUrl'] = base_url().'login/signup/gettingstarted';
							$response = $this->utilsmodel->getResponseData(false, $responseArray, 'profile not created');
							echo json_encode($response);
							return true;
						}				
				
					}
					catch (Exception $e){
						logException('Error in getting user profile for user id' . $user_id . '. Error is:->' . $e->getMessage () );
						$response = $this->utilsmodel->getResponseData(false, '', 'Error in getting user profile.');
						echo json_encode($response);
						return false;
					}
					//redirect('/', 'refresh');
				}
				else
				{
					//if the login was un-successful
					//redirect them back to the login page
					$response = $this->utilsmodel->getResponseData(false, '', 'Username/Password is incorrect.');
					echo json_encode($response);
					return true;
					
				}
			}
		}
		else
		{
			//the user is not logging in so display the login page
			
			$response = $this->utilsmodel->getResponseData(false, '', 'Facebook login un-suuccessful.');
			echo json_encode($response);
			//echo $this->data['message'];
			return true;
				
		}
	
	}
	
	
function forgotPassword()
	{
		$this->form_validation->set_rules('forgot_password_email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			//$this->_render_page('auth/forgot_password', $this->data);
			//echo $this->data['message'];
			
			logException($this->data['message']);
			
			$response = $this->utilsmodel->getResponseData(false, '', '');
			echo json_encode($response);
			return true;
		}
		else
		{	
			// get identity from username or email
			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('forgot_password_email')))->users()->row();
			}
			else
			{
				$identity = $this->ion_auth->where('email', strtolower($this->input->post('forgot_password_email')))->users()->row();
			}
			
	       if(empty($identity)) {
		       $this->ion_auth->set_message('forgot_password_email_not_found');
		       $this->session->set_flashdata('message', $this->ion_auth->messages());
		       
		       $response = $this->utilsmodel->getResponseData(false, '', 'Email not found.');
		       echo json_encode($response);
		       return true;
           }
			
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
			
			if ($forgotten)
			{
				//if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				//redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
				//echo "An email has been sent to ".$this->input->post('forgot_password_email').". Please check your email";
				//return true;
				
				$response = $this->utilsmodel->getResponseData(true, '', '');
				echo json_encode($response);
				return true;
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$response = $this->utilsmodel->getResponseData(false, '', $this->ion_auth->errors());
				echo json_encode($response);
				return true;
			}
		}
	}
	
	public function emailcheck(){
		
		// Setting the response data
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		$this->form_validation->set_rules('forgot_password_email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		
		if ($this->form_validation->run() == false)
		{
			//set any errors and display the form
			//$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$response = $this->utilsmodel->getResponseData(false, '', 'Invalid email.');
		}
		else{
			$email = $this->input->post('forgot_password_email');
			
			if (!$this->ion_auth->email_check($email)){
				//echo "Email not found";
				$response = $this->utilsmodel->getResponseData(false, '', 'Email not found.');
			}
			else{
				//echo 'true';
				$responseArray['emailSent'] = 'An email has been sent to '.$email.'. Please check your email.';
				$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
			}
			
		}
		echo json_encode($response);
		return true;
	}
	
	private function createFacebookUser($email, $password, $additional_data){
	
			$group_name = array();
			$user_id = $this->ion_auth->registerFacebookUser("", $password, $email, $additional_data, $group_name);
	
			if($user_id){
				
				$fbUserData = array(
					
						'user_id' => $user_id,
						'first_name' => $additional_data['first_name'],
						'last_name'  => $additional_data['last_name'],
						'email'      => $email,
						'profile_created' => 0
				);
				
				$this->session->set_userdata($fbUserData);
				
				return true;
				
			}
			
			else
				return false;
		
	}
	
	public function getResponseData($status, $data, $errorMessage){
	
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
	
		$response['status'] = $status;
		$response['data'] = $data;
		$response['errorMessage'] = $errorMessage;
	
		return $response;
	
	}
	
	public function isSessionExist($var){
	
		if(($this->session->userdata($var) != null) && ($this->session->userdata($var) != '')){
			return true;
		}
		else
			return false;
	}
	
	public function isSessionAlive(){
	
		$user_id = $this->session->userdata('user_id');
		if(!isEmpty($user_id)){
			$response = $this->utilsmodel->getResponseData(true, '', '');
			echo json_encode($response);
			return true;
		}
		
		$response = $this->utilsmodel->getResponseData(false, '', '');
		echo json_encode($response);
		return true;
	}
	
	public function loginForReview(){
		
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == true){
			
			$email = $this->input->post('email');
			$password = $this->input->post('password');
				
				
			if ($this->ion_auth->login($email, $password, false))
			{
				$user_id = $this->session->userdata('user_id');
				
				try{
					//get user profile data and save it in session
					$isProfileCreated = $this->session->userdata('profile_created');
				
					// Check if the user profile is alredy created
				
					if(($isProfileCreated != null) && ($isProfileCreated == 1)){
						//echo 'profile created';
						$userProfileData = $this->signupmodel->getUserProfileData($user_id);

						$responseArray['email'] = $email;
						$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
						
						if(!isEmpty($userProfileData)){
							$this->session->set_userdata($userProfileData);
						}
						else{
							logException('Error in getting user profile for user id' . $user_id);
							// If error in getting user profile, destroy user session.
							$this->session->unset_userdata('user_id');
						}
							
						
						$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
						echo json_encode($response);
						return true;
					}
					else{
						$responseArray['email'] = $email;
						$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
						echo json_encode($response);
						$this->session->unset_userdata('user_id');
						return true;
							
					}
				}
				catch (Exception $e){
					
					logException('Error in getting user profile for user id' . $user_id . '. Error is:->' . $e->getMessage () );
					$response = $this->utilsmodel->getResponseData(false, '', 'Email/password is invalid.');
					echo json_encode($response);
					$this->session->unset_userdata('user_id');
					
					return false;
				}
				
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Email/password is invalid.');
				echo json_encode($response);
				return true;
			}
		}
		else{
			$response = $this->utilsmodel->getResponseData(false, '', 'Email/password is invalid.');
			echo json_encode($response);
			return true;
		}
		
		
	}
	
	public function loginWithSocialNetworkForReview(){
	
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		if ($this->form_validation->run() == true){
			
			$email = $this->input->post('email');
			if(!isEmpty($email)){
				$responseArray['email'] = $email;
				$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
				echo json_encode($response);
			}
			
		}
		else{
			logException('Error in getting email from Social Network. Error is:->Email not received.');
			$response = $this->utilsmodel->getResponseData(false, '', 'Email not received.');
			echo json_encode($response);
			return true;
		}
	
	
	}

}