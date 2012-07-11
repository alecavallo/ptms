<?php
	$default = array(
		'widget_id'		=>	rand(100, 5000),
		'configuration'	=>	"",
		'content'		=>	""
	);
	$data = array_merge($default,$data);
	extract($data,EXTR_OVERWRITE);
?>
<div id="<?php echo $widget_id?>"class="smallLeftWidget" style="float:right;">
	<div class="widgetTitle">
        <h4 class="title"> <?php __($title); ?> </h4>
		<span class="controls"><a href="#nogo" id="mx<?php echo $widget_id ?>" class="minimize" onclick="expCol('mx<?php echo $widget_id?>','w<?php echo $widget_id?>',300);"></a><a href="#nogo" id="cf<?php echo $widget_id?>" class="configure" onclick="showPopup('cfb<?php echo $widget_id?>', 3)"></a></span>
		<div id="cfb<?php echo $widget_id?>" class="configBox" style="display:none;">
			<a href="#nogo" onclick="Effect.Fade('cfb<?php echo $widget_id?>', {duration: 1.0});" style="float:right;"> <?php __('Cerrar')?> </a><br/><br/>
			<?php echo $configuration?>
		</div>
	</div>

	<div class="widgetContent" id="w<?php echo $widget_id?>" <?php echo !empty($height)?"style=\"height: {$height}; max-heigjt: {$height}\"":"" ?>>
		<div class="wRow oNews">
			<?php echo $content?>
		</div>
	</div>
    <div class="widgetLowerBorder" id="wl<?php echo $widget_id?>"></div>
</div>