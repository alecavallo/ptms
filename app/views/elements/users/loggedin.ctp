<?php 
if (isset($user) && !empty($user)) {
?>
	<span id="u-avatar">
		<?php
		if (!empty($user['User']['avatar'])) {
			echo $html->link($html->image($user['User']['avatar']),array('controller'=>"users",'action'=>"edit", $user['User']['id']),array('escape'=>false));
		} 
		?>
	</span>
	<span id="u-data"><?php echo $html->link($user['User']['first_name']." ".$user['User']['last_name'],array('controller'=>"users",'action'=>"edit", $user['User']['id']))?></span>
<?php 
}
?>