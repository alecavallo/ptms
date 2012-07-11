<?php 
echo $this->Html->css('columns', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>
<div id="content">
	<!-- <div id="ads"></div> -->
	<div id="usrDesc">
		<?php 
			echo $this->Html->image($user['User']['avatar']);
		?>
		<h3><?php echo "{$user['User']['first_name']} {$user['User']['last_name']} -- {$user['User']['last_name']}"?></h3>
		<p class="description">
			<?php echo $user['User']['description']?>
		</p>
		<p id="webPage">
			<?php echo $this->Html->link($user['Source']['url'],$user['Source']['url'],array('target'=>"blank"))?>
		</p>
	</div>
	<div id="newsList">
		<?php 
		foreach ($news as $row) {
			$image = !empty($user['User']['avatar'])?$user['User']['avatar']:"empty.jpg";
			$image = $this->Html->image($image);
			$section = $this->Html->tag('h4', $row['Category']['name'], array('class'=> "section grey"));
			$title = $this->Html->link($this->Html->tag('h3', $row['News']['title']), $row['News']['link'], array('target'=>'blank', 'escape'=>false));
			$summary = $this->Html->para('summary', $this->Text->truncate($row['News']['summary'], 250, array('ending'=>"...", 'html'=>true, 'exact'=>false)));
			echo $this->Html->div('newsRows', $image.$section.$title.$summary);
		}
		?>
	</div>
	<br clear="both"/>
	<br clear="both"/>
	<br clear="both"/>
</div>