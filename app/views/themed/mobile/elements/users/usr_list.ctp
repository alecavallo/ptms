<div style="float: right; clear: both;">Ordenar por: <div id="orderIndicator" onclick="showHide($('orderPicker'))">Rating</div></div>
<br clear="all"/>
<div id="orderPicker" style="display: none;">
<?php 
	echo $this->Html->para('order', $paginator->sort('Rating', 'rating'));
	echo $this->Html->para('order', $paginator->sort('Nombre', 'first_name'));
	echo $this->Html->para('order', $paginator->sort('Apellido', 'last_name'));
	echo $this->Html->para('order', $paginator->sort('Alias', 'alias'));
?>
</div>
<div id="users">
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<div class="usrRow">
		<div class="uAvatar"><?php echo $this->Html->image(!empty($user['User']['avatar'])?$user['User']['avatar']:"empty.jpg",array('alt'=>$user['User']['alias']))?></div>
		<!-- <div class="section grey"><span class="name"><?php echo "{$user['User']['first_name']} {$user['User']['last_name']}"; ?></span>&nbsp;-&nbsp;<span class="nick"><?php echo $user['User']['alias']?></span></div> -->
		<div class="section grey">
			<?php 
				$name = $this->Html->tag('span', "{$user['User']['first_name']} {$user['User']['last_name']}", array('class'=>"name"));
				$nick = $this->Html->tag('span', $user['User']['alias'], array('class'=>"nick"));
				if(!empty($nick)){
					echo $this->Html->link($name." - ".$nick, "/columna/".$user['User']['alias'].".html", array('escape'=>false));
				}else {
					echo $this->Html->link($name, "/columna/".$user['User']['alias'].".html", array('escape'=>false));
				}
			?>
		</div>
		<div class="desc"><?php echo $user['User']['description'];?>&nbsp;</div>
	</div>
	<?php endforeach; ?>
	<div>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página %page% de %pages%, mostrando %current% usuarios de un total %count%', true)
	));
	?>	</div>
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('anterior', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
	 |
			<?php echo $this->Paginator->next(__('siguiente', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>