<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AddPhotos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('login/userprofilemodel','userprofilemodel');
	
	}
	
	public function uploadGalleryImages(){
	
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		$user_id = $this->session->userdata('user_id');
		
		if($this->isSessionExist('user_id')){
		
		$this->form_validation->set_rules('imagedescription', 'Image Description', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			$response['status'] = false;
			$response['errorMessage'] = 'Description field contains invalid text.';
			echo json_encode($response);
			return false;
		}
		
		else{
			
		
		try{
			$imageOriginalName = $this->input->post('photoname');
			$imageDescription = $this->input->post('imagedescription');
			$imageOriginalHeight = $this->input->post('imageheight');
			$imageOriginalWidth = $this->input->post('imagewidth');
			
			
			$ext = pathinfo($imageOriginalName, PATHINFO_EXTENSION);
				
			// Get the extension of image.
			$imagename = time().'.'.$ext;
				
			//Setting configurations for image
			$config['upload_path'] = $this->config->item('ar_gallery_img_upload_path');
			$config['allowed_types'] = $this->config->item('ar_img_allowed_types');
			$config['max_size']	= $this->config->item('ar_img_max_size');
			$config['overwrite'] = $this->config->item('ar_img_overwrite');
			$config['remove_spaces'] = $this->config->item('ar_img_remove_spaces');
			$config['file_name'] = $imagename;
				
			
			//Check if upload directory exists
				
			if ( ! is_dir($this->config->item('ar_gallery_img_upload_path')) ){
				
				$response = $this->getResponseData(false, '', 'Error in uploading image.');
				echo json_encode($response);
				return false;
			}
				
			$this->load->library('upload', $config);
				
			if ( ! $this->upload->do_upload('galleryimageupload'))
			{
				$response = $this->getResponseData(false, '', 'Image upload failed.');
				echo json_encode($response);
				return false;
			}
			else{
				
				if($this->imageResize($imagename, $imageOriginalHeight, $imageOriginalWidth)){
					
				$imageData = $this->userprofilemodel->addUserGalleryImage($user_id, $imagename, $imageDescription);
				
				if(!is_null($imageData) && $imageData){
					
			/*		//Add this photo in existing session
					$userGalleryImageArray = array();
					$userGalleryImageArray = $this->session->userdata('user_gallery_images');
					
			 		if(!is_null($userGalleryImageArray) && (sizeof($userGalleryImageArray) > 0) && ($userGalleryImageArray != '') ){
						
						$temparray [0] = $imageData['image_id'];
						$temparray [1] = base_url().$this->config->item ('ar_gallery_img_upload_path').$imageData ['image_name'];
						$temparray [2] = $imageData ['image_description'];
						
						array_unshift($userGalleryImageArray, $temparray);
						
						$this->session->set_userdata('user_gallery_images', $userGalleryImageArray);
						
					}
					else{
						$userGalleryImageArray = array();
						
						$temparray [0] = $imageData['image_id'];
						$temparray [1] = base_url().$this->config->item ('ar_gallery_img_upload_path').$imageData ['image_name'];
						$temparray [2] = $imageData ['image_description'];
						
						array_push($userGalleryImageArray, $temparray);
						
						$this->session->set_userdata('user_gallery_images', $userGalleryImageArray);
					} */
					
					
					$imagePath = $this->config->item ('ar_gallery_img_upload_path').$imageData['image_name'];
					$imageDescription = $imageData['image_description'];
					
					$responseArray['image_id'] = $imageData['image_id'];
					$responseArray['image_path'] = base_url().$this->config->item ('ar_gallery_img_upload_path').$imageData['image_name'];
					$responseArray['image_description'] = $imageData['image_description'];
					
					$response = $this->getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return true;
				}
				
				$response = $this->getResponseData(false, '', 'Image upload failed.');
				echo json_encode($response);
				
				return false; 
				}
				else{
					$response = $this->getResponseData(false, '', 'Image upload failed.');
					echo json_encode($response);
					return false;
				}
				
				
			}
				
				
		}
		catch(Exception $e){
				
			log_message ( 'error', 'Error in uploading gallery images ->' . $e->getMessage () );
			
			$response = $this->getResponseData(false, '', 'Error in updating userprofile image.');
			echo json_encode($response);
			return false;
			
		}
		
		}
		
		}
		else{
			log_message ( 'error', 'Error in uploading gallery images.');
			$response['status'] = false;
			$response['errorMessage'] = 'User session expired.';
			echo json_encode($response);
			//return false;
		}
	}
	
	private function imageResize($imagename, $imageOriginalHeight, $imageOriginalWidth){
	
		$this->load->library('image_lib');
		$this->image_lib->clear();
	
		$config['image_library'] = $this->config->item('ar_img_image_library');
		$config['source_image']	= $this->config->item('ar_gallery_img_upload_path').$imagename;
		$config['create_thumb'] = $this->config->item('ar_img_create_thumb');
		$config['maintain_ratio'] = $this->config->item('ar_img_maintain_ratio');
		$config['width']	= $this->config->item('ar_gallery_img_resize_width');
		$config['height']	= $this->config->item('ar_gallery_img_resize_height');
		$config['quality'] =  $this->config->item('ar_img_resize_quality');
		
		$dim = (intval($imageOriginalWidth) / intval($imageOriginalHeight)) - ($config['width'] / $config['height']);
		$config['master_dim'] = ($dim > 0)? "height" : "width";
	
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
}