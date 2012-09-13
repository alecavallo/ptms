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
	<div id="fotos" class="content" style="overflow:hidden">
		<div class="imgListContainer" id="imgListContainer">
			<?php
				echo $html->image(!empty($images)?$images[0]['Media']['url']:"empty.jpg",array('alt'=>$news['News']['title'], 'class'=>"fittedImg", 'style'=>"text-decoration:none; border-width:0px; position:relative;max-height: 247px;max-width: 318px;"));
			?>
		</div>
	</div>
</div>
<?php
	$js->buffer("preSelectTab({$newsId});");
	$js->buffer("$$('.tab').invoke('observe','click',function(event){unselectMultimediaTab(this,{$newsId})})");
?>