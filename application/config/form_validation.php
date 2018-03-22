<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = array();
$config['pesapal_online_checkout'] = array(
			array(
				'field' => 'amount',
				'label' => 'Amount',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'required'
			),
			array(
				'field' => 'type',
				'label' => 'Type',
				'rules' => 'required'
			),
			array(
				'field' => 'reference',
				'label' => 'Reference',
				'rules' => 'required'
			),
			array(
				'field' => 'first_name',
				'label' => 'First Name',
				'rules' => 'required'
			),
			array(
				'rules' => 'last_name',
				'label' => 'Last Name',
				'rules' => 'required'
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required'
			),
			array(
				'field' => 'phone',
				'label' => 'Phone Number',
				'rules' => 'integer'
			)
		);

$config['new_project'] = array(
	array(
		'field' => 'name',
		'label' => 'Project Name',
		'rules' => 'required'
	),
	array(
		'field' => 'description',
		'label' => 'Project Description',
		'rules' => 'required'
	),
	array(
		'field' => 'amount',
		'label' => 'Amount Required',
		'rules' => 'required|integer|greater_than[0]'
	),
	array(
		'field' => 'user',
		'label' => 'User ID',
		'rules' => 'required|integer|greater_than[0]'
	)
);