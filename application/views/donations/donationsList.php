<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php
$CI =& get_instance();
$CI->load->helper('date');
?>

<div class="container" style="padding-top: 60px">
<h3 class="text-center">List of Donations</h3>
<table class="table table-striped">
	<tr>
		<th>User</th>
		<th>Project</th>
		<th>Method</th>
		<th>Amount</th>
		<th>Time</th>
		<th>Status</th>
	</tr>
	<?php foreach ($donationsList->result() as $donation) { ?>
	<?php $user = getUser($donation->user_id);?>
	<tr>
		<td><?php echo $user->first_name." ".$user->last_name;?></td>
		<td><?php echo getProject($donation->project_id)->name;?></td>
		<td><?php echo $donation->method ;?></td>
		<td><?php echo $donation->amount ;?></td>
		<td><?php echo $donation->time ;?></td>
		<td><?php echo $donation->status ;?></td>
	</tr>
	<?php } ?>
</table>
</div>