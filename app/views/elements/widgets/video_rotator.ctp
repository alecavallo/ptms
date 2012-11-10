<?php 
$this->Html->script(array('tweeter/jquery',  'jquery-cycle'),array('inline'=>false, 'once'=>true));
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
				<!-- <iframe id="yt<?php echo $i;?>" class="youtube-player" type="text/html" src="<?php echo $row[0]['url']?>" width="313" height="260" frameborder="0"></iframe> -->
				<div id="yt<?php echo $i;?>1" class="youtube-player"></div>
			</div>
			<?php }?>
			
			<?php if (array_key_exists(1, $row)) {?>
			<div class="img-container">
				<!-- <iframe class="youtube-player" type="text/html" src="<?php echo $row[1]['url']?>" width="313" height="260" frameborder="0"></iframe> -->
				<div id="yt<?php echo $i;?>2" class="youtube-player"></div>
			</div>
			<?php }?>
			
			<?php if (array_key_exists(2, $row)) {?>
			<div class="img-container">
				<!-- <iframe class="youtube-player" type="text/html" src="<?php echo $row[2]['url']?>" width="313" height="260" frameborder="0"></iframe> -->
				<div id="yt<?php echo $i;?>3" class="youtube-player"></div>
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
//cargo un arreglo con los datos de videos
var videos = <?php echo str_replace('\/','/',json_encode($videos));?>;

//cargo youtube loader API
var tag = document.createElement('script');
tag.src = "//www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

//esta función crea el iframe luego que youtube-loader se terminó de cargar
var players = {};
function onYouTubeIframeAPIReady() {
	jQuery(document).ready(function() {
		if(videos[0][0]){
		    players[0] = new YT.Player('yt01', {
		      width: '313',
		      height: '260',
		      videoId: videos[0][0]['videoid'],
		      events: {
		        'onReady': onPlayerReady,
		        'onStateChange': onPlayerStateChange
		      }
		    });
		}
		if(videos[0][1]){
		    players[1] = new YT.Player('yt02', {
		      width: '313',
		      height: '260',
		      videoId: videos[0][1]['videoid'],
		      events: {
		        'onReady': onPlayerReady,
		        'onStateChange': onPlayerStateChange
		      }
		    });
		}
		if(videos[0][2]){
		    players[2] = new YT.Player('yt03', {
		      width: '313',
		      height: '260',
		      videoId: videos[0][2]['videoid'],
		      events: {
		        'onReady': onPlayerReady,
		        'onStateChange': onPlayerStateChange
		      }
		    });
		}
	});

	jQuery(window).load(function() {
		var i=1;
		var j=1;
		videos.shift();
		//videos.shift();
		jQuery.each(videos, function(idx, row){
			if(row[0]){
			    players[2+j] = new YT.Player('yt'+i+'1', {
			      width: '313',
			      height: '260',
			      videoId: row[0]['videoid'],
			      events: {
			        'onReady': onPlayerReady,
			        'onStateChange': onPlayerStateChange
			      }
			    });
			}
			if(row[1]){
			    players[3+j] = new YT.Player('yt'+i+'2', {
			      width: '313',
			      height: '260',
			      videoId: row[1]['videoid'],
			      events: {
			        'onReady': onPlayerReady,
			        'onStateChange': onPlayerStateChange
			      }
			    });
			}
			if(row[2]){
			    players[4+j] = new YT.Player('yt'+i+'3', {
			      width: '313',
			      height: '260',
			      videoId: row[2]['videoid'],
			      events: {
			        'onReady': onPlayerReady,
			        'onStateChange': onPlayerStateChange
			      }
			    });
			}
			j=j+3;
			i++;
		});
	});
}
//esta funcion es llamada por el youtube player cuando el reproductor esta listo
function onPlayerReady(event) {
    //event.target.playVideo();
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
      setTimeout(stopVideo, 6000);
      done = true;
    }
}
function stopVideo() {
	player.stopVideo();
}

jQuery.noConflict();
jQuery(document).ready(function(){
	
});

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