<?php
//debug($feeds);
echo $this->Html->script(array('prototype'),array('inline'=>false, 'once'=>true));
echo $this->Html->css('admin_sources', 'stylesheet', array('inline' => false ));

?>
<div id="content">
<div id="FeedstblContainer">
	<table border="1">
		<?php
		$headers = array($paginator->sort('Nombre Fuente', 'Source.name'), $paginator->sort('URL Fuente', 'Source.url'), $paginator->sort('Categoría', 'Category.name'), $paginator->sort('URL Feed', 'Feed.url'), $paginator->sort('Estado', 'Feed.enabled'), $paginator->sort('Tipo', 'Feed.type'), 'Acciones');
		echo $this->Html->tableHeaders($headers);
		$aux = array();
		foreach ($feeds as $row) {
			$row['actions'] = $this->Html->link('Editar',array('controller'=>"sources", 'action'=>"admin_edit", $row['Source']['id']),array('class'=>"addAction")) . $this->Html->link('Borrar',array('action'=>"admin_delete", $row['Feed']['id']),array('class'=>"addAction"));
			unset($row['Feed']['id']);
			unset($row['Source']['id']);
			$type="";
			switch ($row['Feed']['content_type']) {
				case 1:
					$type="Medios";
				break;

				case 2:
					$type="Blogs";
				break;

				case 1:
					$type="Twitter";
				break;

				default:
					;
				break;
			}

			$enabled = "";
			switch ($row['Feed']['enabled']) {
				case 0:
					$enabled="Deshabilitado";
				break;

				case 1:
					$enabled="Habilitado";
				break;

				case 2:
					$enabled="Revisar";
				break;

				default:
					;
				break;
			}

			$aux[]=array(Sanitize::html($row['Source']['name']), Sanitize::html($row['Source']['url']), Sanitize::html($row['Category']['name']), Sanitize::html($row['Feed']['url']), $enabled, $type, $row['actions']);
		}
		echo $this->Html->tableCells($aux,array('class'=>"lightGrayBkg"), null, true);
		?>
	</table>
	<?php

		echo $paginator->prev('« Anterior ', null, null, array('class' => 'disabled'));
		echo $paginator->numbers();
		echo $paginator->next(' Siguiente »', null, null, array('class' => 'disabled'));
	?>
</div>
<!-- <div id="FeedsPreview">
<h3>Previsualización</h3>
<p id="pUrl"></p>
<iframe id="previewIf" src="" width="100%" height="410px">
  <p>Su navegador no soporta iframes!</p>
</iframe>

</div> -->
<script type="text/javascript">
$$("td.column-2").each(function(e){
	e.observe("click",
	function (event) {
		event.stop();
		/*$('pUrl').update(this.innerHTML);
		$('previewIf').src=this.innerHTML;*/
		window.open(this.innerHTML,'Preview');


	} );
}
);
$$("td.column-4").each(function(e){
	e.observe("click",
	function (event) {
		event.stop();
		/*$('pUrl').update(this.innerHTML);
		$('previewIf').src=this.innerHTML;*/
		window.open(this.innerHTML,'Preview');


	} );
}
);

</script>
<br clear="all"/>
</div>