<?php 
echo $this->Html->css(array('admin', 'fileuploader'), 'stylesheet', array('inline'=>false));
echo $this->Html->script(array('http://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js', 'fileuploader'), array('inline'=>false, 'once'=>true));
?>
<div id="content">
	<div id = "AdsImg" class="adsRow">
		<?php 
		echo $session->flash();
		echo $this->Form->create('Ad', array('type'=>"file", 'id'=>"Ads", 'name'=>"Ads"));
		$catChks = $this->Html->para('cates',"Categorías");
		
		$options = array();
		foreach ($categories as $key=>$value) {
			//$catChks .= $this->Form->input('CategoriesAd.category_id.['.$key.']', array('value'=>$key, 'type'=>"checkbox", 'label'=>$value));
			$options[$key] = $value; 
		}
		    $catChks .= $this->Form->input('Category', array(
			    'type' => 'select',
			    'multiple' => 'checkbox',
		    	'div'		=>	false,
		    	'label'		=>	false,
//			    'options' => $options
		    ));
		//$catChks .= $form->input('Category');
		
		echo $this->Html->div('cates', $catChks);
		$options = array(
			0 => 'Imágen',
			1 => 'Twitter',
			2 => 'Facebook',
			3 => 'Texto'
		);
		echo $this->Form->input('Ad.socialnetwork', array('options'=>$options, 'default'=>0, 'label'=>"Tipo Publicidad", 'empty'=>false, 'title'=>"Especifique si la publicidad proviene de una red social"));
		//echo $this->Form->input('Ad.twitter', array('type'=>"checkbox", 'label'=>"Publicidad twitter", 'div'=>array('id'=>"twitter")));
		echo $this->Form->input('Ad.name', array('label'=>"Nombre"));
		echo $this->Form->input('Ad.link', array('label'=>array('id'=>"link", 'text'=>"Link")));
		$options = array(
			5	=>	'Todos',
			1	=> 'Columna Central (Medios)',
			2	=>	'Columna Derecha (Blogs)',
			3	=>	'Columna izquierda (twitter)',
			4	=>	'Banner Central'
		);
		echo $this->Form->select('Ad.priority', $options, null, array('empty'=>"Seleccione Posición", 'label'=>"Posición", 'title'=>"Seleccione la posición en la que aparecerá la publicidad"));
		echo $this->Html->tag('br');
		echo $this->Html->tag('br');
		echo $this->Form->input('Ad.url',array('label'=>"Avatar",'div'=>array('class'=>'textAds')));
		echo $this->Form->input('Ad.url_img',array('label'=>"Imagen",'div'=>array('class'=>'textAds')));
		echo $this->Form->input('Ad.text',array('label'=>"Texto",'type'=>"textarea",'div'=>array('class'=>'textAds')));
		
        echo $this->Form->submit('Agregar');
        echo $this->Html->tag('br');
		echo $this->Html->tag('br');
        echo $this->Html->div('', "", array('id'=>"button"));
$uploader = <<<IMGUPLOADER
			var imgCnt = 1;
	        var uploader = new qq.FileUploader({
	            // pass the dom node (ex. $(selector)[0] for jQuery users)
	            element: document.getElementById('button'),
	            // path to server-side upload script
	            action: '/admin/ads/tmpUpload',
	            debug: 'true',
	            onSubmit: function(id, fileName){ $('prvImg').src='/img/loading.gif'; $('prvImg').setStyle('height: 20px; width: 20px;') },
	            onComplete: function(id, fileName, responseJSON){ 
	            	$('prvImg').src='/img/ads/tmp/'+fileName;	
	            	var hForm = new Element('input', { id: 'AdUrl'+imgCnt, name: 'data[Ad][url]['+imgCnt+']', type: 'hidden' } );
	            	hForm.value='/img/ads/tmp/'+fileName; 
	            	$('Ads').insert({'bottom': hForm}); 
	            	$('prvImg').setStyle('height:124px; width:380px;'); 
	            	imgCnt += 1;
	            },
	            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif']
		        
	        });
