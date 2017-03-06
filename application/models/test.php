<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Model
{
	
function validate($data){
     $this->db->where('email',$data['login_email']);    
     //$this->db->where('password', $data['password']);  
     
      $result = $this->db->get('test');
      
      if($result->num_rows()==1)
        {
          return true;  
        }else{
        	
         return false; //not correct credentials 
        }
    } 
	
	
}