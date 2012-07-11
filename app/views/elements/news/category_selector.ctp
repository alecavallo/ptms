<div id="catSelector" style="display:none">
	<?php
		$selected = empty($selected)?12:$selected;
		$cateTree = $this->requestAction("categories/getList");
		$options = array();
		foreach ($cateTree as $value) {
			$options[$value['Category']['id']]=$value['Category']['name'];
		}
		echo $form->create('Category');
		$attributes=array('legend'=>false,'separator'=>"<br/>");
		echo $this->Form->hidden('News.id',array('value'=>$newsId));
		echo $this->Form->select('Category', $options, $selected);
		/*echo $this->Html->tag('br');
		echo $this->Html->tag('br');*/

		$this->Js->get('#catSelector');
		$effect = $this->Js->effect('fadeOut');
		$effect = str_replace("\"", "'", $effect);
		echo $this->Form->button('Cancelar',array('type'=>"button", 'onclick'=>$effect));
		echo $ajax->submit('Proponer', array('url'=> array('controller'=>'categories', 'action'=>'propose'), 'div'=>false, 'update' => 'testdiv'));

		/*$this->Js->get('#catSelector');
		$effect = $this->Js->event
		$effect = $this->Js->effect('fadeOut');*/

		echo $form->end();
		echo $html->div('','',array('id'=>"testdiv"));
	?>
</div>