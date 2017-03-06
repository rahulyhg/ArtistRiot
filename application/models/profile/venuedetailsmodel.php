<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// use Entities\ArArtistCategory;

require_once (APPPATH . "models/Entities/ArUsers.php");
require_once (APPPATH . "models/Entities/ArVenueCategory.php");
require_once (APPPATH . "models/Entities/ArVenueProfile.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArVenueGalleryImages.php");
require_once (APPPATH . "models/Entities/ArVenueGalleryVideos.php");

use \ArArtistCategory;
use \ArArtistSubCategory;
use Doctrine\ORM\Query as Query;

class VenueDetailsModel extends CI_Model {
	var $em;
	
	public function get_categories() {
		$this->em = $this->doctrine->em;
		$query = $this->em->createQuery ( 'SELECT u FROM \ArArtistCategory u' );
		$result = $query->getResult ();
		$temparray = array ();
		$categoryArray = array ();
		$count = 0;
		
		foreach ( $result as $categoryData ) {
			
			$temparray [0] = $categoryData->getCategoryId ();
			$temparray [1] = $categoryData->getCategoryName ();
			$categoryArray [$count] = $temparray;
			$count ++;
		}
		
		return $categoryArray;
	}
	
	
	/** Method to get Venue profile data.
	 * @param unknown $user_id
	 * @return boolean|multitype:string NULL Ambigous <string, unknown> Ambigous <NULL, multitype:multitype:string unknown  > Ambigous <NULL, multitype:multitype:unknown  > |NULL
	 */
	
	public function getVenueProfileData($user_id) {
		
		logException('Inside getVenueProfileData()');
		
		$this->em = $this->doctrine->em;
		$profileData = null;
		$userGalleryVideoData = array();
		$userGalleryImageData = array();
		
		try {
			
			$userData = $this->em->find ( '\ArUsers', $user_id );
			
			// Get user profile data
			
			$query = $this->em->createQuery ( 'SELECT  u FROM \ArVenueProfile u join u.user p WHERE p.id = ?1' );
			$query->setParameter ( 1, $user_id );
			$result = $query->getResult ();
			
			if ((!empty($result)) && (sizeof ( $result ) == 1)) {
				
				$profileData = $result [0];
				
				if(empty($profileData)){
					return false;
				}
				
				$profileImageData = $this->getVenueImageData( $user_id );
				$eventTypeIds = $profileData->getEventTypes();
				//Getting event names.
				$eventNames = $this->getEventTypeAsCommaSeparatedString($eventTypeIds);
				
				$venueGalleryImageData = $this->getVenueGalleryImagesData($user_id);
				$venueGalleryVideoData = $this->getVenueGalleryVideosData($user_id);
				
				$venueProfileData = array (
						'first_name' => $userData->getFirstName(),
						'email' => $userData->getEmail(),
						'phone' => $userData->getPhone(),
						'fb_link' => $profileData->getFacebookPageUrl(),
						'venue_city' => $profileData->getCity(),
						'twitter_link' => $profileData->getTwitterPageUrl(),
						'venue_profile_image' => base_url() . $this->config->item('ar_img_upload_path') . $profileImageData ['profile'],
						'venue_description' => $profileData->getVenueDescription(),
						'profile_image_id' => $profileImageData ['profile_image_id'],
						'event_names' => $eventNames,
						'venue_gallery_images' => $venueGalleryImageData,
						'venue_gallery_videos' =>  $venueGalleryVideoData
				);
				
				return $venueProfileData;
			} else {
				log_message ( 'error', 'Error in getVenueProfileData for user id' . $user_id );
				return false;
			}
		} catch ( Exception $e ) {
			log_message ( 'error', 'Error in getVenueProfileData->' . $e->getMessage () );
			return null;
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
	
	public function getVenueImageData($user_id) {
		
		logDebug('Inside getVenueImageData()');
		$this->em = $this->doctrine->em;
		$imageData = array (
				'profile_image_id' => '',
				'profile' => ''
		);
		
		try {
			
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageType, u.imagePath, u.position, p.id FROM \ArUserProfilePicture u join u.user p WHERE p.id = ?1 and u.isActive=1 and u.imageType=?2');
			$query->setParameter ( 1, $user_id);
			$query->setParameter ( 2, 'profile');
			
			$result = $query->getResult ();
			
			// storing result into an array
			logDebug('array size is::'.sizeof ( $result ));
			
			if (!empty($result) && (sizeof ( $result ) == 1)) {
				
				foreach ( $result as $data ) {
					if ($data ['imageType'] == 'profile') {
						$imageData ['profile'] = $data ['imagePath'];
						$imageData ['profile_image_id'] = $data ['imageId'];
					}
					
				}
			}
			
			return $imageData;
			
		} catch ( Exception $e ) {
			logException('Error in getVenueImageData->' . $e->getMessage () );
			return false;
		}
	}
	
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
			log_message ( 'error', 'Error in updating user image.->' . $e->getMessage () );
			return false;
		}
		
	}
	
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
						
