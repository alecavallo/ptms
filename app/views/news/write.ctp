<?php
echo $javascript->link('ckeditor/ckeditor.js',array('inline'=>false));

echo $this->Html->script('prototype',array('inline'=>false));
?>

<div class="steps">
	<div id="scontainer">
		<div class="step completed">
			<div class="indicator" id="st1"><h3>1</h3></div>
			<h3 id="std1">Escribe el artículo</h3>
		</div>
		<div class="step">
			<div class="indicator" id="st2"><h3>2</h3></div>
			<h3 id="std2">Opciones</h3>
		</div>
		<div class="step">
			<div class="indicator" id="st3"><h3>3</h3></div>
			<h3 id="std3">Previsualizar</h3>
		</div>
		<div class="step">
			<div class="indicator" id="st4"><h3>4</h3></div>
			<h3 id="std4">Publicar o Guardar</h3>
		</div>
	</div>
</div>
<div id="news_content">

	<div id="editNewscolLeft">
	<?php echo $this->Session->flash();?>
	<h3><?php __('Publicar Nota')?></h3>
	<hr noshade="noshade" style="background-color: #999999; height: 1px; border-style:none;"/>
	<br/>
	<?php echo $this->Form->create('News',array('id'=>"addNews", 'url'=>array('controller'=>"news",'action'=>"add",'step:1')));?>
		<?php
			echo $this->Form->input('title',array('label'=>__('Título:<br/>',true),'div'=>array('class'=>"newsItem"),'class'=>"writeSc"));

			echo $this->Form->input('summary',array('label'=>__('Copete:<br/>',true), 'class'=>"writeSc"));

			echo "<br clear=\"all\"/>";
			echo $this->Form->label('body', "Artículo: ");
			echo $this->Form->textarea('body');
			if (!empty($errors['body'])) {
				echo $html->div('error-message',$errors['body']);
			}
			$buttons = $this->Form->submit(__('Siguiente',true),array('id'=>"createNews"));
			echo $this->Html->div('right',$buttons,array('style'=>"margin-right: 30px; width: 309px; font-size: 15px"));
		?>
	<?php echo $this->Form->end();?>
	<br clear="all"/>
	</div>
	<!-- <div id="colRight">

	<br clear="all"/>
</div> -->
<script type="text/javascript">

	var ck_newsContent = CKEDITOR.replace( 'NewsBody',
			{
				skin : 'office2003',
				toolbar : 'AddNews'
			}
	);
	//ck_newsContent.setData( 'Escriba la noticia aquí' );
</script>
  <?php

		$CKsave = "function CKsave(){ $('NewsBody').update(CKEDITOR.instances.NewsBody.getData());$('addNews').submit(); }";
		$this->Js->buffer($CKsave);
		echo $this->Js->writeBuffer(array('inline'=>true, 'onDomReady'=>false));

  	$this->Js->get('#NewsTitle');
  	$this->Js->event('click',"$('helpMsg').update('Ingrese un título corto');");

  	$this->Js->get('#createNews');
  	$this->Js->event('click',"CKsave()");
  	//$this->Js->event('blur',"$('helpMsg').update('Aquí usted puede crear su propia noticia!');");

  	$this->Js->get('#NewsSummary');
  	$this->Js->event('click',"$('helpMsg').update('Ingrese el copete. Caso contrario, será seleccionado el primer párrafo del cuerpo de la noticia');");
  	$this->Js->event('blur',"$('helpMsg').update('Aquí usted puede crear su propia noticia!');");
  ?>