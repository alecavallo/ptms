<h1 class="greyTitle" style="margin-bottom: 20px;">Noticias pendientes de ser publicadas</h1>
<img src="/img/degradee.png" alt="" class="degradee">
<div id="categoryIndicator" onclick="showHide($('categoryPicker'))">Todas</div>
<div id="categoryPicker" style="display: none;">
<?php 
	foreach ($categories as $row) {
		echo $this->Html->para('filter', 
			$this->Ajax->link($row['Category']['name'],array('controller'=>"news",'action'=>"listNews", $row['Category']['id']),array('update'=>"pendings"))
		);
	}
?>
</div>
<div id="rows">
	<?php 
	foreach ($data as $row) {
		$image = !empty($row['Feed']['Source']['User'])?$row['Feed']['Source']['User']['avatar']:"empty.jpg";
		$image = $this->Html->image($image);
		$section = $this->Html->tag('h4', $row['Category']['name'], array('class'=> "section grey"));
		$title = $this->Html->tag('h3', $row['News']['title']);
		$summary = $this->Html->para('summary', $this->Text->truncate($row['News']['summary'], 250, array('ending'=>"...", 'html'=>true, 'exact'=>false)));
		echo $this->Html->div('newsRows', $image.$section.$title.$summary);
	}
	?>
</div>