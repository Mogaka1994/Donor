

<div class="container" style="padding-top: 70px">
<?php echo validation_errors();?>

<h3>Contribute for Project <?php echo $project->name;?></h3>
<?php echo form_open('pesapal/checkout/'.$project->id); ?>

		<?php echo form_label('Amount (in KES)', 'amount');?>
		<?php echo form_input(array('name'=>'amount' , 'class'=>'form-control'));?>
		</br>

		<?php echo form_hidden('type', 'MERCHANT');?>
		<?php echo form_hidden('reference', $reference);?>

		<?php echo form_label('Description', 'description');?>
		<?php echo form_input(array('name'=>'description', 'class'=>'form-control'));?>
		</br>

		<?php echo form_label('First Name', 'name');?>
		<?php echo form_input(array('name'=> 'first_name' , 'class'=>'form-control', 'readonly'=>'readonly', 'value'=>set_value('first_name', $this->ion_auth->user()->row()->first_name)));?>
		</br>

		<?php echo form_label('Last Name', 'name');?>
		<?php echo form_input(array('name'=> 'last_name', 'class'=>'form-control', 'readonly'=>'readonly', 'value'=>set_value('last_name', $this->ion_auth->user()->row()->last_name)));?>
		</br>

		<?php echo form_label('Email Address', 'email');?>
		<?php echo form_input(array('name'=>'email','class'=>'form-control', 'readonly'=>'readonly', 'value'=>set_value('email', $this->ion_auth->user()->row()->email)));?>
		</br>

		<?php echo form_label('Phone Number', 'phone');?>
		<?php echo form_input(array('name'=>'phone', 'class'=>'form-control', 'readonly'=>'readonly', 'value'=>set_value('phone', $this->ion_auth->user()->row()->phone)));?>
		</br>

		<?php echo form_submit('submit', 'Make Donation', array('class'=> 'btn btn-success')); ?>

<?php echo form_close();?>
</div>

 <!-- <form>
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" id="email">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd">
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form -->> 