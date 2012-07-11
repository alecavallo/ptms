<?php
echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script('scriptaculous',array('inline'=>false));
//echo $this->Html->script('common',array('inline'=>false));
?>
<div id="submenu">
<ul id="sections">
	<li class="normal selected" onclick="$$('li.normal').each(function(e){e.removeClassName('selected');});$(this).addClassName('selected');$('colCenter').hide();$('colRight').hide(); $('colLeft').show()">Medios</li>
	<li class="normal" onclick="$$('li.normal').each(function(e){e.removeClassName('selected');});$(this).addClassName('selected');$('colLeft').hide();$('colRight').hide(); $('colCenter').show()">Blogs</li>
	<li class="normal" onclick="$$('li.normal').each(function(e){e.removeClassName('selected');});$(this).addClassName('selected');$('colLeft').hide();$('colCenter').hide();$('colRight').show()">Tweets</li>
</ul>
</div>
<div id="content">
		<div id="colLeft">
        	<!-- <div class="title">
        		<h1 class="greyTitle">Medios</h1>
        	</div> -->
        	<?php
			if (!empty($news)) {
				foreach ($news as $row) {
					if (array_key_exists('News', $row)) {
						$aux = $row['News'];
						$aux['Media'] = $row['Media'];
						$aux['User'] = $row['User'];
						$aux['Source'] = $row['Feed']['Source'];
						$aux['Feed'] = $row['Feed'];
						$aux['Category'] = $row['Category'];
						echo $this->element("widgets".DS."timeline_other_news", array('news'=>$aux));
					}elseif (array_key_exists('Ad', $row)){
						//echo $this->element("widgets".DS."news_ads", array('ad'=>$row));
					}


				}
			}
		?>
		</div>
		<div id="colCenter" style="display: none">
        	<!-- <div class="title">
        		<h1 class="greyTitle">Blogs</h1> 
        	</div> -->
        	<?php
        		//debug($blogs);
        		foreach ($blogs as $row) {
        			if (array_key_exists('News', $row)) {
						$aux = $row['News'];
						$aux['Media'] = $row['Media'];
						$aux['User'] = $row['User'];
						$aux['Source'] = $row['Feed']['Source'];
						$aux['Source']['icon'] = $row['Feed']['image_url'];
						$aux['Feed'] = $row['Feed'];
						$aux['Category'] = $row['Category'];
						echo $this->element("widgets".DS."timeline_other_news", array('news'=>$aux));
        			}elseif (array_key_exists('Ad', $row)){
						//echo $this->element("widgets".DS."news_ads", array('ad'=>$row));
					}
				}
        	?>
        </div>
    	<div id="colRight"  style="display: none">
    		<!-- <div class="title">
				<h1 class="greyTitle" style="margin-bottom: 20px;">Twitters</h1>
			</div> -->
			<div id="tweets">
			<?php
				foreach ($twitters as $row) {
					$aux['text'] = $row['text'];
					$aux['username'] = $row['user'];
					$aux['profile_img'] = $row['profile_img'];
					//$aux['Category'] = "";
					$aux['Category']['name'] = $row['category'];
					$aux['created'] = $row['created'];
					echo $this->element("widgets".DS."timeline_twitter", array('tweet'=>$aux));
				}

			?>

        	</div>
        	<?php //echo $this->element("twitter_trends");?>
       </div>


        
        <div id="adsContainer">
        	<?php //echo $html->image('bloque_grande.png', array('style'=>"display: block; position: relative; width: 100%;"))?>
        </div>
        <div id="otherNewsContainer" class="otherNewsContainer">
			<?php
				$parameters = array(
					'wId'	=>	"images",
					'wTitle'	=>	"Posts en imágenes",
					'float'	=>	"left"
				);
        		//echo $this->element("widgets".DS. "hlongimgwidget", array('par'=>$parameters));
        		$param2 = array(
					'wId'	=>	"videos",
					'wTitle'	=>	"Videos populares de youtube",
        			'float'	=>	"right"
				);
        		//echo $this->element("widgets".DS. "hlongvidwidget", array('par'=>$param2));
        	?>

                <br clear="all"/>
        </div>
            <br clear="all"/>
            <br clear="all"/>
    </div>