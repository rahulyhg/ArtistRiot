<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//use Entities\ArArtistCategory;

require_once(APPPATH."models/Entities/ArArtistCategory.php");
require_once(APPPATH."models/Entities/ArArtistSubCategory.php");
use \ArArtistCategory;
use \ArArtistSubCategory;


class Login extends CI_Model
{
	
	var $em;
	
    public function get_categories()
    {
      
    	$this->em = $this->doctrine->em;
    	$query = $this->em->createQuery('SELECT u FROM \ArArtistCategory u');
    	$result = $query->getResult();
    	$temparray = array();
    	$categoryArray = array();
    	$count = 0;
    	
    	foreach($result as $categoryData){
    		
    		$temparray[0] = $categoryData->getCategoryId();
    		$temparray[1] = $categoryData->getCategoryName();
    		$categoryArray[$count] = $temparray;
    		$count++;
    	}
    	
    	return $categoryArray;
 
    }
    
    
    public function get_sub_categories()
    {
    	$this->em = $this->doctrine->em;
    	$query = $this->em->createQuery('SELECT u FROM \ArArtistSubCategory u');
    	$result = $query->getResult();
    	$temparray = array();
    	$subCategoryArray = array();
    	$count = 0;
    	
    	foreach($result as $subCategoryData){
    		
    		$temparray[0] = $subCategoryData->getCategory();
    		$temparray[1] = $subCategoryData->getSubCategoryId();
    		$temparray[2] = $subCategoryData->getSubCategoryName();
    		$subCategoryArray[$count] = $temparray;
    		$count++;
    	}
    	print_r($subCategoryArray);
    	return $subCategoryArray;
    }
}