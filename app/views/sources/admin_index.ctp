<?php
echo $this->Html->script(array('prototype'),array('inline'=>true, 'once'=>true));
echo $this->Html->css('admin_sources', 'stylesheet', array('inline' => false ));

?>
<div id="content">
<div id="tblContainer">
	<table border="1">
		<?php
		$headers = array($paginator->sort('Nombre', 'name'), $paginator->sort('URL', 'url'), 'Opciones');
		echo $this->Html->tableHeaders($headers);
		$aux = array();
		foreach ($sources as $row) {
			$row['Source']['options'] = $this->Html->link('Editar',array('action'=>"admin_edit", $row['Source']['id']),array('class'=>"addAction")) . $this->Html->link('Borrar',array('action'=>"admin_delete", $row['Source']['id']),array('class'=>"addAction"));
			unset($row['Source']['id']);
			$aux[]=$row['Source'];
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
<div id="preview">
<h3>Previsualización</h3>
<p id="pUrl"></p>
<iframe id="previewIf" src="" width="100%" height="410px">
  <p>Su navegador no soporta iframes!</p>
</iframe>
</div>
<script type="text/javascript">
$$("td.column-2").each(function(e){
		e.observe("click",
		function (event) {
			event.stop();
			$('pUrl').update(this.innerHTML);
			$('previewIf').src=this.innerHTML;


		} );
	}
);
</script>
<br clear="all"/>
</div>