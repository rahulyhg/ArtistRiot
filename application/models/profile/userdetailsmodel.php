<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// use Entities\ArArtistCategory;

require_once (APPPATH . "models/Entities/ArUsers.php");
require_once (APPPATH . "models/Entities/ArArtistCategory.php");
require_once (APPPATH . "models/Entities/ArArtistSubCategory.php");
require_once (APPPATH . "models/Entities/ArUserProfile.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArUserGalleryImages.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");
require_once (APPPATH . "models/Entities/ArArtistRating.php");
require_once (APPPATH . "models/Entities/ArArtistReview.php");


use \ArArtistCategory;
use \ArArtistSubCategory;
use Doctrine\ORM\Query as Query;

class UserDetailsModel extends CI_Model {
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
	public function get_sub_categories() {
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
		
		return json_encode ( $subCategoryArray );
	}
	
	
	public function getUserCoverImageData($user_id, $imageType) {
	
		$this->em = $this->doctrine->em;
	
		$imageData = array (
				'cover_image_id' => '',
				'cover_image' => '',
				'image_position' => '0'
		);
	
		try {
	
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imagePath, u.position FROM \ArUserProfilePicture 
					u join u.user p WHERE p.id = ?1 and u.isActive=1 and u.imageType=?2' );
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
			logException('Error in getting user cover image->' . $e->getMessage () );
			return false;
		}
	}
	
	
	/** Function to get user profile data.
	 * @param unknown $user_id
	 * @return multitype:string unknown NULL Ambigous <NULL, Ambigous> Ambigous <string, string, unknown> |boolean|NULL
	 */
	public function getUserProfileData($user_id) {
		
		logDebug('Inside getUserProfileData for user_id::'.$user_id);
		
		$this->em = $this->doctrine->em;
		$profileData = null;
		$userGalleryVideoData = array();
		$userGalleryImageData = array();
		
		try {
			
			$userData = $this->em->find ( '\ArUsers', $user_id );
			
			// Get user profile data
			
			$query = $this->em->createQuery ( 'SELECT  u FROM \ArUserProfile u join u.user p join u.category c join u.subCategory s WHERE p.id = ?1' );
			$query->setParameter ( 1, $user_id );
			$result = $query->getResult ();
			
			if (($result != null) && (sizeof ( $result ) == 1)) {
				
				$profileData = $result [0];
				
				$profileImageData = $this->getUserImageData ( $user_id );
				
				// Getting category and sub category objects
				// Getting category and sub category objects
				
				$categoryId = $profileData->getCategory()->getCategoryId();
				$subCategoryId = $profileData->getSubCategory()->getSubCategoryId();
				
				$categoryData = $profileData->getCategory();
				$subCategoryData = $profileData->getSubCategory();
				
				//Getting social links:
				$facebookLink = (!empty($profileData->getFacebookPageUrl())) ? ($profileData->getFacebookPageUrl()) : '';
				$twitterLink = (!empty($profileData->getTwitterPageUrl())) ? ($profileData->getTwitterPageUrl()) : '';
				$description = (!empty($profileData->getUserDescription())) ? ($profileData->getUserDescription()) : '';
				
				//$categoryData = $this->em->find ( '\ArArtistCategory', $categoryId );
				//$subCategoryData = $this->em->find ( '\ArArtistSubCategory', $subCategoryId );
				
				$userGalleryImageCount = $this->getCountOfUserGalleryImages($user_id);
				$userGalleryVideoCount = $this->getCountOfUserGalleryVideos($user_id);
				
				//Getting user cover image
				$userCoverImage = $profileImageData ['cover'];
				if(!empty($profileImageData ['cover'])){
					$userCoverImage = base_url() . $this->config->item('ar_img_upload_path') . $profileImageData ['cover'];
				}
				
				//Getting user profile image
				$userProfileImage = $profileImageData ['profile']; 
				if(!empty($profileImageData ['profile'])){
					$userProfileImage = base_url() . $this->config->item('ar_img_upload_path') . $profileImageData ['profile'];
				}
				
				//Get artist rating
				$ratingData = $this->getArtistRating($user_id);
				
				$rating = empty($ratingData['rating'])?'0':$ratingData['rating'];
				
				logDebug('User rating is::'. $rating);
				
				
				$userProfileData = array (
						'first_name' => $userData->getFirstName(),
						'last_name' => $userData->getLastName(),
						'role' => $userData->getRole(),
						'email' => $userData->getEmail(),
						'phone' => $userData->getPhone(),
						'fb_link' => $facebookLink,
						'twitter_link' => $twitterLink,
						'category_id' => $categoryId,
						'sub_category_id' => $subCategoryId,
						'user_image' => $userProfileImage,
						'user_cover_image' => $userCoverImage,
						'profile_image_id' => $profileImageData ['profile_image_id'],
						'cover_image_id' => $profileImageData ['cover_image_id'],
						'image_position' => $profileImageData ['image_position'],
						'category_name' => $categoryData->getCategoryName(),
						'sub_category_name' => $subCategoryData->getSubCategoryName(),
						'user_gallery_images' => $userGalleryImageCount,
						'user_gallery_videos' =>  $userGalleryVideoCount,
						'rating' => $rating,
						'description' => $description
				);
				
				return $userProfileData;
			} else {
				log_message ( 'error', 'Error in getting user profile for user id' . $user_id );
				return false;
			}
		} catch ( Exception $e ) {
			logException('Error in creating user profile->' . $e->getMessage () );
			return null;
		}
	}
	
	
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
			
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageType, u.imagePath, u.position, p.id 
					FROM \ArUserProfilePicture u join u.user p WHERE p.id = ?1 and u.isActive=1' );
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
			echo 'inside catch';
			logException('Error in creating user profile->' . $e->getMessage () );
			return $imageData;
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
			logException('Error in updating user image.->' . $e->getMessage () );
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
				
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imagePath FROM \ArUserProfilePicture u join u.user p 
					WHERE p.id = ?1 and u.isActive=1 and u.imageType=?2' );
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
			logException('Error in creating user profile->' . $e->getMessage () );
			return $imageData;
		}
	}
	
	public function getUserGalleryImagesData($user_id, $offset, $limit) {
		
		$this->em = $this->doctrine->em;
		$userGalleryImageData = array();
		
		try {
			if($user_id > 0){
			$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageName, u.imageDescription FROM \ArUserGalleryImages u join u.user p WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
			$query->setParameter ( 1, $user_id );
			$query->setMaxResults($limit);
			$query->setFirstResult($offset);
			$result = $query->getResult ();
			$temparray = array ();
			$count = 0;
			
			if (($result != null) && (sizeof ( $result ) > 0)) {
				foreach ( $result as $imagedata ) {
					
					$temparray ['image_id'] = $imagedata ['imageId'];
					$temparray ['image_path'] = base_url().$this->config->item ('ar_gallery_img_upload_path').$imagedata ['imageName'];
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
			logException('Error in getting user gallery images->' . $e->getMessage () );
			return null;
		}
		
		return $userGalleryImageData;
		
	}
	
	
	/** Method to get count of total images of user. This is to use this method for pagination.
	 * @param unknown $user_id
	 * @return NULL|Ambigous <number, unknown>
	 */
	public function getCountOfUserGalleryImages($user_id) {
	
		logDebug('Inside getCountOfUserGalleryImages()');
		
		$this->em = $this->doctrine->em;
		$imagesCount = 0;
	
		try {
			if($user_id > 0){
				$query = $this->em->createQuery ( 'SELECT  count(u.imageId) as userImagesCount 
						FROM \ArUserGalleryImages u join u.user p WHERE p.id = ?1 GROUP BY p.id' );
				$query->setParameter ( 1, $user_id );
				$result = $query->getResult ();
				
				if (($result != null) && (sizeof ( $result ) == 1)) {
					foreach ( $result as $imagedata ) {
						$imagesCount = $imagedata ['userImagesCount'];
					}
				}
				else{
					return 0;
				}
			}
			else{
				return null;
			}
		} catch ( Exception $e ) {
			logException('Error in getting count of user gallery images->' . $e->getMessage () );
			return null;
		}
		
		logException('Images count is::'.$imagesCount);
		return $imagesCount;
	
	}
	
	/** Method to get count of total videos of user. This is to use this method for pagination.
	 * @param unknown $user_id
	 * @return NULL|Ambigous <number, unknown>
	 */
	public function getCountOfUserGalleryVideos($user_id) {
	
		logDebug('Inside getCountOfUserGalleryVideos()');
	
		$this->em = $this->doctrine->em;
		$videosCount = 0;
	
		try {
			if($user_id > 0){
				$query = $this->em->createQuery ( 'SELECT  count(u.videoId) as userVideosCount
						FROM \ArUserGalleryVideos u join u.user p WHERE p.id = ?1 GROUP BY p.id' );
				$query->setParameter ( 1, $user_id );
				
				$result = $query->getResult ();
	
				if (($result != null) && (sizeof ( $result ) == 1)) {
					foreach ( $result as $videodata ) {
						$videosCount = $videodata ['userVideosCount'];
					}
				}
				else{
					return 0;
				}
			}
			else{
				return null;
			}
		} catch ( Exception $e ) {
			logException ('Error in getting count of user gallery videos->' . $e->getMessage () );
			return null;
		}
	
		logException('Videos count is::'.$videosCount);
		return $videosCount;
	
	}
	
	public function getUserGalleryVideosData($user_id, $offset, $limit) {
	
		$this->em = $this->doctrine->em;
		$userGalleryVideoData = array();
	
		try {
			if($user_id > 0){
				
				$query = $this->em->createQuery ( 'SELECT  u.videoId, u.videoUrl, u.videoDescription, u.youtubeVideoId, u.uploadDate FROM \ArUserGalleryVideos u join u.user p WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
				$query->setParameter ( 1, $user_id );
				$query->setMaxResults($limit);
				$query->setFirstResult($offset);
				$result = $query->getResult ();
				$temparray = array ();
				$count = 0;
				
					
				if (($result != null) && (sizeof ( $result ) > 0)) {
					foreach ( $result as $videodata ) {
							
						$temparray ['video_id'] = $videodata ['videoId'];
						$temparray ['video_url'] = $videodata ['videoUrl'];
						$temparray ['video_description'] = $videodata ['videoDescription'];
						$temparray ['youtube_video_id'] = $videodata ['youtubeVideoId'];
						
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
			logException('Error in getting user gallery videos->' . $e->getMessage () );
			return null;
		}
	
		return $userGalleryVideoData;
	
	}
	
	/**Method to get user's rating
	 * @param unknown $user_id
	 * @return multitype:string unknown |boolean
	 */
	public function getArtistRating($user_id) {
	
		logException('Inside getArtistRating for the user::'.$user_id);
		$this->em = $this->doctrine->em;
	
		$ratingData = array (
				'rating' => '',
				'num_votes' => ''
		);
	
		try {
			
			$query = $this->em->createQuery ( 'SELECT  u.rating, u.numVotes FROM \ArArtistRating u join u.artist p WHERE p.id = ?1' );
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
			logException('Error in getting user rating->' . $e->getMessage () );
			return false;
		}
	
	}
	
	/** Method to get user id from profile url.
	 * @param unknown $userName
	 * @return boolean
	 */
	public function getUserIdFromUserName($userName){
		
		logDebug('Inside getUserIdFromUserName()');
		logDebug('Parameters are:: $userName='.$userName);
		$user_id = '';
		
		if(empty($userName)){
			return '';
		}
		
		try{
			$this->em = $this->doctrine->em;
			$query = $this->em->createQuery ( 'SELECT u.id FROM \ArUsers u WHERE u.username = ?1' );
			$query->setParameter ( 1, $userName );
			$query->useQueryCache(true);
			$result = $query->getResult ();
			
			if (!empty($result) && (sizeof ( $result ) == 1)) {
				foreach ( $result as $data ) {
					$user_id = $data ['id'];
				}
			}
			else{
				logException('$userName is empty.');
			}
			
		}
		catch(Exception $e){
			logException('Error in getting username::'.$e->getMessage());
		}
		
		return $user_id;
	}
	
	public function getArtistRecentGalleryImagesData($user_id, $limit) {
	
		$this->em = $this->doctrine->em;
		$userGalleryImageData = array();
	
		try {
			if($user_id > 0){
				$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageName, u.imageDescription FROM \ArUserGalleryImages u join u.user p WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
				$query->setParameter ( 1, $user_id );
				$query->setMaxResults($limit);
				$query->setFirstResult(0);
				$result = $query->getResult ();
				$temparray = array ();
				$count = 0;
					
				if (($result != null) && (sizeof ( $result ) > 0)) {
					foreach ( $result as $imagedata ) {
							
						$temparray ['image_id'] = $imagedata ['imageId'];
						$temparray ['image_path'] = base_url().$this->config->item ('ar_gallery_img_upload_path').$imagedata ['imageName'];
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
			logException('Error in getting user gallery images->' . $e->getMessage () );
			return null;
		}
	
		return $userGalleryImageData;
	
	}
	
	
	public function getArtistRecentGalleryVideosData($user_id, $limit) {
	
		$this->em = $this->doctrine->em;
		$userGalleryVideoData = array();
	
		try {
			if($user_id > 0){
				
				$query = $this->em->createQuery ( 'SELECT  u.videoId, u.videoUrl, u.videoDescription, u.youtubeVideoId, u.uploadDate FROM \ArUserGalleryVideos u join u.user p WHERE p.id = ?1 ORDER BY u.uploadDate DESC' );
				$query->setParameter ( 1, $user_id );
				$query->setMaxResults($limit);
				$query->setFirstResult(0);
				$result = $query->getResult ();
				$temparray = array ();
				$count = 0;
				
					
				if (($result != null) && (sizeof ( $result ) >= 1)) {
					foreach ( $result as $videodata ) {
							
						$temparray ['video_id'] = $videodata ['videoId'];
						$temparray ['video_url'] = $videodata ['videoUrl'];
						$temparray ['video_description'] = $videodata ['videoDescription'];
						$temparray ['youtube_video_id'] = $videodata ['youtubeVideoId'];
						
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
			logException('Error in getting user gallery videos->' . $e->getMessage () );
			return null;
		}
	
		return $userGalleryVideoData;
	
	}
	
	
	/** Method to get user review.
	 * @param unknown $user_id
	 * @return string|Ambigous <string, unknown>
	 */
	public function getUserReviewData($user_id){
	
		logException('Inside getUserReview()');
		logException('Parameters are:: $user_id='.$user_id);
		
		$userReviewData = array();
		
		if(empty($user_id)){
			return null;
		}
	
		try{
			$this->em = $this->doctrine->em;
			$query = $this->em->createQuery ( 'SELECT u.review, u.reviewDate, u.reviewerName, u.reviewTitle 
					FROM \ArArtistReview u join u.artist p WHERE p.id = ?1 ORDER BY u.reviewDate DESC' );
			$query->setParameter ( 1, $user_id);
			$query->setMaxResults(5);
			$query->setFirstResult(0);
			$result = $query->getResult ();
			$temparray = array ();
			$count = 0;
				
			logException('Size of review result is::'. sizeof ( $result ));
				
			if (($result != null) && (sizeof ( $result ) >= 1)) {
				foreach ( $result as $reviewdata ) {
							
					$temparray ['review'] = $reviewdata ['review'];
					$temparray ['review_date'] = $reviewdata ['reviewDate'];
					$temparray ['reviewer_name'] = $reviewdata ['reviewerName'];
					$temparray ['review_title'] = $reviewdata ['reviewTitle'];
						
					$userReviewData [$count] = $temparray;
					$count ++;
					}
				}
			else{
				logException('Artist review is empty.');
			}
				
		}
		catch(Exception $e){
			logException('Error in getting artist review::'.$e->getMessage());
		}
	
		return $userReviewData;
	}
	
}

