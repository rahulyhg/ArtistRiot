<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ManageVenueData extends CI_Controller {

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
				$response = $this->utilsmodel->getResponseData(false, '', 'Image upload failed.');
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
			
			$response = $this->utilsmodel->getResponseData(false, '', 'Error in updating userprofile image.');
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
	
		
		logDebug('Inside imageResize. Paremeters are: $imagename='.$imagename.
		', $imageOriginalHeight='.$imageOriginalHeight.', $imageOriginalWidth'.$imageOriginalWidth);
		
		//Calculate original image ratio
		$originalImageRatio = $imageOriginalHeight/$imageOriginalWidth;
		
		$this->image_lib->clear();
		
		//Getting configurations for image
		$config = $this->imagemodel->getVenueGalleryImageResizeConfig($imagename);
		
		//Now get the resize height based on original image ratio
		$resizeWidth = $this->config->item('ar_gallery_img_resize_width');
		$resizeHeight =  $originalImageRatio * $resizeWidth;
		$config['height']	= $resizeHeight;
		
		$this->image_lib->initialize($config);
	
		if($this->image_lib->resize()){
			$this->image_lib->clear();
			return true;
		}
		else{
			$error = array('error' => $this->image_lib->display_errors());
			echo "error". ' ' .$this->image_lib->display_errors();
			return false;
		}
	
	}
	
	
	/**
	 * Method to delete gallery image.
	 * @return boolean
	 */
	public function deleteVenueGalleryPhoto()
	{
		logDebug('inside deleteVenueGalleryPhoto');
		
		$errorMessage = '';
		$status=true;
		$response = array();
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
			
		$this->form_validation->set_rules('imageId', 'Gallery Image', 'trim|xss_clean|numeric');
			
		if ($this->form_validation->run() == FALSE)
		{
			$response = $this->utilsmodel->getResponseData(false, '', 'Data not valid');
			
		}
		else{
				
			$imageId = $this->input->post('imageId');
				
			//Call model to delete image from Database
			$imageName = $this->venueprofilemodel->deleteVenueGalleryImage($user_id, $imageId);
				
			// Getting image name from model. Keep image name to either move or delete image.
			if(!empty($imageName)){
				$response = $this->utilsmodel->getResponseData(true, $imageName, '');
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in deleting image.');
			}
		}
		
		echo json_encode($response);
		return;
	}
	
	
	
	/**
	 * Method to delete gallery video.
	 * @return boolean
	 */
	public function deleteVenueGalleryVideo()
	{
	
		logDebug('Inside deleteVenueGalleryVideo');
		
		$response = array();
	
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
	
		
		$this->form_validation->set_rules('videoId', 'Gallery Video', 'trim|xss_clean|numeric');
				
		if ($this->form_validation->run() == FALSE)
		{
			$response = $this->utilsmodel->getResponseData(false, '', 'Data not valid');
			echo json_encode($response);
			return;
		}
		else{
	
			$videoId = $this->input->post('videoId');
	
			//Call model to delete image from Database
			$isVideodeleted = $this->venueprofilemodel->deleteVenueGalleryVideo($user_id, $videoId);
	
			if($isVideodeleted){
				$response = $this->utilsmodel->getResponseData(true, '', '');
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in deleting video.');
			}
		}
		
		echo json_encode($response);
		
	}
	
	/**
	 * Method to upload venue gallery videos.
	 */
	public function uploadVenueGalleryVideos(){
	
		logException('Inside uploadVenueGalleryVideos');
		
		$response = array();
	
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
	
		//Validate input data:
		$this->form_validation->set_rules('videodescription', 'Video Description', 'trim|xss_clean');
		$this->form_validation->set_rules('videourl', 'Video URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('youtubevideoid', 'Youtube Video ID', 'trim|required|xss_clean');
	
		if ($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			$response = $this->utilsmodel->getResponseData(false, '', 'Invalid data');
			echo json_encode($response);
			return;
		}
	
		try{
			$videourl = $this->input->post('videourl');
			$videoDescription = $this->input->post('videodescription');
			$youtubevideoid = $this->input->post('youtubevideoid');

			//Add Video in DB
			$videoData = $this->venueprofilemodel->addVenueGalleryVideo($user_id, $videourl, $videoDescription, $youtubevideoid);

			if(!empty($videoData)){
				$responseArray['video_id'] = $videoData['video_id'];
				$responseArray['video_url'] = $videoData['video_url'];
				$responseArray['video_description'] = $videoData['video_description'];
				$responseArray['youtube_video_id'] = $videoData['youtube_video_id'];
				$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
				
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'Video upload failed.');
			}
			}
			catch(Exception $e){
				logException('Error in uploading gallery videos ->' . $e->getMessage () );
				$response = $this->utilsmodel->getResponseData(false, '', 'Error in updating video.');
			}
			
			echo json_encode($response);
		}
		
}