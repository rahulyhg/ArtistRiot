<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editprofile extends CI_Controller {
	
	var $data;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('login/signupmodel','signupmodel');		
        $this->load->model('profile/userdetailsmodel', 'userdetailsmodel');
        $this->load->model('profile/editProfileModel', 'editProfileModel');
        $this->load->model('utils/imagemodel','imagemodel');
        $this->load->model('utils/utilsmodel','utilsmodel');
	
	}
	
	/**
	 * Method to upload cover image.
	 * 
	 */
	public function selectCoverPhoto(){
		
		logDebug( 'Inside selectCoverPhoto.');
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
		
		//Getting config for image upload.
		$config = $this->imagemodel->getCoverImageUploadConfig($imageName);
		
		$this->load->library('upload', $config);
		
		//upload image
		if ( ! $this->upload->do_upload('coverimage'))
		{
			$error = $this->upload->display_errors();
			$response = $this->utilsmodel->getResponseData(false, '', $error);
			echo json_encode($response);
			logException( 'Image upload failed. Error is: '. $error);
			return;
		}
		
		//Validate image size after image upload
		$imagePath = $this->config->item('ar_img_temp_upload_path').$imageName;
		list($originalWidth, $originalHeight) = getimagesize($imagePath);
		logDebug( 'Cover Image original height is: '.$originalHeight.', width is: '.$originalWidth);
		
		//Validate image width and height
		$minWidth = $this->config->item('ar_cover_img_minimum_width');
		$minHeight = $this->config->item('ar_cover_img_minimum_height');
		
		//Validate for minimum height and width. If invalid then delete the image from server.
		if(($originalWidth < $minWidth) || ($originalHeight < $minHeight) ){
			unlink($this->config->item('ar_img_temp_upload_path').$imageName);
			$response = $this->utilsmodel->getResponseData(false, '', 'Please choose a photo whose width is at least '.$minWidth . ' pixels 
					and height is atleast '.$minHeight. ' pixels.');
			echo json_encode($response);
			return;
		}
		
		//Resize image with proportion after upload
		
		if(!$this->imagemodel->resizeCoverImage($imagePath)){
			$response = $this->utilsmodel->getResponseData(false, '', 'Error during upload. Please try again later.');
			echo json_encode($response);
			return;
		}
		
		$imageUrl = base_url().$this->config->item('ar_img_temp_upload_path').$imageName;
		$responseArray['imageUrl'] = $imageUrl;
		$responseArray['fileName'] = $imageName;
		$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
		echo json_encode($response);
		return;
		
	}
	
	/**
	 * Method to save cover photo.
	 */
	public function uploadCoverPhoto(){
		
		logDebug( 'Inside uploadCoverPhoto.');
		$response = array();
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Your session has expired.');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		//Getting top position for repositioning image.
		$imageTop = $this->input->post('coverimagetop');
		
		//Getting image name from UI.
		$imageName = $this->input->post('fileName');
		$tempImagePath = $this->config->item('ar_img_temp_upload_path').$imageName;
		$permanentImagePath = $this->config->item('ar_img_upload_path').$imageName;
		
		logException('$imageName is::'.$imageName);
		logException('$imageTop is::'.$imageTop);
		
		//Check if image exists
		if(!file_exists($tempImagePath)){
			$response = $this->utilsmodel->getResponseData(false, '', 'Error during saving cover image. Please try again after some time.');
			echo json_encode($response);
			return;
		}
		
		//Update DB
		
		if($this->updateCoverImage($imageName, $imageTop)){
			
			//Move cover image from temp location to user images location
			copy($tempImagePath, $permanentImagePath);
			
			if(!file_exists($permanentImagePath)){
				logException('File not moved.');
				$response = $this->utilsmodel->getResponseData(false, '', 'Error during saving cover image. Please try again after some time.');
				echo json_encode($response);
				return;
			}
			//If file copy successful, then delete file at temp location.
			unlink($tempImagePath);
			
			$responseArray['imageUrl'] = base_url().$permanentImagePath;
			$responseArray['image_position'] = $imageTop;
			$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
			
			echo json_encode($response);
			return;

		}
		else{
			$response = $this->utilsmodel->getResponseData(false, '', 'Error in updating cover image.');
			echo json_encode($response);
			return;
		}
		
	}
	
	
	public function coverImageResize($imagename){
	
		$this->load->library('image_lib');
	
		$config['image_library'] = $this->config->item('ar_img_image_library');
		$config['source_image']	= $this->config->item('ar_img_upload_path').$imagename;
		$config['create_thumb'] = $this->config->item('ar_img_create_thumb');
		$config['maintain_ratio'] = $this->config->item('ar_img_maintain_ratio');
		
		$config['quality'] =  '50%';
	
		$this->image_lib->initialize($config);
	
		if($this->image_lib->resize()){
			return true;
		}
		else{
			$error = array('error' => $this->image_lib->display_errors());
			echo "error". ' ' .print_r($error);
			return false;
		}
	
	}
	
	public function updateCoverImage($imagename, $imageTop){
	
		if ($this->checkUserSession('user_id') == FALSE)
		{
			//echo "User session expired.";
			return false;
		}
		else{
			
			$user_id = $this->session->userdata('user_id');
			$existing_cover_image_id = $this->session->userdata('cover_image_id');
			
			//$old_image_id = $this->session->userdata('profile_image_id');
			$imageType = 'cover';
	
			if(!is_null($user_id) && !is_null($imagename)){
				$imageData = $this->signupmodel->uploadUserCoverImage($user_id, $imagename,  $imageType, $existing_cover_image_id, $imageTop);
	
				if(!is_null($imageData) && $imageData){
					$this->session->set_userdata($imageData);
					return true;
				}
			}
			else{
				//echo 'Error in updating image.';
				return false;
			}
	
		}
	}
	
	public function repositionCoverPhoto(){
	
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
	
		if(!is_null( $this->session->userdata('cover_image_id')) && !is_null( $this->session->userdata('user_id'))){
		
		$coverImageId = $this->session->userdata('cover_image_id');
		$userId = $this->session->userdata('user_id');
		$previousImagePosition = $this->session->userdata('image_position');
		$imageTop = $this->input->post('imageTop');
		
		if($previousImagePosition != $imageTop){
			
			try{

				$result = $this->signupmodel->repositionCoverImage($userId, $coverImageId, $imageTop);
				
				if($result){
					
					$this->session->set_userdata('image_position', $imageTop);
					$response['status'] = true;
					$response['errorMessage'] = '';
					echo json_encode($response);
					
					return true;
				}
				else{
					$response['status'] = false;
					$response['errorMessage'] = 'Error in repositioning.';
					echo json_encode($response);
					
					return false;
					
				}
				
			}
			catch(Exception $e){
				
				$response['status'] = false;
				$response['errorMessage'] = 'Error in repositioning.';
				echo json_encode($response);
				
				return false;
			}
		}
		else{
			$response['status'] = true;
			$response['errorMessage'] = 'Image position is same as old position.';
			echo json_encode($response);
			
			return true;
		}
	}
	
	}
	
	
	/** Method to edit profile image.
	 * @return boolean
	 */
	public function editProfilePhoto(){
		
		logDebug( 'Inside profileImageUpload.');
		$response = array();
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession()){
			logException( 'Your session has expired.');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		
		try{
			
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
			
			/** Loading image and rendering back after resizing
			Upload image
			Getting config for image upload. **/
			
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
				$response = $this->utilsmodel->getResponseData(false, '', 'Please choose a photo whose width and height is at least 200 pixels.');
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
			
			//Set image name in session for cropping
			$profileImageData['profile_image_name'] = $imageName;
			if(!empty($profileImageData)){
				$this->session->set_userdata($profileImageData);
			}
			
			logException( 'profile image name is: '.$this->session->userdata('profile_image_name'));
			echo json_encode($response);
			return;
			
		}
		catch(Exception $e){
			logException('Error in updating userprofile image ->' . $e->getMessage () );
			
			$response = $this->utilsmodel->getResponseData(true, '', 'Error in updating userprofile image.');
			$response['status'] = false;
			$response['errorMessage'] = 'Error in updating userprofile image,';
			echo json_encode($response);
		}
		
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
			
			if(!empty($imageNameFromSession)){
		
				//Getting image extension
				$ext = pathinfo($imageNameFromSession, PATHINFO_EXTENSION);
				//Getting image name
				$newImageName = time().'.'.$ext;
				
				if ($this->imageCrop($imageNameFromSession, $x1, $y1, $w, $h, $newImageName )) {
					
					//Deleting resized image
					unlink($this->config->item('ar_img_upload_path').$imageNameFromSession);
					
					if($this->updateImage($newImageName)){
						//$imageUrl = base_url().$this->config->item('ar_img_upload_path').$imageNameFromSession;
						$imageUrl = base_url().$this->session->userdata('user_image');
						$responseArray['imageUrl'] = $imageUrl;
						$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
						echo json_encode ( $response );
						return;
					}
					else{
						$response = $this->utilsmodel->getResponseData(false, '', 'Error in updating profile image.');
						echo json_encode($response);
						logException('Error in updating image.');
						return;
					}
					
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

	public function updateImage($imagename){
		
		logDebug( 'Inside updateImage()');
		$response = array();
		
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return false;
		}
		
			$user_id = $this->session->userdata('user_id');
			$old_image_id = $this->session->userdata('profile_image_id');
			
			$imageType = 'profile';
			
			if(!empty($old_image_id) && !empty($imagename)){
				
				$imageData = $this->signupmodel->updateUserImage($user_id, $old_image_id, $imagename, $imageType);
				
				if(!empty($imageData)){
					$this->session->set_userdata($imageData);
					return true;
				}
			}
			else{
				logException('Error in updating profile image.');
				return false;
			}
	
	}
	
	
	
	
	public function imageResize($imagename){
		
		$this->load->library('image_lib');
		$this->image_lib->clear();
		
		$config['image_library'] = $this->config->item('ar_img_image_library');
		$config['source_image']	= $this->config->item('ar_img_upload_path').$imagename;
		$config['create_thumb'] = $this->config->item('ar_img_create_thumb');
		$config['maintain_ratio'] = $this->config->item('ar_img_maintain_ratio');
		$config['width']	= $this->config->item('ar_edit_img_resize_width');
		$config['height']	= $this->config->item('ar_edit_img_resize_height');
		$config['quality'] =  $this->config->item('ar_img_resize_quality');
		
		$this->image_lib->initialize($config);
		
		if($this->image_lib->resize()){
			$this->image_lib->clear();
			return true;
		}
		else{
			
			$error = array('error' => $this->image_lib->display_errors());
			echo "error". ' ' .print_r($error);
			return false;
		}
		
	}
	
	public function imageCrop($imagename, $x1, $y1, $w, $h, $newImageName){
		
		$this->load->library('image_lib');
		$this->image_lib->clear();
       
       // crop
        $config['image_library'] = $this->config->item('ar_img_image_library');
        $config['source_image'] = $this->config->item('ar_img_upload_path').$imagename;
        $config['new_image'] =  $this->config->item('ar_img_upload_path').$newImageName;
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
			echo "error". ' ' .print_r($error);
			return false;
		}
		
	}


	public function checkUserSession($var){
	
		if($this->session->userdata($var) != null){
			return true;
		}
		else
			return false;
	}
	
	public function test($user_id){
		
		$data = $this->signupmodel->getUserGalleryImagesData($user_id);
		print_r($data);
	}
	public function updateprofile()
    {

        $user_id = $this->session->userdata('user_id');
        $profile_id = $this->session->userdata('profile_id');
        if ($user_id > 1)
        {
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean|alpha');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean|alpha');
            $this->form_validation->set_rules('mobile', 'Phone Number', 'trim|xss_clean|exact_length[10]|numeric');
            $this->form_validation->set_rules('category', 'Type Of Artist', 'trim|required|xss_clean|integer');
            $this->form_validation->set_rules('subcategory', 'Speciality', 'trim|required|xss_clean|integer');
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $mobile = $this->input->post('mobile');
                $category = $this->input->post('category');
                $subcategory = $this->input->post('subcategory');
                $categoryName = $this->input->post('categoryName');
                $subcategoryName = $this->input->post('subcategoryName');
                $status = $this->editProfileModel->UpdateProfileData($profile_id, $user_id, $firstname, $lastname, $mobile, $category, $subcategory, $categoryName, $subcategoryName);
                if ($status)
                {
                    return true;
                }
                else
                    return false;
            }
        }
        else
        {
            redirect(base_url(), 'refresh');
        }
    }

    public function updatelinks()
    {

        $user_id = $this->session->userdata('user_id');
        $profile_id = $this->session->userdata('profile_id');
        if ($user_id > 1)
        {
            $this->form_validation->set_rules('fblink', 'Facebook Link', 'trim|xss_clean');
            $this->form_validation->set_rules('twitterlink', 'Twitter Link', 'trim|xss_clean');
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $fblink = $this->input->post('fblink');
                $twitterlink = $this->input->post('twitterlink');
                $status = $this->editProfileModel->UpdateLinks($profile_id, $user_id, $fblink, $twitterlink);
                if ($status)
                {
                    return true;
                }
                else
                    return false;
            }
        }
        else
        {
            redirect(base_url(), 'refresh');
        }
    }

    public function updatepassword()
    {

        $user_id = $this->session->userdata('user_id');
        if ($user_id > 1)
        {
            $this->form_validation->set_rules('crntpassword', 'Current Password', 'trim|required|min_length[8]|max_length[30]|callback_confirmPassword');
            $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[8]|max_length[30]');
            if ($this->form_validation->run() == FALSE)
            {
                // print_r(validation_errors());
                // redirect(base_url()+'/profile/artist/edit');
                $response = $this->getResponseData(false, '', validation_errors());
            }
            else
            {
                $newpassword = $this->input->post('newpassword');
                $reset = $this->ion_auth->reset_password($this->session->userdata('email'), $newpassword);
                if ($reset)
                {
                    $response = $this->getResponseData(true, '', 'Password has been reset.');
                }
                else
                {
                    $response = $this->getResponseData(false, '', 'There was some issue while resetting the password. Please try again later.');
                }
            }
            echo json_encode($response);
            return true;
        }
        else
        {
            redirect(base_url(), 'refresh');
        }
    }

    public function confirmPassword($password)
    {
        if (($this->ion_auth->hash_password_db($this->session->userdata('email'), $password))==TRUE)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('confirmPassword', 'The password entered is incorrect');
            return FALSE;
        }
    }

    public function getResponseData($status, $data, $errorMessage)
    {

        $response = array('data' => '', 'status' => true, 'errorMessage' => '');

        $response['status'] = $status;
        $response['data'] = $data;
        $response['errorMessage'] = $errorMessage;

        return $response;
    }

}
