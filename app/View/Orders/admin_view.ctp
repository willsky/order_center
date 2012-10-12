<div class="orders view">
<h2><?php  echo __('Order'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['product_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Name'); ?></dt>
		<dd>
			<?php echo h($order['Order']['product_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Realname'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_realname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Telephone'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_telephone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Email'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Zipe Code'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_zipe_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Address'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Note'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Ip'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ts Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['ts_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Send Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['send_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($order['Order']['note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($order['Order']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sended'); ?></dt>
		<dd>
			<?php echo h($order['Order']['sended']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($order['Order']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order'), array('action' => 'edit', $order['Order']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order'), array('action' => 'delete', $order['Order']['id']), null, __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('action' => 'add')); ?> </li>
	</ul>
</div>
