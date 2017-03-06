<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function isEmpty($val)
{
	if(($val != null) && ($val != '') ){
		return false;
	}
	else{
		return true;
	}
	
}

/** Function to check valid user session.
 * @return boolean
 */
function isValidSession() {
	
	// Get current CodeIgniter instance
	$CI =& get_instance();
	
	// We need to use $CI->session instead of $this->session
	$user = $CI->session->userdata('user_id');
	
	if(!empty($user)){
		return true;
	}
	else {
		return false;
	}

}

/**Function to check session value of a variable.
 * @param unknown $var
 * @return boolean
 */
function isSessionExist($var){

	// Get current CodeIgniter instance
	$CI = & get_instance();
	
	if( $CI->session->userdata($var) !== false){
		$data = $CI->session->userdata($var);
		
		if(!empty($data)){
			return true;
		}
		else{
			return false;
		}
	}
	
	return false;
}


/** Function to get response data
 * @param unknown $status
 * @param unknown $data
 * @param unknown $errorMessage
 * @param string $sessionExist
 * @return multitype:string boolean unknown 
 */
function getResponseData($status, $data, $errorMessage, $sessionExist=true){

	$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
	
	$response['status'] = $status;
	$response['data'] = $data;
	$response['errorMessage'] = $errorMessage;
	$response['sessionExist'] = $sessionExist;

	return $response;

}

function getStringArrayFromString($separator, $str){
	
	$strArray = array();
	
	if(!empty($str)){
		$strArray = explode($separator, $str);
	}
	
	return $strArray;
	
}

function logException($errorMessage){
	log_message('error', $errorMessage);
}

function logDebug($message){
	log_message('debug', $message);
}




