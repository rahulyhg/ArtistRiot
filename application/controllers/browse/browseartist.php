<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author snigam
 *
 */
class BrowseArtist extends CI_Controller {

	var $data;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('login/signupmodel','signupmodel');
		$this->load->model('utils/utilsmodel','utilsmodel');
		$this->load->model('search/searchartistmodel','searchartistmodel');
	}
	
	public function index(){
		
		
		$categories = $this->signupmodel->get_categories();
		$subCategories = $this->signupmodel->get_sub_categories();
		
		$data['categories'] = $categories;
		$data['sub_categories'] = $subCategories;
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "ArtistRiot-Browse Artist";
		
		
		$this->load->view('browse/browseartist', $data);
	}
	
	/** Method to return browse page results.
	 * @param unknown $categoryId
	 * @param unknown $subCategoryId
	 */
	public function browseResults(){
		
		logDebug('Inside browseResults()');
		$searchData = array();
		
		//Getting post parameters
		$categoryId = $this->input->post('categoryId');
		$subCategoryId = $this->input->post('subCategoryId');
		$city = $this->input->post('city');
		
		logException('$categoryId is::'.$categoryId);
		
		if(empty($categoryId)){
			$response = $this->utilsmodel->getResponseData(false, '', '');
			echo json_encode($response);
			return;
		}
		
		//Getting browse results.
		$searchData = $this->searchartistmodel->searchBrowseResults($categoryId, $subCategoryId, $city);
		
		if(!empty($searchData)){
			logException('search data not empty');
			
			$responseArray['searchData'] = json_encode($searchData);
			$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
			
		}
		else{
			$response = $this->utilsmodel->getResponseData(true, '', '');
		}
		
		echo json_encode($response);
		return;
		
	}
	
	/** Method to return browse page results.
	 * @param unknown $categoryId
	 * @param unknown $subCategoryId
	 */
	public function loadMoreBrowseResults(){
	
		logException('Inside loadMoreBrowseResults()');
		$searchData = array();
	
		//Getting post parameters
		$categoryId = $this->input->post('categoryId');
		$subCategoryId = $this->input->post('subCategoryId');
		$city = $this->input->post('city');
		$offset = $this->input->post('offset');
	
		logException('$$offset is::'.$offset);
	
		if(empty($categoryId)){
			$response = $this->utilsmodel->getResponseData(false, '', '');
			echo json_encode($response);
			return;
		}
		
		$maxResultsPerPage = 10;
		//Getting browse results.
		$searchData = $this->searchartistmodel->searchBrowseResults($categoryId, $subCategoryId, 
				$city, $offset, $maxResultsPerPage);
			
		if(!empty($searchData)){
			logException('search data not empty');
			$responseArray['searchData'] = json_encode($searchData);
			$response = $this->utilsmodel->getResponseData(true, $responseArray, '');
				
		}
		else{
			$response = $this->utilsmodel->getResponseData(true, '', '');
		}
	
		echo json_encode($response);
		return;
	
	}
	
	/**
	 * Method to display browse page with parameters.
	 */
	public function browseFilter(){
		
		logDebug('Inside browseFilter()');
		$searchData = array();
		$categoryId = '';
		$subCategoryId = '';
		$city = '';
		
		$default = array('category', 'genre', 'city');
		$searchParameters = $this->uri->uri_to_assoc(2, $default);
		
		$categories = $this->signupmodel->get_categories();
		$subCategories = $this->signupmodel->get_sub_categories();
		$data['categories'] = $categories;
		$data['sub_categories'] = $subCategories;
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "ArtistRiot-Browse Artist";
		
		$categoryName = urldecode($searchParameters['category']);
		$subCategoryName = urldecode($searchParameters['genre']);
		$city = urldecode($searchParameters['city']);
		 
		if(empty($categoryName)){
			redirect(base_url().'browse', 'refresh');
		}
		else{
			//getting category id from category array.
			$categoryId = $this->utilsmodel->getKeyFromValueInArray($categoryName, $categories, 1);
			
			if($categoryId > 0){
				$data['categoryId'] = $categoryId;
				logDebug('categoryId is::'.$categoryId);
			}
		}
		
		if(!empty($subCategoryName)){
			$subCategoryId = $this->utilsmodel->getKeyFromValueInArray($subCategoryName, json_decode($subCategories), 2, 1);
			$data['subCategoryId'] = $subCategoryId;
			logDebug('subCategoryId is::'.$subCategoryId);
		}
		if(!empty($city)){
			$data['city'] = $city;
		}
		
		//Getting browse results.
		$searchData = $this->searchartistmodel->searchBrowseResults($categoryId, $subCategoryId, $city);
		
		if(!empty($searchData)){
			$data['searchData'] = $searchData;
		}
		
		$this->load->view('browse/browseartist', $data);
		
	}
	
}