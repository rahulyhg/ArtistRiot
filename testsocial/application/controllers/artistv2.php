<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artistv2 extends CI_Controller
{

    public function index()
    {

        $data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['language'] = "en";
        $data['title'] = "Artist Riot-Profile";
        $data['wallclass'] = "active";
        $data['photosclass'] = "";
        $data['videosclass'] = "";
        $data['heading'] = "Wall";
        $data['is_my_profile'] = true;
        $this->load->view('new/profile', $data);
    }
    
    public function event()
    {

        $data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['language'] = "en";
        $data['title'] = "Artist Riot-Profile";
        $data['wallclass'] = "active";
        $data['photosclass'] = "";
        $data['videosclass'] = "";
        $data['heading'] = "Wall";
        $data['is_my_profile'] = true;
        $this->load->view('new/event', $data);
    }

    public function save_profile_pic()
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["profile_pic"]["name"]);
         
        $extension = end($temp);
        echo $extension;
       // echo '<script>hello</script>';
        if ((($_FILES["profile_pic"]["type"] == "image/gif") || ($_FILES["profile_pic"]["type"] == "image/jpeg") || ($_FILES["profile_pic"]["type"] == "image/jpg") || ($_FILES["profile_pic"]["type"] == "image/pjpeg") || ($_FILES["profile_pic"]["type"] == "image/x-png") || ($_FILES["profile_pic"]["type"] == "image/png")) && ($_FILES["profile_pic"]["size"] < 2000000) && in_array($extension, $allowedExts))
        {
            if ($_FILES["profile_pic"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["profile_pic"]["error"] . "<br>";
            }
            else
            {
                echo "Upload: " . $_FILES["profile_pic"]["name"] . "<br>";
                echo "Type: " . $_FILES["profile_pic"]["type"] . "<br>";
                echo "Size: " . ($_FILES["profile_pic"]["size"] / 1024) . " kB<br>";
                echo "Temp file: " . $_FILES["profile_pic"]["tmp_name"] . "<br>";
                if (file_exists(base_url() . "upload/" . $_FILES["profile_pic"]["name"]))
                {
                    echo $_FILES["profile_pic"]["name"] . " already exists. ";
                }
                else
                {
                    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "images/uploads/" . $_FILES["profile_pic"]["name"]);
                    echo "Stored in: " . base_url(). "images/uploads/" . $_FILES["profile_pic"]["name"];
                }
            }
        }
        else
        {
            echo "Invalid file";
        }
    }

}
