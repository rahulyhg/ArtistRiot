-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2015 at 08:32 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `artistriot`
--

-- --------------------------------------------------------

--
-- Table structure for table `ar_artist_category`
--

CREATE TABLE IF NOT EXISTS `ar_artist_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL COMMENT 'Artist categories',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_artist_rating`
--

CREATE TABLE IF NOT EXISTS `ar_artist_rating` (
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) unsigned NOT NULL,
  `rating` float NOT NULL,
  `num_votes` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rating_id`),
  UNIQUE KEY `artist_id` (`artist_id`),
  KEY `rating_id` (`rating_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_artist_review`
--

CREATE TABLE IF NOT EXISTS `ar_artist_review` (
  `review_id` int(10) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  `review_title` varchar(100) NOT NULL,
  `reviewer_name` varchar(100) NOT NULL,
  `review` varchar(500) NOT NULL,
  `rating` float NOT NULL,
  `review_date` int(12) NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_artist_sub_category`
--

CREATE TABLE IF NOT EXISTS `ar_artist_sub_category` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'sub category id',
  `category_id` int(11) NOT NULL COMMENT 'category id',
  `sub_category_name` varchar(50) NOT NULL COMMENT 'category name',
  PRIMARY KEY (`sub_category_id`),
  KEY `category_id` (`category_id`),
  KEY `category_id_2` (`category_id`),
  KEY `category_id_3` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_groups`
--

CREATE TABLE IF NOT EXISTS `ar_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_login_attempts`
--

CREATE TABLE IF NOT EXISTS `ar_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_search`
--

CREATE TABLE IF NOT EXISTS `ar_search` (
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `name` (`name`,`role`),
  KEY `name_2` (`name`),
  KEY `name_3` (`name`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ar_subscription`
--

