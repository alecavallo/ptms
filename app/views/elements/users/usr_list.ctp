<h1 class="greyTitle" style="margin-bottom: 20px;">Columnas</h1>
<img src="/img/degradee.png" alt="" class="degradee">
<div id="orderIndicator" onclick="showHide($('orderPicker'))"><span id="order">Rating</span>▼</div>
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
		<article itemscope itemtype="http://data-vocabulary.org/Person">
		<div class="uAvatar"><?php echo $this->Html->image(!empty($user['User']['avatar'])?$user['User']['avatar']:"empty.jpg",array('alt'=>$user['User']['alias']))?></div>
		<div class="section grey">
			<?php 
				$name = $this->Html->tag('span', "{$user['User']['first_name']} {$user['User']['last_name']}", array('class'=>"name", 'itemprop'=>"name"));
				$nick = $this->Html->tag('span', $user['User']['alias'], array('class'=>"nick", 'itemprop'=>"nickname"));
				if(!empty($user['User']['alias'])){//si el nick no es vacío, mostrar guion
					echo $this->Html->link($name." - ".$nick, "/columna/".$user['User']['alias'].".html", array('escape'=>false));
				}else {
					echo $this->Html->link($name, "/columna/".$user['User']['alias'].".html", array('escape'=>false, 'itemprop'=>"nickname"));
				}
			?>
		</div>
		<div class="desc"><?php echo $user['User']['description'];?>&nbsp;</div>
		</article>
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