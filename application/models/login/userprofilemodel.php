<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require_once (APPPATH . "models/Entities/ArUsers.php");
require_once (APPPATH . "models/Entities/ArArtistCategory.php");
require_once (APPPATH . "models/Entities/ArArtistSubCategory.php");
require_once (APPPATH . "models/Entities/ArUserProfile.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArUserGalleryImages.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");
require_once (APPPATH . "models/Entities/ArArtistReview.php");
require_once (APPPATH . "models/Entities/ArArtistRating.php");


use Doctrine\ORM\Query as Query;

class UserProfileModel extends CI_Model {
	
	var $em;
	
	
	public function addUserGalleryImage($user_id, $userimagename, $imageDescription){
	
		$this->em = $this->doctrine->em;
		$result = true;
		$imageData = array ();
		try {
				$userData = $this->em->find ('\ArUsers', $user_id );
	
				if ($userData != null) {
					$userImageData = new ArUserGalleryImages();
					$userImageData->setUser( $userData );
					$userImageData->setImageName( $userimagename );
					$userImageData->setImageDescription($imageDescription);
					
					//get current time in seconds after 1/1/1970
					$time = time();
					$userImageData->setUploadDate($time);
	
					$this->em->persist ( $userImageData );
					$this->em->flush ();
					
					$imageId = $userImageData->getImageId();
					
					if(!is_null($imageId) && ($imageId > 0)){
						
						$imageData['image_name'] = $userimagename;
						$imageData['image_id'] = $imageId;
						$imageData['image_description'] = $imageDescription;
						
						return $imageData;
						
					}
					
					return false;
					
				}
				else
					return false;
				
				
		} catch ( Exception $e ) {
			logException ('Error in creating user profile->' . $e->getMessage () );
			return false;
		}
	
		return false;
	
	}
	
	public function addUserGalleryVideo($user_id, $videourl, $videoDescription, $youtubeVideoId){
	
		$this->em = $this->doctrine->em;
		$result = true;
		$videoData = array ();
		try {
			$userData = $this->em->find ( '\ArUsers', $user_id );
	
			if ($userData != null) {
				$userVideoData = new ArUserGalleryVideos();
				$userVideoData->setUser( $userData );
				$userVideoData->setVideoUrl( $videourl );
				$userVideoData->setVideoDescription($videoDescription);
				$userVideoData->setYoutubeVideoId($youtubeVideoId);
				
				//get current time in seconds after 1/1/1970
				$time = time();
				$userVideoData->setUploadDate($time);
	
				$this->em->persist ($userVideoData);
				$this->em->flush ();
					
				$videoId = $userVideoData->getVideoId();
					
				if(!is_null($videoId) && ($videoId > 0)){
	
					$videoData['video_url'] = $videourl;
					$videoData['video_id'] = $videoId;
					$videoData['video_description'] = $videoDescription;
					$videoData['youtube_video_id'] = $youtubeVideoId;
					return $videoData;
	
				}
					
				return false;
					
			}
			else
				return false;
	
		} catch ( Exception $e ) {
			logException ('Error in uploading video->' . $e->getMessage () );
			return false;
		}
	
		return false;
	
	}
	
	
	/** Method to add rating to the artist
	 * @param unknown $reviewData
	 * @return boolean|unknown
	 */
	public function addArtistReview($reviewData){
	
		logDebug('Inside addArtistReview');
		
		$this->em = $this->doctrine->em;
		
		$artist_id = $reviewData['artist_id'];
		$email = $reviewData['email'];
		$reviewerName = $reviewData['reviewername'];
		$reviewTitle = $reviewData['reviewtitle'];
		$review = $reviewData['review'];
		$rating = $reviewData['rating'];
		
		try {
			$userData = $this->em->find ( '\ArUsers', $artist_id );
			
			if(empty($userData)){
				return false;
			}
			
			//User data is not empty
			
			$userReviewData = new ArArtistReview();
			$userReviewData->setArtist($userData);
			$userReviewData->setEmail($email);
			$userReviewData->setReview($review);
			$userReviewData->setReviewerName($reviewerName);
			$userReviewData->setReviewTitle($reviewTitle);
			$userReviewData->setRating($rating);
				
			//get current time in seconds after 1/1/1970
			$time = time();
			$userReviewData->setReviewDate($time);
	
			$this->em->persist ($userReviewData);
			$this->em->flush ();
					
			$reviewId = $userReviewData->getReviewId();
				
			if(!is_null($reviewId) && ($reviewId > 0)){
					
				//Modify average rating of artist
				
				if($this->modifyAverageRating($userData, $rating)){
					
				}
				$resultData['review_id'] = $reviewId;
				$resultData['review'] = $review;
				return $resultData;
			}
					
				return false;
					
			
			
		} catch (Exception $e ) {
			logException('Error in artist review->' . $e->getMessage () );
			return false;
		}
	
		return false;
	
	}
	
	/** Function to modify average rating of artist
	 * @param unknown $userData
	 * @param unknown $rating
	 */
	
	private function modifyAverageRating($userData, $rating){
		
		logDebug('Inside modifyAverageRating');
		
		$this->em = $this->doctrine->em;
		
		if(empty($userData) || empty($rating)){
			return false;
		}
		
		try{
			
			//Check if artist rating is already present
			$user_id = $userData->getId();
			$artistRating = null;
			
			logException('user id is:'.$user_id);
			$query = $this->em->createQuery('SELECT r FROM \ArArtistRating r join r.artist p WHERE p.id = ?1' );
			$query->setParameter ( 1, $user_id );
			$result = $query->getResult();
			
			logException('after result');
			if(!empty($result) && (sizeof ( $result ) == 1)) {
				$artistRating = $result[0];
			}
			
			if(!empty($artistRating)){
				logDebug('Adding avg rating for existing user. Rating id is::'. $artistRating->getRatingId());
				
				//Adding avg rating for existing user.
				$existingRating = $artistRating->getRating();
				$num_votes = $artistRating->getNumVotes();
				$newAvgRating = (($existingRating*$num_votes) + $rating) / ($num_votes + 1);
				$num_votes = $num_votes + 1;
				
				//Updating artist avg rating
				$artistRating->setRating($newAvgRating);
				$artistRating->setNumVotes($num_votes);
				
				$this->em->persist($artistRating);
				$this->em->flush ();
			
			}
			
			else{
				//No record found for artist. Insert new record
				
				logException('No record found for artist. Insert new record');
				$artistRating = new ArArtistRating();
				
				$artistRating->setArtist($userData);
				$artistRating->setRating($rating);
				$artistRating->setNumVotes(1);
				
				$this->em->persist($artistRating);
				$this->em->flush ();
				
			}
			
			return true;
			
		}
		catch (Exception $e ) {
			logException('Error in artist review->' . $e->getMessage () );
			return false;
		}
		
	}
	
}