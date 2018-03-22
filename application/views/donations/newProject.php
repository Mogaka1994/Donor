<?php defined('BASEPATH') or exit('No direct script access allowed');?>


<div class="container" style="padding-top: 60px">

<h3 class="text-center">Add a new Project</h3>
<?php echo validation_errors();?>

<?php echo form_open('donations/new_project'); ?>

		<?php echo form_label('Name', 'name');?>
		<?php echo form_input(array('name'=>'name', 'class'=>'form-control'));?>
		</br>

		<?php echo form_label('Description', 'description');?>
		<?php echo form_input(array('name'=>'description', 'class'=>'form-control'));?>
		</br>

		<?php echo form_label('Amount Required', 'amount');?>
		<?php echo form_input(array('name'=>'amount', 'class'=>'form-control'));?>
		</br>

		<?php echo form_hidden('user', $this->ion_auth->user()->row()->id);?>

		<?php echo form_submit('submit', 'Register Project', array('class'=> 'btn btn-success')); ?>

<?php echo form_close();?>
</div>