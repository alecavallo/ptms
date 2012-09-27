<?php 
if (isset($loggedUser) && !empty($loggedUser)) {
?>
	<span id="u-avatar">
		<?php
		if (!empty($loggedUser['User']['avatar'])) {
			echo $html->link($html->image($loggedUser['User']['avatar']),array('controller'=>"users",'action'=>"edit", $loggedUser['User']['id']),array('escape'=>false));
		} 
		?>
	</span>
	<span id="u-data"><?php echo $html->link($loggedUser['User']['first_name']." ".$loggedUser['User']['last_name'],array('controller'=>"users",'action'=>"edit", $loggedUser['User']['id']))?></span>
<?php 
}
?>