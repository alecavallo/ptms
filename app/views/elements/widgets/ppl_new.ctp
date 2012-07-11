<div id="main">
	<div id="title">
		<h4 class="section aqua">
			<?php echo $category?>
		</h4>
		<h1 class="title">
			<?php echo $html->link($pplTitle,$pplTitle_url,array('escape'=>false))?>
		</h1>
	</div>
	<?php
	if (!empty($new_photo)) {
	?>
	<div id="photo">
		<?php echo $html->image($new_photo, array('alt'=>"Foto", 'class'=>"pplNewsImage"))?>
	</div>
	<?php
	}
	?>


	<div id="description" class="<?php if(!empty($new_photo)){ echo "reduced";}?>">
		<p class="copete">
			<?php echo $description ?>
			<br />
			<?php echo $html->link($feedImgTitle, $feedImgLink, array('escape'=>false, 'class'=>"noborder source", 'style'=>"float:right"))?>
		</p>

		<br clear="all"/>
		<div class="mainComments">
			<?php echo $html->link(
				$comments." ".$html->image('comments.png',array('alt'=>"comentarios")),
				$comments_url,
				array('escape'=>false)
				);
			?>
			<?php echo $html->link($photos." ".$html->image('photos.png',array('alt'=>"fotos")), $photos_url, array('escape'=>false))?>

			<span class="date"> <?php echo $created ?> - <?php echo empty($usr)?$html->image('rss_small.png', array('alt'=>"RSS", 'style'=>"height: 13px;")):"De".$usr?></span>
			<span id = "votes_<?= rand(1, 300) ?>" class="green right bottom"> <?php echo $html->image('tick.png',array('alt'=>"votos"))?> <?php echo $votes ?></span>
		</div>
	</div>
	<div style="clear:both; height: 1px;"></div>
</div>