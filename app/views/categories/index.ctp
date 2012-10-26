<?php
echo $this->Html->script(array('tweeter/jquery',  'underscore', 'tweeter/feed', 'prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script('scriptaculous',array('inline'=>false));
//echo $this->Html->script('common',array('inline'=>false));
?>
<div id="content">
		<h1 class="greyTitle">Últimas noticias de <?php echo $category['Category']['name']?></h1>
		<?php echo $this->element('news'.DS.'marquee',array('categoryId'=>$category['Category']['id']))?>
		<section>
			<?php
				echo $this->element("widgets".DS. "img_rotator", array(/*'cache'=>'1 hour'*/));
			?>
		</section>
		<br/>
    	<div id="colLeft">
    	<section>
			<h2 class="greyTitle" style="margin-bottom: 20px;">Twitters</h2>
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
					t.getList('posteamosArg',section,50,1,'#tweets');
				});
			</script>
			
        	</div>
        	<?php
        	echo $this->element("templates".DS."timeline_twitter", array('cache'=>"1 hour"));
        	
        	switch ($category['Category']['id']) {
        		case 3:
        			$object = <<<OBJ
<OBJECT ID="MediaPlayer" WIDTH=260 HEIGHT=380 classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"
					STANDBY="Loading Windows Media Player components..."
					type="application/x-oleobject">
					    <PARAM NAME="FileName" VALUE="mms://hsn.telecomdatacenter.com.ar/hsn">
					    <PARAM NAME="ShowControls" VALUE="1">
					    <PARAM NAME="ShowDisplay" VALUE="1">
					    <PARAM NAME="ShowStatusBar" VALUE="1">
					    <PARAM NAME="AutoSize" VALUE="1">
					<EMBED TYPE="application/x-mplayer2" 
					SRC="mms://hsn.telecomdatacenter.com.ar/hsn"
					pluginspage="http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/" 
					NAME="MediaPlayer"
					WIDTH="260"
					HEIGHT="380" 
					ShowControls="1" 
					ShowStatusBar="1" 
					ShowDisplay="1" 
					autostart="0"> 
					</EMBED>
					
					</OBJECT>
OBJ;
					echo "<div id=\"senadoVid\"><h2 class=\"greyTitle\">Senado en vivo!</h2><br/>{$object}</div>";
        			break;
        		case 4:
        			echo '<div style="float: left; margin-top: 548px;"><h2 class="greyTitle">Cotización de divisas</h2><br/><br/><iframe frameborder="0" scrolling="no" height="115" width="273" allowtransparency="true" marginwidth="0" marginheight="0" src="http://fxrates.forexpros.es/index.php?pairs_ids=1505;2090;10453;&header-text-color=%23FFFFFF&header-bg=%23979797&curr-name-color=%230059b0&inner-text-color=%23000000&green-text-color=%232A8215&green-background=%23B7F4C2&red-text-color=%23DC0001&red-background=%23FFE2E2&inner-border-color=%23CBCBCB&border-color=%23cbcbcb&bg1=%23F6F6F6&bg2=%23ffffff&bid=show&ask=show&last=hide&open=hide&high=hide&low=hide&change=hide&last_update=hide"></iframe><br /><div style="width:273"><span style="float:left"><span style="font-size: 11px;color: #333333;text-decoration: none;">Cambio de Divisas entregado por <a href="http://www.forexpros.es" target="_blank" style="font-size: 11px;color: #06529D; font-weight: bold;" class="underline_link">Forexpros.es</a></span></span></div></div>';
        		break;
        		
        		case 7:
        			$object = <<<OBJ
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="260" height="230" id="tvChart" align="middle">
        <param name="movie" value="http://www.ibope.com.ar/ibope/wp/wp-content/themes/ibope/swf/tv.swf?siteUrl=http://www.ibope.com.ar/ibope/wp/wp-content/files_mf/Cuartos_20111117.xml&showIt=true" />
        <param name="FlashVars" value="siteUrl=http://www.ibope.com.ar/ibope/wp/wp-content/files_mf/Cuartos_20111117.xml&showIt=true" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <param name="play" value="true" />
        <param name="loop" value="true" />
        <param name="wmode" value="transparent" />
        <param name="scale" value="showall" />
        <param name="menu" value="true" />
        <param name="devicefont" value="false" />
        <param name="salign" value="" />
        <param name="allowScriptAccess" value="sameDomain" />
        <!--[if !IE]>-->
        <object type="application/x-shockwave-flash" data="http://www.ibope.com.ar/ibope/wp/wp-content/themes/ibope/swf/tv.swf?siteUrl=http://www.ibope.com.ar/ibope/wp/wp-content/files_mf/Cuartos_20111117.xml&showIt=true" width="260" height="230">
            <param name="movie" value="http://www.ibope.com.ar/ibope/wp/wp-content/themes/ibope/swf/tv.swf?siteUrl=http://www.ibope.com.ar/ibope/wp/wp-content/files_mf/Cuartos_20111117.xml&showIt=true" />
            <param name="FlashVars" value="siteUrl=http://www.ibope.com.ar/ibope/wp/wp-content/files_mf/Cuartos_20111117.xml&showIt=true" />
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            <param name="play" value="true" />
            <param name="loop" value="true" />
            <param name="wmode" value="transparent" />
            <param name="scale" value="showall" />
            <param name="menu" value="true" />
            <param name="devicefont" value="false" />
            <param name="salign" value="" />
            <param name="allowScriptAccess" value="sameDomain" />
            <!--<![endif]-->
            <a href="http://www.adobe.com/go/getflash">
                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
            </a>
            <!--[if !IE]>-->
        </object>
        <!--<![endif]-->
    </object>
OBJ;
					echo "<div id=\"rating-tv\"><h2 class=\"greyTitle\">Rating</h2><br/>{$object}<span>fuente: IBOPE</span></div>";
        			break;
        		case 8:
        			echo "<div id=\"resultados-futbol\"><h2 class=\"greyTitle\">Resultados fútbol</h2><iframe frameborder=\"no\" scrolling=\"no\" style=\"border: 0px solid rgb(255, 255, 255); height: 352px; width: 220px;\" src=\"http://www.marcadoresonline.com/widgets/widget2.php?mantenerse=si&liga=ARGENTINA\"></iframe></div>";
        			break;
        		case 11:
        			$twtr_object = <<<OBJ
<a class="twitter-timeline" href="https://twitter.com/search?q=tecnolog%C3%ADa" data-widget-id="260418475439296513">Tweets sobre "tecnología"</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        			
OBJ;
					echo $twtr_object;
					break;
        		case 16:
        			echo "<div id=\"clima\" style=\"clear:both;\"><div style='width: 240px; height: 218px; background-image: url( http://vortex.accuweather.com/adcbin/netweather_v2/backgrounds/silver_240x420_bg.jpg ); background-repeat: no-repeat; background-color: #86888B;' ><div id='NetweatherContainer' style='height: 405px;' ><script src='http://netweather.accuweather.com/adcbin/netweather_v2/netweatherV2ex.asp?partner=netweather&tStyle=whteYell&logo=1&zipcode=SAM|AR|AR022|ARGENTINA|&lang=esp&size=12&theme=silver&metric=1&target=_self'></script></div><div style='text-align: center; font-family: arial, helvetica, verdana, sans-serif; font-size: 10px; line-height: 15px; color: #FFFFFF;' ><a style='color: #FFFFFF' href='http://www.accuweather.com/world-index-forecast.asp?partner=netweather&locCode=SAM|AR|AR022|ARGENTINA|&metric=1' >Weather Forecast</a> | <a style='color: #FFFFFF' href='http://www.accuweather.com/maps-satellite.asp' >Weather Maps</a> | <a style='color: #FFFFFF' href='http://www.accuweather.com/index-radar.asp?partner=accuweather&zipcode=SAM|AR|AR022|ARGENTINA|' >Weather Radar</a></div></div></div>";
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
        	<h2 class="greyTitle">Medios</h2>
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
        	<h2 class="greyTitle">Blogs</h2>
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