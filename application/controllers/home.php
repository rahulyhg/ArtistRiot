<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
		$this->load->model('login/signupmodel','signupmodel');
		$this->load->model('utils/utilsmodel','utilsmodel');
	}
	
    public function index(){
     
      
      $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "";
    	
      $categories = $this->signupmodel->get_categories();
      $data['categories'] = $categories;
      
      if(!empty($this->session->userdata('user_id')) && ($this->session->userdata('profile_created') == 1)){
      	
      	if(!empty($this->session->userdata('role')) && ($this->session->userdata('role') == 'artist')){
      		redirect(base_url().'profile/artist', 'refresh');
      	}
      	else if(!empty($this->session->userdata('role')) && ($this->session->userdata('role') == 'venue')){
      		redirect(base_url().'profile/venue', 'refresh');
      	}
      	
      }
      else if(!empty($this->session->userdata('user_id')) && ($this->session->userdata('profile_created') == 0)){
      	redirect(base_url().'login/signup/gettingstarted', 'refresh');
      }
      else{
      	$this->load->view('homepage',$data);
      }
    }
    
    public function home($pageref){
    	 
    	
    	$data['meta_keywords'] = "";
    	$data['meta_description'] = "";
    	$data['language'] = "en";
    	$data['title'] = "Artist Riot";
    	$data['tab'] = "";
    	
    	if(($this->session->userdata('user_id') != null) && ($pageref == 'home')){
    		$this->load->view('homepage',$data);
    	}
    	
    }
    
     
}