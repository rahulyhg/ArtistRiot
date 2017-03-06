<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class UtilsModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	
	/** Function to check valid user session.
	 * @return boolean
	 */
	function isValidSession() {
	
		$isValidSession = false;
	
		if( $this->session->userdata('user_id') !== false){
			$user = $this->session->userdata('user_id');
	
			if(!empty($user)){
				$isValidSession = true;
			}
			else {
				$isValidSession = false;
			}
		}
	
		return $isValidSession;
	}
	
	/**Function to check session value of a variable.
	 * @param unknown $var
	 * @return boolean
	 */
	function isSessionExist($var){
	
		if( $this->session->userdata($var) !== false){
			$data = $this->session->userdata($var);
	
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
	
	public function showPageNotFound(){
		$data['content'] = 'error_404'; // View name
		$this->load->view('error/custom_error_404',$data);//loading in my template
	}
	
	public function getValueFromCache($key){
		
		$this->load->driver('cache');
		
		$val = $this->cache->file->get($key);
		
		if(!empty($val)){
			return $val;
		}
		
		return null;
		
	} 
	
	public function saveValueInCache($key, $val, $timeInMillis = 300){
		
		logDebug('Inside save cache. key is::'.$key);
		$this->cache->file->save($key, $val, $timeInMillis);
	}
	
	public function getKeyFromValueInArray($value, $array, $posVal, $posKey = 0){
		
		logDebug('Inside getKeyFromValueInArray');
		
		$key = null;
		
		foreach ( $array as $temparray ) {
			if(strtolower(trim($temparray[$posVal])) == strtolower(trim($value))){
				$key = $temparray[$posKey];
				break;
			}
		}
		
		return $key;
		
	}
}

