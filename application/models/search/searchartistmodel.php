<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require_once (APPPATH . "models/Entities/ArUsers.php");
require_once (APPPATH . "models/Entities/ArSearch.php");
require_once (APPPATH . "models/Entities/ArArtistCategory.php");
require_once (APPPATH . "models/Entities/ArArtistSubCategory.php");
require_once (APPPATH . "models/Entities/ArUserProfile.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArUserGalleryImages.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");
require_once (APPPATH . "models/Entities/ArArtistRating.php");

use Doctrine\ORM\Query as Query;

class SearchArtistModel extends CI_Model {
	
	var $em;
	
	
	public function searchArtist($name){
	
		$this->em = $this->doctrine->em;
		$result = true;
		
		try {
				$this->em = $this->doctrine->em;
				$query = $this->em->createQuery ('SELECT p.id, u.name, u.role FROM \ArSearch u join u.user p where u.name like ?1');
				$query->setParameter (1, $name.'%');
				//Setting max results
				$query->setMaxResults(8);
				$query->setFirstResult(0);
				$query->useResultCache(true, 3600, 'search_artist_id');
				$query->useQueryCache(true);
				$result = $query->getResult();
				
				if($result && (sizeof($result) > 0)){
					return $result;
				}
				
		} catch ( Exception $e ) {
			log_message ( 'error', 'Error getting autocomplete search results->' . $e->getMessage () );
			return false;
		}
	
		return false;
	
	}
	
	public function getSearchData(){
	
		$this->em = $this->doctrine->em;
		$result = true;
		$count = 0;
		$userDataArray = array();
		try {
			$this->em = $this->doctrine->em;
			$query = $this->em->createQuery ('SELECT distinct u.name, u.role FROM \ArSearch u join u.user p');
			$query->useResultCache(true, 1800, 'search_artist_id');
			$query->useQueryCache(true);
			$result = $query->getResult();
			
			if($result && (sizeof($result) > 0)){
				foreach ( $result as $userData ) {
					$searchData['name'] = $userData['name'];
					$searchData['role'] = $userData['role'];
					$userDataArray[$count] = $searchData;
					$count++;
				}
				
			}
	
		} catch ( Exception $e ) {
			logException('Error getting search data->' . $e->getMessage ());
			return false;
		}
	
		return $userDataArray;
	
	}
	
	public function searchArtistsProfile($searchString,$category_id){
	
		logException('Inside searchArtistsProfile');
		
		$this->em = $this->doctrine->em;
		$result = true;
		$searchData = array (
				'user_id' => '',
				'profile_id' => '',
				'username' => '',
				'role' => '',
				'first_name' => '',
				'last_name' => '',
				'city' => '',
				'user_image_path' => '',
				'sub_category_name' => '' 
		);
		
		$searchResultsArray = array();
		
		try {
			
			$this->em = $this->doctrine->em;
                        logDebug('categoryId'.$category_id);
                        if($category_id!=-1)
						{
                            $query = $this->em->createQuery ( 'SELECT u.id, u.role, u.firstName, u.lastName, u.username, s.subCategoryName, p.city, p.userDescription 
                            			FROM \ArUserProfile p join p.user u join p.category c join p.subCategory s 
                                        where u.role=\'artist\' and u.active = 1 and u.profileCreated = 1 and c.categoryId=?1 and CONCAT(u.firstName, CONCAT(\' \', u.lastName)) like ?2');
                            $query->setParameter (1, $category_id);
                            $query->setParameter (2, $searchString.'%');
                        }
                        else{
                            
                            $query = $this->em->createQuery ( 'SELECT u.id, u.role, u.firstName, u.lastName, u.username, s.subCategoryName, p.city, p.userDescription 
                            FROM \ArUserProfile p join p.user u join p.category c join p.subCategory s where 
							u.role=\'artist\' and u.active = 1 and u.profileCreated = 1 and CONCAT(u.firstName, CONCAT(\' \', u.lastName)) like ?1');
                            $query->setParameter (1, $searchString.'%');
                        }
			//$query->useResultCache(true, 3600, 'search_artist_profile');
			$query->useQueryCache(true);
			$result = $query->getResult();
			$count = 0;
			
			if($result && (sizeof($result) > 0)){
				foreach ( $result as $userData ) {
					$searchData['user_id'] = $this->ar_encrypt->encode($userData['id'], $this->config->item('encryption_key'));
					$searchData['first_name'] = $userData['firstName'];
					$searchData['last_name'] = $userData['lastName'];
					$searchData['userName'] = $userData['username'];
					$searchData['role'] = $userData['role'];
					$searchData['city'] = $userData['city'];
					$searchData['user_description'] = $userData['userDescription'];
					$searchData['sub_category_name'] = $userData['subCategoryName'];
					
					/** Get the profile image data for each user **/
					$userImageData = $this->getUserImageData($userData['id']);
					
					$searchData['user_image_path'] = base_url().$this->config->item ('ar_img_upload_path') . $userImageData['user_image'];
					                    
                    /** Get Rating Data  ****/
                    $this->load->model('profile/UserDetailsModel');
                    $ratingData = $this->UserDetailsModel->getArtistRating($userData['id']);
                    $searchData['rating'] = $ratingData['rating'];
                    $searchResultsArray[$count] = $searchData;
					$count++;
				}
				
				return $searchResultsArray;
			}
			else{
				return false;
			}
	
		} catch ( Exception $e ) {
			logException('Error getting search results->' . $e->getMessage () );
			return false;
		}
	
		return true;
	
	}
	
