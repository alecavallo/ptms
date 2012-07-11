<?php
echo $this->Html->script('prototype',array('inline'=>false));
echo $this->Html->script('scriptaculous',array('inline'=>false));
echo $this->Html->script('common',array('inline'=>false));

//$data = $data['data'];
//debug($this->params['paging']);
/*$par['wId']=4;
$par['wTitle']="La semana en imágenes";*/
$videos=$data;

$paginator->options(array(
			'url'	=>	array('controller'=>"news", 'action'=>"getPopularVideos",str_ireplace(" & ", "%7C",$par['category'])),
		    'update' => "#w".$par['wId'],
			'before' => $this->Js->get("#{$par['wId']}-busy-indicator")->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get("#{$par['wId']}-busy-indicator")->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true
));
?>
<div class="right newsCategory"></div>
<br clear="all"/>
<div class="imgListContainer" id="imgListContainer">
	<div class="pagButtonsContainer">
		<div class="pagButton left">
		<?php
			if($paginator->hasPrev('YoutubeFavorite')){
				echo $paginator->prev($html->image('ant_sig.png', array('alt'=>"<")), array('model'=>"YoutubeFavorite", 'escape'=>false));
			}
		?>
		</div>
		<div class="pagButton right">
		<?php
			if($paginator->hasNext('YoutubeFavorite')){
				echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), array('model'=>"YoutubeFavorite", 'escape'=>false));
			}
		?>
		</div>
	</div>
	<?php if(!empty($videos)){?>
	<object width="390" height="290" style="position:relative; float:left;margin-left:0px; top:-45px; z-index:1">
		<param name="movie" value="<?php echo $videos['url']?>&amp;fs=1&amp;hl=es_ES&amp;rel=0"></param>
		<param name="allowFullScreen" value="true"></param>
		<param name="allowscriptaccess" value="always"></param>
		<param name="wmode" value="transparent"></param>
		<embed src="<?php echo $videos['url']?>&amp;fs=1&amp;hl=es_ES&amp;rel=0;showinfo=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="390" height="290" wmode="transparent"></embed>
	</object>
	<?php }?>
</div>
<div class="imgTitle"><h4><?php echo $text->truncate($videos['title'],45, array('ending'=>'...', 'exact'=>false, 'html'=>true));?></h4></div>
<div class="paginate">
	<!-- <a class="pNoSelected" href="#nogo"> &lt;&lt; </a><a class="pNoSelected" href="#nogo">&nbsp;&nbsp;&lt;&nbsp;&nbsp; </a><a class="pSelected" href="#nogo">1</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">2</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">3</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">4</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">5</a><a class="pNoSelected" href="#nogo"> &nbsp;&nbsp;&gt;&nbsp;&nbsp; </a><a class="pNoSelected" href="#nogo"> &gt;&gt; </a> -->
	<?php //echo $paginator->first("<<", array('model'=>"Media"))?>

	<?php echo $paginator->numbers(array('model'=>"YoutubeFavorite", 'separator'=>" - ")); ?>

	<?php //echo $paginator->last(">>", array('model'=>"Media"))?>
</div>
<div id="<?php echo $par['wId']?>-busy-indicator" style="display:none; position: relative; top: -366px; z-index: 100; background-color: white; height: 195px; opacity:0.7; padding-top: 105px; padding-left: 45%;">
	<?php echo $this->Html->image('loading.gif', array('id' => 'busy-indicator', 'style'=>"display: block; float: left; position: relative; margin-top:15px")); ?>
</div>
<?php echo $this->Js->writeBuffer();?>