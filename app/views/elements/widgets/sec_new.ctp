<div id="<?php echo $elmId?>" class="left secNew">
	<h4 class="green section"><?php echo $secCategory ?></h4>
	<h3>
		<?php echo $html->link($text->truncate($secTitle, 85, array('ending'=>'[...]', 'exact'=>false, 'html'=>true)),$secTitle_url,array('escape'=>false))?>
	</h3>
	<br />
	<?php
		if (!empty($secNewsPhoto)) {
			echo $html->image($secNewsPhoto, array('alt'=>"Foto", 'class'=>"secNewImage"));
		}

	?>
	<?php //debug($secDescription) ?>
	<p class="<?php if(!empty($secNewsPhoto)){ echo "reduced";} ?>">
		<span style="min-height: 95px; display:block;">
		<?php echo !empty($secDescription)?$text->truncate(Sanitize::html(html_entity_decode($secDescription, ENT_QUOTES, Configure::read('App.encoding')), array('remove'=>true)), 170, array('ending'=>'...', 'exact'=>false, 'html'=>true)):'' ?>
		<?php //echo !empty($secDescription)?$text->truncate(html_entity_decode($secDescription, ENT_QUOTES, Configure::read('App.encoding')), 200, array('ending'=>'...', 'exact'=>false, 'html'=>true)):'' ?>
		</span>
		<br/>
		<?php echo $html->link($text->truncate($feedImgTitle, 30, array('ending'=>'...', 'exact'=>false, 'html'=>true)), $feedImgLink, array('escape'=>false, 'style'=>"text-decoration: none;text-aling:right; float:right;", 'class'=>"noborder"))?>
		<?php //echo $html->link($feedImgTitle, $feedImgLink, array('escape'=>false, 'style'=>"text-decoration: none;text-aling:right; float:right;", 'class'=>"noborder"))?>
	</p>
	<br />
	<br />
	<div class="comments">
		<?php echo $html->link(
			$secComments." ".$html->image('comments.png',array('alt'=>"comentarios")),
			$secComments_url,
			array('escape'=>false)
			);
		?>
		<?php echo $html->link($secPhotos." ".$html->image('photosT.png',array('alt'=>"fotos")), $secPhotos_url, array('escape'=>false))?>

		<span class="date"> <?php echo $secCreated ?> - <?php echo empty($secUsr)?$html->image('rss_small.png', array('alt'=>"RSS", 'style'=>"height: 13px;")):"De".$secUsr?></span>
		<span class="green right bottom"> <?php echo $html->image('tick.png',array('alt'=>"votos",'class'=>"right"))?> <?php echo $secVotes ?></span>
	</div>
</div>