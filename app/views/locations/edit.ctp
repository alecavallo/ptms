<div class="locations form">
<?php echo $this->Form->create('Location');?>
	<fieldset>
 		<legend><?php __('Edit Location'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ip');
		echo $this->Form->input('city');
		echo $this->Form->input('country_code');
		echo $this->Form->input('latitude');
		echo $this->Form->input('longitude');
		echo $this->Form->input('exists');
		echo $this->Form->input('cities_id');
		echo $this->Form->input('countries_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Location.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Location.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Locations', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Cities', true), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cities', true), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Countries', true), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Countries', true), array('controller' => 'countries', 'action' => 'add')); ?> </li>
	</ul>
</div>