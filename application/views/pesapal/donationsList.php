<table>
	<tr>
		<th>Type</th>
		<th>Amount</th>
		<th>Reference</th>
		<th>Status</th>
		<th>Time Initiated</th>
	</tr>
	<?php foreach ($donations->result_array() as $donation) { ?>
	<tr>
		<td><?php echo $donation['method'];?></td>
		<td><?php echo $donation['amount'];?></td>
		<td><?php echo $donation['merchant_reference'];?></td>
		<td><?php echo $donation['status'];?></td>
		<td><?php echo $donation['time'];?></td>
	</tr>
	<?php } ?>

</table>