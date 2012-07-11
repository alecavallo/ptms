<div class="tNews">
	<div class="icon">
		<?php
			if (!empty($news['Source']) && !empty($news['Source']['icon'])) {
				echo $html->image($news['Source']['icon'], array('alt'=>$news['Source']['name'], 'width'=>"60"));
			}else {
				echo $html->para('', $news['Source']['name']);
			}
		?>
	</div>
	<div class="tContent">
		<h4 class="section aqua">
			<?php echo $news['Category']['name']?>
		</h4>
		<h3><?php echo $html->link($text->truncate(__($news['title'], true),100, array('ending'=>'...', 'exact'=>false, 'html'=>true)),$news['link'], array('escape'=>false, 'target'=>"_blank"));?></h3>
		<div class="photo">
			<?php
			if (!empty($news['Media']) && !empty($news['Media']['url'])) {
				echo $html->image($news['Media']['url'], array('alt'=>"", 'width'=>"50"));
			}
			?>
		</div>
		<p class="summary">
			<?php
				echo $text->truncate(__(Sanitize::clean(html_entity_decode($news['summary'],ENT_COMPAT,'UTF-8'),array('remove_html'=>true,'carriage'=>true,'odd_spaces'=>true)), true),150, array('ending'=>'...', 'exact'=>false, 'html'=>true));
			?>
		</p>
	</div>
	<br clear="all"/>
	<div class="mainComments">
		<span class="green right bottom"> </span>
	</div>

	<br clear="both"/>
</div>