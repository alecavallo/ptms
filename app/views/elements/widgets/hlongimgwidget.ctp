<?php
$par['categoryId'] = array_key_exists('categoryId', $par)?$par['categoryId']:0;
$data = $this->requestAction("medias/index/{$par['categoryId']}");
if (array_key_exists('paging', $data)) {
	$paginator->params['paging'] = $data['paging'];
}

$data = $data['data'];
$image=$data[0];
$n=$data[0];
$par['wId']='image';
$paginator->options(array(
			'url'	=>	array('controller'=>"medias", 'action'=>"index", $par['categoryId']),
		    'update' => "#w".$par['wId'],
			'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true
));

$float = empty($float)?'left':$float;
?>
<div class="longWidget5" style="float:<?php echo $float ?>;">
	<div id="imagenes" class="widgetTitle">
		<h4 class="title"> <?php echo $par['wTitle']?> </h4>
		<span class="controls">
			<a href="#nogo" id="mx<?php echo $par['wId']?>" class="minimize" onclick="expCol('mx<?php echo $par['wId']?>','w<?php echo $par['wId']?>',300);"></a>
			<!-- <a href="#nogo" id="cf<?php echo $par['wId']?>" class="configure" onclick="showPopup('cfb<?php echo $par['wId']?>', 3)"></a> -->
		</span>
	</div>

	<div id="w<?php echo $par['wId']?>">
		<?php $usr = !empty($image['News']['User']['alias'])?$image['News']['User']['alias']:"RSS";?>
		<div id="title5" class="right newsCategory"><?php echo $image['News']['Category']['name']." - ".$usr ?></div>
		<br/>

		<div class="imgListContainer" id="imgListContainer">
			<div class="pagButtonsContainer">
				<div class="pagButton left">
				<?php
					if($paginator->hasPrev()){
						echo $paginator->prev($html->image('ant_sig.png', array('alt'=>"<")), array('model'=>"Media", 'escape'=>false));
					}
				?>
				</div>
				<div class="pagButton right">
				<?php
					if($paginator->hasNext()){
						echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), array('model'=>"Media", 'escape'=>false));
					}
				?>
				</div>
			</div>
			<?php
				echo $html->link(
					$html->image($n['Media']['url'],array('alt'=>$n['News']['title'], 'id'=>"link")),
					$n['News']['link'],
					array('escape'=>false, 'target'=>"blank")
				);
			?>
			<script type="text/javascript">
				(function() {
					var img = $('link');
					img.onload = function() {
					    if(img.height > img.width) {
					        img.setStyle({height: '100%', width: 'auto'});
					    }else{
					    	img.setStyle({height: 'auto', width: '100%'});
					    }
					};
				}());
			</script>
			

		</div>
		<div class="imgTitle"><h4><?php echo $text->truncate($image['News']['title'],45, array('ending'=>'...', 'exact'=>false, 'html'=>true));?></h4></div>
		<div class="paginate">
			<!-- <a class="pNoSelected" href="#nogo"> &lt;&lt; </a><a class="pNoSelected" href="#nogo">&nbsp;&nbsp;&lt;&nbsp;&nbsp; </a><a class="pSelected" href="#nogo">1</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">2</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">3</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">4</a><span class="pSeparator">-</span><a class="pNoSelected" href="#nogo">5</a><a class="pNoSelected" href="#nogo"> &nbsp;&nbsp;&gt;&nbsp;&nbsp; </a><a class="pNoSelected" href="#nogo"> &gt;&gt; </a> -->
			<?php //echo $paginator->first("<<", array('model'=>"Media"))?>

			<?php echo $paginator->numbers(array('model'=>"Media", 'separator'=>" - ")); ?>

			<?php //echo $paginator->last(">>", array('model'=>"Media"))?>
		</div>
		<div id="cfb<?php echo $par['wId']?>" class="configBox" style="display:none;">
			<a href="#nogo" onclick="Effect.Fade('cfb<?php echo $par['wId']?>', {duration: 0.5});" style="float:right;"> Cerrar </a>
			<br/><br/>
			Este div va a mostrar los parametros de configuracion de cada widget.

		</div>
		<div id="busy-indicator" style="display:none; position: relative; top: -327px; z-index: 100; background-color: white; height: 189px; opacity:0.7; padding-top: 105px; padding-left: 45%;">
				<?php echo $this->Html->image('loading.gif', array('id' => 'busy-indicator', 'style'=>"display: block; float: left; position: relative; margin-top:15px")); ?>
		</div>
	</div>
</div>

<?php echo $this->Js->writeBuffer(array('inline'=>true, 'safe'=>true));?>
