<?php
$photoPagOptions = array(
			'url'	=>	array('controller'=>"medias", 'action'=>"getPagImages",$newsId),
		    'update' => "#fotos",
			'before' => $this->Js->get('#pbusy-indicator')->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get('#pbusy-indicator')->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true,
			'escape'=>false
);
$videoPagOptions = array(
			'url'	=>	array('controller'=>"medias", 'action'=>"getPagVideos",$newsId),
			'model'	=>	"Media",
		    'update' => "#videos",
			'before' => $this->Js->get('#vbusy-indicator')->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get('#vbusy-indicator')->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true
);
$audioPagOptions = array(
			'url'	=>	array('controller'=>"medias", 'action'=>"getPagAudios", $newsId),
		    'update' => "#audios",
			'before' => $this->Js->get('#abusy-indicator')->effect('fadeIn', array('buffer' => false)),
    		'complete' => $this->Js->get('#abusy-indicator')->effect('fadeOut', array('buffer' => false)),
			'evalScripts' => true
);
?>
<?php
	switch ($tabID) {
		case 'fotos':
			$paginator->options = $photoPagOptions;
			$busyIndicator = "pbusy-indicator";
			$overlayPos="";
			$overlayImgPos="";
		break;
		case 'videos':
			$paginator->options = $videoPagOptions;
			$busyIndicator = "vbusy-indicator";
			$overlayPos="top: -27px;";
			$overlayImgPos="top: -148px;";
		break;

		case 'audios':
			$paginator->options = $audioPagOptions;
			$busyIndicator = "abusy-indicator";
		break;

		default:
			$paginator->options = $photoPagOptions;
		break;
	}
?>
	<?php
		switch ($tabID) {
			case 'fotos':
				echo '<div class="imgListContainer" id="imgListContainer">';
			break;
			case 'videos':
				echo '<div class="vidListContainer" id="vidListContainer">';
			break;

			case 'audios':
				echo '<div class="audListContainer" id="audListContainer">';
			break;

			default:
				echo "<div>";
			break;
		}
	?>

		<div class="pagButtonsContainer" style="top: 73px;">
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
					//echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), $photoPagOptions);
					echo $paginator->next($html->image('ant_sig.png', array('alt'=>">", 'class'=>"nxt")), array('model'=>"Media", 'escape'=>false));
				}
			?>
			</div>
		</div>
		<?php
				switch ($tabID) {
					case 'fotos':
						echo $html->image($media[0]['Media']['url'],array('alt'=>"",'class'=>"fittedImg", 'style'=>"text-decoration:none; border-width:0px; position:relative; top: -45px;"));
					break;
					case 'videos':
						echo $html->tag('object',
							$html->tag('param',"",array("name"=>"movie", "value"=>$media[0]['Media']['url']."?fs=1&amp;hl=es_ES&amp;rel=0")).
							$html->tag('param',"",array("name"=>"allowFullScreen", "value"=>"true")).
							$html->tag('param',"",array("name"=>"allowscriptaccess", "value"=>"always")).
							$html->tag('param',"",array("name"=>"wmode", "value"=>"transparent")).
							$html->tag('embed',"",array("src"=>$media[0]['Media']['url']."?fs=1&amp;hl=es_ES&amp;rel=0;showinfo=0", "type"=>"application/x-shockwave-flash", "allowscriptaccess"=>"always", "allowfullscreen"=>"true", "width"=>"313", "height"=>"210", "wmode"=>"transparent"))
						,array("width"=>"313", "height"=>"210", "style"=>"position:relative; float:left;margin-left:3px; top:-45px; z-index:1"));
					break;

					case 'audios':

					break;
				}

		?>
	</div>
	<div class="paginate" style="position:relative;top:-47px">
		<?php
			echo $paginator->numbers(array('model'=>"Media", 'separator'=>" - "));

			//echo $paginator->numbers(array_merge($photoPagOptions,$dfltPagNumbers));
		?>
	</div>
	<div id="<?php echo $busyIndicator?>" class="busy-indicator"style="display:none; <?php echo $overlayPos;?>">
		<?php echo $this->Html->image('loading.gif', array('style'=>"position: relative; {$overlayImgPos}")); ?>
	</div>
<?php
	echo $js->writeBuffer();
?>