<?php 
$this->Html->script(array('jquery-cycle'),array('inline'=>false, 'once'=>true));
echo $this->Html->css('img-rotate');
?>
<div class="img-widget">
	<div id="img-rotator" class="rotator-container">
		<?php 
			$row = array_shift($images);
			$otherImages = $images;	
		?>
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
	</div>
	<div id="prev" class="controls"> &lt; </div>
	<div id="next" class="controls"> &gt; </div>
</div>
<script type="text/template" id="rel-news-row">

</script>
<script type="text/javascript">
jQuery.noConflict();
var imgWidget = jQuery('div#img-rotator');
var images = <?php echo str_replace('\/','/',json_encode($otherImages));?>;
jQuery(document).ready(function() {
	jQuery.each(images,function(idx, arr_row){
		//creo contenedor de fila
		var row = document.createElement('div');
		row.setAttribute('class','img-row');
		//creo contenedor de imagen
		var imgContainer = document.createElement('div');
		imgContainer.setAttribute('class','img-container');
		//creo titulo
		var imgTitle = document.createElement('div');
		imgTitle.setAttribute('class','img-title');
		//creo link
		var link = document.createElement('a');
		link.setAttribute('href', arr_row[0]['News']['url']);
		link.innerHTML = arr_row[0]['News']['title'];
		//creo imagen
		var img = new Image(); 
        img.src = arr_row[0]['Media']['url'];
		//agrego link al titulo
		imgTitle.appendChild(link);
		//agrego titulo al contenedor de imagen
		imgContainer.appendChild(imgTitle);
		//agrego imagen a contenedor de imagen;
		imgContainer.appendChild(img);
		row.appendChild(imgContainer);

		/**Imagen nro 2**/
		//creo contenedor de imagen
		try{
		imgContainer = document.createElement('div');
		imgContainer.setAttribute('class','img-container');
		//creo titulo
		imgTitle = document.createElement('div');
		imgTitle.setAttribute('class','img-title');
		//creo link
		link = document.createElement('a');
		link.setAttribute('href', arr_row[1]['News']['url']);
		link.innerHTML = arr_row[1]['News']['title'];
		//creo imagen
		img = new Image(); 
        img.src = arr_row[1]['Media']['url'];
		//agrego link al titulo
		imgTitle.appendChild(link);
		//agrego titulo al contenedor de imagen
		imgContainer.appendChild(imgTitle);
		//agrego imagen a contenedor de imagen;
		imgContainer.appendChild(img);
		row.appendChild(imgContainer);
		}catch(err){
			console.log('no existe imagen #2');
		}

		/**Imagen nro 3**/
		//creo contenedor de imagen
		try{
		imgContainer = document.createElement('div');
		imgContainer.setAttribute('class','img-container');
		//creo titulo
		imgTitle = document.createElement('div');
		imgTitle.setAttribute('class','img-title');
		//creo link
		link = document.createElement('a');
		link.setAttribute('href', arr_row[2]['News']['url']);
		link.innerHTML = arr_row[2]['News']['title'];
		//creo imagen
		img = new Image(); 
        img.src = arr_row[2]['Media']['url'];
		//agrego link al titulo
		imgTitle.appendChild(link);
		//agrego titulo al contenedor de imagen
		imgContainer.appendChild(imgTitle);
		//agrego imagen a contenedor de imagen;
		imgContainer.appendChild(img);
		row.appendChild(imgContainer);
		}catch(err){
			console.log('no existe imagen #3');
		}
		
		imgWidget.append(row);
	});
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