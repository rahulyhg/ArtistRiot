<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['facebook']['api_id'] = '1427059004241068';
$config['facebook']['app_secret'] = 'YOUR APP SECRET';
$config['facebook']['redirect_url'] = 'http://artistriot.com/artistriot';
$config['facebook']['permissions'] = array(
		'email',
		'first_name',
		'last_name'
);