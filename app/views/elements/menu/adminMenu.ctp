<div id="menu">
	<?php
		$content = $this->Html->link('Fuentes', array('controller'=>"sources",'action'=>'index', 'admin'=>true));
		$content .= $this->Html->tag('ul', $this->Html->tag('li', $this->Html->link('Agregar', array('controller'=>"sources", 'action'=>"add", 'admin'=>true))));
		$lis = $this->Html->tag('li',$content);

		$content = $this->Html->link('Feeds', array('controller'=>"feeds",'action'=>'index', 'admin'=>true));
		$content .= $this->Html->tag('ul', $this->Html->tag('li', $this->Html->link('Agregar', array('controller'=>"feeds", 'action'=>"add", 'admin'=>true))));
		$lis .= $this->Html->tag('li',$content);
		
		$content = $this->Html->link('Publicidades', array('controller'=>"ads",'action'=>'index', 'admin'=>true));
		$content .= $this->Html->tag('ul', $this->Html->tag('li', $this->Html->link('Agregar', array('controller'=>"ads", 'action'=>"add", 'admin'=>true))));
		$lis .= $this->Html->tag('li',$content);

		echo $this->Html->tag('ul',$lis);

	?>
</div>