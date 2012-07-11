<?php
	echo $this->Html->script('prototype',array('inline'=>false));
?>
<div class="steps">
	<div id="scontainer">
		<div class="step completed">
			<div class="indicator" id="st1"><h3>1</h3></div>
			<h3 id="std1">Escribe el artículo</h3>
		</div>
		<div class="step completed">
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

	<div id="colLeft">
		<?php echo $this->Session->flash();?>
		<h2><?php __('Publicar Nota - Opciones')?></h2>
		<hr noshade="noshade" style="background-color: #999999; height: 1px; border-style:none;"/>
		<br/>
		<?php
			echo $this->Form->create('News',array('id'=>"addNews", 'url'=>array('controller'=>"news",'action'=>"add",'step:2')));
			/*creo select para categorías*/
			$cateSelect = $this->Form->label('Category',__('Categoría:',true))."<br />";
			$cateSelect .= $this->Form->select('Category', $categories, null, array('empty'=>__('Seleccione una categoría',true)));
			echo $this->Html->div('optionBox lightGreenBkg',$cateSelect,array('id'=>'categories'));
			/*creo box para tags*/
			$pageTags = $this->Form->label('tags',__('Tags:',true))."<br />";
			$pageTags .= $this->Form->text('Tags',array('id'=>"tagsInput"));
			$pageTags .= $this->Form->hidden('TagsList');
			$pageTags .= $this->Form->hidden('coordinates');
			$twitter = "<script src=\"http://widgets.twimg.com/j/2/widget.js\"></script>
