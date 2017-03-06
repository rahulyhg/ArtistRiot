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


use Doctrine\ORM\Query as Query;

/**
 * Model to update user profile.
 *
 */
class UpdateProfileModel extends CI_Model {
	var $em;

	/**Method to delete Gallery Image
	 * @param unknown $user_id
	 * @param unknown $image_id
	 * @return boolean|Ambigous <NULL, unknown>
	 */
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('utils/imagemodel','imagemodel');
		
	}
	
	
	public function deleteGalleryImage($user_id, $image_id) {
	
		log_message ('debug', 'Input parameters: $user_id:' . $user_id . ' and $image_id:'.$image_id);
		
		$this->em = $this->doctrine->em;
		$userImageData= null;
		$imageName = null;
	
		try{
			if( $image_id > 0 ){
			
				$query = $this->em->createQuery ( 'SELECT  u.imageId, u.imageName FROM \ArUserGalleryImages u join u.user p WHERE p.id = ?1 and u.imageId=?2' );
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
				$query = $this->em->createQuery ( 'DELETE \ArUserGalleryImages u WHERE u.imageId = ?1' );
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
	
	/**Method to delete Gallery Video
	 * @param unknown $user_id
	 * @param unknown $video_id
	 * @return boolean|Ambigous <NULL, unknown>
	 */
	public function deleteGalleryVideo($user_id, $video_id) {
	
		log_message ('debug', 'Input parameters: $user_id:' . $user_id . ' and $$video_id:'.$video_id);
	
		$this->em = $this->doctrine->em;
	
		try{
			if( $video_id > 0 ){
	
				//Now deleting video
				$query = $this->em->createQuery ( 'DELETE \ArUserGalleryVideos u WHERE u.videoId = ?1' );
				$query->setParameter ( 1, $video_id );
				$result = $query->execute();
	
				log_message ('debug', 'Result after gallery video delete is: ->' . $result);
	
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
			log_message ('error', 'Error in deleting gallery video. Error is ->' . $e->getMessage () );
			return false;
		}
	
	}
	
	/**
	 * @param unknown $user_id
	 * @param unknown $userimagename
	 * @param unknown $imageType
	 * @param unknown $existing_cover_image_id
	 * @param unknown $imageTop
	 * @return Ambigous <multitype:string , boolean, multitype:string unknown >|boolean
	 */
	public function deleteArtistCoverImage($user_id, $cover_image_id){
	
		$this->em = $this->doctrine->em;
		$coverImageData= null;
		$coverImageName = null;
		$deletedDirPath = $this->config->item('ar_profile_img_delete_path');
	
		try {
				
			// Set any existing active cover images as inactive.
			
			if(empty($cover_image_id) && $cover_image_id <= 0){
				logException('Empty cover image id received.');
				return false;	
			}
			
			
			$coverImageData = $this->em->find ( '\ArUserProfilePicture', $cover_image_id);
				
			if(!empty($coverImageData)){
				
				$coverImageName = $coverImageData->getImagePath();
				$coverImageData->setIsActive(0);

				//Move cover image to deleted folder
				$originalImagePath = $this->config->item('ar_img_upload_path').$coverImageName;
				$targetImagePath = $this->config->item('ar_profile_img_delete_path').$coverImageName;
				
				if($this->imagemodel->moveImage($originalImagePath, $targetImagePath)){
					$this->em->persist ( $coverImageData );
					$this->em->flush ();
				}
					
			}
				
		} catch ( Exception $e ) {
			logException( 'Error in creating user profile->' . $e->getMessage () );
			return false;
		}
	
		return true;
	
	}
	
}
