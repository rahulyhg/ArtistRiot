<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class SearchArtist extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('search/searchartistmodel','searchartistmodel');
		$this->load->model('utils/utilsmodel', 'utilsmodel');
	
	}
	
	public function index()
	{
	}
	
	/**
	 * @return boolean
	 */
	public function searchArtists(){
		
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		$this->form_validation->set_rules('name', 'Search String', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == true){
		try{
			$nameStartsWith = $this->input->post('name', TRUE);
			// Getting search results from user search model
				
			$searchResultsData = $this->searchartistmodel->searchartist($nameStartsWith);
					
			if($searchResultsData){
				$response = $this->utilsmodel->getResponseData(true, $searchResultsData, '');
				echo json_encode($response);
				return true;
			}
			else{
				$response = $this->utilsmodel->getResponseData(false, '', 'No matching data found.');
				echo json_encode($response);
				return false;
			}
			
		}
		
		catch(Exception $e){
				
			logException('Error in searching artists ->' . $e->getMessage () );
			$response = $this->utilsmodel->getResponseData(false, '', 'No matching data found.');
			echo json_encode($response);
			return;
		}
		}
		else{
			$response = $this->utilsmodel->getResponseData(false, '', 'Invalid data.');
			echo json_encode($response);
			return false;
		}
		
		
	}
	
	/** Method for getting search results
	 * @param unknown $searchQuery
	 * @return boolean
	 */
	public function searchResults($category = '-1',$searchQuery = '')
	{
		
		logDebug('Inside SearchResults()');
                $category_Id = $this->input->post('searchcatinput');
                if($category_Id==null){
                    $category_Id=-1;
                }
		$data['meta_keywords'] = "";
		$data['meta_description'] = "";
		$data['language'] = "en";
		$data['title'] = "Artist Riot-Artist|Search";
		$data['wallclass'] = "";
		$data['photosclass'] = "active";
		$data['videosclass'] = "";
		$data['heading'] = "Photos";
		$data['tab'] = "";
	
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		
		if(empty($searchQuery)){
			logException('Search query is empty');
			$this->utilsmodel->showPageNotFound();
			return;
		}
		
		$searchQuery = urldecode($searchQuery);
		logException('search query is::'. $searchQuery);
		
			try{
				
				// Getting search results from user search model
				$searchResultsData = $this->searchartistmodel->searchArtistsProfile($searchQuery,$category_Id);
					
				if($searchResultsData){
					
					$data['searchResultsData'] = $searchResultsData;
					
				}
				else{
					$data['searchResultsData'] = '';
				}
				
				$data['searchQuery'] = $searchQuery;
				$this->load->view('search/searchresults', $data);
					
			}
		
			catch(Exception $e){
				logException('Error in searching artists ->' . $e->getMessage () );
				$response = $this->utilsmodel->getResponseData(false, '', 'No matching data found.');
				echo json_encode($response);
				return;
			}
		
	}
	
	/**
	 * Method to load artist name and id for search. This returns the javascript array. 
	 */
	public function getArtistsForSearch(){
	
		$errorMessage = '';
		$status=true;
		$response = array('data' => '', 'status'=>true, 'errorMessage'=>'');
		$this->output->set_content_type('text/javascript');
		
		try{
			
			$searchResultsData = $this->searchartistmodel->getSearchData();
					
			if(!empty($searchResultsData)){
				echo 'var usersData = '. json_encode($searchResultsData);
				return;
			}
			else{
				echo 'var usersData = []';
				return;
			}
					
		}
	
		catch(Exception $e){
	
			logException('Error in searching artists ->' . $e->getMessage () );
			$response = $this->utilsmodel->getResponseData(false, '', 'No matching data found.');
			echo json_encode($response);
			return;
		}

		
	}
	
	public function test($user){
		 
		echo 'inside test';
		$this->searchartistmodel->searchartistsprofile($user);
	}
}