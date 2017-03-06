<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	var $data;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('login/signupmodel','signupmodel');
		$this->load->model('utils/imagemodel','imagemodel');
		$this->load->model('utils/utilsmodel','utilsmodel');
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
	
		logDebug( 'Inside createuser() method.');
		
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
			$response = $this->utilsmodel->getResponseData(false, '', $errorMessage);
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
				
			
				if($this->form_validation->run() == FALSE){
					$errorMessage = validation_errors();
					$response = $this->utilsmodel->getResponseData(false, '', $errorMessage);
					echo json_encode($response);
					return;
				}
				else{
					$signupData['first_name'] = ucfirst($this->input->post('firstname'));
					$signupData['last_name'] = ucfirst($this->input->post('lastname'));
					
					$this->artistSignUp($signupData);
				}
			}
			else if($signupData['user_role'] == 'venue'){
				//Validate venue related fields
				$this->form_validation->set_rules('venue_name', 'Venue Name', 'trim|required|xss_clean');
				
				if($this->form_validation->run() == FALSE){
					$errorMessage = validation_errors();
					$response = $this->utilsmodel->getResponseData(false, '', $errorMessage);
					echo json_encode($response);
					return;
				}
				else{
					$signupData['venue_name'] = ucwords($this->input->post('venue_name'));
					$this->venueSignUp($signupData);
				}
				
			}
		}
		
	}
	
	/** Function for artist profile signup
	 * @param unknown $signupData
	 */
	private function artistSignUp($signupData){
		
		$response = array();
		
		if(!isEmpty($signupData)){
			
			//Getting username
			$userName = $this->signupmodel->getUserName($signupData['first_name'], $signupData['last_name']);
			
			//Getting additional data for signup
			$additional_data = array(
					'first_name' => $signupData['first_name'],
					'last_name' => $signupData['last_name'],
					'active' => 0,
					'phone' => $signupData['mobile'],
					'role' => $signupData['user_role'],
					'profile_created' => 0
			);
			
			$group_name = array();
			$user_id = $this->ion_auth->register($userName, $signupData['password'], $signupData['email'], $additional_data, $group_name);
			
			if($user_id){
				$response = $this->utilsmodel->getResponseData(true, '', '');
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Error occurred during sign up.');
			}
				
		}
		else{
			logException( '$signupData is empty');
			$response = $this->utilsmodel->getResponseData(false, '', 'Error occurred during sign up.');
		}
		
		echo json_encode($response);
		return;
	}
	
	/** Function for venue profile signup
	 * @param unknown $signupData
	 */
	private function venueSignUp($signupData){
	
		$response = array();
		
		if(!isEmpty($signupData)){

			//Getting username
			$userName = $this->signupmodel->getUserName($signupData['venue_name'], '');
				
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
			$user_id = $this->ion_auth->register($userName, $signupData['password'], $signupData['email'], $additional_data, $group_name);
				
			if($user_id){
				$response = $this->utilsmodel->getResponseData(true, '', '');
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Error occurred during sign up.');
			}
		
		}
		else{
			logException( '$signupData is empty');
			$response = $this->utilsmodel->getResponseData(false, '', 'Error occurred during sign up.');
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
				//Redirect to the getting started page
				redirect(base_url().'login/signup/gettingstarted', 'refresh');
			}
			else{
				echo "Activation error.";
			}
			
		}
		else
		{
			$this->gettingstarted();
			
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
		
		if(!isEmpty($user_id) && ($profileCreated == 0)) {
			$this->load->view('login/gettingstarted', $data);
		}
		else{
			redirect(base_url(), 'refresh');
		}
		
	}
	
	/** Method to validate and store data in session for first step of profile creation form
	 * @return void|boolean
	 */
	public function artistprofile(){
	
		//Validate session first
		
		$response = array();
		
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
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
			
			logDebug( 'Inside artist role');
			
			$this->form_validation->set_rules('artist_category', 'Artist type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('artist_sub_category', 'Artist speciality', 'trim|required|xss_clean');
			$this->form_validation->set_rules('description', 'Artist Description', 'trim|required|min_length[50]');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
				
			
			//Validate form
			if ($this->form_validation->run() == FALSE){
				$error = validation_errors();
				logException( $error);
				$response = $this->utilsmodel->getResponseData(false, '', 'Invalid data received.');
				
			}
			else{
				//Valid data received
				$artist_category = $this->input->post('artist_category');
				$artist_sub_category = $this->input->post('artist_sub_category');
				$gender = $this->input->post('gender');
				$description = $this->input->post('description');
				$city = $this->input->post('city');
				$gender = $this->input->post('gender');
				
				
				$profileData = array(
						'artist_category' => $artist_category,
						'artist_sub_category' => $artist_sub_category,
						'description' => $description,
						'city' => $city,
						'gender' => $gender
				);
				
				$this->session->set_userdata($profileData);
				$response = $this->utilsmodel->getResponseData(true, '', '');
			}
		}
		else if($role =='venue'){
			
			logDebug( 'Inside venue role');
			
			$this->form_validation->set_rules('venue_description', 'Venue description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('events_category', 'Events category', 'trim|required|xss_clean');
			
			//Validate form
			if ($this->form_validation->run() == FALSE){
				//Invalid data
				$error = validation_errors();
				logException( $error);
				$response = $this->utilsmodel->getResponseData(false, '', 'Invalid data received.');
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
				
				logException('$events_category::'. $this->session->userdata('events_category'));
				$response = $this->utilsmodel->getResponseData(true, '', '');
			}
		}
		else{
			$response = $this->utilsmodel->getResponseData(false, '', 'Invalid user role.');
		}
		
		logDebug( implode(" ", $response));
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
	
		logDebug( 'Inside social profile form.');
		
		$response = array();
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		//Validating form
		$this->form_validation->set_rules('facebookpage', 'Facebook page', 'trim|xss_clean');
		$this->form_validation->set_rules('twitterpage', 'Twitter page', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			logException( 'Validation errors: '. validation_errors());
			$response = $this->utilsmodel->getResponseData(false, '', 'Invalid data received.');
		}
		else{
			
			$facebookpage = $this->input->post('facebookpage');
			$twitterpage = $this->input->post('twitterpage');
	
			$socialData = array(
					'facebookpage' => $facebookpage,
					'twitterpage' => $twitterpage
			);
				
			$this->session->set_userdata($socialData);
			$response = $this->utilsmodel->getResponseData(true, '', '');
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
			logException( 'Image resize failed. Error is: '. print_r($error));
			
			return false;
		}
		
	}
	
	public function imageCrop($imageName, $x1, $y1, $w, $h){
		
		$this->load->library('image_lib');
		$this->image_lib->clear();
       
       // crop
        $config['image_library'] = $this->config->item('ar_img_image_library');
        $config['source_image'] = $this->config->item('ar_img_upload_path').$imageName;
        $config['new_image'] =  $this->config->item('ar_img_upload_path').$imageName;
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
			$error = $this->image_lib->display_errors();
			logException( 'Image crop failed. Error is: '.$error);
			return false;
		}
		
	}
	
	public function profileImageUpload(){
		logDebug( 'Inside profileImageUpload.');
		$response = array();
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Your session has expired.');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		//applying form validations
		$this->form_validation->set_rules('filename', 'File', 'trim|xss_clean');
		
		//Check if data is valid.
		if ($this->form_validation->run() == FALSE)
		{
			logException( 'Validation errors: '. validation_errors());
			$response = $this->utilsmodel->getResponseData(false, '', 'Invalid data received.');
			echo json_encode($response);
			return;
		}
		//Getting image original name from UI.
		$imageOriginalName = $this->input->post('filename');
		
		//Getting image extension
		$ext = pathinfo($imageOriginalName, PATHINFO_EXTENSION);
		
		//Getting image name
		$imageName = time().'.'.$ext;
		
		//Loading image and rendering back after resizing
		
		//Upload image
		
		//Getting config for image upload.
		$config = $this->imagemodel->getProfileImageUploadConfig($imageName);
		
		$this->load->library('upload', $config);
		
		//upload image
		if ( ! $this->upload->do_upload('profileimage'))
		{
			$error = $this->upload->display_errors();
			$response = $this->utilsmodel->getResponseData(false, '', $error);
			echo json_encode($response);
			logException( 'Image upload failed. Error is: '. $error);
			return;
		}
		
		//Validate image size after image upload
		$imagePath = $this->config->item('ar_img_upload_path').$imageName;
		list($originalWidth, $originalHeight) = getimagesize($imagePath);
		logDebug( 'Image original height is: '.$originalHeight.', width is: '.$originalWidth);
		
		//Validate image width and height
		$minWidth = $this->config->item('ar_img_min_width');
		$minHeight = $this->config->item('ar_img_min_height');
		
		//Validate for minimum height and width. If invalid then delete the image from server.
		if(($originalWidth < $minWidth) || ($originalHeight < $minHeight) ){
			unlink($this->config->item('ar_img_upload_path').$imageName);
			$response = $this->utilsmodel->getResponseData(false, '', 'Please choose a photo whose width and height is at least 300 pixels.');
			echo json_encode($response);
			return;
		}
		
		//Resize image with proportion after upload
		
		if(!$this->imagemodel->resizeProfileImage($imagePath)){
			$response = $this->utilsmodel->getResponseData(false, '', 'Error in upload.');
			echo json_encode($response);
			return;
		}
		
		$imageUrl = base_url().$this->config->item('ar_img_upload_path').$imageName;
		$responseArray['imageUrl'] = $imageUrl;
		$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
		
		//Check for change profile image
		if($this->utilsmodel->isSessionExist('profile_image_name')){
			
			$imageFromSession = $this->session->userdata('profile_image_name');
			
			//Removing image name from session and also deleting it from server.
			if(!empty($imageFromSession)){
				unlink($this->config->item('ar_img_upload_path').$imageFromSession);
				$this->session->unset_userdata('profile_image_name');
			}
		}
		
		//Set image name in session for cropping
		$profileImageData['profile_image_name'] = $imageName;
		
		if(!empty($profileImageData)){
			$this->session->set_userdata($profileImageData);
		}
		
		logException( 'profile image name is: '.$this->session->userdata('profile_image_name'));
		echo json_encode($response);
		return;
		
	}
	
	/**
	 * Method to cancel image upload. This method also deletes the image from the server.
	 * 
	 */
	public function cancelImageUpload(){
		
		logDebug( 'Inside cancelImageUpload()');
		$response = array();
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		//getting image name from session
		$imageFromSession = $this->session->userdata('profile_image_name');
		
		//Removing image name from session and also deleting it from server.
		if(!empty($imageFromSession)){
			unlink($this->config->item('ar_img_upload_path').$imageFromSession);
			$this->session->unset_userdata('profile_image_name');
		}
		
		//send response back to UI
		$response = $this->utilsmodel->getResponseData(true, '', '');
		echo json_encode($response);
		return;
		
	}
	
	public function cropAndSaveImage(){
		
		logDebug( 'Inside cropAndSaveImage()');
		$response = array();
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		//applying form validations
		$this->form_validation->set_rules('x1', 'Data', 'trim|required|xss_clean');
		$this->form_validation->set_rules('y1', 'File', 'trim|required|xss_clean');
		$this->form_validation->set_rules('w', 'File', 'trim|required|xss_clean');
		$this->form_validation->set_rules('h', 'File', 'trim|required|xss_clean');
		
		//Check if data is valid.
		if ($this->form_validation->run() == FALSE)
		{
			logException( 'Validation errors: '. validation_errors());
			$response = $this->utilsmodel->getResponseData(false, '', 'Invalid data received.');
			echo json_encode($response);
			return;
		}
		
		$x1=$this->input->post('x1');
		$y1=$this->input->post('y1');
		$w=$this->input->post('w');
		$h=$this->input->post('h');
		
		//Getting image name from session.
		try{
			//getting image name from session
			$imageNameFromSession = $this->session->userdata('profile_image_name');
			
			//Removing image name from session and also deleting it from server.
			if(!empty($imageNameFromSession)){
				
				if ($this->imageCrop($imageNameFromSession, $x1, $y1, $w, $h )) {
					
					$imageUrl = base_url().$this->config->item('ar_img_upload_path').$imageNameFromSession;
					$responseArray['imageUrl'] = $imageUrl;
					$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
					echo json_encode ( $response );
					return;
				} else {
					$response = $this->utilsmodel->getResponseData(false, '', 'Error in image cropping.' );
					echo json_encode ( $response );
					return;
				}
				
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Error during image upload.' );
				echo json_encode ( $response );
				return;
			}
		}
		catch( Exception $e){
			logException( 'Error in image crop:->' . $e->getMessage () );
			$response = $this->utilsmodel->getResponseData(false, '', 'An unexpected error has occured. Please try after some time.');
			return;
		}
		
	}

	/**Method to create user profile from multi step profile creation form.
	 * @return boolean
	 */
	public function createUserProfile(){
	
		
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		
		//Arrays for storing profile data and image data.
		$profile_data = array();
		$image_data = array();
		
		if($role == 'artist'){
			$artist_category = $this->session->userdata('artist_category');
			$artist_sub_category = $this->session->userdata('artist_sub_category');
			$description = $this->session->userdata('description');
			$facebookPage = $this->session->userdata('facebookpage');
			$twitterPage = $this->session->userdata('twitterpage');
			$profileImageName = $this->session->userdata('profile_image_name');
			$city = $this->session->userdata('city');
			$gender = $this->session->userdata('gender');
			
			logException('City is::'.$city);
			
			$profile_data = array(
					'id' => $user_id,
					'category_id' => $artist_category,
					'sub_category_id' => $artist_sub_category,
					'gender' => $gender,
					'description' => $description,
					'facebookpage' => $facebookPage,
					'twitterpage' => $twitterPage,
					'city' => $city
			);
			
			// Creating user image data
			$image_data = array(
					'id' => $user_id,
					'image_path' => $profileImageName,
					'image_type' => 'profile'
			);
			
			$isProfileCreated = $this->signupmodel->createUserProfile($profile_data, $image_data);
				
			// If user profile is created, get user profile details in session
			if($isProfileCreated){
			
				$userProfileData = $this->signupmodel->getUserProfileData($user_id);
				
				if(!isEmpty($userProfileData)){
					$this->session->set_userdata($userProfileData);
					$responseArray['profileUrl'] = base_url().'profile/artist';
					$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return true;
				}
			
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in creating profile.');
				echo json_encode($response);
				return true;
			
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in creating profile.');
				echo json_encode($response);
				return true;
			}
			
		}
		
		else if($role == 'venue'){
			
			logException( 'inside venue profile create.');
			//Getting venue related information
			$venue_category = $this->session->userdata('events_category');
			$venue_description = $this->session->userdata('venue_description');
			$facebookPage = $this->session->userdata('facebookpage');
			$twitterPage = $this->session->userdata('twitterpage');
			$profileImageName = $this->session->userdata('profile_image_name');
			$city = $this->session->userdata('city');
			
			logException( '$venue_category is: ', $venue_category);
			
			//Creating venue profile data.
			$profile_data = array(
					'id' => $user_id,
					'venue_categories' => $venue_category,
					'venue_description' => $venue_description,
					'facebookpage' => $facebookPage,
					'twitterpage' => $twitterPage,
					'city'  => $city
			);
				
			// Creating venue image data
			$image_data = array(
					'id' => $user_id,
					'image_path' => $profileImageName,
					'image_type' => 'profile'
			);
			
			
			$isProfileCreated = $this->signupmodel->createVenueProfile($profile_data, $image_data);
			
			// If user profile is created, get user profile details in session
			if($isProfileCreated){
					
				$venueProfileData = $this->signupmodel->getVenueProfileData($user_id);
				
				if(!empty($venueProfileData)){
					logDebug(implode($venueProfileData));
					$this->session->set_userdata($venueProfileData);
					$responseArray['profileUrl'] = base_url().'profile/venue';
					$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return;
				}
					
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in creating profile.');
				echo json_encode($response);
				return true;
					
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in creating profile.');
				echo json_encode($response);
				return true;
			}
		}
	}

	private function getProfileImageUploadConfig($imageName){
		
		$config['upload_path'] = $this->config->item('ar_img_upload_path');
		$config['allowed_types'] = $this->config->item('ar_img_allowed_types');
		$config['max_size']	= $this->config->item('ar_img_max_size');
		$config['max_width']  = $this->config->item('ar_img_max_width');
		$config['overwrite'] = $this->config->item('ar_img_overwrite');
		$config['remove_spaces'] = $this->config->item('ar_img_remove_spaces');
		$config['file_name'] = $imageName;
		
		return $config;
	}
	
	/** Method to insert data in search table
	 * @param unknown $user_id
	 * @param unknown $name
	 * @param unknown $role
	 */
	private function insertSearchData($user_id, $name, $role){
		
		logDebug('Inside insertSearchData');
		
		if(!empty($user_id) && !empty($name) && !empty($role)){
			
		}
		
	}
	
}