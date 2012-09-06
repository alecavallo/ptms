<?php
echo $javascript->link('ckeditor/ckeditor.js',array('inline'=>false));
echo $this->Html->script(array('tweeter/jquery', 'underscore', 'prototype'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));

echo $this->Html->script('prototype',array('inline'=>false));
?>
<?php echo $this->element('betanotice'/*, array('cache'=>'30 minutes')*/)?>
<div class="steps">
	<div id="scontainer">
		<div class="step completed">
			<div class="indicator" id="st1"><h3>1</h3></div>
			<h3 id="std1">Escribe el artículo</h3>
		</div>
		<div class="step">
			<div class="indicator" id="st3"><h3>2</h3></div>
			<h3 id="std3">Previsualizar</h3>
		</div>
		<div class="step">
			<div class="indicator" id="st4"><h3>3</h3></div>
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
	<?php echo $this->Form->create('News',array('id'=>"addNews", 'enctype' => 'multipart/form-data', 'url'=>array('controller'=>"news",'action'=>"add",'step:1')));?>
		<?php
			echo $this->Form->input('title',array('label'=>__('Título:<br/>',true),'div'=>array('class'=>"newsItem"),'class'=>"writeSc"));

			echo $this->Form->input('summary',array('label'=>__('Copete:<br/>',true), 'class'=>"writeSc"));

			echo "<br clear=\"all\"/>";
			echo $this->Form->label('body', "Artículo: ");
			echo $this->Form->textarea('body');
			if (!empty($errors['body'])) {
				echo $html->div('error-message',$errors['body']);
			}
			
			/*creo box para fotos*/
			$img = $this->Form->label('tags',__('Foto:',true));
			$img .= $this->Form->input('photo', array('label'=>false,'type'=>'file'));
			echo $this->Html->div('optionBox',$img,array('id'=>'photo'));
			
			/*creo select para categorías*/
			$cateSelect = $this->Form->label('Category',__('Categoría:',true));
			$cateSelect .= $this->Form->select('Category', $categories, null, array('empty'=>__('Seleccione una categoría',true)));
			echo $this->Html->div('optionBox lightGreenBkg',$cateSelect,array('id'=>'categories'));
			
			
			
			/*creo box para tags*/
			$pageTags = $this->Form->label('tags',__('Tags:',true))."<br />";
			$pageTags .= $this->Form->text('Tags',array('id'=>"tagsInput"));
			$pageTags .= $this->Form->hidden('TagsList');
			$pageTags .= $this->Form->hidden('coordinates');
			
			$pageTags .= $this->Html->div('tagsSet',"",array('id'=>'tagsSet'));
			$pageTags .= "<br />";

			/*escucho los clicks hechos en los tags para quitarlos de twitter también*/
			$this->Js->buffer("function closess(elem){var parent = $(elem).ancestors()[0]; parent.remove(); var search = '';
				$$('.tagsSet div span.txt').each(function(s){search += s.innerHTML + ' OR '});
				if( search.length > 4){
					search = search.substring(0, search.length-4);
				}
				}");
			echo $this->Js->writeBuffer(array('inline'=>true, 'onDomReady'=>false));
			echo $this->Html->div('optionBox',$pageTags,array('id'=>'tags'));

			/*escucho las keys presionadas para validar y detectar un input*/
			$tagsValidation = "
			if(event.keyCode==13 || event.keyCode==188){
				event.stop();
				var newTag = new Element('div',{'class': 'tag'});
				var textBox = $('tagsInput');
				$('NewsTagsList').value = $('NewsTagsList').value+'|#|'+textBox.value;

				newTag.update($('tagsInput').innerHTML+'<span class=\"txt\">'+textBox.value+'</span>'+'   <span onclick=\"closess($(this));\" class=\\'green close\\'><strong>x</stong></span>');
				textBox.value='';
				var container = $('tagsSet');
				container.appendChild(newTag);
				var search = '';
				$$('.tagsSet div span.txt').each(function(s){search += s.innerHTML + ' OR '});
				if( search.length > 4){
					search = search.substring(0, search.length-4);
				}

			}";
			//$this->Js->buffer($tagsValidation);
			//echo $this->Js->writeBuffer(array('inline'=>true, 'onDomReady'=>false));
			$this->Js->get('#tags');
  			$this->Js->event('keydown',$tagsValidation,array('stop'=>false));
  			echo $this->Js->writeBuffer();



			/*creo select para país*/
  			echo $this->Form->hidden('Country',array('value'=>1));
			
			
			$buttons = $this->Form->submit(__('Siguiente',true),array('id'=>"createNews"));
			echo $this->Html->div('right',$buttons,array('style'=>"margin-right: 30px; width: 309px; font-size: 15px"));
		?>
	<?php echo $this->Form->end();?>
	<br clear="all"/>
	</div>
	<div id="colRight">
	
		<?php
		if(Router::url("/",true) != "http://posteamos.localhost.com/"){//
		?>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Anuncio columnas y pendientes 1 */
		google_ad_slot = "2925543696";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Anuncio columnas y pendientes 2a */
		google_ad_slot = "3802193888";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Anuncio columnas y pendientes 3 */
		google_ad_slot = "1111764142";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<?php }?>

		<br clear="all"/>
	</div>
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
  	<?php
		if(Router::url("/",true) != "http://posteamos.localhost.com/"){//
	?>
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-6965617047977932";
	/* Footer-Bloque Anuncios */
	google_ad_slot = "6067688955";
	google_ad_width = 728;
	google_ad_height = 15;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<?php }?>
	<!-- Google Code for P&aacute;gina de publicidad Conversion Page -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 995381652;
	var google_conversion_language = "en";
	var google_conversion_format = "3";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "BFwtCLTz8wMQlKPR2gM";
	var google_conversion_value = 0;
	/* ]]> */
	</script>
	<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/995381652/?value=0&amp;label=BFwtCLTz8wMQlKPR2gM&amp;guid=ON&amp;script=0"/>
	</div>
	</noscript>
	<br clear="all"/>
</div>