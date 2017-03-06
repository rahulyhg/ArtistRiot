<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// use Entities\ArArtistCategory;

require_once (APPPATH . "models/Entities/ArUsers.php");
require_once (APPPATH . "models/Entities/ArArtistCategory.php");
require_once (APPPATH . "models/Entities/ArArtistSubCategory.php");
require_once (APPPATH . "models/Entities/ArUserProfile.php");
require_once (APPPATH . "models/Entities/ArVenueProfile.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArUserGalleryImages.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");
require_once (APPPATH . "models/Entities/ArVenueCategory.php");
require_once (APPPATH . "models/Entities/ArSearch.php");

use \ArArtistCategory;
use \ArArtistSubCategory;
use Doctrine\ORM\Query as Query;

class SignupModel extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('utils/utilsmodel','utilsmodel');
	}
	
	var $em;
	
	
	/**
	 * @return multitype:multitype:NULL  
	 */
	public function get_categories() {
		
		$categoryArray = array ();
		
		/* $categoryArray = $this->utilsmodel->getValueFromCache('artist_categories');
		
		if(!empty($categoryArray)){
			return $categoryArray;
		} */
		
		$this->em = $this->doctrine->em;
		$query = $this->em->createQuery ( 'SELECT u FROM \ArArtistCategory u' );
		$result = $query->getResult ();
		$temparray = array ();
		
		$count = 0;
		
		foreach ( $result as $categoryData ) {
			
			$temparray [0] = $categoryData->getCategoryId ();
			$temparray [1] = $categoryData->getCategoryName ();
			$categoryArray [$count] = $temparray;
			$count ++;
		}
		
		$this->utilsmodel->saveValueInCache('artist_categories', $categoryArray, 86400);
		
		return $categoryArray;
	}
	/**
	 * @return string
	 */
	public function get_sub_categories() {
		
		$subCategories = $this->utilsmodel->getValueFromCache('artist_sub_categories');
		
		if(!empty($subCategories)){
			return $subCategories;	
		}
		
		$this->em = $this->doctrine->em;
		$query = $this->em->createQuery ( 'SELECT  u.subCategoryId, p.categoryId, u.subCategoryName FROM \ArArtistSubCategory u join u.category p' );
		$result = $query->getResult ();
		$temparray = array ();
		$subCategoryArray = array ();
		$count = 0;
		
		foreach ( $result as $subCategoryData ) {
			
			$temparray [0] = $subCategoryData ['categoryId'];
			$temparray [1] = $subCategoryData ['subCategoryId'];
			$temparray [2] = $subCategoryData ['subCategoryName'];
			
			$subCategoryArray [$count] = $temparray;
			$count ++;
		}
		
		$this->utilsmodel->saveValueInCache('artist_sub_categories', json_encode($subCategoryArray), 86400);
		return json_encode ( $subCategoryArray );
		
	}
	
	/** Method to get venue event types
	 * @return multitype:multitype:NULL  
	 */
	public function getVenueCategories(){
		
		$this->em = $this->doctrine->em;
		
		$query = $this->em->createQuery ( 'SELECT u FROM \ArVenueCategory u' );
		$result = $query->getResult ();
		$temparray = array ();
		$venueCategoryArray = array ();
		$count = 0;
		
		foreach ( $result as $venueCategoryData ) {
				
			$temparray [0] = $venueCategoryData->getCategoryId();
			$temparray [1] = $venueCategoryData->getEventType();
			
			$venueCategoryArray [$count] = $temparray;
			$count ++;
		}
		
		//logDebug( 'Venue categories are: '. implode(",", $venueCategoryArray));
		
		return $venueCategoryArray;
	}
	
	
	/**
	 * @param unknown $profileData
	 * @param unknown $imageData
	 * @return boolean
	 */
	public function createUserProfile($profileData, $imageData) {
		
		logDebug( 'Inside createVenueProfile()');
		
		if(empty($profileData) || empty($imageData)){
			logException('profileData and imageData is empty');
			return false;
		}
		
		$this->em = $this->doctrine->em;
		
		try {
			
			$userData = $this->em->find ( '\ArUsers', $profileData ['id'] );
			
			//Getting category data
			$categoryData = $this->em->find ( '\ArArtistCategory', $profileData ['category_id'] );
			$subCategoryData = $this->em->find ( '\ArArtistSubCategory', $profileData ['sub_category_id'] );
			
			$userProfileData = new ArUserProfile ();
			
			$userProfileData->setUser ( $userData );
			$userProfileData->setCategory($categoryData);
			$userProfileData->setSubCategory($subCategoryData);
			$userProfileData->setUserDescription ( $profileData ['description'] );
			$userProfileData->setFacebookPageUrl ( $profileData ['facebookpage'] );
			$userProfileData->setTwitterPageUrl ( $profileData ['twitterpage'] );
			$userProfileData->setGender($profileData ['gender']);
			$userProfileData->setCity($profileData ['city']);
			
			//Getting profile URL
			$firstName = $userData->getFirstName();
			$lastName = $userData->getLastName();
			
			//Getting User Search Data
			$searchData = $this->getUserSearchData($userData);
			
			
			if ($imageData ['image_path'] != null) {
				$userImageData = new ArUserProfilePicture ();
				$userImageData->setUser ( $userData );
				$userImageData->setImagePath ( $imageData ['image_path'] );
				$userImageData->setImageType ( $imageData ['image_type'] );
				$userImageData->setIsActive ( 1 );
				$userImageData->setPosition('');
				$this->em->persist ( $userImageData );
			}
			
			$this->em->persist ( $userProfileData );
			
			// Set profile created flag in user table
			$userData->setProfileCreated(1);
			$this->em->persist ( $userData );
			
			//Inserting search data in DB
			$this->em->persist ($searchData);
			
			$this->em->flush ();
			return true;
			
		} catch ( Exception $e ) {
			logException( 'Error in creating user profile->' . $e->getMessage () );
			return false;
		}
		
		return false;
	}
	
	/** Method to cerate venue profile.
	 * @param unknown $profileData
	 * @param unknown $imageData
	 * @return boolean
	 */
	public function createVenueProfile($profileData, $imageData) {
		
		logDebug( 'Inside createVenueProfile()');
		
		if(empty($profileData) || empty($imageData)){
			logException('profileData and imageData is empty');
			return false;
		}
		
		$this->em = $this->doctrine->em;
		
		try {
			
			$userData = $this->em->find ( '\ArUsers', $profileData ['id'] );
			$venueProfileData = new ArVenueProfile();
			$venueProfileData->setUser ($userData);
			$venueProfileData->setEventTypes($profileData['venue_categories']);
			$venueProfileData->setVenueDescription($profileData ['venue_description']);
			$venueProfileData->setFacebookPageUrl ( $profileData ['facebookpage'] );
			$venueProfileData->setTwitterPageUrl ( $profileData ['twitterpage'] );
			$venueProfileData->setCity($profileData['city']);

			
			
			if ($imageData ['image_path'] != null) {
				$venueImageData = new ArUserProfilePicture ();
				$venueImageData->setUser ( $userData );
				$venueImageData->setImagePath ( $imageData ['image_path'] );
				$venueImageData->setImageType ( $imageData ['image_type'] );
				$venueImageData->setIsActive ( 1 );
				$this->em->persist ( $venueImageData );
			}

			// Set profile created flag in user table
			$userData->setProfileCreated(1);
			$this->em->persist ( $userData );
			$this->em->persist ( $venueProfileData );
			
			$this->em->flush ();
			return true;
				
		} catch ( Exception $e ) {
			logException( 'Error in creating venue profile->' . $e->getMessage () );
			return false;
		}
	
		return false;
	}
	
	
	
	/**
	 * @param unknown $user_id
	 * @param unknown $userimagename
	 * @param unknown $imageType
	 * @param unknown $existing_cover_image_id
	 * @param unknown $imageTop
	 * @return Ambigous <multitype:string , boolean, multitype:string unknown >|boolean
	 */
	public function uploadUserCoverImage($user_id, $userimagename,  $imageType, $existing_cover_image_id, $imageTop){

		logDebug('Inside uploadUserCoverImage().');
		
		$this->em = $this->doctrine->em;
		$userCoverImageData= null;
		$result = true;
		
		try {
			
			// Set any existing active cover images as inactive.
			if(!is_null($existing_cover_image_id) && ($existing_cover_image_id != '')){
				$query = $this->em->createQuery ( 'update \ArUserProfilePicture u set u.isActive=0 WHERE u.imageId=?1 and u.isActive = 1' );
				$query->setParameter ( 1, $existing_cover_image_id );
				$result = $query->execute();
			}	
			
			if($result){
			
			$userData = $this->em->find ( '\ArUsers', $user_id );
				
			if ($userData != null) {
				$userImageData = new ArUserProfilePicture ();
				$userImageData->setUser ( $userData );
				$userImageData->setImagePath ( $userimagename );
				$userImageData->setImageType ( $imageType );
				$userImageData->setIsActive ( 1 );
				$userImageData->setPosition($imageTop);
				
				$this->em->persist ( $userImageData );
				$this->em->flush ();
			}
			// Return new cover image data in array.
			
			$newUserProfileImageData = $this->getUserCoverImageData($user_id, $imageType);
			return $newUserProfileImageData;
			}
			
		} catch ( Exception $e ) {
			logException( 'Error in uploading user cover image.->' . $e->getMessage () );
			return false;
		}
		
		return false;
		
	}
	
	/**
	 * @param unknown $user_id
	 * @param unknown $imageType
	 * @return multitype:string unknown |boolean
	 */
	public function getUserCoverImageData($user_id, $imageType) {
	
		$this->em = $this->doctrine->em;
	
		$imageData = array (
				'cover_image_id' => '',
				'cover_image' => '',
				'image_position' => '0'
		);
	
		try {
	
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imagePath, u.position FROM \ArUserProfilePicture u join u.user p WHERE p.id = ?1 and u.isActive=1 and u.imageType=?2' );
			$query->setParameter ( 1, $user_id );
			$query->setParameter ( 2, $imageType );
	
			$result = $query->getResult ();
	
			// storing result into an array
	
			if (($result != null) && (sizeof ( $result ) == 1)) {
	
				foreach ( $result as $data ) {
	
					$imageData ['user_cover_image'] = $this->config->item ( 'ar_img_upload_path' ).$data ['imagePath'];
					$imageData ['cover_image_id'] = $data ['imageId'];
					$imageData ['image_position'] = $data ['position'];
				}
			}
	
			return $imageData;
				
		} catch ( Exception $e ) {
			//echo 'Error in getting cover image.';
			logException( 'Error in getting user cover image->' . $e->getMessage () );
			return false;
		}
	}
	
	
	/**
	 * @param unknown $user_id
	 * @param unknown $coverImageId
	 * @param unknown $imageTop
	 * @return unknown|boolean
	 */
	public function repositionCoverImage($user_id, $coverImageId, $imageTop){
		
		$this->em = $this->doctrine->em;
		
		try{
		if(!is_null($user_id) && ($coverImageId != '') && !is_null($imageTop)){
			$query = $this->em->createQuery ( 'update \ArUserProfilePicture u set u.position=?1 WHERE u.imageId=?2 and u.isActive = 1' );
			$query->setParameter ( 1, $imageTop );
			$query->setParameter ( 2, $coverImageId );
			$result = $query->execute();
			return $result;
		}
		}
		catch(Exception $e){
			logException( 'Error in updating imageposition for user id' . $user_id );
			return false;
		}
		
		return false;
	}
	
	/**
	 * @param unknown $user_id
	 * @return multitype:string unknown NULL Ambigous <string, string, unknown> |boolean|NULL
	 */
	public function getUserProfileData($user_id) {
		
		logException('Inside getUserProfileData');
		
		$this->em = $this->doctrine->em;
		$profileData = null;
		$categoryData = null;
		$subCategoryData =  null;
		
		$userGalleryVideoData = array();
		$userGalleryImageData = array();
		
		try {
			
			$userData = $this->em->find ( '\ArUsers', $user_id );
			
			// Get user profile data
			
			$query = $this->em->createQuery ( 'SELECT  u FROM \ArUserProfile u join u.user p join u.category c join u.subCategory s WHERE p.id = ?1' );
			$query->setParameter ( 1, $user_id );
			$result = $query->getResult();
			
			if (!empty($result) && (sizeof ( $result ) == 1)) {
				
				$profileData = $result[0];
				//Below line use proxy to load profile.
				//$profileData = $this->em->find ( '\ArUserProfile', 16 );
				$profileImageData = $this->getUserImageData ( $user_id );
				
				// Getting category and sub category objects
				
				$categoryData = $profileData->getCategory();
				$subCategoryData = $profileData->getSubCategory();
				
				logException('Category id is:'. $categoryData->getCategoryId());
				
				//$categoryData = $this->em->find ( '\ArArtistCategory', $categoryId );
				//$subCategoryData = $this->em->find ( '\ArArtistSubCategory', $subCategoryId );
				
				$userProfileData = array (
						'profile_id' => $profileData->getProfileId(),
						'first_name' => $userData->getFirstName (),
						'last_name' => $userData->getLastName (),
						'email' => $userData->getEmail(),
						'user_image' => $this->config->item ( 'ar_img_upload_path' ) . $profileImageData ['profile'],
						'user_cover_image' => $this->config->item ( 'ar_img_upload_path' ) . $profileImageData ['cover'],
						'profile_image_id' => $profileImageData ['profile_image_id'],
						'cover_image_id' => $profileImageData ['cover_image_id'],
						'image_position' => $profileImageData ['image_position'],
						'category_name' => $categoryData->getCategoryName(),
						'sub_category_name' => $subCategoryData->getSubCategoryName(),
						'profile_created' => 1
				);
				
				return $userProfileData;
			} else {
				logException( 'Error in getting user profile for user id' . $user_id );
				return false;
			}
		} catch ( Exception $e ) {
			logException( 'Error in getting user profile.->' . $e->getMessage () );
			return null;
		}
	}
	
	
	
	
	/** Method to get venue profile data
	 * @param unknown $user_id
	 * @return multitype:string unknown NULL Ambigous <string, string, unknown> |boolean|NULL
	 */
	public function getVenueProfileData($user_id) {

		$this->em = $this->doctrine->em;
		$profileData = null;
		$userGalleryVideoData = array();
		$userGalleryImageData = array();
	
		try {
				
			$userData = $this->em->find ( '\ArUsers', $user_id );
				
			// Get venue profile data
				
			$query = $this->em->createQuery ( 'SELECT u FROM \ArVenueProfile u join u.user p WHERE p.id = ?1' );
			$query->setParameter ( 1, $user_id );
			$result = $query->getResult ();
				
			if (!empty($result) && (sizeof( $result ) == 1)) {
	
				$profileData = $result[0];

				//Getting image data.
				$profileImageData = $this->getUserImageData ( $user_id );
				logException('$profileImageData is::'.$profileImageData['profile']);
				
				//Getting event categories. This is a comma separated event ids.
				$venueCategories = $this->getEventTypeAsCommaSeparatedString($profileData->getEventTypes());
	
				$venueProfileData = array (
						'profile_id' => $profileData->getProfileId(),
						'first_name' => $userData->getFirstName (),
						'email' => $userData->getEmail(),
						'venue_profile_image' => $this->config->item ( 'ar_img_upload_path' ) . $profileImageData ['profile'],
						'venue_profile_image_id' => $profileImageData ['profile_image_id'],
						'venue_categories' => $venueCategories,
						'profile_created' => 1
				);
				
	
				return $venueProfileData;
			} else {
				logException( 'Error in getting venue profile for user id' . $user_id );
				return false;
			}
		} catch ( Exception $e ) {
			logException( 'Error in getting venue profile->' . $e->getMessage () );
			return false;
		}
	}
	
	
	
	/** Method to get comma separated event names from comma separated event Ids
	 * @param unknown $eventTypes
	 * @return string
	 */
	private function getEventTypeAsCommaSeparatedString($eventTypes){

		logDebug( 'Inside getEventTypeAsCommaSeparatedString()');
		$eventNames = '';
		try{
			if(empty($eventTypes)){
				return '';
			}
			
			//Getting string array from string separated by comma.
			$eventIdArray = getStringArrayFromString(',', $eventTypes);
			
			if(empty($eventIdArray)){
				return '';
			}
			
			foreach ( $eventIdArray as $categoryId ) {
				$categoryName = $this->getVenueCategoryNameFromId(trim($categoryId));
				$eventNames = $eventNames.$categoryName.',';
			}
			
			//Removing last character
			if(!empty($eventNames)){
				$eventNames = substr(trim($eventNames), 0, -1);
			}
			
			logDebug( '$eventNames is::'.$eventNames);
		}
		catch(Exception $e){
			logException($e->getMessage());
		}
		
		return $eventNames;
	}
	
	
	/** Method to get category name from ArVenueCategory based on categoryId.
	 * @param unknown $categoryId
	 * @return unknown|string
	 */
	public function getVenueCategoryNameFromId($categoryId){
		
		logDebug( 'Inside getEventNameFromId()');
		$this->em = $this->doctrine->em;
		$venueCategoryName = '';
		
		try{
			$query = $this->em->createQuery ( 'SELECT u FROM \ArVenueCategory u where u.categoryId=?1' );
			$query->setParameter ( 1, $categoryId );
			$result = $query->getResult();
			
			if (!empty($result) && (sizeof ( $result ) == 1)) {
				$venueCategoryData = $result [0];
				$venueCategoryName = $venueCategoryData->getEventType();
			}
			
		}
		catch(Exception $e){
			logException('Error in getting category name for venue for categoryId='. $categoryId .'. Error is::'. $e->getMessage () );
			return $imageData;
		}
		
		return $venueCategoryName;
		
	}
	
	
	/**
	 * @param unknown $user_id
	 * @return multitype:string unknown 
	 */
	public function getUserImageData($user_id) {
		$this->em = $this->doctrine->em;
		$imageData = array (
				'profile_image_id' => '',
				'profile' => '',
				'cover_image_id' => '',
				'cover' => '',
				'image_position' => '0' 
		);
		
		try {
			
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageType, u.imagePath, u.position, p.id FROM \ArUserProfilePicture u join u.user p WHERE p.id = ?1 and u.isActive=1' );
			$query->setParameter ( 1, $user_id );
			
			$result = $query->getResult ();
			
			// storing result into an array
			
			if (($result != null) && (sizeof ( $result ) > 0)) {
				
				foreach ( $result as $data ) {
					
					if ($data ['imageType'] == 'profile') {
						$imageData ['profile'] = $data ['imagePath'];
						$imageData ['profile_image_id'] = $data ['imageId'];
					}
					
					if ($data ['imageType'] == 'cover'){
						$imageData ['cover'] = $data ['imagePath'];
						$imageData ['cover_image_id'] = $data ['imageId'];
						$imageData ['image_position'] = $data ['position'];
					}
				}
			}
			
			return $imageData;
		} catch ( Exception $e ) {
			logException('Error in getting user image data.->' . $e->getMessage () );
			return $imageData;
		}
	}
	
	/**
	 * @param unknown $user_id
	 * @param unknown $image_id
	 * @param unknown $image_name
	 * @param unknown $imageType
	 * @return Ambigous <multitype:string , multitype:string unknown >|boolean
	 */
	public function updateUserImage($user_id, $image_id, $image_name, $imageType) {
		
		$this->em = $this->doctrine->em;
		$userImageData= null;
		
		try{
			
		if( ($image_id != '') || ($image_id != null) ){
		
		$query = $this->em->createQuery ( 'update \ArUserProfilePicture u set u.isActive=0 WHERE u.imageId=?1 and u.isActive = 1' );
		// $query->setParameter ( 1, $user_id );
		$query->setParameter ( 1, $image_id );
		
		$result = $query->getResult();
		
		if ($result) {
			$userData = $this->em->find ( '\ArUsers', $user_id );
			if ($userData != null) {
				
				$userImageData = new ArUserProfilePicture ();
				$userImageData->setUser ( $userData );
				$userImageData->setImagePath ( $image_name );
				$userImageData->setImageType ( $imageType );
				$userImageData->setIsActive (1);
				$userImageData->setPosition('');
				$this->em->persist($userImageData);
				$this->em->flush ();
				
			}
			
			// Return new image data in array.
			$newUserProfileImageData = $this->getUserProfileImageData($user_id, $imageType);
			return $newUserProfileImageData;
		
		}
		
		}
		
		else{
			
			$userData = $this->em->find ( '\ArUsers', $user_id );
			echo $userData->getEmail();
			if ($userData != null) {
			
				$userImageData = new ArUserProfilePicture ();
				$userImageData->setUser ( $userData );
				$userImageData->setImagePath ( $image_name );
				$userImageData->setImageType ( $imageType );
				$userImageData->setIsActive (1);
				$userImageData->setPosition('');
				
				$this->em->persist($userImageData);
				$this->em->flush ();
				
			}
				
			// Return new image data in array.
			$newUserProfileImageData = $this->getUserProfileImageData($user_id, $imageType);
			return $newUserProfileImageData;
		}
		
		}
		catch ( Exception $e ) {
			logException('error', 'Error in updating user image.->' . $e->getMessage () );
			return false;
		}
		
	}
	
	/**
	 * @param unknown $user_id
	 * @param unknown $imageType
	 * @return multitype:string unknown 
	 */
	public function getUserProfileImageData($user_id, $imageType) {
		
		$this->em = $this->doctrine->em;
		
		$imageData = array (
				'profile_image_id' => '',
				'user_image' => ''
		);
	
		try {
				
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imagePath FROM \ArUserProfilePicture u join u.user p WHERE p.id = ?1 and u.isActive=1 and u.imageType=?2' );
			$query->setParameter ( 1, $user_id );
			$query->setParameter ( 2, $imageType );
				
			$result = $query->getResult ();
				
			// storing result into an array
				
			if (($result != null) && (sizeof ( $result ) == 1)) {
	
				foreach ( $result as $data ) {
						
						$imageData ['user_image'] = $this->config->item ( 'ar_img_upload_path' ).$data ['imagePath'];
						$imageData ['profile_image_id'] = $data ['imageId'];
					
				}
			}
			
			return $imageData;
			
		} catch ( Exception $e ) {
			echo 'Error in updating profile image.';
			logException( 'Error in getting user profile image data.->' . $e->getMessage () );
			return $imageData;
		}
	}
	
	/**
	 * @param unknown $user_id
	 * @return NULL|multitype:multitype:string unknown  
	 */
	public function getUserGalleryImagesData($user_id) {
		
		$this->em = $this->doctrine->em;
		$userGalleryImageData = array();
		
		try {
			if($user_id > 0){
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageName, u.imageDescription FROM \ArUserGalleryImages u join u.user p WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
			$query->setParameter ( 1, $user_id );
			$result = $query->getResult ();
			$temparray = array ();
			$count = 0;
			
			if (($result != null) && (sizeof ( $result ) > 1)) {
				foreach ( $result as $imagedata ) {
					
					$temparray [0] = $imagedata ['imageId'];
					$temparray [1] = base_url().$this->config->item ('ar_gallery_img_upload_path').$imagedata ['imageName'];
					$temparray [2] = $imagedata ['imageDescription'];
					
					$userGalleryImageData [$count] = $temparray;
					$count ++;
				}
			}
			else{
				return null;
			}
			}
			else{
				return null;
			}
		} catch ( Exception $e ) {
			logException( 'Error in getting user gallery images->' . $e->getMessage () );
			return null;
		}
		
		return $userGalleryImageData;
		
	}
	
	/**
	 * @param unknown $user_id
	 * @return NULL|multitype:multitype:unknown  
	 */
	public function getUserGalleryVideosData($user_id) {
	
		$this->em = $this->doctrine->em;
		$userGalleryVideoData = array();
	
		try {
			if($user_id > 0){
				
				$query = $this->em->createQuery ( 'SELECT  u.videoId, u.videoUrl, u.videoDescription, u.youtubeVideoId, u.uploadDate FROM \ArUserGalleryVideos u join u.user p WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
				$query->setParameter ( 1, $user_id );
				$result = $query->getResult ();
				$temparray = array ();
				$count = 0;
				
					
				if (($result != null) && (sizeof ( $result ) > 1)) {
					foreach ( $result as $videodata ) {
							
						$temparray [0] = $videodata ['videoId'];
						$temparray [1] = $videodata ['videoUrl'];
						$temparray [2] = $videodata ['videoDescription'];
						$temparray [3] = $videodata ['youtubeVideoId'];
						
						$userGalleryVideoData [$count] = $temparray;
						$count ++;
					}
				}
				else{
					return null;
				}
			}
			else{
				return null;
			}
		} catch ( Exception $e ) {
			logException( 'Error in getting user gallery videos->' . $e->getMessage () );
			return null;
		}
	
		return $userGalleryVideoData;
	
	}
	
	
	
	
	/**Method to get profile URL of the user.
	 * @param unknown $user_id
	 * @param unknown $firstName
	 * @param unknown $lastName
	 * @return boolean|string
	 */
	
	public function getUserName($firstName, $lastName) {
		
		$this->em = $this->doctrine->em;
		
		logDebug('Inside getUserName()');
		logDebug('Method parameters are: $firstName::'.$firstName.', $lastName::'.$lastName);
		
		
		try {
			$suffix = 0;
			
			$firstName = str_replace(' ', '', $firstName);
			$lastName = str_replace(' ', '', $lastName);
			
			$userNamesArray = array();
			$userName = $this->generateUserName($firstName, $lastName);
			
			$query = $this->em->createQuery('SELECT u.username FROM \ArUsers u WHERE u.username like ?1');
			$query->setParameter ( 1, $userName.'%' );
			$query->useQueryCache(true);
			
			$result = $query->getResult ();
			
			$isUserNameAvailable = false;
			
			$current  = 1;
			$ceiling  = 1000;
			
			//Creating array of profile urls.
			if(!empty($result) && (sizeof($result) > 0)){
				$count = 0;
				foreach ( $result as $data ) {
					$userNamesArray [$count] = strtolower($data['username']);
					$count = $count + 1;
				}
			}
			
			if(empty($userNamesArray)){
				return $userName;
			}
			
			while(!$isUserNameAvailable) {
				
				// Check if the loop ceiling has been reached.
				if($current == $ceiling) {
					logException('generateUserProfile userName limit has reached.');
					return false;
				}
				
				if(!in_array(strtolower($userName), $userNamesArray)) {
					$isUserNameAvailable = true;
				}else{
					$suffix = $suffix + 1;
					$current = $current + 1;
					$userName = $this->generateUserName($firstName, $lastName, $suffix);
				}
			}

			logException('$userName is::'.$userName);
			
			return $userName;
			
		} catch ( Exception $e ) {
			logException('Error in creating username->' . $e->getMessage () );
			return false;
		}
	
	}
	
	
	
	/** Method to generate profile URL with a suffix.
	 * @param unknown $firstName
	 * @param unknown $lastName
	 * @param string $suffix
	 * @return string
	 */
	private function generateUserName($firstName, $lastName, $suffix=''){
		
		logDebug('Inside generateProfileName()');
		
		$profileName = $firstName.$lastName.$suffix;
		
		return $profileName;
		
	}
	
	/** Method to insert data into search table
	 * @param unknown $user_id
	 * @param unknown $name
	 * @param unknown $role
	 * @return boolean
	 */
	public function getUserSearchData($userData){
		
		logDebug('Inside getSearchData()');
		$searchData = null;
		
		try{
			if (!empty($userData)) {
			
				$searchData = new ArSearch();
				$searchData->setUser( $userData);
				$searchData->setName($userData->getFirstName().' '.$userData->getLastName());
				$searchData->setRole($userData->getRole());
				
			}
		}
		catch(Exception $e){
			logException('Error in getting search data::'.$e);
		}
		
		return $searchData;
		
	}
}
