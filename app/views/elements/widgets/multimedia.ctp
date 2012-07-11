<?php
$photoPagOptions = array(
			'url'	=>	array('controller'=>"medias", 'action'=>"getPagImages",$news['News']['id']),
			'model'	=> 'Image',
		    'update' => "#fotos",
			'before' => $this->Js->get('#pbusy-indicator')->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get('#pbusy-indicator')->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true,
			'escape'=>false
);
$videoPagOptions = array(
			'url'	=>	array('controller'=>"medias", 'action'=>"getPagVideos",$news['News']['id']),
			'model'	=> 'Video',
		    'update' => "#videos",
			'before' => $this->Js->get('#vbusy-indicator')->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get('#vbusy-indicator')->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true
);
$audioPagOptions = array(
			'url'	=>	array('controller'=>"medias", 'action'=>"index"),
		    'update' => "#audios",
			'before' => $this->Js->get('#abusy-indicator')->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get('#abusy-indicator')->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true
);
?>
<?php //debug(array_merge($photoPagOptions,$dfltPagNumbers))?>
<div id="mediaSlideshowContainer">
	<div id="tabsContainer">
		<div id="fotosTab" onmousedown="return false" onselectstart="return false" class="tab selected"><?php __('Fotos')?></div>
		<?php if(!empty($videos[0]['Media']['url'])){?><div id="videosTab" onmousedown="return false" onselectstart="return false" class="tab"><?php __('Videos')?></div><?php }?>
		<?php if(!empty($audios)){?><div id="audiosTab" onmousedown="return false" onselectstart="return false" class="tab"><?php __('Audios')?></div><?php }?>
	</div>
	<?php
		$paginator->options = $photoPagOptions;
	?>
	<div id="fotos" class="content">
		<div class="imgListContainer" id="imgListContainer">
			<div class="pagButtonsContainer">
				<div class="pagButton left">
				<?php
					if($paginator->hasPrev()){
						echo $paginator->prev($html->image('ant_sig.png', array('alt'=>"<")), array('model'=>"Image", 'escape'=>false));
						//echo $paginator->prev($html->image('ant_sig.png', array('alt'=>"<")), $photoPagOptions);
					}
				?>
				</div>
				<div class="pagButton right">
				<?php
					if($paginator->hasNext()){
						//echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), $photoPagOptions);
						echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), array('model'=>"Image", 'escape'=>false));
					}
				?>
				</div>
			</div>
			<?php
				echo $html->image(!empty($images)?$images[0]['Media']['url']:"empty.jpg",array('alt'=>$news['News']['title'], 'class'=>"fittedImg", 'style'=>"text-decoration:none; border-width:0px; position:relative; top: -45px;"));
			?>
		</div>
		<div class="paginate">
			<?php
				echo $paginator->numbers(array('model'=>"Image", 'separator'=>" - "));

				//echo $paginator->numbers(array_merge($photoPagOptions,$dfltPagNumbers));
			?>
		</div>
		<div id="pbusy-indicator" class="busy-indicator" style="display:none;" >
			<?php echo $this->Html->image('loading.gif', array('style'=>"position: relative;")); ?>
		</div>
	</div>
	<?php
		if(!empty($videos[0]['Media']['url'])){
			$paginator->options = $videoPagOptions;
	?>
	<div id="videos" class="content">
		<div class="vidListContainer" id="vidListContainer">
			<div class="pagButtonsContainer" style="top: 73px;">
				<div class="pagButton left">
				<?php
					if($paginator->hasPrev()){
						echo $paginator->prev($html->image('ant_sig.png', array('alt'=>"<")), array('model'=>"Video", 'escape'=>false));
						//echo $paginator->prev($html->image('ant_sig.png', array('alt'=>"<")), $photoPagOptions);
					}
				?>
				</div>
				<div class="pagButton right">
				<?php
					if($paginator->hasNext()){
						//echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), $photoPagOptions);
						echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), array('model'=>"Video", 'escape'=>false));
					}
				?>
				</div>
			</div>
			<?php if(!empty($videos)){?>
			<object width="316" height="210" style="position:relative; float:left;margin-left:0px; top:-45px; z-index:1">
				<param name="movie" value="<?php echo $videos[0]['Media']['url']?>?fs=1&amp;hl=es_ES&amp;rel=0"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<param name="wmode" value="transparent"></param>
				<embed src="<?php echo $videos[0]['Media']['url']?>?fs=1&amp;hl=es_ES&amp;rel=0;showinfo=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="318" height="209" wmode="transparent"></embed>
			</object>
			<?php }?>
		</div>
		<div class="paginate" style="position:relative;top:-47px">
			<?php
				echo $paginator->numbers(array('model'=>"Image", 'separator'=>" - "));
			?>
		</div>
		<div id="vbusy-indicator" class="busy-indicator" style="display:none; top: -27px;">
			<?php echo $this->Html->image('loading.gif', array('style'=>"position: relative; top: -148px;")); ?>
		</div>
	</div>
	<?php } //end video div?>
	<?php if(!empty($audios)){?>
	<div id="audios" class="content">
		<?php debug($audios)?>
		<div id="abusy-indicator" style="display:none; position: relative; left: 3px; top: -238px; z-index: 100; background-color: white; width: 53%; height: 104px; opacity:0.7; padding-top: 104px; padding-left: 44%;">
			<?php echo $this->Html->image('loading.gif', array('style'=>"display: block; float: left; position: relative;")); ?>
		</div>
	</div>
	<?php } //end video audios?>
</div>
<?php
	$js->buffer("preSelectTab({$newsId});");
	$js->buffer("$$('.tab').invoke('observe','click',function(event){unselectMultimediaTab(this,{$newsId})})");
?>