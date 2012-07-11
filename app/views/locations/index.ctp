<div class="locations index">
	<h2><?php __('Locations');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ip');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('country_code');?></th>
			<th><?php echo $this->Paginator->sort('latitude');?></th>
			<th><?php echo $this->Paginator->sort('longitude');?></th>
			<th><?php echo $this->Paginator->sort('exists');?></th>
			<th><?php echo $this->Paginator->sort('cities_id');?></th>
			<th><?php echo $this->Paginator->sort('countries_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($locations as $location):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $location['Location']['id']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['ip']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['city']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['country_code']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['latitude']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['longitude']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['exists']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($location['Cities']['name'], array('controller' => 'cities', 'action' => 'view', $location['Cities']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($location['Countries']['name'], array('controller' => 'countries', 'action' => 'view', $location['Countries']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $location['Location']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $location['Location']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $location['Location']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $location['Location']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Location', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cities', true), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cities', true), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Countries', true), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Countries', true), array('controller' => 'countries', 'action' => 'add')); ?> </li>
	</ul>
</div>