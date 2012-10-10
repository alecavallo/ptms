<?php 
echo $this->Html->script(array('tweeter/jquery',  'jquery-cycle'),array('inline'=>false, 'once'=>true));
echo $this->Html->css('img-rotate');
?>
<div class="img-widget">
	<div id="img-rotator" class="rotator-container">
		<?php foreach ($images as $row) {?>
		<div class="img-row">
			<?php if (array_key_exists(0, $row)) {?>
			<div class="img-container">
				<div class="img-title">
					<a href="<?php echo $row[0]['News']['url']?>"><?php echo $row[0]['News']['title']?></a>
				</div>
				<img class="news-img" alt="<?php echo $row[0]['News']['title']?>" src="<?php echo $row[0]['Media']['url']?>">
			</div>
			<?php }?>
			
			<?php if (array_key_exists(1, $row)) {?>
			<div class="img-container">
				<div class="img-title">
					<a href="<?php echo $row[1]['News']['url']?>"><?php echo $row[1]['News']['title']?></a>
				</div>
				<img class="news-img" alt="<?php echo $row[1]['News']['title']?>" src="<?php echo $row[1]['Media']['url']?>">
			</div>
			<?php }?>
			
			<?php if (array_key_exists(2, $row)) {?>
			<div class="img-container">
				<div class="img-title">
					<a href="<?php echo $row[2]['News']['url']?>"><?php echo $row[2]['News']['title']?></a>
				</div>
				<img class="news-img" alt="<?php echo $row[2]['News']['title']?>" src="<?php echo $row[2]['Media']['url']?>">
			</div>
			<?php }?>
		</div>
		<?php }?>
	</div>
	<div id="prev" class="controls"> &lt; </div>
	<div id="next" class="controls"> &gt; </div>
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
    jQuery('div#img-rotator').cycle({
		fx: 'fade',
		speed: 1500,
		timeout: 7000,
		pause: 1,
		next:   'div#next', 
	    prev:   'div#prev'
	    //before: loadOtherImages
	});
});
</script>