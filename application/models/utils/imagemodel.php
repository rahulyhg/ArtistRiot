<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class ImageModel extends CI_Model {
	
	/** Function to resize profile image
	 * @param unknown $imagePath
	 * @return boolean
	 */
	function resizeProfileImage($imagePath){
	
		logDebug('Inside resizeProfileImage');
		//Get original image dimensions:
	
		list($originalWidth, $originalHeight) = getimagesize($imagePath);
		log_message('error', 'Image original height is: '.$originalHeight.', width is: '.$originalWidth);
	
		//Image ratio
		$originalImageRatio = $originalWidth / $originalHeight;
		
		/*if($originalWidth > $originalHeight){
			$newHeight = (300/$originalWidth) * $originalHeight;
			$newWidth = 300;
		}
		else{
			$newWidth = (300/$originalHeight) * $originalWidth;
			$newHeight = 300;
		}*/
	
		if(empty($originalImageRatio)){
			return false;
		}
		//Since width is fixed,calculating image height based on image ratio.
		$newWidth = $this->config->item('ar_img_resize_width');
		$newHeight =  $newWidth / $originalImageRatio;
	
		//Setting profile image resize config values
		$config['image_library'] = $this->config->item('ar_img_image_library');
		$config['source_image']	= $imagePath;
		$config['create_thumb'] = $this->config->item('ar_img_create_thumb');
		$config['maintain_ratio'] = $this->config->item('ar_img_maintain_ratio');
		$config['width']	= $newWidth;
		$config['height']	= $newHeight;
		$config['quality'] =  $this->config->item('ar_img_resize_quality');
	
		$this->image_lib->initialize($config);
	
		if($this->image_lib->resize()){
			return true;
		}
		else{
			$error = $this->image_lib->display_errors();
			log_message ( 'error', 'Profile image resize failed. Error is: '. $error);
			return false;
		}
	
	}
	
	/** Method to resize Cover image.
	 * @param unknown $imagePath
	 * @return boolean
	 */
	function resizeCoverImage($imagePath){
	
		logDebug('Inside resizeCoverImage');
		//Get original image dimensions:
	try{
		list($originalWidth, $originalHeight) = getimagesize($imagePath);
		logException('Image original height is: '.$originalHeight.', width is: '.$originalWidth);
		
		//Image ratio
		$originalImageRatio = $originalWidth / $originalHeight;
		
		
		if(empty($originalImageRatio)){
			return false;
		}
		//Since width is fixed,calculating image height based on image ratio.
		$newWidth = $this->config->item('ar_cover_img_resize_width');
		$newHeight =  $newWidth / $originalImageRatio;
		
		//Setting profile image resize config values
		$config['image_library'] = $this->config->item('ar_img_image_library');
		$config['source_image']	= $imagePath;
		$config['create_thumb'] = $this->config->item('ar_img_create_thumb');
		$config['maintain_ratio'] = $this->config->item('ar_img_maintain_ratio');
		$config['width']	= $newWidth;
		$config['height']	= $newHeight;
		$config['quality'] =  $this->config->item('ar_img_resize_quality');
		
		$this->image_lib->initialize($config);
		
		if($this->image_lib->resize()){
			return true;
		}
		else{
			$error = $this->image_lib->display_errors();
			logException('Cover image resize failed. Error is: '. $error);
			return false;
		}
	}
	catch(Exception $e){
		logException('Cover image resize failed. Error is: '. $e);
	}
		
	
	}
	
	/**
	 * @param unknown $imageName
	 * @return unknown
	 */
	function getProfileImageUploadConfig($imageName){
	
		$config['upload_path'] = $this->config->item('ar_img_upload_path');
		$config['allowed_types'] = $this->config->item('ar_img_allowed_types');
		$config['max_size']	= $this->config->item('ar_img_max_size');
		//$config['max_width']  = $this->config->item('ar_img_max_width');
		$config['overwrite'] = $this->config->item('ar_img_overwrite');
		$config['remove_spaces'] = $this->config->item('ar_img_remove_spaces');
		$config['file_name'] = $imageName;
	
		return $config;
	}
	
	/**Method to get config values for Cover image upload.
	 * @param unknown $imageName
	 * @return unknown
	 */
	function getCoverImageUploadConfig($imageName){
	
		$config['upload_path'] = $this->config->item('ar_img_temp_upload_path');
		$config['allowed_types'] = $this->config->item('ar_img_allowed_types');
		$config['max_size']	= $this->config->item('ar_img_max_size');
		//$config['max_width']  = $this->config->item('ar_img_max_width');
		$config['overwrite'] = $this->config->item('ar_img_overwrite');
		$config['remove_spaces'] = $this->config->item('ar_img_remove_spaces');
		$config['file_name'] = $imageName;
	
		return $config;
	}
	
	
	/**Method to get config values for Venue gallery image upload.
	 * @param unknown $imageName
	 * @return unknown
	 */
	function getVenueGalleryImageUploadConfig($imageName){
	
		$config['upload_path'] = $this->config->item('ar_venue_gallery_img_upload_path');
		$config['allowed_types'] = $this->config->item('ar_img_allowed_types');
		$config['max_size']	= $this->config->item('ar_img_max_size');
		$config['overwrite'] = $this->config->item('ar_img_overwrite');
		$config['remove_spaces'] = $this->config->item('ar_img_remove_spaces');
		$config['file_name'] = $imageName;
	
		return $config;
	}
	
	/**Method to get config values for Venue gallery image resize.
	 * @param unknown $imageName
	 * @return unknown
	 */
	function getVenueGalleryImageResizeConfig($imageName){
	
		$config['image_library'] = $this->config->item('ar_img_image_library');
		$config['source_image']	= $this->config->item('ar_venue_gallery_img_upload_path').$imageName;
		$config['create_thumb'] = $this->config->item('ar_img_create_thumb');
		$config['quality'] =  $this->config->item('ar_img_resize_quality');
		$config['maintain_ratio'] = $this->config->item('ar_gallery_img_maintain_ratio');
		$config['width']	= $this->config->item('ar_gallery_img_resize_width');
	
		return $config;
	}
	
	/** Method to copy image from one path to another
	 * @param unknown $originalImagePath
	 * @param unknown $targetImagePath
	 */
	function moveImage($originalImagePath, $targetImagePath){
		logDebug('Inside moveImage');

		try{
			if(!file_exists($originalImagePath)){
				logException('Original image path is not valid. Path is::'. $originalImagePath);
				return false;
			}
			
			if(copy($originalImagePath, $targetImagePath)){
				//If image copy is successful, then delete the image from original path
				unlink($originalImagePath);
			}
			
		}
		catch (Exception $e){
			logException('Exception in moving image.'. $e->getMessage ());
			return false;	
		}	
		
		return true;
	}
	
}