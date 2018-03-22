<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="container" style="padding-top: 60px">
<p>
<?php
$CI =& get_instance();
$CI->load->library('ion_auth');
if ($CI->ion_auth->logged_in() && $CI->ion_auth->is_admin()) { ?>
	<a href="<?php echo site_url('donations/new_project');?>"><button class="btn btn-success">New Project</button></a>
<?php } ?>
<a href="<?php echo site_url('donations');?>"><button class="btn btn-success">View Donations</button></a>
</p>
<h3 class="text-center">List of Projects</h3>
<table class="table table-striped">
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>User Posting</th>
		<th>Amount Required</th>
		<th>Amount Raised</th>
		<th>Action</th>
	</tr>
	<?php foreach ($projectsList->result() as $project) { ;?>
	<?php $user = $this->ion_auth->user($project->user_posting_id)->row();?>
	<tr>
		<td><?php echo $project->name;?></td>
		<td><?php echo $project->description;?></td>
		<td><?php echo $user->first_name." ".$user->last_name;?></td>
		<td><?php echo $project->amount_required;?></td>
		<td><?php echo $project->amount_contributed;?></td>
		<td><?php echo anchor('pesapal/checkout/'.$project->id, 'Contribute');?> </td>
	</tr>
	<?php } ?>
</table>
</div>