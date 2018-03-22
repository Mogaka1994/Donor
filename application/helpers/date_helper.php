<?php
defined('BASEPATH') or exit('No direct script access allowed');

function getCurrentTime($format = null)
{
	$date = new DateTime();
	if ($format == null) 
	{
		$format = 'Y-m-d H:i:s';
	}
	return $date->format($format);
}

function getProject($id)
{
	$CI =& get_instance();
	$CI->load->model('donation_model');
	return $CI->donation_model->getProjectByID($id)->row();
}

function getUser($id)
{
	$CI =& get_instance();
	$CI->load->library('ion_auth');
	return $CI->ion_auth->user($id)->row();
}