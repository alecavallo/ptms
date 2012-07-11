<?php
echo $this->Html->css('admin_sources', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('prototype', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>
<div id="content">
	<?php
		echo $this->Form->create("Source", array('enctype' => 'multipart/form-data'));
		echo $this->Html->div('sourceData',
			$this->Form->input('Source.name', array('label'=>"Nombre")).
			$this->Form->input('Source.url', array('label'=>"URL")).
			$this->Html->div('input',
				$this->Form->label('data[SourceIcon][0]', "Icono Fuente").
				$fileUpload->input(array('var' => 'SourceIcon', 'model' => false))
			).
			$this->Form->error('Source.icon', isset($source_icon_error)?$source_icon_error:"").
			$this->Form->error('Source.icon', isset($source_size_error)?$source_size_error:"").
			$this->Form->error('Source.icon', isset($source_tmp_name_error)?$source_tmp_name_error:"").
			$this->Form->error('Source.icon', isset($source_type_error)?$source_type_error:"").
			$this->Form->error('Source.icon', isset($source_error_error)?$source_error_error:"").
			$this->Form->button('Cancelar', array('id'=>"cancel1", 'class'=>"cancel")).
			$this->Form->submit('Guardar Cambios')
		);
	?>
	<br/>
	<br/>
	<br/>
	<br/>
	<div id="delMessage" style="display: none"></div>
	<fieldset>
		<legend>RSS Feeds de la fuente</legend>
			<?php
				for ($i = 0; $i < 8; $i++) {
					echo $this->Html->div('feedRow',
						$this->Form->hidden("Feed.{$i}.id").
						$this->Form->input("Feed.{$i}.url", array('label'=>array('text'=>"URL", 'id'=>"lblInput{$i}", 'class'=>"lblUrlUsuario"), 'div'=>array('class'=>'input left'))).
						$this->Html->div('input left',
							$this->Form->label("Feed.{$i}.category_id", "Categoría").
							$this->Form->select("Feed.{$i}.category_id", $categories, null, array('empty'=>"seleccione una categoría", 'div'=>array('class'=>'input left')))
						).
						$this->Html->div('input left',
							$this->Form->label("Feed.{$i}.content_type", "Tipo").
							$this->Form->select("Feed.{$i}.content_type", array(1=>"Medios", 2=>"Blogs", 3=>"Twitter"))
						).
						$this->Html->div('input left',
							$this->Ajax->link('Borrar', 
								"/admin/feeds/delete/{$this->data['Feed'][$i]['id']}/delMessage/row{$i}",
								array(
									'update'=>'delMessage',
								)
							)
						),
						array('id'=>"row{$i}")

					);
					$this->Js->get("#Source{$i}ContentType");
					$this->Js->event('change', "if(this.value == 3){ $('lblInput{$i}').update('Usuario');}else { $('lblInput{$i}').update('URL'); }");

					$this->Js->get(".cancel");
					$this->Js->event('click', "window.location = '".Router::url(array('controller'=>"sources",'admin'=>true,'action'=>"index"))."'");
				}

			?>
		<?php //echo $this->Form->button('[+]',array('id'=>"addFeed", 'div'=>array('class'=>'input left')));?>
	</fieldset>
	<?php
		echo $this->Form->button('Cancelar', array('id'=>"cancel2", 'class'=>"cancel"));
		echo $this->Form->end('Guardar Cambios');
	?>
	<br clear="all"/>
</div>