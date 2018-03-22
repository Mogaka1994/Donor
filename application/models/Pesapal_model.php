<?php 
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Pesapal_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function insert($transaction)
	{
		return $this->db->insert('tbl_pesapal_payments', $transaction);
	}

	function update($transaction, $id)
	{
		$this->db->where('tbl_pesapal_payments.id', $id);
		return $this->db->update('tbl_pesapal_payments', $transaction);
	}

	function delete($id)
	{
		$this->db->where('tbl_pesapal_payments.id', $id);
		return $this->db->delete();
	}

	function getAll()
	{
		$this->db->select('tbl_pesapal_payments.*');
		$this->db->order_by('tbl_pesapal_payments.time');
		$this->db->from('tbl_pesapal_payments');
		return $this->db->get();
	}

	function getById($id)
	{
		$this->db->select('tbl_pesapal_payments.*');
		$this->db->where('tbl_pesapal_payments.id', $id);
		$this->db->limit(1, 0);
		$this->db->from('tbl_pesapal_payments');
		return $this->db->get();
	}

	function getByTrackingId($id)
	{
		$this->db->select('tbl_pesapal_payments.*');
		$this->db->where('tbl_pesapal_payments.tracking_id', $id);
		$this->db->limit(1, 0);
		$this->db->from('tbl_pesapal_payments');
		return $this->db->get();
	}

	function saveIPN($IPN)
	{
		if (!isset($IPN['tracking_id']) || !isset($IPN['merchant_reference'])) 
		{
			return false;
		} 
		else 
		{
			if ($this->getByTrackingID($IPN['tracking_id'])->row()) 
			{
				$this->db->where('tbl_pesapal_payments.tracking_id', $IPN['tracking_id']);
				return $this->db->update('tbl_pesapal_payments', $IPN);
			} 
			else 
			{
				return $this->db->insert('tbl_pesapal_payments', $IPN);
			}
		}
	}
}