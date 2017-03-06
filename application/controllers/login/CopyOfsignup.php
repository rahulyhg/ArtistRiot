<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	var $data;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('login/signupmodel','signupmodel');
		
	}
	
	public function index()
	{
		$data['categories'] = $this->signupmodel->get_categories();
		$data['sub_categories'] = $this->signupmodel->get_sub_categories();
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "Artist Riot";
		$data['tab'] = "signup";
		$this->load->view('login/signupform', $data);
	}
	
	/**
	 * Method for user signup.
	 * 
	 */
	public function createuser(){
	
		log_message ( 'debug', 'Inside createuser() method.');
		
		$signupData = array();
		
		// Validate common fields for artists and venues and then call methods for artist and venue signup.
		$this->form_validation->set_rules('user_role', 'Role', 'trim|required');
		$this->form_validation->set_rules('signup_email', 'Email Address', 'trim|required|valid_email|matches[signup_email_confirm]');
		$this->form_validation->set_rules('signup_email_confirm', 'Email confirmation', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[30]');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|xss_clean|exact_length[10]|numeric');
		$this->form_validation->set_rules('signup_email', 'Email Address', 'callback_email_exist');
		
		if ($this->form_validation->run() == FALSE){
			$errorMessage = validation_errors();
			$response = getResponseData(false, '', $errorMessage);
			echo json_encode($response);
			return;
		}
		else{
			
			//Create signUp data array
			$signupData['user_role'] = $this->input->post('user_role');
			$signupData['email'] = $this->input->post('signup_email');
			$signupData['password'] = $this->input->post('password');
			$signupData['mobile'] = $this->input->post('mobile');
			
			if($signupData['user_role'] == 'artist'){
				//Validate artist related fields
				$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean|alpha');
				$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean|alpha');
				$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			
				if($this->form_validation->run() == FALSE){
					$errorMessage = validation_errors();
					$response = getResponseData(false, '', $errorMessage);
					echo json_encode($response);
					return;
				}
				else{
					$signupData['first_name'] = $this->input->post('firstname');
					$signupData['last_name'] = $this->input->post('lastname');
					$signupData['gender'] = $this->input->post('gender');
					
					$this->artistSignUp($signupData);
				}
			}
			else if($signupData['user_role'] == 'venue'){
				//Validate venue related fields
				$this->form_validation->set_rules('venue_name', 'Venue Name', 'trim|required|xss_clean');
				
				if($this->form_validation->run() == FALSE){
					$errorMessage = validation_errors();
					$response = getResponseData(false, '', $errorMessage);
					echo json_encode($response);
					return;
				}
				else{
					$signupData['venue_name'] = $this->input->post('venue_name');
					$this->venueSignUp($signupData);
				}
				
			}
		}
		
	}
	
	/** Function for artist profile signup
	 * @param unknown $signupData
	 */
	private function artistSignUp($signupData){
		
		$response = '';
		
		if(!isEmpty($signupData)){
			
			//Getting additional data for signup
			$additional_data = array(
					'first_name' => $signupData['first_name'],
					'last_name' => $signupData['last_name'],
					'active' => 0,
					'phone' => $signupData['mobile'],
					'role' => $signupData['user_role'],
					'gender' => $signupData['gender'],
					'profile_created' => 0
			);
			
			$group_name = array();
			$user_id = $this->ion_auth->register("", $signupData['password'], $signupData['email'], $additional_data, $group_name);
			
			if($user_id){
				$response = getResponseData(true, '', '');
			}
			else{
				$response = getResponseData(false, '', 'Error occurred during sign up.');
			}
				
		}
		else{
			log_message('error', '$signupData is empty');
			$response = getResponseData(false, '', 'Error occurred during sign up.');
		}
		
		echo json_encode($response);
		return;
	}
	
	/** Function for venue profile signup
	 * @param unknown $signupData
	 */
	private function venueSignUp($signupData){
	
		$response = '';
		
		if(!isEmpty($signupData)){
				
			//Getting additional data for signup
			$additional_data = array(
					'first_name' => $signupData['venue_name'],
					'last_name' => '',
					'active' => 0,
					'phone' => $signupData['mobile'],
					'role' => $signupData['user_role'],
					'profile_created' => 0
			);
				
			$group_name = array();
			$user_id = $this->ion_auth->register("", $signupData['password'], $signupData['email'], $additional_data, $group_name);
				
			if($user_id){
				$response = getResponseData(true, '', '');
			}
			else{
				$response = getResponseData(false, '', 'Error occurred during sign up.');
			}
		
		}
		else{
			log_message('error', '$signupData is empty');
			$response = getResponseData(false, '', 'Error occurred during sign up.');
		}
		
		echo json_encode($response);
		return;
	}
	
	
	public function signupconfirm(){
		
		$this->load->view('login/signupconfirm');
	}
	
	public function email_exist($email){
	
		if ($this->ion_auth->email_check($email))
		{
			$this->form_validation->set_message('email_exist', 'This email address is already in use.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}
	
		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			
			$data['categories'] = $this->signupmodel->get_categories();
			$data['sub_categories'] = $this->signupmodel->get_sub_categories();
			$data['meta_keywords'] = "";
			$data['meta_description'] = "";
			$data['language'] = "en";
			$data['title'] = "Artist Riot";
			$data['tab'] = "signup";
			$data['role'] = $this->session->userdata('role');
			
			if($this->session->userdata('user_id') != null){
				$this->load->view('login/gettingstarted', $data);
			}
			else{
				echo "Activation error.";
			}
			
		}
		else
		{
			$this->gettingstarted();
			//Check if profile is created or not else redirect the user to the gettingstarted page.
			
			//redirect them to the forgot password page
			//$this->session->set_flashdata('message', $this->ion_auth->errors());
			//redirect("auth/forgot_password", 'refresh');
		}
	}
	
	function gettingstarted(){
		
		$data['categories'] = $this->signupmodel->get_categories();
		$data['sub_categories'] = $this->signupmodel->get_sub_categories();
		$data['venueCategories'] = $this->signupmodel->getVenueCategories();
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "Artist Riot";
		$data['tab'] = "Getting started";
		
		$profileCreated = $this->session->userdata('profile_created');
		$user_id = $this->session->userdata('user_id');
		
		//echo $this->session->userdata('profile_created');
		if(!isEmpty($user_id) && ($profileCreated == 0)) {
			$this->load->view('login/gettingstarted', $data);
		}
		else{
			redirect(base_url(), 'refresh');
			//echo "User session expired.. Please login again.";
		}
		
	}
	
	/** Method to validate and store data in session for first step of profile creation form
	 * @return void|boolean
	 */
	public function artistprofile(){
	
		//Validate session first
		
		$response = array();
		
		if(!isValidSession() || !isSessionExist('role')){
			log_message('error', 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		$profileData = array();
		//Common validations
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		
		// Role specific validations
		if($role == 'artist'){
			
			log_message('error', 'Inside artist role');
			
			$this->form_validation->set_rules('artist_category', 'Artist type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('artist_sub_category', 'Artist speciality', 'trim|required|xss_clean');
			$this->form_validation->set_rules('description', 'Artist Description', 'trim|required|min_length[50]');
			
			//Validate form
			if ($this->form_validation->run() == FALSE){
				$error = validation_errors();
				log_message('error', $error);
				$response = getResponseData(false, '', 'Invalid data received.');
				
			}
			else{
				//Valid data received
				$artist_category = $this->input->post('artist_category');
				$artist_sub_category = $this->input->post('artist_sub_category');
				$gender = $this->input->post('gender');
				$description = $this->input->post('description');
				$city = $this->input->post('city');
				
				$profileData = array(
						'artist_category' => $artist_category,
						'artist_sub_category' => $artist_sub_category,
						'description' => $description,
						'city' => $city
				);
				$response = getResponseData(true, '', '');
			}
		}
		else if($role =='venue'){
			
			log_message('debug', 'Inside venue role');
			
			$this->form_validation->set_rules('venue_description', 'Venue description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('events_category', 'Events category', 'trim|required|xss_clean');
			
			//Validate form
			if ($this->form_validation->run() == FALSE){
				//Invalid data
				$error = validation_errors();
				log_message('error', $error);
				$response = getResponseData(false, '', 'Invalid data received.');
			}
			else{
				//Valid data received
				$venue_description = $this->input->post('venue_description');
				$events_category = $this->input->post('events_category');
				$city = $this->input->post('city');
					
				$profileData = array(
						'venue_description' => $venue_description,
						'events_category' => $events_category,
						'city' => $city
				);
				
				$this->session->set_userdata($profileData);
				$response = getResponseData(true, '', '');
			}
		}
		else{
			$response = getResponseData(false, '', 'Invalid user role.');
		}
		
		log_message('debug', implode(" ", $response));
		//Returning response.
		if(!empty($response)){
			echo json_encode($response);
		}
		
		return true;
		
	}
	
	/**
	 * Method to create artist social profile in profile creation form.
	 *  
	 */
	public function socialprofile(){
	
		log_message('debug', 'Inside social profile form.');
		
		$response = array();
		
		//Validate session first
		if(!isValidSession() || !isSessionExist('role')){
			log_message('error', 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		//Validating form
		$this->form_validation->set_rules('facebookpage', 'Facebook page', 'trim|xss_clean');
		$this->form_validation->set_rules('twitterpage', 'Twitter page', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			log_message('error', 'Validation errors: '. validation_errors());
			$response = getResponseData(false, '', 'Invalid data received.');
		}
		else{
			
			$facebookpage = $this->input->post('facebookpage');
			$twitterpage = $this->input->post('twitterpage');
	
			$socialData = array(
					'facebookpage' => $facebookpage,
					'twitterpage' => $twitterpage
			);
				
			$this->session->set_userdata($socialData);
			$response = getResponseData(true, '', '');
		}
		
		if(!empty($response)){
			echo json_encode($response);
		}
		
		return;
	
	}
	
	public function imageResize($imagename, $newHeight, $newWidth){
		
		//return true;
		$this->load->library('image_lib');
		
		$config['image_library'] = $this->config->item('ar_img_image_library');
		$config['source_image']	= $this->config->item('ar_img_upload_path').$imagename;
		$config['create_thumb'] = $this->config->item('ar_img_create_thumb');
		$config['maintain_ratio'] = $this->config->item('ar_img_maintain_ratio');
		//$config['width']	= $this->config->item('ar_img_resize_width');
		//$config['height']	= $this->config->item('ar_img_resize_height');
		$config['quality'] =  $this->config->item('ar_img_resize_quality');
		$config['width'] = $newWidth;
		$config['height'] = $newHeight;
		//Now get the resize height based on original image ratio
		//$resizeWidth = $this->config->item('ar_img_resize_width');
		//$resizeHeight =  $originalImageRatio * $resizeWidth;
		//$config['height']	= $resizeHeight;
		
		
		$this->image_lib->initialize($config);
		
		if($this->image_lib->resize()){
			return true;
		}
		else{
			
			$error = array('error' => $this->image_lib->display_errors());
			log_message ( 'error', 'Image resize failed. Error is: '. print_r($error));
			
			return false;
		}
		
	}
	
	public function imageCrop($imagename, $x1, $y1, $w, $h){
		
		$this->load->library('image_lib');
		$this->image_lib->clear();
       
       // crop
        $config['image_library'] = $this->config->item('ar_img_image_library');
        $config['source_image'] = $this->config->item('ar_img_upload_path').$imagename;
        $config['new_image'] =  $this->config->item('ar_img_upload_path').$imagename;
        $config['x_axis'] = $x1;
        $config['y_axis'] = $y1;
        $config['width'] = $w;
        $config['height'] = $h; // actually $this->input->post('h'), but we don't care cuz it is a square thumbnail
        $config['maintain_ratio'] = $this->config->item('ar_img_maintain_ratio');
		
		$this->image_lib->initialize($config);
		
		if($this->image_lib->crop())
		{
			$this->image_lib->clear();
			return true;
		}
		else
		{	
			$error = array('error' => $this->image_lib->display_errors());
			log_message ( 'error', 'Image crop failed. Error is: '. print_r($error));
			return false;
		}
		
	}
	
	public function imageUpload(){
		
		log_message('debug', 'Inside image upload form.');
		$response = array();
		
		//Validate session first
		if(!isValidSession() || !isSessionExist('role')){
			log_message('error', 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		//applying form validations
		$this->form_validation->set_rules('filename', 'File', 'trim|xss_clean');
		
		//Check if data is valid.
		if ($this->form_validation->run() == FALSE)
		{
			log_message('error', 'Validation errors: '. validation_errors());
			$response = getResponseData(false, '', 'Invalid data received.');
			echo json_encode($response);
			return;
		}
		
		$isCropNeeded = true;
		
		//If form is valid then proceed 
		//Getting post parameters
		$imageOriginalName = $this->input->post('filename');
		$x1=$this->input->post('x1');
		$y1=$this->input->post('y1');
		$x2=$this->input->post('x2');
		$y2=$this->input->post('y2');
		$w=$this->input->post('w');
		$h=$this->input->post('h');
		
		$imageHeightUI = $this->input->post('profileimageheight');
		$imageWidthUI = $this->input->post('profileimagewidth');
		
		//If image area is not selected for crop.
		if($x2 == 0){
			$isCropNeeded = false;
			$x2 = $imageWidthUI;
		}
			
		
		if($y2 == 0)
			$y2 = $imageHeightUI;
		
		//Getting image extension
		$ext = pathinfo($imageOriginalName, PATHINFO_EXTENSION);
		
		//Getting image name
		$imagename = time().'.'.$ext;
		
		$config['upload_path'] = $this->config->item('ar_img_upload_path');
		$config['allowed_types'] = $this->config->item('ar_img_allowed_types');
		$config['max_size']	= $this->config->item('ar_img_max_size');
		$config['max_width']  = $this->config->item('ar_img_max_width');
		$config['max_height']  = $this->config->item('ar_img_max_height');
		$config['overwrite'] = $this->config->item('ar_img_overwrite');
		$config['remove_spaces'] = $this->config->item('ar_img_remove_spaces');
		$config['file_name'] = $imagename;
		
		//Check if directory path is valid
		if ( ! is_dir($this->config->item('ar_img_upload_path')) ){
			$response = getResponseData(false, '', 'Image upload failed');
			echo json_encode($response);
			log_message ( 'error', 'Image upload directory does not exist.');
			return;
		} 

		//Upload image
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('profileimageupload'))
		{
			$error = $this->upload->display_errors();
			
			$response = getResponseData(false, '', 'Image upload failed.');
			echo json_encode($response);
			log_message ( 'error', 'Image upload failed. Error is: '. $error);
			return;
			
		}
		else
		{
			//Image upload successful
			
			//Getting original height and width of image
			list($originalWidth, $originalHeight) = getimagesize($this->config->item('ar_img_upload_path').$imagename);
			log_message('debug', 'Image original height is: '.$originalHeight.', width is: '.$originalWidth);
			
			//Logic for image resizing by maintaining image ratio.
			
			$newHeight = 0;
			$newWidth = 0;
			$x0 = 0;
			$x20 = 0;
			$y0 = 0;
			$y20 = 0;
			
			if($originalWidth > $originalHeight){
				$newHeight = ($imageWidthUI/$originalWidth) * $originalHeight;
				$newWidth = $imageWidthUI;
				$y0 = ($imageHeightUI - $newHeight)/2;
				
				$y20 = $y0 + $newHeight;
				if($y1 < $y0){
					$y1 = 0;
				}
				else{
					$y1 = $y1 - $y0;
				}
				
				if($y2 < $y20){
					$y2 = $y2 - $y0;
				}
				else{
					$y2 = $newHeight;
				}
				
			}
			if($originalWidth < $originalHeight){
				$newWidth = ($imageHeightUI/$originalHeight) * $originalWidth;
				$newHeight = $imageHeightUI;
				
				$x0 = ($imageWidthUI - $newWidth)/2;
				$x20 = $x0 + $newWidth;
				
				if($x1 < $x0){
					$x1 = 0;
				}
				else{
					$x1 = $x1 - $x0;
				}
				
				if($x2 < $x20){
					$x2 = $x2 - $x0;
				}
				else{
					$x2 = $newWidth;
				}
			}
			
			$w = $x2 - $x1;
			$h = $y2 - $y1;
			
			// Resize the image before crop
			if ($this->imageResize ( $imagename, $newHeight, $newWidth )) {
				
				$this->session->set_userdata ( 'userimagename', $imagename );
				
				if ($isCropNeeded) {
					// Crop the image
					if ($this->imageCrop ( $imagename, $x1, $y1, $w, $h )) {
						$response = getResponseData ( true, 'Image uploaded.', '' );
						echo json_encode ( $response );
						return;
					} else {
						$response = getResponseData ( false, '', 'Error in image uploading.' );
						echo json_encode ( $response );
						return;
					}
				} else {
					$response = getResponseData ( true, 'Image uploaded.', '' );
					echo json_encode ( $response );
					return;
				}
			} else {
				$response = getResponseData ( false, '', 'Image size not correct.' );
				echo json_encode ( $response );
				return true;
			}
		}
	
	}

	/**Method to create user profile from multi step profile creation form.
	 * @return boolean
	 */
	public function createUserProfile(){
	
		$user_id = $user_id = $this->session->userdata('user_id');
		
		if(!isEmpty($user_id)){
			
			$artist_category = $this->session->userdata('artist_category');
			$artist_sub_category = $this->session->userdata('artist_sub_category');
			$gender = $this->session->userdata('gender');
			$description = $this->session->userdata('description');
			$facebookpage = $this->session->userdata('facebookpage');
			$twitterpage = $this->session->userdata('twitterpage');
			$userimagename = $this->session->userdata('userimagename');
	
			// Creating profile data
			
			$profile_data = array(
					'id' => $user_id,
					'category_id' => $artist_category,
					'sub_category_id' => $artist_sub_category,
					'gender' => $gender,
					'description' => $description,
					'facebookpage' => $facebookpage,
					'twitterpage' => $twitterpage
			);
			
			// Creating user image data
			
			$image_data = array(
					'id' => $user_id,
					'image_path' => $userimagename,
					'image_type' => 'profile'
			);
	
			$isProfileCreated = $this->signupmodel->createUserProfile($profile_data, $image_data);
			
			// If user profile is created, get user profile details in session
			if($isProfileCreated){
				
				$userProfileData = $this->signupmodel->getUserProfileData($user_id);
				
				if(!isEmpty($userProfileData)){
					$this->session->set_userdata($userProfileData);
					$responseArray['profileUrl'] = base_url().'profile/artist';
					$response = getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return true;
				}
				
				$response = getResponseData(false, '', 'Error in creating profile.');
				echo json_encode($response);
				return true;
				
			}
			else{
				$response = getResponseData(false, '', 'Error in creating profile.');
				echo json_encode($response);
				return true;
			}
			
			
		}
		else{
			$response = getResponseData(false, '', 'User session expired..');
			echo json_encode($response);
			return true;
		}
	
	}
	
}