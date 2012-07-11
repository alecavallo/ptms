<?php
	$pplSNews= array_shift($sNews['News']);
	//debug($pplSNews['Media']);
	$imgUrl = !empty($pplSNews['Media'])?$pplSNews['Media'][0]['url']:null;
	$created = date_format(date_create($pplSNews['created']), "H:i");
	$usr = !empty($pplSNews['User'])?$pplSNews['User']['alias']:$html->image('rss_small.png', array('alt'=>"RSS", 'style'=>"height: 13px;"));
?>
<div class="secNew">
	<h3><?php echo __($wTitle, true);?></h3>
	<hr noshade="noshade" />
	<div class="tinyWidgetContent">
		<?php
			if (!empty($imgUrl)) {
				echo $html->image($imgUrl, array('alt'=>$pplSNews['title']));
			}


		?>
		<h4>
			<?php echo $html->link($text->truncate(html_entity_decode($pplSNews['title'], ENT_COMPAT, 'UTF-8'), 65, array('ending'=>'...', 'exact'=>false, 'html'=>true)),array('action'=>'view',$pplSNews['id']))?>
		</h4>
		<span class="date"><?php echo $created?> hs <?php echo $usr?></span>
		<div style="clear: both">
			<ul>
				<?php
				foreach ($sNews['News'] as $row) {
					echo $html->tag('li',
						$html->link($text->truncate(html_entity_decode($row['title'], ENT_COMPAT, 'UTF-8'), 65, array('ending'=>'...', 'exact'=>true, 'html'=>true)), array('action'=>'view',$row['id']))
					);
				}
				?>
			</ul>
		</div>
	</div>
</div>