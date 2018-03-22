<?php defined('BASEPATH') or exit('No direct access allowed');

/**
* 
*/
class Paypal extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('errors/html/page_coming_soon');
	}
}