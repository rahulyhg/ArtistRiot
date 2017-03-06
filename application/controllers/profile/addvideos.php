<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AddVideos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('login/userprofilemodel','userprofilemodel');
	//	$this->load->driver('cache',array('adapter'=>'memcached'));
	
	}
	
	public function uploadVideos(){
	
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		$user_id = $this->session->userdata('user_id');
		
		if($this->isSessionExist('user_id')){
		
		//Validate input data:	
		$this->form_validation->set_rules('videodescription', 'Video Description', 'trim|xss_clean');
		$this->form_validation->set_rules('videourl', 'Video URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('youtubevideoid', 'Youtube Video ID', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			//echo validation_errors();
			$response['status'] = false;
			$response['errorMessage'] = 'Invalid data';
			echo json_encode($response);
			return false;
		}
		
		else{
		
		try{
			$videourl = $this->input->post('videourl');
			$videoDescription = $this->input->post('videodescription');
			$youtubevideoid = $this->input->post('youtubevideoid');
			
			
				$videoData = $this->userprofilemodel->addUserGalleryVideo($user_id, $videourl, $videoDescription, $youtubevideoid);
					
			/* 	//Add this video in existing session
				$userGalleryVideoArray = array();
				$userGalleryVideoArray = $this->session->userdata('user_gallery_videos');
					
					if(!is_null($userGalleryVideoArray) && (sizeof($userGalleryVideoArray) > 0) && ($userGalleryVideoArray != '') ){
						
						$temparray [0] = $videoData['video_id'];
						$temparray [1] = $videoData ['video_url'];
						$temparray [2] = $videoData ['video_description'];
						$temparray [3] = $videoData['youtube_video_id'];
						
						array_unshift($userGalleryVideoArray, $temparray);
						
						$this->session->set_userdata('user_gallery_videos', $userGalleryVideoArray);
						
					}
					else{
						$userGalleryVideoArray = array();
						
						$temparray [0] = $videoData['video_id'];
						$temparray [1] = $videoData ['video_url'];
						$temparray [2] = $videoData ['video_description'];
						$temparray [3] = $videoData['youtube_video_id'];
						
						array_push($userGalleryVideoArray, $temparray);
						
						$this->session->set_userdata('user_gallery_videos', $userGalleryVideoArray);
					}
					
				 */	
					$responseArray['video_id'] = $videoData['video_id'];
					$responseArray['video_url'] = $videoData['video_url'];
					$responseArray['video_description'] = $videoData['video_description'];
					$responseArray['youtube_video_id'] = $videoData['youtube_video_id'];
					
					$response = $this->getResponseData(true, $responseArray, '');
					echo json_encode($response);
					return true;
				
				
				$response = $this->getResponseData(false, '', 'Video upload failed.');
				echo json_encode($response);
				
				return false; 
				
		}
		catch(Exception $e){
				
			log_message ( 'error', 'Error in uploading gallery videos ->' . $e->getMessage () );
			
			$response = $this->getResponseData(false, '', 'Error in updating video.');
			echo json_encode($response);
			return false;
			
		}
		
		}
		
		}
		else{
			log_message ( 'error', 'Error in uploading gallery videos.');
			$response['status'] = false;
			$response['errorMessage'] = 'User session expired.';
			echo json_encode($response);
			//return false;
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