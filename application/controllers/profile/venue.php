<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Venue extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('profile/venuedetailsmodel', 'venuedetailsmodel');
		$this->load->model('login/signupmodel', 'signupmodel');
		$this->load->model('utils/utilsmodel','utilsmodel');
		$userProfileData = array();
		
	}
	
	public function index(){
		
		logDebug( 'Inside Venue profile.');
		
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "Artist Riot-Venue Profile";
		$data['wallclass'] = "active";
		$data['photosclass'] = "";
		$data['videosclass'] = "";
		$data['heading'] = "Wall";
		$data['tab'] = "";
		
		$response = array();
		//Check for session
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Venue session does not exist');
			$responseArray['base_url'] = base_url();
			$response = $this->utilsmodel->getResponseData(false, $responseArray, '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		$venueProfileData = $this->getProfile($user_id);
		$data['venueProfileData'] = $venueProfileData;
		
		if($venueProfileData){
			$this->load->view('venue/profile', $data);
		}
		
	}
	
	public function photos()
	{
		$is_my_profile = true;
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "Artist Riot-Profile|Photos";
		$data['wallclass'] = "";
		$data['photosclass'] = "active";
		$data['videosclass'] = "";
		$data['heading'] = "Photos";
		$data['tab'] = "";
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Session does not exist');
			redirect(base_url(), 'refresh');
		}
		 
		$user_id = $this->session->userdata('user_id');
		$maxImagePerPage = $this->config->item('ar_img_max_image_per_page');
		$venueGalleryImageData = $this->venuedetailsmodel->getVenueGalleryImagesData($user_id, 0, $maxImagePerPage);
		$data['userGalleryImageData'] = $venueGalleryImageData;
		$this->load->view('venue/selfprofile-photos', $data);
		
	}
	
	
	public function videos()
	{
		$is_my_profile = true;
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "Artist Riot-Profile|Videos";
		$data['wallclass'] = "";
		$data['photosclass'] = "";
		$data['videosclass'] = "active";
		$data['heading'] = "Videos";
		$data['tab'] = "";
		
		//Validate session first
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Session does not exist');
			redirect(base_url(), 'refresh');
		}
		
		$user_id = $this->session->userdata('user_id');
		
		$maxVideosPerPage = $this->config->item('ar_img_max_videos_per_page');
		$venueGalleryVideoData = $this->venuedetailsmodel->getVenueGalleryVideosData($user_id, 0, $maxVideosPerPage);
		$data['venueGalleryVideoData'] = $venueGalleryVideoData;
		$this->load->view('venue/selfprofile-videos', $data);
		
	}
	
	private function getProfile($user_id){
	
		if($user_id > 1){
			$venueProfileData = $this->venuedetailsmodel->getVenueProfileData($user_id);
	
			if(!isEmpty($venueProfileData)){
				return $venueProfileData;
			}
			else{
				return null;
			}
		}
	}
	
}