	public function getUserImageData($user_id) {
		$this->em = $this->doctrine->em;
		$imageData = array (
				'profile_image_id' => '',
				'user_image' => ''
		);
	
		try {
				
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageType, u.imagePath FROM \ArUserProfilePicture u join u.user p WHERE p.id = ?1 and u.isActive=1' );
			$query->setParameter ( 1, $user_id );
			$query->useResultCache(true, 3600, 'search_artist_profile_image');
			$query->useQueryCache(true);
			
			$result = $query->getResult();
				
			// storing result into an array
				
			if (($result != null) && (sizeof ( $result ) > 0)) {
	
				foreach ( $result as $data ) {
						
					if ($data ['imageType'] == 'profile') {
						$imageData ['user_image'] = $data ['imagePath'];
						$imageData ['profile_image_id'] = $data ['imageId'];
					}
				}
			}

			
			return $imageData;
			
		} catch ( Exception $e ) {
			echo 'inside catch';
			log_message ( 'error', 'Error in creating user profile->' . $e->getMessage () );
			return $imageData;
		}
	}
	
	
	/** 
	 * @param unknown $categoryId
	 * @param unknown $subCategoryId
	 * @return multitype:string unknown NULL |boolean|unknown
	 */
	public function searchBrowseResults($categoryId, $subCategoryId, $city, $offset=0, $maxResultsPerPage = 10){
		
		logException('Inside searchBrowseResultsModel()');
		
		
		$this->em = $this->doctrine->em;
		$result = true;
		$searchData = array ();
		$queryString = '';
		
		try{
			
			$queryString = 'SELECT u.id, u.role, u.firstName, u.lastName, u.username, s.subCategoryName, p.city, r.rating, 
							dp.imageType, dp.imagePath
                            FROM \ArUserProfile p join p.user u join p.category c join p.subCategory s
							left join \ArArtistRating r with r.artist = p.user
							left join \ArUserProfilePicture	dp with dp.user = p.user 
							where u.role=\'artist\' and u.active = 1 and u.profileCreated = 1 and  dp.isActive=1 and dp.imageType = \'profile\'
							and c.categoryId=?1';
			
			
			if(!empty($subCategoryId))
			{
				$queryString = $queryString. ' and s.subCategoryId = '.$subCategoryId;
				
			}
			if(!empty($city)){
				$queryString = $queryString.' and p.city like \''. $city.'%\'';
			}
			
			logDebug('query is::'. $queryString);
			
			$query = $this->em->createQuery($queryString);
			$query->useQueryCache(true);
			$query->setParameter ( 1, $categoryId );
			
			//Setting max results
			$query->setMaxResults($maxResultsPerPage);
			$query->setFirstResult($offset);
			
			$result = $query->getResult();
			$count = 0;
			
			if($result && (sizeof($result) > 0)){
				foreach ( $result as $userData ) {
					$searchData['user_id'] = $this->ar_encrypt->encode($userData['id'], $this->config->item('encryption_key'));
					$searchData['first_name'] = $userData['firstName'];
					$searchData['last_name'] = $userData['lastName'];
					$searchData['userName'] = $userData['username'];
					$searchData['role'] = $userData['role'];
					$searchData['city'] = $userData['city'];
					$searchData['sub_category_name'] = $userData['subCategoryName'];
					$searchData['rating'] = $userData['rating'];
					
					//Getting image path
					if(!empty($userData['imagePath'])){
						$searchData['user_image_path'] = base_url().$this->config->item ('ar_img_upload_path') . $userData['imagePath'];
					}
					else{
						$searchData['user_image_path'] = '';
					}
					
					//Getting rating
					if(!empty($searchData['rating'])){
						$searchData['rating'] = round($searchData['rating'], 1);
					}
					else{
						$searchData['rating'] = '';
					}
					
					
					$searchResultsArray[$count] = $searchData;
					$count++;
				}
			
				return $searchResultsArray;
			}
			else{
				return false;
			}
			
		} catch ( Exception $e ) {
			logException($e->getMessage());
			return null;
		}
		
	}
	
	
}