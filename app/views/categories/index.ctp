<?php
echo $this->Html->script(array('tweeter/jquery',  'underscore', 'tweeter/feed', 'prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script('scriptaculous',array('inline'=>false));
//echo $this->Html->script('common',array('inline'=>false));
?>
<div id="content">
		<?php echo $this->element('news'.DS.'marquee',array('categoryId'=>$category['Category']['id']))?>
    	<div id="colLeft">
    	<section>
			<h1 class="greyTitle" style="margin-bottom: 20px;">Twitters</h1>
			<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
			<div id="tweets" class="<?php if($category['Category']['id']==4){ echo "economia";}else{echo "";}?>">
			<div id="loading">
				<p>Conect&aacute;ndose con twitter...</p>
				<img alt="cargando" src="/img/loading.gif"/>
			</div>
			<script type="text/javascript">
				var section = "<?php echo str_ireplace(" & ", "-", $category['Category']['name']) ?>";
				jQuery(document).ready(function(){
					window.t = new Twitter();
					t.getList('posteamos',section,50,1,'#tweets');
				});
			</script>
			
        	</div>
        	<?php
        	echo $this->element("templates".DS."timeline_twitter", array('cache'=>"1 hour"));
        	
        	switch ($category['Category']['id']) {
        		case 4:
        			echo '<div style="float: left; margin-top: 11px;"><h1 class="greyTitle">Cotización de divisas</h1><br/><br/><iframe frameborder="0" scrolling="no" height="115" width="273" allowtransparency="true" marginwidth="0" marginheight="0" src="http://fxrates.forexpros.es/index.php?pairs_ids=1505;2090;10453;&header-text-color=%23FFFFFF&header-bg=%23979797&curr-name-color=%230059b0&inner-text-color=%23000000&green-text-color=%232A8215&green-background=%23B7F4C2&red-text-color=%23DC0001&red-background=%23FFE2E2&inner-border-color=%23CBCBCB&border-color=%23cbcbcb&bg1=%23F6F6F6&bg2=%23ffffff&bid=show&ask=show&last=hide&open=hide&high=hide&low=hide&change=hide&last_update=hide"></iframe><br /><div style="width:273"><span style="float:left"><span style="font-size: 11px;color: #333333;text-decoration: none;">Cambio de Divisas entregado por <a href="http://www.forexpros.es" target="_blank" style="font-size: 11px;color: #06529D; font-weight: bold;" class="underline_link">Forexpros.es</a></span></span></div></div>';
        		break;
        		
        		default:
        			echo $this->element("twitter_trends");
        		break;
        	} 
        	
        	?>
        </section>
       </div>
        <div id="colCenter">
        <section>
        	<h1 class="greyTitle">Medios</h1>
        	<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
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
							$aux['link'] = strtolower("/medios/".Inflector::slug($row['Feed']['Source']['name'],"-")."/noticia/{$row['News']['id']}-".Inflector::slug($row['News']['title'],"-").".html");
							echo $this->element("widgets".DS."timeline_other_news", array('news'=>$aux));
						}elseif (array_key_exists('Ad', $row)){
							if ($row['Ad']['socialnetwork']==0) {
								echo $this->element("widgets".DS."news_ads", array('ad'=>$row));
							}else {
							switch ($row['Ad']['socialnetwork']) {
									case 1:
										$aux = $row['Ad'];
										$aux['image'] = $row['twitter']['image'];
										$aux['name'] = $row['twitter']['name'];
										$aux['nickname'] = $row['twitter']['nickname'];
										$aux['text'] = $row['twitter']['text'];
										$aux['snType'] = $row['Ad']['socialnetwork'];
										$aux['link'] = "https://twitter.com/#!/{$row['twitter']['nickname']}";
									break;
									
									case 3:
										//debug($row['Ad']);
										$aux = $row['Ad'];
										$aux['image'] = $row['Ad']['url'];
										$aux['photo'] = $row['Ad']['url_img'];  
										$aux['name'] = $row['Ad']['name'];
										$aux['nickname'] = "";
										$aux['text'] = $row['Ad']['text'];
										$aux['snType'] = $row['Ad']['socialnetwork'];
										$aux['link'] = $row['Ad']['link'];
									break;
									
									case 2:
										$aux = $row['Ad'];
										$aux['image'] = $row['facebook']['image'];
										$aux['name'] = $row['facebook']['name'];
										$aux['nickname'] = $row['facebook']['nickname'];
										$aux['text'] = $row['facebook']['text'];
										$aux['snType'] = $row['Ad']['socialnetwork'];
										$aux['link'] = !empty($row['facebook']['pubLink'])?$row['facebook']['pubLink']:"http://www.facebook.com/{$aux['nickname']}";;
									break;
								}
								echo $this->element("widgets".DS."twtr_ads", array('ad'=>$aux));
						}
					}
				}}
			?>
			</section>
			</div>

        <div id="colRight">
        <section>
        	<h1 class="greyTitle">Blogs</h1>
        	<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
        	<?php
        		//debug($blogs);
        		foreach ($blogs as $row) {
        			if (array_key_exists('News', $row)) {
						$aux = $row['News'];
						$aux['Media'] = $row['Media'];
						$aux['User'] = $row['Feed']['Source']['name'];
						$aux['Source'] = $row['Feed']['Source'];
						$aux['Source']['icon'] = $row['Feed']['image_url'];
						$aux['Feed'] = $row['Feed'];
						$aux['Category'] = $row['Category'];
						echo $this->element("widgets".DS."timeline_other_news", array('news'=>$aux));
        			}elseif (array_key_exists('Ad', $row)){
	        			if ($row['Ad']['socialnetwork']==0) {
							echo $this->element("widgets".DS."news_ads", array('ad'=>$row));
						}else {
						switch ($row['Ad']['socialnetwork']) {
									case 1:
										$aux = $row['Ad'];
										$aux['image'] = $row['twitter']['image'];
										$aux['name'] = $row['twitter']['name'];
										$aux['nickname'] = $row['twitter']['nickname'];
										$aux['text'] = $row['twitter']['text'];
										$aux['snType'] = $row['Ad']['socialnetwork'];
										$aux['link'] = "https://twitter.com/#!/{$row['twitter']['nickname']}";
									break;
									
									case 3:
										//debug($row['Ad']);
										$aux = $row['Ad'];
										$aux['image'] = $row['Ad']['url'];
										$aux['photo'] = $row['Ad']['url_img'];  
										$aux['name'] = $row['Ad']['name'];
										$aux['nickname'] = "";
										$aux['text'] = $row['Ad']['text'];
										$aux['snType'] = $row['Ad']['socialnetwork'];
										$aux['link'] = $row['Ad']['link'];
									break;
									
									case 2:
										$aux = $row['Ad'];
										$aux['image'] = $row['facebook']['image'];
										$aux['name'] = $row['facebook']['name'];
										$aux['nickname'] = $row['facebook']['nickname'];
										$aux['text'] = $row['facebook']['text'];
										$aux['snType'] = $row['Ad']['socialnetwork'];
										$aux['link'] = !empty($row['facebook']['pubLink'])?$row['facebook']['pubLink']:"http://www.facebook.com/{$aux['nickname']}";;
									break;
								}
							echo $this->element("widgets".DS."twtr_ads", array('ad'=>$aux));
						}
					}
        		}
        	?>
        </section>
        </div>
        
        <div id="adsContainer">
        	<?php 
        	if (!empty($banner)) {
        		echo $html->link($html->image($banner[0]['Ad']['url'], array('alt'=>$banner[0]['Ad']['name'], 'style'=>"display: block; position: relative; width: 100%;")), $banner[0]['Ad']['link'], array('escape'=>false));
        	}
        	?>
        </div>
        <section>
        	<?php 
        	echo $this->element("widgets".DS. "img_rotator");
        	echo $this->element("widgets".DS. "video_rotator");
        	?>
        </section>
            <br clear="all"/>
            <br clear="all"/>
    </div>
    
	<?php echo $this->element("templates".DS."timeline_twitter", array('tweet'=>$aux));?>
	<script type="text/javascript">
	//mostrar título completo en hover
	jQuery(document).ready(function(){
		jQuery("div.news").hover(
	            function(){
	            	window.dflt = jQuery(this).html();
	            	//alert(window.dflt);
	            	var id = jQuery(this).attr('id');
	                jQuery('div#'+id+" h3 a").html(jQuery('div#'+id+" #title"+id).val());
	    		},
	    		function(){
	        		//alert(window.dflt);
					jQuery(this).html(dflt);
	    		}
	     );
	});
	</script>