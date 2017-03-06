<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artist extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('profile/userdetailsmodel', 'userdetailsmodel');
        $this->load->model('login/signupmodel', 'signupmodel');
        $this->load->model('utils/utilsmodel', 'utilsmodel');
        $this->load->library("pagination");
        $userProfileData = array();
    }

    public function index()
    {
    	$data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['language'] = "en";
        $data['title'] = "Artist Riot-Profile";
        $data['wallclass'] = "active";
        $data['photosclass'] = "";
        $data['videosclass'] = "";
        $data['heading'] = "Wall";
        $data['is_my_profile'] = true;
        $data['tab'] = "";
        $user_id = $this->session->userdata('user_id');
        
        if(!empty($user_id)){
        	$userProfileData = $this->getProfile($user_id);
        	
        	if(!empty($userProfileData)){
        		$data['userProfileData'] = $userProfileData;
        		$this->load->view('profile/profile', $data);
        	}
        	else{
        		redirect(base_url(), 'refresh');
        	}
        }
        else{
        	redirect(base_url(), 'refresh');
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
       
        $user_id = $this->session->userdata('user_id');
        // Check if user session is valid.
        
        if (!empty($user_id))
        {
         	$user_id = $this->session->userdata('user_id');
         	$maxImagePerPage = $this->config->item('ar_img_max_image_per_page');
        	$userGalleryImageData = $this->userdetailsmodel->getUserGalleryImagesData($user_id, 0, $maxImagePerPage);
            $data['userGalleryImageData'] = $userGalleryImageData;
            
            $this->load->view('profile/selfprofile-photos', $data);
            
        }
        else
        {
            //$this->load->view('profile/profile-photos', $data);
        	redirect(base_url(), 'refresh');
        }
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
        $user_id = $this->session->userdata('user_id');
        
        if (!isEmpty($user_id))
        {
        	$maxVideosPerPage = $this->config->item('ar_img_max_videos_per_page');
        	$userGalleryVideoData = $this->userdetailsmodel->getUserGalleryVideosData($user_id, 0, $maxVideosPerPage);
    		$data['userGalleryVideoData'] = $userGalleryVideoData;
    		$this->load->view('profile/selfprofile-videos', $data);
        }
        else
        {
            //$this->load->view('profile/profile-videos', $data);
        	redirect(base_url(), 'refresh');
        }
    }
    
    public function events()
    {
    	$is_my_profile = true;
    	$data['meta_keywords'] = "";
    	$data['meta_description'] = "";
    	$data['language'] = "en";
    	$data['title'] = "Artist Riot-Profile|Events";
    	$data['wallclass'] = "";
    	$data['photosclass'] = "";
    	$data['videosclass'] = "active";
    	$data['heading'] = "Videos";
    	$data['tab'] = "";
    	$user_id = $this->session->userdata('user_id');
    	
    	if (!isEmpty($user_id))
    	{
    		$this->load->view('profile/event', $data);
    	}
    	else
    	{
    		//$this->load->view('profile/profile-videos', $data);
    		redirect(base_url(), 'refresh');
    	}
    }
    
    public function getUserProfile($id){
    	
    	$user_id = $this->ar_encrypt->decode($id, $this->config->item('encryption_key'));
    	
    	$data['meta_keywords'] = "";
    	$data['meta_description'] = "";
    	$data['language'] = "en";
    	$data['title'] = "Artist Riot-Profile";
    	$data['wallclass'] = "active";
    	$data['photosclass'] = "";
    	$data['videosclass'] = "";
    	$data['heading'] = "Wall";
    	$data['is_my_profile'] = false;
    	$data['tab'] = "";
    	
    	if($user_id > 1){
    		$userProfileData = $this->userdetailsmodel->getUserProfileData($user_id);
    		$data['userProfileData'] = $userProfileData;
    		$data['user_id'] = $id;
    		
    		$this->load->view('public-profile/profile', $data);
    		
    	}
    }
    
    public function getProfile($user_id){
    	 
    	//$user_id = $this->ar_encrypt->decode($id, $this->config->item('encryption_key'));
    	 
    	$data['meta_keywords'] = "";
    	$data['meta_description'] = "";
    	$data['language'] = "en";
    	$data['title'] = "Artist Riot-Profile";
    	$data['wallclass'] = "active";
    	$data['photosclass'] = "";
    	$data['videosclass'] = "";
    	$data['heading'] = "Wall";
    	$data['is_my_profile'] = false;
    	$data['tab'] = "";
    	 
    	if($user_id > 1){
    		$userProfileData = $this->userdetailsmodel->getUserProfileData($user_id);
    		
    		if(!empty($userProfileData)){
    			return $userProfileData;
    		}
    		else{
    			return null;
    		}
    	}
    }

	public function edit()
    {
        $user_id = $this->session->userdata('user_id');
        $is_my_profile = true;
        $data['categoriesList'] = json_encode($this->signupmodel->get_categories());
        $data['sub_categories'] = $this->signupmodel->get_sub_categories();
        $data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['language'] = "en";
        $data['title'] = "Artist Riot-Profile|Edit";
        $data['wallclass'] = "";
        $data['photosclass'] = "active";
        $data['videosclass'] = "";
        $data['heading'] = "Edit";
        $data['tab'] = "";
       
        
        // Check if user session is valid.

        if ($user_id > 1)
        {
            $userProfileData = $this->userdetailsmodel->getUserProfileData($user_id);
            $data['userProfileData'] = $userProfileData;

            $this->load->view('profile/editProfile', $data);
        }
        
    }
    
    /** Method to get public profile of artist using userName.
     * @param unknown $profileUrl
     */
    public function getArtistPublicProfile($userName){
    	 
    	logDebug('Inside getArtistPublicProfile');
    	
    	$data['meta_keywords'] = "";
    	$data['meta_description'] = "";
    	$data['language'] = "en";
    	$data['title'] = "Artist Riot-Profile";
    	$data['wallclass'] = "active";
    	$data['photosclass'] = "";
    	$data['videosclass'] = "";
    	$data['heading'] = "Wall";
    	$data['is_my_profile'] = false;
    	$data['tab'] = "";
    	
    	if(empty($userName)){
    		$this->utilsmodel->showPageNotFound();
    	}

    	// Getting user id from profile URL
    	$user_id = $this->userdetailsmodel->getUserIdFromUserName($userName);
    	
    	if(empty($user_id)){
    		logException('User id is empty.');
    		$this->utilsmodel->showPageNotFound();
    		return; 
    	}
    	
    	else if($user_id > 1){
    		logDebug('User id is::'.$user_id);
    		$userProfileData = $this->userdetailsmodel->getUserProfileData($user_id);
    		$data['userProfileData'] = $userProfileData;
    		$data['user_id'] = $this->ar_encrypt->encode($user_id, $this->config->item('encryption_key'));
    		$data['userName'] = $userName;
    		$data['role'] = $userProfileData['role'];
    		$this->load->view('public-profile/profile', $data);
    	}
    	else{
    		$this->utilsmodel->showPageNotFound();
    	}
    	
    }
	
    /** Method to get Artist video using userName of artist
     * @param unknown $userName
     */
    public function getArtistVideos($userName){
    
    	logDebug('Inside getArtistVideos()');
    	
    	$data['meta_keywords'] = "";
    	$data['meta_description'] = "";
    	$data['language'] = "en";
    	$data['title'] = "Artist Riot-Profile";
    	$data['wallclass'] = "active";
    	$data['photosclass'] = "";
    	$data['videosclass'] = "";
    	$data['heading'] = "Wall";
    	$data['is_my_profile'] = false;
    
    	
    	if(empty($userName)){
    		$this->utilsmodel->showPageNotFound();
    	}
    	
    	// Getting user id from profile URL
    	$user_id = $this->userdetailsmodel->getUserIdFromUserName($userName);
    	
    	if(empty($user_id)){
    		logException('User id is empty.');
    		$this->utilsmodel->showPageNotFound();
    		return;
    	}
    	
    	else if($user_id > 1){
    		
    		$maxVideosPerPage = $this->config->item('ar_img_max_videos_per_page');
    		$userGalleryVideoData = $this->userdetailsmodel->getUserGalleryVideosData($user_id, 0, $maxVideosPerPage);
    		$data['userGalleryVideoData'] = $userGalleryVideoData;
    		$data['user_id'] = $user_id;
    		$userProfileData = $this->userdetailsmodel->getUserProfileData($user_id);
    		$data['userProfileData'] = $userProfileData;
    		$data['userName'] = $userName;
    		$data['role'] = $userProfileData['role'];
    		$this->load->view('public-profile/selfprofile-videos', $data);
    	}
    	else{
    		logException('User id is not proper.');
    		$this->utilsmodel->showPageNotFound();
    		return;
    	}
    }
	
    /** Method to get Artist images using userName of artist
     * @param unknown $id
     */
    public function getArtistImages($userName){
    
    	logDebug('Inside getArtistImages()');
    	
    	$data['meta_keywords'] = "";
    	$data['meta_description'] = "";
    	$data['language'] = "en";
    	$data['title'] = "Artist Riot-Profile";
    	$data['wallclass'] = "active";
    	$data['photosclass'] = "";
    	$data['videosclass'] = "";
    	$data['heading'] = "Wall";
    	$data['is_my_profile'] = false;
    
    	if(empty($userName)){
    		$this->utilsmodel->showPageNotFound();
    	}
    	 
    	// Getting user id from profile URL
    	$user_id = $this->userdetailsmodel->getUserIdFromUserName($userName);
    	 
    	if(empty($user_id)){
    		logException('User id is empty.');
    		$this->utilsmodel->showPageNotFound();
    		return;
    	}
    	
    	else if($user_id > 1){
    		
    		$countOfGalleryImages = $this->userdetailsmodel->getCountOfUserGalleryImages($user_id);
    		
    		if(empty($countOfGalleryImages) || ($countOfGalleryImages == 0)){
    			logException('Count of photos is::'.$countOfGalleryImages);
    			return;
    		}
    		
    		$maxImagePerPage = $this->config->item('ar_img_max_image_per_page');
    		
    		$userGalleryImageData = $this->userdetailsmodel->getUserGalleryImagesData($user_id, 0, $maxImagePerPage);
    		$data['userGalleryImageData'] = $userGalleryImageData;
    		$userProfileData = $this->userdetailsmodel->getUserProfileData($user_id);
    		$data['userProfileData'] = $userProfileData;
    		$data['userName'] = $userName;
    		$data['role'] = $userProfileData['role'];
    		$data['user_id'] = $user_id;
    		$this->load->view('public-profile/selfprofile-photos', $data);
    
    	}
    	else{
    		logException('User id is not proper.');
    		$this->utilsmodel->showPageNotFound();
    		return;
    	}
    	
    }
    
    private function getPaginationConfig(){
    	
    	$config['base_url'] = base_url().'/artist/satyamnigam/images/';
    	$config["per_page"] = 4;
    	$config["uri_segment"] = 4;
    	$config['use_page_numbers'] = TRUE;
    	$config['first_link'] = FALSE;
    	$config['last_link'] = FALSE;
    	$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
    	$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
    	 
    	$config['cur_tag_open'] = "<li><span><b>";
    	$config['cur_tag_close'] = "</b></span></li>";
    	
    	return $config;
    }
    
    /**
     * Method to load more gallery images for logged in user.
     */
    public function loadMoreGalleryImages()
    {
    	logDebug( 'Inside loadMoreImages().');
    	$response = array();
    	$user_id='';
    	
    	$userName = $this->input->post('user_name');
    	logException('Username is::'.$userName);
    	if(!empty($userName)){
    		// Getting user id from profile URL
    		$user_id = $this->userdetailsmodel->getUserIdFromUserName($userName);
    		
    		if(empty($user_id)){
    			logException('User id is empty.');
    			$this->utilsmodel->showPageNotFound();
    			return;
    		}
    		
    	}
    	
    	else{
    		//If user id is not received then check for session
    		if(!$this->utilsmodel->isValidSession()){
    			logException( 'session does not exist');
    			$response = $this->utilsmodel->getResponseData(false, '', '', false);
    			echo json_encode($response);
    			return;
    		}
    		else{
    			$user_id = $this->session->userdata('user_id');
    		}
    	}
    	
    	 
    	
    	$offset =  $this->input->post('offset');
    	logException( 'Offset is ::'.$offset);
    	
    	if(empty($offset) || !is_numeric($offset) || ($offset <= 0)){
    		logException( 'Offset is not valid');
    		$response = $this->utilsmodel->getResponseData(false, '', 'Offset is not valid');
    		echo json_encode($response);
    		return;
    	}
    	
    	$maxImagePerPage = $this->config->item('ar_img_max_image_per_page');
    	logException('$user_id is::'. $user_id);
    	$userGalleryImageData = $this->userdetailsmodel->getUserGalleryImagesData($user_id, $offset, $maxImagePerPage);
    	
    	if(!empty($userGalleryImageData)){
    		$responseArray['imageDataArray'] = json_encode($userGalleryImageData);
    		$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
    		echo json_encode($response);
    		return;
    	}
    	else{
    		logException('Empty load more images data');
    		$response = $this->utilsmodel->getResponseData(false, '', '');
    		echo json_encode($response);
    		return;
    	}
    	
    }
    
    /**
     * Method to load more gallery videos.
     */
    public function loadMoreGalleryVideos()
    {
    	logDebug( 'Inside loadMoreGalleryVideos().');
    	 
    	$response = array();
    	$user_id='';
    	
    	$userName = $this->input->post('user_name');
    	 
    	if(!empty($userName)){
    		// Getting user id from profile URL
    		$user_id = $this->userdetailsmodel->getUserIdFromUserName($userName);
    	
    		if(empty($user_id)){
    			logException('User id is empty.');
    			$this->utilsmodel->showPageNotFound();
    			return;
    		}
    	
    	}
    	 
    	else{
    		//If user id is not received then check for session
    		if(!$this->utilsmodel->isValidSession()){
    			logException( 'session does not exist');
    			$response = $this->utilsmodel->getResponseData(false, '', '', false);
    			echo json_encode($response);
    			return;
    		}
    		else{
    			$user_id = $this->session->userdata('user_id');
    		}
    	}
    	
    	
    	
    	//Getting offset from UI.
    	$offset =  $this->input->post('offset');
    	logException( 'Offset is ::'.$offset);
    	 
    	if(empty($offset) || !is_numeric($offset) || ($offset <= 0)){
    		logException( 'Offset is not valid');
    		$response = $this->utilsmodel->getResponseData(false, '', 'Offset is not valid');
    		echo json_encode($response);
    		return;
    	}
    	//Getting max videos to be retrieved at one load.
    	$maxVideosPerPage = $this->config->item('ar_img_max_videos_per_page');
    	 
    	$userGalleryVideoData = $this->userdetailsmodel->getUserGalleryVideosData($user_id, $offset, $maxVideosPerPage);
    	 
    	if(!empty($userGalleryVideoData)){
    		$responseArray['videoDataArray'] = json_encode($userGalleryVideoData);
    		$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
    		echo json_encode($response);
    		return;
    	}
    	else{
    		$response = $this->utilsmodel->getResponseData(false, '', '');
    		echo json_encode($response);
    		return;
    	}
    	
    }
    
    /**
     * Method to get artist review
     */
    public function getArtistReview(){
    	
    logDebug('Inside artist review');
    	
    $response = array();
		
		if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
			logException( 'Session does not exist');
			$response = $this->utilsmodel->getResponseData(false, '', '', false);
			echo json_encode($response);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		logException('User id is::', $user_id);
		
		//Getting artist review data
		$userReviewData = $this->userdetailsmodel->getUserReviewData($user_id);
		
		if(empty($userReviewData)){
			logException('Empty artist review data for user::'.$user_id);
			$response = $this->utilsmodel->getResponseData(false, '', '');
			echo json_encode($response);
			return;
		}
		
		$responseArray['userReviewData'] = json_encode($userReviewData);
		$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
		
		echo json_encode($response);
		return;
    }
    
    /**
     * Method to get artist recent photos
     */
    public function getArtistRecentPhotos(){
    	 
    	logDebug('Inside getArtistRecentPhotos()');
    	 
    	$response = array();
    
    	if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
    		logException( 'Session does not exist');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    		echo json_encode($response);
    		return;
    	}
    
    	$user_id = $this->session->userdata('user_id');
    	logDebug('User id is::', $user_id);
    
    	//Getting artist review data
    	$galleryImageData = $this->userdetailsmodel->getArtistRecentGalleryImagesData($user_id, 3);
    
    	if(empty($galleryImageData)){
    		logException('Empty artist review data for user::'.$user_id);
    		$response = $this->utilsmodel->getResponseData(true, '', '');
    		echo json_encode($response);
    		return;
    	}
    
    	$responseArray['galleryImageData'] = json_encode($galleryImageData);
    	$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
    
    	echo json_encode($response);
    	return;
    }
    
    /**
     * Method to get artist recent videos
     */
    public function getArtistRecentVideos(){
    
    	logDebug('Inside getArtistRecentVideos()');
    
    	$response = array();
    
    	if(!$this->utilsmodel->isValidSession() || !$this->utilsmodel->isSessionExist('role')){
    		logException( 'Session does not exist');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    		echo json_encode($response);
    		return;
    	}
    
    	$user_id = $this->session->userdata('user_id');
    	logDebug('User id is::', $user_id);
    
    	//Getting artist review data
    	$galleryVideoData = $this->userdetailsmodel->getArtistRecentGalleryVideosData($user_id, 3);
    
    	if(empty($galleryVideoData)){
    		logException('Empty artist video data for user::'.$user_id);
    		$response = $this->utilsmodel->getResponseData(true, '', '');
    		echo json_encode($response);
    		return;
    	}
    
    	$responseArray['galleryVideoData'] = json_encode($galleryVideoData);
    	$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
    
    	echo json_encode($response);
    	return;
    }
    
    /**
     * Method to get artist recent photos
     */
    public function getArtistRecentPhotosPublic(){
    
    	logDebug('Inside getArtistRecentPhotosPublic()');
    	
    	$response = array();
    
    	$user_id = $this->input->post('user_id');
    	
    	if(empty($user_id)){
    		logException( 'User Id is empty.');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    		echo json_encode($response);
    		return;
    	}
    	
    	$user_id = $this->ar_encrypt->decode($user_id, $this->config->item('encryption_key'));
    	 
    	if($user_id > 1){
    		
    		//Getting artist image data
    		$galleryImageData = $this->userdetailsmodel->getArtistRecentGalleryImagesData($user_id, 3);
    		
    		if(empty($galleryImageData)){
    			logException('Empty artist image data for user::'.$user_id);
    			$response = $this->utilsmodel->getResponseData(true, '', '');
    		}
    		else{
    			$responseArray['galleryImageData'] = json_encode($galleryImageData);
    			$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
    		}
    		
    	}
    	
    	else{
    		logException( 'Error in decoding user id.');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    	}
    
    	echo json_encode($response);
    	return;
    }
    
    /**
     * Method to get artist recent videos for public profile.
     */
    public function getArtistRecentVideosPublic(){
    
    	logDebug('Inside getArtistRecentVideosPublic()');
    	
    	$response = array();
    
    	$user_id = $this->input->post('user_id');
    	
    	if(empty($user_id)){
    		logException( 'User Id is empty.');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    		echo json_encode($response);
    		return;
    	}
    	
    	
    	$user_id = $this->ar_encrypt->decode($user_id, $this->config->item('encryption_key'));
    	logDebug('User id is::', $user_id);
    
    	if($user_id > 1){
    		//Getting artist video data
    		$galleryVideoData = $this->userdetailsmodel->getArtistRecentGalleryVideosData($user_id, 3);
    		
    		if(empty($galleryVideoData)){
    			logException('Empty artist video data for user::'.$user_id);
    			$response = $this->utilsmodel->getResponseData(true, '', '');
    		}
    		else{
    			$responseArray['galleryVideoData'] = json_encode($galleryVideoData);
    			$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
    		}
    	}
    	else{
    		logException( 'Error in decoding user id.');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    	}
    	
    	echo json_encode($response);
    	return;
    }
    
    /**
     * Method to get artist review
     */
    public function getArtistReviewPublic(){
    	 
    	logDebug('Inside getArtistReviewPublic()');
    	 
    	$response = array();
    
    	$user_id = $this->input->post('user_id');
    	
    	if(empty($user_id)){
    		logException( 'User Id is empty.');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    		echo json_encode($response);
    		return;
    	}
    
    	$user_id = $this->ar_encrypt->decode($user_id, $this->config->item('encryption_key'));
    	logDebug('User id is::', $user_id);
    
    	if($user_id > 1){
    		
    		//Getting artist review data
    		$userReviewData = $this->userdetailsmodel->getUserReviewData($user_id);
    		
    		if(empty($userReviewData)){
    			logException('Empty artist review data for user::'.$user_id);
    			$response = $this->utilsmodel->getResponseData(true, '', '');
    			echo json_encode($response);
    			return;
    		}
    		
    		$responseArray['userReviewData'] = json_encode($userReviewData);
    		$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
    	}
    	
    	else{
    		logException( 'Error in decoding user id.');
    		$response = $this->utilsmodel->getResponseData(false, '', '', false);
    	}
    	
    	echo json_encode($response);
    	return;
    
    }
}