<script>
tweetPoint = '{$coordinates['latitude']},{$coordinates['longitude']},25km';
$('NewsCoordinates').value = tweetPoint;
var widget = new TWTR.Widget({
  version: 2,
  type: 'search',
  search: 'geocode:'+tweetPoint,
  interval: 6000,
  title: 'Tags de la noticia',
  subject: 'TituloDeNoticia',
  width: 500,
  height: 162,
  theme: {
    shell: {
      background: '#8ac33f',
      color: '#000000'
    },
    tweets: {
      background: '#ffffff',
      color: '#444444',
      links: '#1985b5'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    hashtags: true,
    timestamp: true,
    avatars: true,
    toptweets: true,
    behavior: 'default'
  }
}).render().start();
</script>";
			$pageTags .= $this->Html->div('tagsSet',"",array('id'=>'tagsSet'));
			$pageTags .= "<br />";
			$pageTags .= $twitter;

			/*escucho los clicks hechos en los tags para quitarlos de twitter también*/
			$this->Js->buffer("function closess(elem){var parent = $(elem).ancestors()[0]; parent.remove(); var search = '';
				$$('.tagsSet div span.txt').each(function(s){search += s.innerHTML + ' OR '});
				if( search.length > 4){
					search = search.substring(0, search.length-4);
				}
				widget.destroy().setSearch(search+' geocode:'+tweetPoint).render().start();}");
			echo $this->Js->writeBuffer(array('inline'=>true, 'onDomReady'=>false));
			echo $this->Html->div('optionBox',$pageTags,array('id'=>'tags'));

			/*escucho las keys presionadas para validar y detectar un input*/
			$tagsValidation = "
			if(event.keyCode==13){
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
				widget.destroy().setSearch(search+' geocode:'+tweetPoint).render().start();

			}";
			//$this->Js->buffer($tagsValidation);
			//echo $this->Js->writeBuffer(array('inline'=>true, 'onDomReady'=>false));
			$this->Js->get('#tags');
  			$this->Js->event('keydown',$tagsValidation,array('stop'=>false));
  			echo $this->Js->writeBuffer();



			/*creo select para país*/
			$countrySelect = $this->Form->label('Country',__('País:',true),array('id'=>"lCountry"))."<br />";
			$countrySelect .= $this->Form->select('Country', $countries, null, array('class'=>"lSelector", 'empty'=>__('Seleccione un país',true)));
			$countrySelect = $this->Html->div('left', $countrySelect);
			/*creo select para provincia*/
			$stateSelect = $this->Form->label('State',__('Provincia:',true),array('id'=>"lState", 'style'=>"display:none;"))."<br />";
			$stateSelect .= $this->Form->select('State', array(), null, array('style'=>"display:none;",'class'=>"lSelector", 'empty'=>__('Seleccione una provincia',true)));
			$stateSelect = $this->Html->div('left', $stateSelect, array('style'=>"margin-left: 15px"));
			/*creo select para ciudad*/
			$citySelect = $this->Form->label('City',__('Ciudad:',true),array('id'=>"lCity", 'style'=>"display:none;"))."<br />";
			$citySelect .= $this->Form->select('City', array(), null, array('style'=>"display:none;", 'empty'=>__('Seleccione una ciudad',true)));
			$citySelect = $this->Html->div('left', $citySelect, array('style'=>"margin-left:15px"));

			echo $this->Html->div('optionBox',$countrySelect.$stateSelect.$citySelect, array('id'=>'countries'));

			/*creo el manejador de eventos para cuando se selecciona un país*/
			$this->Js->get('#NewsCountry');

			$populateStates = "
				d = response.responseJSON;
				var s = $('NewsState');

				s.childElements().each( function(r) { r.remove() });

				//var o = new Element('option');
				var o = new Element('Option',{ value: 0 });
				o.innerHTML = 'Seleccione una provincia';
				//o.value = 0;
				s.appendChild(o);

				d.states.each( function (r) {
					var o = new Element('Option',{value: r['State']['id'] });
					o.innerHTML = r['State']['name'];
					//o.value = r['State']['id'];
					s.appendChild(o);
				});
				s.show();

				var search = '';
				$$('.tagsSet div span.txt').each(function(h){search += h.innerHTML + ' OR '});
				if( search.length > 4){
					search = search.substring(0, search.length-4);
				}
				tweetPoint = d.coordinates.latitude+','+d.coordinates.longitude+',1000km'
				$('NewsCoordinates').value = tweetPoint;
				widget.destroy().setSearch(search+' geocode:'+tweetPoint).render().start();
			";
			$selCountry = $this->Js->request(array('controller'=>"states", 'action'=>"searchByCountryId"), array('method'=>"GET", 'type'=>"json", 'data'=>"'id='+Event.element(event).value", 'dataExpression'=>true, 'before' => "$('lState').show();", 'success'=>$populateStates, 'error'=>"alert('".__('No se pudiron obtener los datos. Refresque la pantalla e intente nuevamente',true)."')"));
  			$this->Js->event('change',$selCountry, array('stop'=>false));

  			/*creo el manejador de eventos para cuando se selecciona una provincia*/
			$this->Js->get('#NewsState');
			$populateCities = "
				d = response.responseJSON;
				var s = $('NewsCity');

				s.childElements().each( function(r) { r.remove() });

				var o = new Element('option');
				o.text = 'Seleccione una ciudad';
				o.value = 0;
				s.appendChild(o);

				d.cities.each( function (r) {
					var o = new Element('option');
					o.text = r['City']['name'];
					o.value = r['City']['id'];
					s.appendChild(o);
				});
				s.show();
				var search = '';
				$$('.tagsSet div span.txt').each(function(h){search += h.innerHTML + ' OR '});
				if( search.length > 4){
					search = search.substring(0, search.length-4);
				}
				tweetPoint = d.coordinates.latitude+','+d.coordinates.longitude+',300km';
				$('NewsCoordinates').value = tweetPoint;
				widget.destroy().setSearch(search+' geocode:'+tweetPoint).render().start();
			";
			$selState = $this->Js->request(array('controller'=>"cities", 'action'=>"searchByStateId"), array('method'=>"GET", 'type'=>"json", 'data'=>"'id='+Event.element(event).value", 'dataExpression'=>true, 'before' => "$('lCity').show();", 'success'=>$populateCities, 'failure'=>"alert(".__('No se pudiron obtener los datos. Refresque la pantalla e intente nuevamente',true).'"'));
  			$this->Js->event('change',$selState, array('stop'=>false));

  			/*creo el manejador de eventos para cuando se selecciona una ciudad*/
			$this->Js->get('#NewsCity');
			$populateCities = "
				d = response.responseJSON;
				var s = $('NewsCity');
				var search = '';
				$$('.tagsSet div span.txt').each(function(h){search += h.innerHTML + ' OR '});
				if( search.length > 4){
					search = search.substring(0, search.length-4);
				}
				tweetPoint = d.coordinates.latitude+','+d.coordinates.longitude+',25km';
				$('NewsCoordinates').value = tweetPoint;
				widget.destroy().setSearch(search+' geocode:'+tweetPoint).render().start();
			";
			$selCity = $this->Js->request(array('controller'=>"cities", 'action'=>"getCoordinates"), array('method'=>"GET", 'type'=>"json", 'data'=>"'id='+Event.element(event).value", 'dataExpression'=>true, 'success'=>$populateCities, 'failure'=>"alert(".__('No se pudo geolocalizar los tweets. Refresque la pantalla e intente nuevamente',true).'"'));
  			$this->Js->event('change',$selCity, array('stop'=>false));

  			$buttons = $this->Html->link(__('Anterior',true),array('controller'=>"news", 'action'=>"add", "step:1"), array('class'=>"prevBtn"));
  			$buttons .= $this->Form->submit(__('Siguiente',true),array('id'=>"createNews"));
  			echo $this->Html->div('right',$buttons,array('style'=>"margin-right: 30px; width: 309px; font-size: 15px"));
		?>
	</div>
	<div id="colRight">
	<h2><?php __('Ayuda')?></h2>
	<hr noshade="noshade" style="background-color: #999999; height: 1px; border-style:none;"/>
	<br/>
	<div id="help" class="helpMessage">
		<p id="helpMsg"></p>
	</div>
	<br/>
	</div>
	<br clear="all"/>
</div>