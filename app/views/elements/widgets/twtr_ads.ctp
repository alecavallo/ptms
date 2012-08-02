<div class="tNews adContainer">
	<div class="icon">
		<?php
			if (!empty($ad) && !empty($ad['image'])) {
				echo $html->image($ad['image'], array('alt'=>$ad['name'], 'width'=>"65"));
			}else {
				echo $html->para('', $ad['name']);
			}
		?>
	</div>
	<div class="tContent">
		<!-- <div id="anuncio">Anuncio</div> -->
		<h4 class="section grey">
			<span style="font-weight: 400;">Anuncios</span>		</h4>
		<h3><?php echo $html->link($ad['name'],$ad['link'], array('escape'=>false, 'target'=>"_blank", 'onclick'=>"new Ajax.Request('/ads/click/{$ad['id']}'); return true;"));?></h3>
		<div class="photo">
		</div>
		<p class="summary">
			<?php
				//echo __(Sanitize::clean(html_entity_decode($ad['text'],ENT_COMPAT,'UTF-8'),array('remove_html'=>true,'carriage'=>true,'odd_spaces'=>true)), true);
				echo $text->truncate(__(Sanitize::clean(html_entity_decode($ad['text'],ENT_COMPAT,'UTF-8'),array('remove_html'=>true,'carriage'=>true,'odd_spaces'=>true)), true),150, array('ending'=>'...', 'exact'=>false, 'html'=>true));
			?>
		</p>
	</div>
	<br clear="all"/>
	<div class="mainComments">
		<span class="green right bottom"> </span>
	</div>

	<br clear="both"/>
</div>