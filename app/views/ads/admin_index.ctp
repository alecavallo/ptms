<?php 
	echo $this->Html->css(array('admin'), 'stylesheet', array('inline'=>false));
?>
<div id="content">
<?php echo $session->flash();?>
<table id="adsList" border="1">
	<?php 
		echo $html->tableHeaders(
			array(
				$this->Paginator->sort('ID', 'id'),
				$this->Paginator->sort('Nombre', 'name'),
				$this->Paginator->sort('URL', 'url'),
				"Categorías",
				"Posición",
				"Previsualización",
				"Acciones"
			),
			array('class'=>"headRow"),
			array('class'=>"tableHeader")
		);
	?>
	<?php
		$content = array();
		foreach ( $ads as $ad ){
			$aux = "";
			foreach ($ad['Category'] as $row) {
				$aux .= $html->para('showCateTable', $row['name']);
			}
			$posicion="";
			switch ($ad['Ad']['priority']) {
				case 1:
					$posicion="Medios";
				break;
				
				case 2:
					$posicion="Blogs";
				break;
				
				case 3:
					$posicion="Twitter";
				break;
				
				case 4:
					$posicion="Banner Central";
				break;
				
				case 5:
					$posicion="Todas las columnas";
				break;
				
				default:
					;
				break;
			}
			$image = !empty($ad['Ad']['url'])?$html->image($ad['Ad']['url'],array('alt'=>"no se ve"))/*.$html->image("/img/small_293/476048.gif",array('style'=>"width: 100px;"))*/:"";
			$content[] = array(
				$ad['Ad']['id'],
				$ad['Ad']['name'],
				$ad['Ad']['link'],
				$aux,
				$posicion,
				$image,
				$html->link('Editar', "edit/{$ad['Ad']['id']}")." ".$html->link('Borrar', "delete/{$ad['Ad']['id']}")
			);
		}
		echo $html->tableCells($content);
	?>
</table>
</div>