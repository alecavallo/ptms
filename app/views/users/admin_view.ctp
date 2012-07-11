<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('First Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['first_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['last_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Alias'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['alias']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last Signup'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['last_signup']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rating'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['rating']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($user['City']['name'], array('controller' => 'cities', 'action' => 'view', $user['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Column Allowed'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['column_allowed']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sources Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['sources_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cities', true), array('controller' => 'cities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New City', true), array('controller' => 'cities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Preferred Layouts', true), array('controller' => 'preferred_layouts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Preferred Layout', true), array('controller' => 'preferred_layouts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments', true), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment', true), array('controller' => 'comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List News', true), array('controller' => 'news', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News', true), array('controller' => 'news', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php __('Related Preferred Layouts');?></h3>
	<?php if (!empty($user['PreferredLayout'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['PreferredLayout']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cookie Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['PreferredLayout']['cookie_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parameters');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['PreferredLayout']['parameters'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['PreferredLayout']['user_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Layout Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['PreferredLayout']['layout_id'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Preferred Layout', true), array('controller' => 'preferred_layouts', 'action' => 'edit', $user['PreferredLayout']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php __('Related Comments');?></h3>
	<?php if (!empty($user['Comment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Contain'); ?></th>
		<th><?php __('News Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Votes'); ?></th>
		<th><?php __('Ads Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Comment'] as $comment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $comment['id'];?></td>
			<td><?php echo $comment['date'];?></td>
			<td><?php echo $comment['contain'];?></td>
			<td><?php echo $comment['news_id'];?></td>
			<td><?php echo $comment['user_id'];?></td>
			<td><?php echo $comment['votes'];?></td>
			<td><?php echo $comment['ads_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'comments', 'action' => 'view', $comment['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'comments', 'action' => 'edit', $comment['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'comments', 'action' => 'delete', $comment['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $comment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Comment', true), array('controller' => 'comments', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related News');?></h3>
	<?php if (!empty($user['News'])):?>
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
		<th><?php __('HasImages'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('Ktitle'); ?></th>
		<th><?php __('Ksummary'); ?></th>
		<th><?php __('Kbody'); ?></th>
		<th><?php __('IsRelated'); ?></th>
		<th><?php __('Processed'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['News'] as $news):
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
			<td><?php echo $news['hasImages'];?></td>
			<td><?php echo $news['url'];?></td>
			<td><?php echo $news['ktitle'];?></td>
			<td><?php echo $news['ksummary'];?></td>
			<td><?php echo $news['kbody'];?></td>
			<td><?php echo $news['isRelated'];?></td>
			<td><?php echo $news['processed'];?></td>
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
