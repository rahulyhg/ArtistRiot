<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page extends CI_Controller {
    
    public function howItWorks(){
     
      
     $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "about";
    //  $data['content'] = $this->load->view('includes/profile/profile_content', '', true);
      $this->load->view('tabs',$data);
     
    }
    
    public function whyUs(){
     
      
     $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "services";
    //  $data['content'] = $this->load->view('includes/profile/profile_content', '', true);
      $this->load->view('tabs',$data);
     
    }
    
    public function trends(){
     
      
     $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "trend";
    //  $data['content'] = $this->load->view('includes/profile/profile_content', '', true);
      $this->load->view('tabs',$data);
     
    }
    
    public function faq(){
     
      
     $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "faq";
    //  $data['content'] = $this->load->view('includes/profile/profile_content', '', true);
      $this->load->view('tabs',$data);
     
    }
    
    
    public function team(){
     
      
     $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "team";
    //  $data['content'] = $this->load->view('includes/profile/profile_content', '', true);
      $this->load->view('tabs',$data);
     
    }
    
    public function contact(){
     
      
     $data['meta_keywords'] = "";
      $data['meta_description'] = "";
      $data['language'] = "en";
      $data['title'] = "Artist Riot";
      $data['tab'] = "contact";
    //  $data['content'] = $this->load->view('includes/profile/profile_content', '', true);
      $this->load->view('tabs',$data);
     
    }
     
}