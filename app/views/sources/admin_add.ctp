<?php
echo $this->Html->css('admin_sources', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('prototype'),array('inline'=>false, 'once'=>true));
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
			$this->Form->submit('Agregar Fuente')
		);
	?>
	<br/>
	<br/>
	<br/>
	<br/>
	<fieldset>
		<legend>RSS Feeds de la fuente</legend>
			<?php
				for ($i = 0; $i < 8; $i++) {
					echo $this->Html->div('feedRow',
						$this->Form->input("Source.Feed.{$i}.url", array('label'=>array('text'=>"URL", 'id'=>"lblInput{$i}", 'class'=>"lblUrlUsuario"), 'div'=>array('class'=>'input left'))).
						$this->Html->div('input left',
							$this->Form->label("Source.Feed.{$i}.category_id", "Categoría").
							$this->Form->select("Source.Feed.{$i}.category_id", $categories, null, array('empty'=>"seleccione una categoría", 'div'=>array('class'=>'input left')))
						).
						$this->Html->div('input left',
							$this->Form->label("Source.Feed.{$i}.content_type", "Tipo").
							$this->Form->select("Source.Feed.{$i}.content_type", array(1=>"Medios", 2=>"Blogs", 3=>"Twitter"), 2)
						)/*.
						$this->Html->div('input left',
							$this->Form->label("Source.Feed.{$i}.image_url", "Icono Feed").
							$this->Form->file("Source.Feed.{$i}.image_url",array('div'=>array('class'=>'input left')))
						)*/

					);
					$this->Js->get("#Source{$i}Type");
					$this->Js->event('change', "if(this.value == 3){ $('lblInput{$i}').update('Usuario');}else { $('lblInput{$i}').update('URL'); }");
				}

			?>
		<?php //echo $this->Form->button('[+]',array('id'=>"addFeed", 'div'=>array('class'=>'input left')));?>
	</fieldset>
	<?php echo $this->Form->end('Agregar Fuente');?>
	<br clear="all"/>
</div>