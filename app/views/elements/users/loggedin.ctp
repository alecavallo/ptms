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
	<!-- <span id="u-data"><?php echo $html->link($loggedUser['User']['first_name']." ".$loggedUser['User']['last_name']." "."<span style='color:rgb(100,100,100);font-weight: normal;'>(editar)</span>",array('controller'=>"users",'action'=>"edit", $loggedUser['User']['id']),array('escape'=>false))?></span>
	&nbsp;&nbsp; 
	<span id="u-data"><?php echo $facebook->logout(array('redirect' => '/users/logout'), 'Cerrar sesión');?></span>-->
	
	<span id="u-data">
		<?php echo $html->link($loggedUser['User']['first_name']." ".$loggedUser['User']['last_name'],array('controller'=>"users",'action'=>"edit", $loggedUser['User']['id']),array('escape'=>false))?>&nbsp;
		<span style='color:rgb(100,100,100);font-weight: normal;'>(<?php echo $html->link("editar",array('controller'=>"users",'action'=>"edit", $loggedUser['User']['id']),array('escape'=>false))?> / <?php echo $facebook->logout(array('redirect' => '/users/logout'), 'cerrar sesión');?>)</span>	
	</span>
<?php 
}
?>