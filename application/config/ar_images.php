<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Upload image configurations

$config['ar_img_upload_path'] = './userimages/';
$config['ar_profile_img_delete_path'] = './deleteduserimages/';
$config['ar_img_temp_upload_path'] = './imageuploads/';
$config['ar_img_allowed_types'] = 'gif|jpg|png';
$config['ar_img_max_size'] = '0';
$config['ar_img_max_width'] = '1024';
$config['ar_img_max_height'] = '768';
$config['ar_img_overwrite'] = TRUE;
$config['ar_img_remove_spaces'] = TRUE;


//Resize image configurations

$config['ar_img_image_library'] = 'gd2';
$config['ar_img_create_thumb'] = FALSE;
$config['ar_img_maintain_ratio'] = TRUE;
$config['ar_img_resize_quality'] = '90%';
$config['ar_img_resize_width'] = 300;
$config['ar_img_resize_height'] = 300;

// Resize option for edit photo
$config['ar_edit_img_resize_width'] = 250;
$config['ar_edit_img_resize_height'] = 250;

//Resize option for cover photo
$config['ar_cover_img_resize_width'] = 960;
//$config['ar_cover_img_resize_height'] = 380;
$config['ar_cover_img_minimum_width'] = 400;
$config['ar_cover_img_minimum_height'] = 250;


//Crop image configurations:

$config['ar_img_maintain_ratio'] = FALSE;


// User gallery image configurations:
$config['ar_gallery_img_upload_path'] = './usergalleryimages/';
//Venue gallery image configuraions
$config['ar_venue_gallery_img_upload_path'] = './venuegalleryimages/';

// Resize option for edit photo
$config['ar_gallery_img_resize_width'] = 700;
//$config['ar_gallery_img_resize_height'] = 420;
$config['ar_gallery_img_maintain_ratio'] = TRUE;

//New resize logic
$config['ar_img_min_width'] = 300;
$config['ar_img_min_height'] = 300;

//Gallery image limit per page
$config['ar_img_max_image_per_page'] = 12;
$config['ar_img_max_videos_per_page'] = 12;

