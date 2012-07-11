<div class="categories view">
<h2><?php  __('Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['parent_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lft'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['lft']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rght'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['rght']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category', true), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Category', true), array('action' => 'delete', $category['Category']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds', true), array('controller' => 'feeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feed', true), array('controller' => 'feeds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ads', true), array('controller' => 'ads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad', true), array('controller' => 'ads', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List News', true), array('controller' => 'news', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News', true), array('controller' => 'news', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Feeds');?></h3>
	<?php if (!empty($category['Feed'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('Source Id'); ?></th>
		<th><?php __('Category Id'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('Last Processing Date'); ?></th>
		<th><?php __('Image Url'); ?></th>
		<th><?php __('Image Title'); ?></th>
		<th><?php __('Image Link'); ?></th>
		<th><?php __('Image Width'); ?></th>
		<th><?php __('Image Height'); ?></th>
		<th><?php __('Copyright'); ?></th>
		<th><?php __('Ttl'); ?></th>
		<th><?php __('Rating'); ?></th>
		<th><?php __('Language'); ?></th>
		<th><?php __('Webmaster'); ?></th>
		<th><?php __('Editor'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($category['Feed'] as $feed):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $feed['id'];?></td>
			<td><?php echo $feed['url'];?></td>
			<td><?php echo $feed['source_id'];?></td>
			<td><?php echo $feed['category_id'];?></td>
			<td><?php echo $feed['city_id'];?></td>
			<td><?php echo $feed['state_id'];?></td>
			<td><?php echo $feed['last_processing_date'];?></td>
			<td><?php echo $feed['image_url'];?></td>
			<td><?php echo $feed['image_title'];?></td>
			<td><?php echo $feed['image_link'];?></td>
			<td><?php echo $feed['image_width'];?></td>
			<td><?php echo $feed['image_height'];?></td>
			<td><?php echo $feed['copyright'];?></td>
			<td><?php echo $feed['ttl'];?></td>
			<td><?php echo $feed['rating'];?></td>
			<td><?php echo $feed['language'];?></td>
			<td><?php echo $feed['webmaster'];?></td>
			<td><?php echo $feed['editor'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'feeds', 'action' => 'view', $feed['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'feeds', 'action' => 'edit', $feed['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'feeds', 'action' => 'delete', $feed['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $feed['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Feed', true), array('controller' => 'feeds', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Ads');?></h3>
	<?php if (!empty($category['Ad'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Url'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($category['Ad'] as $ad):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $ad['id'];?></td>
			<td><?php echo $ad['name'];?></td>
			<td><?php echo $ad['url'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'ads', 'action' => 'view', $ad['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'ads', 'action' => 'edit', $ad['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'ads', 'action' => 'delete', $ad['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ad['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ad', true), array('controller' => 'ads', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related News');?></h3>
	<?php if (!empty($category['News'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Summary'); ?></th>
		<th><?php __('Body'); ?></th>
		<th><?php __('Rating'); ?></th>
		<th><?php __('Visits'); ?></th>
		<th><?php __('Votes'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('Repeated Url'); ?></th>
		<th><?php __('Feed Id'); ?></th>
		<th><?php __('Related News Id'); ?></th>
		<th><?php __('Media Type'); ?></th>
		<th><?php __('Media Url'); ?></th>
		<th><?php __('Media Title'); ?></th>
		<th><?php __('Media Width'); ?></th>
		<th><?php __('Media Height'); ?></th>
		<th><?php __('Media Link'); ?></th>
		<th><?php __('Media Description'); ?></th>
		<th><?php __('Link'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($category['News'] as $news):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $news['id'];?></td>
			<td><?php echo $news['title'];?></td>
			<td><?php echo $news['summary'];?></td>
			<td><?php echo $news['body'];?></td>
			<td><?php echo $news['rating'];?></td>
			<td><?php echo $news['visits'];?></td>
			<td><?php echo $news['votes'];?></td>
			<td><?php echo $news['created'];?></td>
			<td><?php echo $news['modified'];?></td>
			<td><?php echo $news['user_id'];?></td>
			<td><?php echo $news['city_id'];?></td>
			<td><?php echo $news['state_id'];?></td>
			<td><?php echo $news['repeated_url'];?></td>
			<td><?php echo $news['feed_id'];?></td>
			<td><?php echo $news['related_news_id'];?></td>
			<td><?php echo $news['media_type'];?></td>
			<td><?php echo $news['media_url'];?></td>
			<td><?php echo $news['media_title'];?></td>
			<td><?php echo $news['media_width'];?></td>
			<td><?php echo $news['media_height'];?></td>
			<td><?php echo $news['media_link'];?></td>
			<td><?php echo $news['media_description'];?></td>
			<td><?php echo $news['link'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'news', 'action' => 'view', $news['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'news', 'action' => 'edit', $news['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'news', 'action' => 'delete', $news['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New News', true), array('controller' => 'news', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