						$imageData ['user_image'] = base_url().$this->config->item ( 'ar_img_upload_path' ).$data ['imagePath'];
						$imageData ['profile_image_id'] = $data ['imageId'];
					
				}
			}
			
			return $imageData;
			
		} catch ( Exception $e ) {
			echo 'Error in updating profile image.';
			log_message ( 'error', 'Error in getUserProfileImageData->' . $e->getMessage () );
			return $imageData;
		}
	}
	
	public function getVenueGalleryImagesData($user_id) {
		
		logException('Inside getVenueGalleryImagesData');
		
		$this->em = $this->doctrine->em;
		$userGalleryImageData = array();
		
		try {
			if($user_id > 0){
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageName, u.imageDescription FROM \ArVenueGalleryImages u join u.user p 
					WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
			$query->setParameter ( 1, $user_id );
			$result = $query->getResult ();
			$temparray = array ();
			$count = 0;
			
			if (($result != null) && (sizeof ( $result ) >= 1)) {
				foreach ( $result as $imagedata ) {
					
					$temparray ['image_id'] = $imagedata ['imageId'];
					$temparray ['image_path'] = base_url().$this->config->item ('ar_venue_gallery_img_upload_path').$imagedata ['imageName'];
					$temparray ['image_description'] = $imagedata ['imageDescription'];
					
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
			log_message ( 'error', 'Error in getting user gallery images->' . $e->getMessage () );
			return null;
		}
		
		return $userGalleryImageData;
		
	}
	
	public function getVenueGalleryVideosData($user_id) {
	
		logDebug('Inside getVenueGalleryVideosData');
		
		$this->em = $this->doctrine->em;
		$venueGalleryVideoData = array();
	
		try {
			if($user_id > 0){
				
				$query = $this->em->createQuery ( 'SELECT  u.videoId, u.videoUrl, u.videoDescription, u.youtubeVideoId, u.uploadDate FROM \ArVenueGalleryVideos u join u.user p WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
				$query->setParameter ( 1, $user_id );
				$result = $query->getResult ();
				$temparray = array ();
				$count = 0;
				
					
				if (($result != null) && (sizeof( $result ) >= 1)) {
					
					foreach ( $result as $videodata ) {
						$temparray ['video_id'] = $videodata ['videoId'];
						$temparray ['video_url'] = $videodata ['videoUrl'];
						$temparray ['video_description'] = $videodata ['videoDescription'];
						$temparray ['youtube_video_id'] = $videodata ['youtubeVideoId'];
						
						$venueGalleryVideoData [$count] = $temparray;
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
			log_message ( 'error', 'Error in getting user gallery videos->' . $e->getMessage () );
			return null;
		}
	
		return $venueGalleryVideoData;
	
	}
	
	public function getArtistRating($user_id) {
	
	$this->em = $this->doctrine->em;
	
		$ratingData = array (
				'rating' => '',
				'num_votes' => ''
		);
	
		try {
			
			$query = $this->em->createQuery ( 'SELECT  u.rating, u.numVotes FROM \ArArtistRating u join u.user p WHERE p.id = ?1' );
			$query->setParameter ( 1, $user_id );
	
			$result = $query->getResult ();
	
			// storing result into an array
	
			if (($result != null) && (sizeof ( $result ) == 1)) {
	
				foreach ( $result as $data ) {
	
					$ratingData ['rating'] = $data ['rating'];
					$ratingData ['num_votes'] = $data ['numVotes'];
					
				}
			}
	
			return $ratingData;
				
		} catch ( Exception $e ) {
			//echo 'Error in getting cover image.';
			log_message ( 'error', 'Error in getting user cover image->' . $e->getMessage () );
			return false;
		}
	
	}
}
