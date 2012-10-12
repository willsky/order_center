<div class="orders form">
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Order'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('product_id');
		echo $this->Form->input('product_name');
		echo $this->Form->input('customer_realname');
		echo $this->Form->input('customer_telephone');
		echo $this->Form->input('customer_email');
		echo $this->Form->input('customer_zipe_code');
		echo $this->Form->input('customer_address');
		echo $this->Form->input('customer_note');
		echo $this->Form->input('customer_ip');
		echo $this->Form->input('ts_id');
		echo $this->Form->input('send_id');
		echo $this->Form->input('note');
		echo $this->Form->input('sended');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Order.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Order.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
	</ul>
</div>
