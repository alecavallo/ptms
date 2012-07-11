<div id="content">
	<div id="form">
		<?php
		echo $form->create('News', array('type'=>"post", 'action'=>"search"));
		echo $form->input('pattern', array('label'=>"Buscar: "));
		echo $form->submit('Buscar');

		?>
	</div>
	<div id="results">
		<?php
			foreach ($results as $row) {
				$category = $html->tag('h4', "{$row['Category']['name']}");
				$title = $html->tag('h3', "{$row['News']['title']}");
				$icon = $html->image($row['Feed']['Source']['icon'], array('alt'=>$row['Feed']['Source']['name'], 'width'=>"60", 'style'=>"display: block; float: left;"));
				$summary = $html->para('resultRow', $row['News']['summary']);
				$data = $html->div('data', $category.$title.$summary);
				echo $html->div('searchResult', $icon.$data);
			}
			echo $html->para('rowCount', count($results));
		?>
	</div>
	<?php
		debug($results);
	?>
</div>