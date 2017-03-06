<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_captcha'))
{
	function get_captcha()
	{
	  $this->load->helper('captcha');
      $vals = array(
      		'img_path' => './captcha/',
      		'img_url' => $this->config->item('base_url').'/captcha/'
      );
      
      $cap = create_captcha($vals);
      
      /*
      $data = array(
      		'captcha_time' => $cap['time'],
      		'ip_address' => $this->input->ip_address(),
      		'word' => $cap['word']
      );
      */
      //$this->session->set_userdata($data);
      
      return $cap['image'];
      
	}
}
