<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ManageVenuePhotos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('profile/updateprofilemodel','updateprofilemodel');
		$this->load->model('login/userprofilemodel','userprofilemodel');
		$this->load->model('profile/venueprofilemodel','venueprofilemodel');
		$this->load->model('utils/utilsmodel','utilsmodel');
		$this->load->model('utils/imagemodel','imagemodel');
		$this->load->library('image_lib');
	
	}
	
	/** Method to upload venue gallery images
	 * @return boolean
	 */
	
	public function uploadGalleryImages(){
	
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		
		$this->form_validation->set_rules('imagedescription', 'Image Description', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			$response = $this->utilsmodel->getResponseData(false, '', 'Description field contains invalid text.');
			echo json_encode($response);
			return;
		}
		
		
		try{
			$imageOriginalName = $this->input->post('photoname');
			$imageDescription = $this->input->post('imagedescription');
			$imageOriginalHeight = $this->input->post('imageheight');
			$imageOriginalWidth = $this->input->post('imagewidth');
			
			
			$ext = pathinfo($imageOriginalName, PATHINFO_EXTENSION);
				
			// Get the extension of image.
			$imagename = time().'.'.$ext;
				
			//Getting configurations for image
			$config = $this->imagemodel->getVenueGalleryImageUploadConfig($imagename);
			
			//Check if upload directory exists
			if ( ! is_dir($this->config->item('ar_venue_gallery_img_upload_path')) ){
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in uploading image.');
				echo json_encode($response);
				return;
			}
				
			$this->load->library('upload', $config);

			//Uploading photo
			if ( ! $this->upload->do_upload('galleryimageupload'))
			{
				$response = $this->getResponseData(false, '', 'Image upload failed.');
				echo json_encode($response);
				return;
			}

				if($this->imageResize($imagename, $imageOriginalHeight, $imageOriginalWidth)){
					
				$imageData = $this->venueprofilemodel->addVenueGalleryImage($user_id, $imagename, $imageDescription);
				
				if(!empty($imageData)){
					
					$imagePath = $this->config->item ('ar_venue_gallery_img_upload_path').$imageData['image_name'];
					$imageDescription = $imageData['image_description'];
					
					$responseArray['image_id'] = $imageData['image_id'];
					$responseArray['image_path'] = base_url().$this->config->item ('ar_venue_gallery_img_upload_path').$imageData['image_name'];
					$responseArray['image_description'] = $imageData['image_description'];
					
					$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return true;
				}
				
				$response = $this->utilsmodel->getResponseData(false, '', 'Image upload failed.');
				echo json_encode($response);
				
				return false; 
				}
				else{
					$response = $this->utilsmodel->getResponseData(false, '', 'Image upload failed.');
					echo json_encode($response);
					return false;
				}
				
		}
		catch(Exception $e){
				
			log_message ( 'error', 'Error in uploading gallery images ->' . $e->getMessage () );
			
			$response = $this->getResponseData(false, '', 'Error in updating userprofile image.');
			echo json_encode($response);
			return false;
			
		}
	
	}
	
	/**
	 * @param unknown $imagename
	 * @param unknown $imageOriginalHeight
	 * @param unknown $imageOriginalWidth
	 * @return boolean
	 */
	private function imageResize($imagename, $imageOriginalHeight, $imageOriginalWidth){
	
		
		log_message ( 'debug', 'Inside imageResize. Paremeters are: $imagename='.$imagename.
		', $imageOriginalHeight='.$imageOriginalHeight.', $imageOriginalWidth'.$imageOriginalWidth);
		
		//Calculate original image ratio
		$originalImageRatio = $imageOriginalHeight/$imageOriginalWidth;
		
		$this->image_lib->clear();
		
		//Getting configurations for image
		$config = $this->imagemodel->getVenueGalleryImageResizeConfig($imagename);
		
		//Now get the resize height based on original image ratio
		$resizeWidth = $this->config->item('ar_gallery_img_resize_width');
		$resizeHeight =  $originalImageRatio * $resizeWidth;
		
		//$config['height']	= $this->config->item('ar_gallery_img_resize_height');
		$config['height']	= $resizeHeight;
		
		//$dim = (intval($imageOriginalWidth) / intval($imageOriginalHeight)) - ($config['width'] / $config['height']);
		//$config['master_dim'] = ($dim > 0)? "height" : "width";
	
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
	
	public function isSessionExist($var){
	
		if(($this->session->userdata($var) != null) && ($this->session->userdata($var) != '')){
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
	
	/**
	 * Method to delete gallery image.
	 * @return boolean
	 */
	public function deleteGalleryPhoto()
	{
		
		$user_id = $this->session->userdata('user_id');
	
		if (!isEmpty($user_id))
		{	
			$this->form_validation->set_rules('imageId', 'Gallery Image', 'trim|xss_clean|numeric');
			
			if ($this->form_validation->run() == FALSE)
			{
				$response = $this->getResponseData(false, '', 'Data not valid');
				echo json_encode($response);
				return false;
			}
			else{
				
				$imageId = $this->input->post('imageId');
				
				//Call model to delete image from Database
				$imageName = $this->updateprofilemodel->deleteGalleryImage($user_id, $imageId);
				
				// Getting image name from model. Keep image name to either move or delete image.
				if($imageName){
					$response = $this->getResponseData(true, $imageName, '');
					echo json_encode($response);
					return true;
				}
				else{
					$response = $this->getResponseData(false, '', 'Error in deleting image.');
					echo json_encode($response);
					return false;
				}
			}
		}
		else
		{
			log_message ( 'error', 'User session expired.');
			$responseArray['session_exist'] = false;
			$responseArray['url'] = base_url();
			$response = $this->getResponseData(false, $responseArray, 'User session expired.');
			echo json_encode($response);
			return false;
		}
	}
	
	/**
	 * Method to delete gallery video.
	 * @return boolean
	 */
	public function deleteGalleryVideo()
	{
	
		$user_id = $this->session->userdata('user_id');
	
		if (!isEmpty($user_id))
		{
			$this->form_validation->set_rules('videoId', 'Gallery Video', 'trim|xss_clean|numeric');
				
			if ($this->form_validation->run() == FALSE)
			{
				$response = $this->getResponseData(false, '', 'Data not valid');
				echo json_encode($response);
				return false;
			}
			else{
	
				$imageId = $this->input->post('videoId');
	
				//Call model to delete image from Database
				$imageName = $this->updateprofilemodel->deleteGalleryVideo($user_id, $imageId);
	
				// Getting image name from model. Keep image name to either move or delete image.
				if($imageName){
					$response = $this->getResponseData(true, $imageName, '');
					echo json_encode($response);
					return true;
				}
				else{
					$response = $this->getResponseData(false, '', 'Error in deleting image.');
					echo json_encode($response);
					return false;
				}
			}
		}
		else
		{
			log_message ( 'error', 'User session expired.');
			$responseArray['session_exist'] = false;
			$responseArray['url'] = base_url();
			$response = $this->getResponseData(false, $responseArray, 'User session expired.');
			echo json_encode($response);
			return false;
		}
	}
	
}