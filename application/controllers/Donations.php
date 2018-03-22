<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donations extends CI_Controller {
	function __contruct()
	{
		parent::__contruct();
	}

	function index()
	{
		$this->load->model('pesapal_model');
		$data['donationsList'] = $this->pesapal_model->getAll();
		$this->load->view('includes/header');
		$this->load->view('donations/donationsList', $data);
		$this->load->view('includes/footer');
	}

	function projects()
	{
		$this->load->model('donation_model');
		$data['projectsList'] = $this->donation_model->getAllProjects();
		$this->load->view('includes/header');
		$this->load->view('donations/projectsList', $data);
		$this->load->view('includes/footer');
	}


	function new_project()
	{
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->model('donation_model');

		if ($this->ion_auth->logged_in()) 
		{
			if ($this->ion_auth->is_admin()) 
			{
				if (!$this->form_validation->run('new_project')) 
				{
					$this->load->view('includes/header');
					$this->load->view('donations/newProject');
					$this->load->view('includes/footer');
				} 
				else 
				{
					$project['name'] = $this->input->post('name');
					$project['user_posting_id'] = $this->input->post('user');
					$project['amount_required'] = $this->input->post('amount');
					$project['description'] = $this->input->post('description');

					$data['project'] = $project;

					if ($this->donation_model->insertNewProject($project)) {
						$this->load->view('donations/projectRegisterSuccess', $data);
					} else {
						$this->load->view('donations/projectRegisterFail', $data);
					}
				}
			} 
			else 
			{
				$this->load->view('auth/insufficientPriviledges');
			}
			
		} 
		else 
		{
			redirect('auth/login', 'refresh');
		}
	}
}