IMGUPLOADER;

        echo $this->Javascript->codeBlock($uploader, array('safe'=>true,'inline'=>true));
        
$noscript = <<<NOSCRIPT
<noscript>          
	<br/><br/>
	
	<p style="color: red">Es necesario habilitar el soporte Javascript para poder hacer uso de todas las funcionalidades de carga de archivos en ésta página</p>
</noscript>
NOSCRIPT;
	echo $noscript;
	echo $this->Form->end();
	$img = $this->Html->para('lala', "<b>Previsualizacion</b>");
	$img .= $this->Html->image('empty.jpg', array(/*'style' => "height:124px", */'id'=>"prvImg"));
	echo $this->Html->div('preview', $img, array('id'=>'preview'));
?>
	<br clear="all"/>
	</div>
	<br clear="all"/>
</div>
<?php 
$this->Js->get('#AdPriority');
$this->Js->event('change', "var elem = event.element(); if(elem.value == 4){ $('prvImg').setStyle('height:144px; width:1080px;'); } else { $('prvImg').setStyle('height: 124px;width:380px;'); }");
?>
<script type="text/javascript">
	$('AdText').observe('keypress',function(e){
		if($('AdText').value.length >= 148){
			if(e.keyCode != Event.KEY_BACKSPACE || e.keyCode != Event.KEY_TAB || e.keyCode != Event.KEY_ESC || e.keyCode != Event.KEY_LEFT ||
				e.keyCode != Event.KEY_UP || e.keyCode != Event.KEY_RIGHT || e.keyCode != Event.KEY_DOWN || e.keyCode != Event.KEY_DELETE || 
				e.keyCode != Event.KEY_HOME || e.keyCode != Event.KEY_END || e.keyCode != Event.KEY_PAGEUP || e.keyCode != Event.KEY_PAGEDOWN ||
				e.keyCode != Event.KEY_INSERT){
				
					alert('No se pueden introducir mas de 148 caracteres!');
					Event.stop(e);
					return false;
			}else{
				return true;
			}
			
		}
	});
	$('AdText').observe('blur',function(e){
		if($('AdText').value.length >= 148){
					alert('No se pueden introducir mas de 148 caracteres!');
					Event.stop(e);
					$('AdText').focus();
					return false;
		}else{
			return true;
		}
			
	});
</script>
<script type="text/javascript">
//$$('.textAds').each(Element.hide);
var selected = $('AdSocialnetwork').value;
		//console.log(selected);
		switch(selected){
		case '0':
			$('button').show();
			$('preview').show();
			$('link').update('Link');
			$$('.textAds').each(Element.hide);
			break;
		case '1':
			$('button').hide();
			$('preview').hide();
			$('link').update('Twitter ID');
			$$('.textAds').each(Element.hide);
			break;

		case '2':
			$('button').hide();
			$('preview').hide();
			$('link').update('Facebook ID');
			$$('.textAds').each(Element.hide);
			break;

		case '3':
			$('button').hide();
			$('preview').hide();
			$('link').update('Link');
			$$('.textAds').each(Element.show);
			break;
		}

$('AdSocialnetwork').observe('change',
	function(event){
		var selected = $('AdSocialnetwork').value;
		//console.log(selected);
		switch(selected){
		case '0':
			$('button').show();
			$('preview').show();
			$('link').update('Link');
			$$('.textAds').each(Element.hide);
			break;
		case '1':
			$('button').hide();
			$('preview').hide();
			$('link').update('Twitter ID');
			$$('.textAds').each(Element.hide);
			break;

		case '2':
			$('button').hide();
			$('preview').hide();
			$('link').update('Facebook ID');
			$$('.textAds').each(Element.hide);
			break;

		case '3':
			$('button').hide();
			$('preview').hide();
			$('link').update('Link');
			$$('.textAds').each(Element.show);
			break;
		}

	}
);
</script>