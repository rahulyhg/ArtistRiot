<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require_once (APPPATH . "models/Entities/ArUsers.php");
require_once (APPPATH . "models/Entities/ArArtistCategory.php");
require_once (APPPATH . "models/Entities/ArArtistSubCategory.php");
require_once (APPPATH . "models/Entities/ArUserProfile.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArVenueGalleryImages.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");
require_once (APPPATH . "models/Entities/ArArtistReview.php");
require_once (APPPATH . "models/Entities/ArArtistRating.php");
require_once (APPPATH . "models/Entities/ArVenueGalleryVideos.php");

use Doctrine\ORM\Query as Query;

class VenueProfileModel extends CI_Model {
	
	var $em;
	
	
	public function addVenueGalleryImage($user_id, $userimagename, $imageDescription){
	
		$this->em = $this->doctrine->em;
		$result = true;
		$imageData = array();
		try {
				$userData = $this->em->find ('\ArUsers', $user_id );
				
				if(empty($userData)){
					return false;
				}
	
				$userImageData = new ArVenueGalleryImages();
				$userImageData->setUser( $userData );
				$userImageData->setImageName( $userimagename );
				$userImageData->setImageDescription($imageDescription);
					
				//get current time in seconds after 1/1/1970
				$time = time();
				$userImageData->setUploadDate($time);
	
				$this->em->persist( $userImageData );
				$this->em->flush();
					
				$imageId = $userImageData->getImageId();
					
				if(!is_null($imageId) && ($imageId > 0)){
						
					$imageData['image_name'] = $userimagename;
					$imageData['image_id'] = $imageId;
					$imageData['image_description'] = $imageDescription;
				}
				
		} catch ( Exception $e ) {
			logException ('Error in creating user profile->' . $e->getMessage () );
		}
	
		return $imageData;
	
	}
	
	/**Method to delete Gallery Image
	 * @param unknown $user_id
	 * @param unknown $image_id
	 * @return boolean|Ambigous <NULL, unknown>
	 */
	public function deleteVenueGalleryImage($user_id, $image_id) {
	
		logDebug('Input parameters: $user_id:' . $user_id . ' and $image_id:'.$image_id);
	
		$this->em = $this->doctrine->em;
		$userImageData= null;
		$imageName = null;
	
		try{
			if( $image_id > 0 ){
					
				$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageName FROM \ArVenueGalleryImages u join u.user p WHERE p.id = ?1 and u.imageId=?2' );
				$query->setParameter ( 1, $user_id );
				$query->setParameter ( 2, $image_id );
					
				$result = $query->getResult ();
	
				//Getting Image Name
				if (($result != null) && (sizeof ( $result ) == 1)) {
					foreach ( $result as $data ) {
						$imageName = $data ['imageName'];
					}
				}
				else{
					return false;
				}
	
				//Now deleting image
				$query = $this->em->createQuery ( 'DELETE \ArVenueGalleryImages u WHERE u.imageId = ?1' );
				$query->setParameter ( 1, $image_id );
				$result = $query->execute();
	
				log_message ('debug', 'Result after gallery image delete is: ->' . $result);
	
				if($result == 1){
					return $imageName;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		catch(Exception $e){
			log_message ('error', 'Error in deleting gallery image. Error is ->' . $e->getMessage () );
			return false;
		}
	
	}
	
	
	/**
	 * @param unknown $user_id
	 * @param unknown $videourl
	 * @param unknown $videoDescription
	 * @param unknown $youtubeVideoId
	 * @return multitype:unknown number |boolean
	 */
	public function addVenueGalleryVideo($user_id, $videourl, $videoDescription, $youtubeVideoId){
	
		$this->em = $this->doctrine->em;
		$result = true;
		$videoData = array ();
		try {
			$userData = $this->em->find ( '\ArUsers', $user_id );
	
			if ($userData != null) {
				$venueVideoData = new ArVenueGalleryVideos();
				$venueVideoData->setUser( $userData );
				$venueVideoData->setVideoUrl( $videourl );
				$venueVideoData->setVideoDescription($videoDescription);
				$venueVideoData->setYoutubeVideoId($youtubeVideoId);
	
				//get current time in seconds after 1/1/1970
				$time = time();
				$venueVideoData->setUploadDate($time);
	
				$this->em->persist ($venueVideoData);
				$this->em->flush ();
					
				$videoId = $venueVideoData->getVideoId();
					
				if(!is_null($videoId) && ($videoId > 0)){
					logException('$videourl::'.$videourl);
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
	
	/**Method to delete Gallery Video
	 * @param unknown $user_id
	 * @param unknown $video_id
	 * @return boolean|Ambigous <NULL, unknown>
	 */
	public function deleteVenueGalleryVideo($user_id, $video_id) {
	
		logDebug('Input parameters: $user_id:' . $user_id . ' and $video_id:'.$video_id);
	
		$this->em = $this->doctrine->em;
	
		try{
			if( $video_id > 0 ){
	
				//Now deleting video
				$query = $this->em->createQuery ( 'DELETE \ArVenueGalleryVideos u WHERE u.videoId = ?1' );
				$query->setParameter ( 1, $video_id );
				$result = $query->execute();
	
				logDebug('Result after gallery video delete is: ->' . $result);
	
				if($result == 1){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		catch(Exception $e){
			logException('Error in deleting gallery video. Error is ->' . $e->getMessage () );
			return false;
		}
	
	}
	
}