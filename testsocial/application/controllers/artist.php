<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artist extends CI_Controller
{

    public function index($is_my_profile)
    {

        $data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['language'] = "en";
        $data['title'] = "Artist Riot-Profile";
        $data['wallclass'] = "active";
        $data['photosclass'] = "";
        $data['videosclass'] = "";
        $data['heading'] = "Wall";
        $data['is_my_profile'] = $is_my_profile;
        if ($is_my_profile=='true')
        {
            $this->load->view('selfprofile', $data);
        }
        else
        {
            $this->load->view('profile', $data);
        }
    }

    public function photos($is_my_profile)
    {

        $data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['language'] = "en";
        $data['title'] = "Artist Riot-Profile|Photos";
        $data['wallclass'] = "";
        $data['photosclass'] = "active";
        $data['videosclass'] = "";
        $data['heading'] = "Photos";
        $data['is_my_profile'] = $is_my_profile;
        if ($is_my_profile=='true')
        {
            $this->load->view('selfprofile-photos', $data);
        }
        else
        {
            $this->load->view('profile-photos', $data);
        }
    }

    public function videos($is_my_profile)
    {

        $data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['language'] = "en";
        $data['title'] = "Artist Riot-Profile|Videos";
        $data['wallclass'] = "";
        $data['photosclass'] = "";
        $data['videosclass'] = "active";
        $data['heading'] = "Videos";
        $data['is_my_profile'] = $is_my_profile;
         if ($is_my_profile=='true')
        {
            $this->load->view('selfprofile-videos', $data);
        }
        else
        {
            $this->load->view('profile-videos', $data);
        }
    }

}
