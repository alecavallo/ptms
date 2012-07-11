<div id="timelinemain">
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
		<?php
			echo $html->image($new_photo, array('alt'=>"Foto", 'width'=>"180"));

		?>
	</div>
	<?php
		}
	?>
	<div id="timelinedescription" style="<?php if (empty($new_photo)){ echo "width: 100%";} ?>">
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

			<span class="date"> <?php echo $created ?> - <?php echo empty($usr)?"RSS":"De".$usr?></span>
			<span class="green right bottom"> <?php echo $html->image('tick.png',array('alt'=>"votos"))?> <?php echo $votes ?></span>
		</div>
	</div>
	<div style="clear:both; height: 1px;"></div>
</div>