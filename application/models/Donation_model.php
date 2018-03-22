<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Donation_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function insertNewProject($project)
	{
		$this->db->insert('tbl_projects', $project);
		return $this->db->insert_id();
	}

	function update($project, $id)
	{
		
	}

	function delete($id)
	{

	}

	function getAllProjects()
	{
		$this->db->select('tbl_projects.*');
		$this->db->order_by('tbl_projects.name');
		$this->db->from('tbl_projects');
		return $this->db->get();
	}

	function getProjectByID($id)
	{
		$this->db->select('tbl_projects.*');
		$this->db->where('tbl_projects.id', $id);
		$this->db->limit(1, 0);
		$this->db->order_by('tbl_projects.name');
		$this->db->from('tbl_projects');
		return $this->db->get();
	}

	function updateContibution($id, $amount)
	{
		$oldBal = $this->getProjectByID($id)->row()->amount_contributed;
		$newBal = $oldBal+$amount;
		$this->db->where('tbl_projects.id', $id);
		$this->db->set('tbl_projects.amount_contributed', $newBal);
		return $this->db->update('tbl_projects');
	}
}