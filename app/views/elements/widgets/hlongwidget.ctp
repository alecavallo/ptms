<div class="longWidget">
	<div id="notLocales" class="widgetTitle">
		<h4 class="title"><?php echo $par['w_title']?></h4>
		<span class="controls">
			<a href="#nogo" class="minimize" id="mx<?php echo $par['wid']?>" onclick="expCol('mx<?php echo $par['wid']?>','w<?php echo $par['wid']?>',300);"></a>
			<a href="#nogo" class="configure" onclick="showPopup('cfb<?php echo $par['wid']?>', 3)" id="cf1"></a>
		</span>
		<div id="cfb<?php echo $par['wid']?>" class="configBox" style="display: none;">
			<a href="#nogo"	onclick="Effect.Fade('cfb1', {duration: 0.5});" style="float: right;">Cerrar </a>
			<br />
			<br />
			<?php echo $par['config_content']?>
		</div>
	</div>

	<div class="widgetContent" id="w<?php echo $par['wid']?>">
		<div class="wRow">
			<h4 class="title">
				<?php echo $html->link(
					$text->truncate(__(Sanitize::html(html_entity_decode($par[0]['News']['title'],ENT_QUOTES, Configure::read('App.encoding')), array('remove'=>true)), true), 95, array('ending'=>'[...]', 'exact'=>false, 'html'=>true)),
					array('action'=>"view", $par[0]['News']['id']),array('escape'=>false)
					)
				?>
			</h4>
			<br clear="all"/>
			<?php $image = $par[0]['News']['media_url']; ?>
			<?php
				if(!empty($image)){
					echo $html->image($image, array('alt'=>$image, 'class'=>"resize11090"));
					$width = "";
				}else {
					$width = "width: 100%";
				}
			?>

			<?php echo $html->tag("p",__(Sanitize::html(html_entity_decode($par[0]['News']['summary'],ENT_QUOTES, Configure::read('App.encoding')), array('remove'=>true)),true),array('style'=>$width))?>
		</div>

		<div class="wRow oNews">
			<ul>
				<?php
				for ($i = 1; $i < count($par)-3; $i++) {
					echo $html->tag("li",
						$html->tag("h3",
							$html->link(
								$text->truncate(__($par[$i]['News']['title'],true), 80, array('ending'=>'[...]', 'exact'=>false, 'html'=>true)),
								array('action'=>"view", $par[$i]['News']['id']),array('escape'=>false)
							),
							array('class'=>"wTitle")
						)
					);
				}
				?>
			</ul>
		</div>
	</div>
	<div class="widgetLowerBorder" id="wl<?php echo $par['wid']?>"></div>
</div>