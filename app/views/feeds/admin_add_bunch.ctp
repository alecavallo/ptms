<?php
	echo $this->Form->create('Feed',array('controller'=>"feeds",'action'=>"admin/add/1"));
?>

<table border="1">
	<tr>
		<th>Redes Sociales</th><th>País</th><th>Provincia</th><th>Ciudad</th><th>Categoría</th><th>Nombre</th><th>XML</th><th>URL sitio</th><th>Habilitado</th>
	</tr>
	<?php
		$i=0;
		foreach ($fdata[1] as $row) {
			if ($row[0]!="Medios") {
				$td = $this->Form->checkbox("Feed.social_network.{$i}",array('checked'=>true,'id'=>"FeedSocialNetwork{$i}"));
				$td = $this->Html->tag('td',$td);
			}else {
				$td = $this->Form->checkbox("Feed.social_network.{$i}",array('checked'=>false,'id'=>"FeedSocialNetwork{$i}"));
				$td = $this->Html->tag('td',$td);
			}

			//país
			$txt = $this->Form->text("Country.name.{$i}",array('value'=>$row[1],'id'=>"CountryName{$i}"));
			//$txt = $jqautocomplete->searchbox("CountryName{$i}",'/country/search/', array('startText'=>$row[1],'minChars'=>3, 'selectionLimit'=>1, 'limitText'=>"Solo debe introducir un país",'asHtmlID'=>"CountryName{$i}",'selectedValuesProp'=>"id"), array('id'=>"CountryName{$i}",'label'=>false,'div'=>false));
			$td .= $this->Html->tag('td',$txt);

			//provincia
			//$selector = "function(string){  var c = $('#CountryName{$i}').val(); return jQuery.trim(c)+'-'+string}";
			//$txt = $jqautocomplete->searchbox("StateName{$i}",'/states/search/', array('startText'=>$row[2],'minChars'=>3, 'selectionLimit'=>1, 'limitText'=>"Solo debe introducir una ciudad",'asHtmlID'=>"StateName{$i}",'selectedValuesProp'=>"id",'beforeRetrieve'=>$selector), array('id'=>"StateName{$i}",'label'=>false,'div'=>false));
			$txt = $this->Form->text("State.name.{$i}",array('value'=>$row[2],'id'=>"StateName{$i}"));
			$td .= $this->Html->tag('td',$txt);

			//ciudad
			$txt = $this->Form->text("City.name.{$i}",array('value'=>$row[3],'id'=>"CityName{$i}"));
			$td .= $this->Html->tag('td',$txt);

			//categoría
			$ids = array_flip($categories);
			switch ($row[4]) {
				case 'Espectáculos y Cultura':
					$aux = 'Espectáculos';
				break;

				case 'Tecnología & Ciencia':
					$aux = 'Tecno & Ciencia';
				break;

				case 'Sociales':
					$aux="Sociedad";
				break;

				default:
					$aux = $row[4];
				break;
			}
			$selected = !empty($ids[$aux])?$ids[$aux]:$ids['No Categorizado'];
			$sel = $this->Form->select("Category.id.{$i}",$categories,$selected);
			$td .= $this->Html->tag('td',$sel);

			//nombre
			$txt = $this->Form->text("Source.name.{$i}",array('value'=>$row[5],'id'=>"SourceName{$i}"));
			$td .= $this->Html->tag('td',$txt);

			//XML
			$txt = $this->Form->text("Feed.url.{$i}",array('value'=>$row[6],'id'=>"FeedUrl{$i}"));
			$td .= $this->Html->tag('td',$txt);

			//URL sitio
			$txt = $this->Form->text("Source.url.{$i}",array('value'=>$row[7],'id'=>"SourceUrl{$i}"));
			$td .= $this->Html->tag('td',$txt);

			//habilitado
			$aux = $this->Form->checkbox("Feed.enabled.{$i}",array('checked'=>true,'id'=>"FeedEnabled{$i}"));
			$td .= $this->Html->tag('td',$aux);
			echo $this->Html->tag('tr',$td);
			$i++;
		}

	?>
</table>
<?php
	echo $this->Form->end('Enviar');
	echo $this->Js->writeBuffer(array('inline'=>true, 'safe'=>true));
?>