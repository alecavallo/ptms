<?php 
echo $this->Html->css('columns', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>
<div id="content">
<div id="submenu">
<ul id="sections">
	<li class="normal selected" onclick="$$('li.normal').each(function(e){e.removeClassName('selected');});$(this).addClassName('selected');$('pending').hide(); $('colLeft').show()">Columnas</li>
	<li class="normal" onclick="$$('li.normal').each(function(e){e.removeClassName('selected');});$(this).addClassName('selected');$('colLeft').hide();$('pending').show()">Pendientes</li>
</ul>
</div>
	<?php //echo $this->element('news'.DS.'marquee')?>
	<div id="colLeft" class="colLeft">
		<?php 
		    $this->Paginator->options(array(
		    'update' => 'colLeft',
		    'evalScripts' => true
		    ));
		?>
		<?php echo $this->element('users'.DS.'usr_list',array('users', $users))?>
		
	</div>
	<div id="pending" style="display: none">
		<?php echo $this->element('news'.DS.'pendings', array('categories'=>$categories))?>
	</div>
	
	<br clear="all"/>
</div>
