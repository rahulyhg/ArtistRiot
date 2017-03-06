<?php

class membership_model extends CI_Model{
        
    function validate(){
     $this->db->where('username',$this->input->post('username'));    
     $this->db->where('password',md5($this->input->post('password')));  
     
      $result = $this->db->get('users_info');
      if($result->num_rows()==1)
        {
          return TRUE;  
        }else{
         return FALSE; //not correct credentials 
        }
    }
    
    function create_member(){
       // $username = $this->input->post('username');
        $new_member_insert_data = array(
          'first_name' => $this->input->post('first_name'),
          'last_name' => $this->input->post('last_name'), 
          'email' => $this->input->post('email'),
          'username' => $this->input->post('username'),
          'password' => md5($this->input->post('password'))
        );
        $insert = $this->db->insert('users_info',$new_member_insert_data);
        return $insert;
    }
    function check_if_username_exists($username) {
          $this->db->where('username',$username);
        $result = $this->db->get('users_info');
        if($result->num_rows()==1)
        {
          return TRUE;  
        }else{
         return FALSE; //username taken  
        }
        
    }
    function check_if_email_exists($email) {
          $this->db->where('email',$email);
        $result = $this->db->get('users_info');
        if($result->num_rows()==1)
        {
          return TRUE;  
        }else{
         return FALSE; //username taken  
        }
        
    }
}


