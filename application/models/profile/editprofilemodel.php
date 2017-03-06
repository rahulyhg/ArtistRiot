<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once (APPPATH . "models/Entities/ArUsers.php");
require_once (APPPATH . "models/Entities/ArArtistCategory.php");
require_once (APPPATH . "models/Entities/ArArtistSubCategory.php");
require_once (APPPATH . "models/Entities/ArUserProfile.php");
require_once (APPPATH . "models/Entities/ArUserProfilePicture.php");
require_once (APPPATH . "models/Entities/ArUserGalleryImages.php");
require_once (APPPATH . "models/Entities/ArUserGalleryVideos.php");

use \ArUserProfile;
use \ArUsers;
use Doctrine\ORM\Query as Query;

class editProfileModel extends CI_Model
{

    var $em;

    public function UpdateProfileData($profile_id, $user_id, $firstname, $lastname, $mobile, $category, $subcategory, $categoryName, $subcategoryName)
    {
        try
        {
            log_message('debug', 'inside updateProfileData values are: profileid-->' . $profile_id . '@userid-->' . $user_id . '@firstname-->' . $firstname . '@lastname-->' . $lastname . '@mobile-->' . $mobile . '@category-->' . $category . '@subCategory-->' . $subcategory);
            //updating values inuserProfile table
            $this->em = $this->doctrine->em;
            $query = $this->em->createQuery('Update \ArUserProfile u set u.categoryId=?1, u.subCategoryId=?2 WHERE u.profileId=?3');
            $query->setParameter(1, $category);
            $query->setParameter(2, $subcategory);
            $query->setParameter(3, $profile_id);

            $result = $query->execute();
            if ($result)
            {
                $this->session->set_userdata('category_name', $categoryName);
                $this->session->set_userdata('sub_category_name', $subcategoryName);
            }

            //updating values in user table
            $this->em = $this->doctrine->em;
            $query = $this->em->createQuery('Update \ArUsers u set u.firstName=?1, u.lastName=?2 , u.phone=?3 WHERE u.id=?4');
            $query->setParameter(1, $firstname);
            $query->setParameter(2, $lastname);
            $query->setParameter(3, $mobile);
            $query->setParameter(4, $user_id);

            $result = $query->execute();
            if ($result)//updating cache
            {
                $this->session->set_userdata('first_name', $firstname);
                $this->session->set_userdata('last_name', $lastname);
            }

            $this->em->flush();
            return true;
        }
        catch (Exception $e)
        {
            log_message('error', 'Error in updating Profile.->' . $e->getMessage());
            return false;
        }
    }

    public function UpdateLinks($profile_id, $user_id, $fblink, $twitterlink)
    {
        try
        {
            log_message('debug', 'inside UpdateLinks values are: profileid-->' . $profile_id . '@userid-->' . $user_id . '@fblink-->' . $fblink . '@twitterlink-->' . $twitterlink);
            //updating values inuserProfile table
            $this->em = $this->doctrine->em;
            $query = $this->em->createQuery('Update \ArUserProfile u set u.facebookPageUrl=?1, u.twitterPageUrl=?2 WHERE u.profileId=?3');
            $query->setParameter(1, $fblink);
            $query->setParameter(2, $twitterlink);
            $query->setParameter(3, $profile_id);
            $result = $query->execute();
            $this->em->flush();
            return true;
        }
        catch (Exception $e)
        {
            log_message('error', 'Error in updating links in profile.->' . $e->getMessage());
            return false;
        }
    }

}
