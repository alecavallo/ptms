<?php 
echo $this->Html->script(array('tweeter/jquery',  'jquery-cycle'),array('inline'=>false, 'once'=>true));
//echo $this->Html->css('img-rotate');
?>
<div class="img-widget">
	<div id="vid-rotator" class="rotator-container">
		<?php 
		$i=0;
		foreach ($videos as $row) {?>
		<div class="img-row">
			<?php if (array_key_exists(0, $row)) {?>
			<div class="img-container">
				<iframe id="yt<?php echo $i;?>" class="youtube-player" type="text/html" src="<?php echo $row[0]['url']?>" width="313" height="260" frameborder="0"></iframe>
			</div>
			<?php }?>
			
			<?php if (array_key_exists(1, $row)) {?>
			<div class="img-container">
				<!-- <div class="img-title">
					<p><?php echo $row[1]['title']?></p>
				</div> -->
				<iframe class="youtube-player" type="text/html" src="<?php echo $row[1]['url']?>" width="313" height="260" frameborder="0"></iframe>
			</div>
			<?php }?>
			
			<?php if (array_key_exists(2, $row)) {?>
			<div class="img-container">
				<!-- <div class="img-title">
					<p><?php echo $row[2]['title']?></p>
				</div> -->
				<iframe class="youtube-player" type="text/html" src="<?php echo $row[2]['url']?>" width="313" height="260" frameborder="0"></iframe>
			</div>
			<?php }?>
		</div>
		<?php 
			$i++;
		}?>
	</div>
	<div id="vprev" class="controls"> &lt; </div>
	<div id="vnext" class="controls"> &gt; </div>
</div>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function() {
	var slidesAdded = false; 
	function loadOtherImages(curr, next, opts){
		if (!opts.addSlide || slidesAdded){
			return;
		} 
		window.setTimeout('alert(\'Se terminó el callback\')', 7000);
		slidesAdded=true;
	}
    jQuery('div#vid-rotator').cycle({
		fx: 'fade',
		speed: 1500,
		timeout: 9000,
		pause: 1,
		next:   'div#vnext', 
	    prev:   'div#vprev'
	    //before: loadOtherImages
	});
    jQuery('div#vid-rotator').cycle('pause');
});	
</script>