CREATE TABLE IF NOT EXISTS `ar_subscription` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_users`
--

CREATE TABLE IF NOT EXISTS `ar_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL COMMENT 'User role',
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_created` int(1) NOT NULL DEFAULT '0' COMMENT 'Flag to identify if profile is created.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  FULLTEXT KEY `last_name` (`last_name`),
  FULLTEXT KEY `first_name` (`first_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=110 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_users_groups`
--

CREATE TABLE IF NOT EXISTS `ar_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_ar_users_groups` (`user_id`,`group_id`),
  KEY `fk_ar_users_groups_users1_idx` (`user_id`),
  KEY `fk_ar_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_user_gallery_images`
--

CREATE TABLE IF NOT EXISTS `ar_user_gallery_images` (
  `user_id` int(11) unsigned NOT NULL,
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(50) NOT NULL,
  `image_description` varchar(200) DEFAULT NULL,
  `upload_date` int(12) unsigned NOT NULL COMMENT 'Date of photo upload.',
  PRIMARY KEY (`image_id`),
  KEY `user_id` (`user_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_user_gallery_videos`
--

CREATE TABLE IF NOT EXISTS `ar_user_gallery_videos` (
  `user_id` int(11) unsigned NOT NULL,
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_url` varchar(400) NOT NULL,
  `video_description` varchar(200) DEFAULT NULL,
  `youtube_video_id` varchar(30) DEFAULT NULL COMMENT 'Video ID of youtube video.',
  `upload_date` int(12) NOT NULL,
  PRIMARY KEY (`video_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_user_profile`
--

CREATE TABLE IF NOT EXISTS `ar_user_profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Profile id of user.',
  `user_id` int(11) unsigned NOT NULL COMMENT 'User id of user.',
  `category_id` int(11) NOT NULL COMMENT 'Category ID if user.',
  `sub_category_id` int(11) NOT NULL COMMENT 'Sub category id of user.',
  `user_description` varchar(2000) NOT NULL COMMENT 'Description of user.',
  `gender` varchar(10) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL COMMENT 'Date of birth',
  `facebook_page_url` varchar(500) DEFAULT NULL COMMENT 'Facebook fan page URL.',
  `twitter_page_url` varchar(500) DEFAULT NULL COMMENT 'Twitter fan page URL',
  `is_other_skill` int(11) DEFAULT NULL COMMENT 'Other skills flag',
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `user_id_4` (`user_id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `user_id_3` (`user_id`),
  KEY `profile_id` (`profile_id`),
  KEY `category_id` (`category_id`),
  KEY `sub_category_id` (`sub_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_user_profile_picture`
--

CREATE TABLE IF NOT EXISTS `ar_user_profile_picture` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Photo ID',
  `user_id` int(11) unsigned NOT NULL COMMENT 'User ID',
  `image_type` varchar(10) NOT NULL COMMENT 'Type of photo, profile or cover',
  `image_path` varchar(100) NOT NULL COMMENT 'Image name.',
  `position` varchar(10) DEFAULT '0' COMMENT 'Position from top. Added for image re-positioning.  ',
  `is_active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=300 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_venue_category`
--

CREATE TABLE IF NOT EXISTS `ar_venue_category` (
  `category_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `event_type` varchar(30) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_venue_gallery_images`
--

CREATE TABLE IF NOT EXISTS `ar_venue_gallery_images` (
  `user_id` int(11) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_name` varchar(50) NOT NULL,
  `image_description` varchar(200) DEFAULT NULL,
  `upload_date` int(12) unsigned NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_venue_gallery_videos`
--

CREATE TABLE IF NOT EXISTS `ar_venue_gallery_videos` (
  `user_id` int(11) unsigned NOT NULL,
  `video_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `video_url` varchar(200) NOT NULL,
  `video_description` varchar(200) DEFAULT NULL,
  `youtube_video_id` varchar(30) NOT NULL,
  `upload_date` int(12) NOT NULL,
  PRIMARY KEY (`video_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_venue_profile`
--

CREATE TABLE IF NOT EXISTS `ar_venue_profile` (
  `profile_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `venue_description` varchar(500) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `facebook_page_url` varchar(400) DEFAULT NULL,
  `twitter_page_url` varchar(400) DEFAULT NULL,
  `fans` int(11) unsigned DEFAULT NULL,
  `capacity` varchar(40) DEFAULT NULL,
  `event_types` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `user_id_2` (`user_id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_3` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ar_artist_rating`
--
ALTER TABLE `ar_artist_rating`
  ADD CONSTRAINT `FK_ARTIST_RATING` FOREIGN KEY (`artist_id`) REFERENCES `ar_users` (`id`);

--
-- Constraints for table `ar_artist_review`
--
ALTER TABLE `ar_artist_review`
  ADD CONSTRAINT `FK_ARTIST_REVIEW` FOREIGN KEY (`artist_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_artist_sub_category`
--
ALTER TABLE `ar_artist_sub_category`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `ar_artist_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_search`
--
ALTER TABLE `ar_search`
  ADD CONSTRAINT `FK_SEARCH` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_users_groups`
--
ALTER TABLE `ar_users_groups`
  ADD CONSTRAINT `fk_ar_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `ar_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ar_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ar_user_gallery_images`
--
ALTER TABLE `ar_user_gallery_images`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_user_gallery_videos`
--
ALTER TABLE `ar_user_gallery_videos`
  ADD CONSTRAINT `fk_video_user_id` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_user_profile`
--
ALTER TABLE `ar_user_profile`
  ADD CONSTRAINT `fk_artist_profile_category` FOREIGN KEY (`category_id`) REFERENCES `ar_artist_category` (`category_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `fk_artist_profile_sub_category` FOREIGN KEY (`sub_category_id`) REFERENCES `ar_artist_sub_category` (`sub_category_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_user_profile_picture`
--
ALTER TABLE `ar_user_profile_picture`
  ADD CONSTRAINT `FK_USER_IMAGE` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ar_venue_gallery_images`
--
ALTER TABLE `ar_venue_gallery_images`
  ADD CONSTRAINT `FK_VENUE_GALLERY_IMAGES` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_venue_gallery_videos`
--
ALTER TABLE `ar_venue_gallery_videos`
  ADD CONSTRAINT `FK_VENUE_GALLERY_VIDEOS` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_venue_profile`
--
ALTER TABLE `ar_venue_profile`
  ADD CONSTRAINT `FK_USER_VENUE_PROFILE` FOREIGN KEY (`user_id`) REFERENCES `ar_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
