<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ArtistReview extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('login/userprofilemodel','userprofilemodel');
		$this->load->model('profile/userdetailsmodel','userdetailsmodel');
		$this->load->model('utils/utilsmodel', 'utilsmodel');
	}
	
	public function review($artistUserName){
		
		//$id = $this->ar_encrypt->decode($artist_id, $this->config->item('encryption_key'));
		
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "Artist Riot - Write Review";
		$data['tab'] = "";
		
		if(empty($artistUserName)){
			$this->utilsmodel->showPageNotFound();
		}
		
		// Getting user id from profile URL
		$artist_id = $this->userdetailsmodel->getUserIdFromUserName($artistUserName);
		
		if(empty($artist_id)){
			logException('User id is empty.');
			$this->utilsmodel->showPageNotFound();
			return;
		}
		
		$data['artist_id'] = $artist_id;
		
		
		
		if($artist_id > 1){
    		
    		$userProfileData = $this->userdetailsmodel->getUserProfileData($artist_id);
    		$data['userProfileData'] = $userProfileData;
    		$data['role'] = $userProfileData['role'];
    		$data['userName'] = $artistUserName;
    		$data['artist_id'] = $artist_id;
    		$data['user_id'] = $artist_id;
    		
    		$this->load->view('public-profile/addreview', $data);
    
    	}
    }
	
	
	/**
	 * This method adds the testimonial for the artist.
	 * @param unknown $artist_id (in encrypted format)
	 */
	public function addTestimonial(){
		
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		$artist_id = $this->input->post('artist_id');
		$user_id = $this->session->userdata('user_id');
		
		if ($this->isSessionExist('user_id')){
		try{
			//$this->form_validation->set_rules('artist_id', 'Artist Id', 'trim|required');
			$this->form_validation->set_rules('testimonial', 'Testimonial', 'trim|required|xss_clean');
			//$artist_id = $this->ar_encrypt->decode($artist_id, $this->config->item('encryption_key'));
			
			if ($this->form_validation->run() == true){
				
				$testimonial = $this->input->post('testimonial');
				if($artist_id > 1){
					// Call the model to insert testimonial into DB.
					
					$testimonialData = $this->userprofilemodel->addArtistTestimonial($user_id, $artist_id, $testimonial);
					
					
					if(!is_null($testimonialData) && $testimonialData){
						
						$responseArray['testimonialId'] = $testimonialData['testimonialId'];
						$responseArray['testimonial'] = $testimonialData['testimonial'];
						
						$response = $this->getResponseData(true, $responseArray, '');
					}
					else{
						$response = $this->getResponseData(false, '', 'Error in uploading testimonial.');
					}
					echo json_encode($response);
					return true;
				}
				else{
					$response = $this->getResponseData(false, '', 'Artist ID not correct.');
					echo json_encode($response);
				}
				
			}
			
		}
		catch(Exception $e){
			log_message ( 'error', 'Error in submitting testimonials:'.$e);
			$response = $this->getResponseData(false, '', 'Error in submitting testimonials.');
			echo json_encode($response);
		}
		}
		else{
			log_message ( 'error', 'Error in submitting testimonials. User session does not exist.');
			$response = $this->getResponseData(false, '', 'User session does not exist.');
			echo json_encode($response);
		}
	}
	
	
	public function addArtistReview(){
		
		$user_id = $this->session->userdata('user_id');
		
		if(!isEmpty($user_id)){
			
			
			$this->form_validation->set_rules('reviewername', 'Your name', 'trim|required|valid_email');
			$this->form_validation->set_rules('rating_score', 'Rating', 'trim|required');
			$this->form_validation->set_rules('reviewtitle', 'Review title', 'trim|required');
			$this->form_validation->set_rules('review', 'Review', 'trim|required');
			$this->form_validation->set_rules('artist_id', 'Artist', 'trim|required');
			$this->form_validation->set_rules('reviewername', 'Your name', 'trim|required');
			
			$reviewData = array();
			
			if($this->form_validation->run() == FALSE){
				$errorMessage = validation_errors();
				$response = $this->getResponseData(false, '', $errorMessage);
				echo json_encode($response);
				return true;
			}
			else{
					
				$email = $this->session->userdata('email');
				$artist_id = $this->input->post('artist_id');
				$reviewername = $this->input->post('reviewername');
				$reviewtitle = $this->input->post('reviewtitle');
				$review = $this->input->post('review');
				$rating = $this->input->post('rating_score');
			
				// Decrypting artist_id
				$id = $this->ar_encrypt->decode($artist_id, $this->config->item('encryption_key'));
				
				//Getting artist profile data.
				$userProfileData = $this->userdetailsmodel->getUserProfileData($artist_id);
				
				$data['userProfileData'] = $userProfileData;
				$data['artist_id'] = $artist_id;
				$data['user_id'] = $artist_id;
			
				$reviewData['artist_id'] = $artist_id;
				$reviewData['email'] = $email;
				$reviewData['reviewername'] = $reviewername;
				$reviewData['reviewtitle'] = $reviewtitle;
				$reviewData['review'] = $review;
				$reviewData['rating'] = $rating;
			
					
				if($artist_id > 1){
					$responseData = $this->userprofilemodel->addArtistReview($reviewData);
					
					if($responseData){
						$responseArray['review_id'] = $responseData['review_id'];
						$responseArray['review'] = $responseData['review'];
			
						$response = $this->getResponseData(true, $responseArray, '');
						echo json_encode($response);
						return true;
					}
				}
					
				$response = $this->getResponseData(false, '', 'Error in getting artist profile');
				echo json_encode($response);
				return true;
			}
			
		}
		else{
			$responseArray['session_exist'] = false;
			$response = $this->getResponseData(false, $responseArray, '');
			echo json_encode($response);
			return true;
		}
		
		
	}
	
	public function addArtistReviewFromGuest(){
		
			$this->form_validation->set_rules('reviewername', 'Your name', 'trim|required|valid_email');
			$this->form_validation->set_rules('rating_score', 'Rating', 'trim|required');
			$this->form_validation->set_rules('reviewtitle', 'Review title', 'trim|required');
			$this->form_validation->set_rules('review', 'Review', 'trim|required');
			$this->form_validation->set_rules('artist_id', 'Artist', 'trim|required');
			$this->form_validation->set_rules('reviewername', 'Your name', 'trim|required');
			$this->form_validation->set_rules('reviewer_email', 'Your email', 'trim|required');
				
			$reviewData = array();
				
			if($this->form_validation->run() == FALSE){
				$errorMessage = validation_errors();
				$response = $this->getResponseData(false, '', $errorMessage);
				echo json_encode($response);
				return true;
			}
			else{
					
				$email = $this->input->post('reviewer_email');
				$artist_id = $this->input->post('artist_id');
				$reviewername = $this->input->post('reviewername');
				$reviewtitle = $this->input->post('reviewtitle');
				$review = $this->input->post('review');
				$rating = $this->input->post('rating_score');
					
				// Decrypting artist_id
				
					
				$reviewData['artist_id'] = $artist_id;
				$reviewData['email'] = $email;
				$reviewData['reviewername'] = $reviewername;
				$reviewData['reviewtitle'] = $reviewtitle;
				$reviewData['review'] = $review;
				$reviewData['rating'] = $rating;
					
					
				if($artist_id > 1){
					$responseData = $this->userprofilemodel->addArtistReview($reviewData);
						
					if($responseData){
						$responseArray['review_id'] = $responseData['review_id'];
						$responseArray['review'] = $responseData['review'];
							
						$response = $this->getResponseData(true, $responseArray, '');
						echo json_encode($response);
						return;
					}
				}
					
				$response = $this->getResponseData(false, '', 'Error in getting artist profile for which you are reviewing.');
				echo json_encode($response);
				return;
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