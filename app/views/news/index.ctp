<?php
echo $this->Html->script(array('tweeter/jquery',  'underscore', 'tweeter/feed', 'prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script('scriptaculous',array('inline'=>false));
//echo $this->Html->script('common',array('inline'=>false));
?>
<?php echo $this->element('news'.DS.'popup'/*, array('cache'=>'30 minutes')*/)?>
<script type="text/javascript">
<!--
var commentsId = new Array();
var commentsUrl = new Array();
//-->
</script>
<div id="content">
		<?php echo $this->element('news'.DS.'marquee', array('cache'=>'30 minutes'))?>
    	<div id="colLeft">
    	<section>
			<h1 class="greyTitle" style="margin-bottom: 20px;">Twitters</h1>
			<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
			<cake:nocache>
			<div id="tweets">
			<?php
				echo $this->element("templates".DS."timeline_twitter");
			?>
			
        	</div>
        	</cake:nocache>
        	<script type="text/javascript">
				jQuery(document).ready(function(){
					window.t = new Twitter();
					t.getHomeFeed(0, '#tweets');
				});
			</script>
        	<?php echo $this->element("twitter_trends", array('cache'=>'3 minutes'));?>
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
								//debug($row);
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
				}
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
        
        <script type="text/javascript">
        	jQuery("div.news").hover(
                function(){
                	window.dflt = jQuery(this).html();
                	//alert(window.dflt);
                	var id = jQuery(this).attr('id');
                    /*var link = document.createElement('span');
                    link.innerHTML="ampliar &gt;&gt;";*/
                    
                    jQuery('div#'+id+" h3 a").html(jQuery('div#'+id+" #title"+id).val());
                    /*link.onclick = function(param1,param2){
                        var id = jQuery(this).closest('div.news').attr('id');
						//alert(jQuery(this).closest('div.news').attr('id'));
						//jQuery('div#'+id+" h3 a").html(jQuery('div#'+id+" #title"+id).val());
						jQuery(this).closest('div.news').addClass('expanded');
						jQuery(this).closest('div.news').removeClass('collapsed');
						jQuery('div.news').unbind('hover');
                    	jQuery('div#'+id+" h3 a").html(jQuery('div#'+id+" #title"+id).val());
                    	jQuery('div#'+id+" p.summary").html(jQuery('div#'+id+" #summary"+id).val());
                    	//jQuery('div#'+id+" div.mainComments").html('');
                    	jQuery('div#'+id+" div.mainComments").load("/news/getComment/"+id);
                    	
                    };*/
                    //link.setAttribute('onclick',alert('hola'););
                    
					//jQuery(this).find("div.mainComments").append(link);
        		},
        		function(){
            		//alert(window.dflt);
					jQuery(this).html(dflt);
        		}
           	);
        </script>
        
        <div id="adsContainer">
        	<?php 
        	if (!empty($banner)) {
        		echo $html->link($html->image($banner[0]['Ad']['url'], array('alt'=>$banner[0]['Ad']['name'], 'style'=>"display: block; position: relative; width: 100%;")), $banner[0]['Ad']['link'], array('escape'=>false));
        	}
        	?>
        </div>
        
        <section>
			<?php
				$parameters = array(
					'wId'	=>	"images",
					'wTitle'	=>	"Posts en imágenes",
					'float'	=>	"left"
				);
        		echo $this->element("widgets".DS. "hlongimgwidget", array('par'=>$parameters,'cache'=>'1 hour'));
        		$param2 = array(
					'wId'		=>	"videos",
					'wTitle'	=>	"Videos populares de youtube",
        			'float'		=>	"right",
        			'category'	=>	""
				);
        		echo $this->element("widgets".DS. "hlongvidwidget", array('par'=>$param2,'cache'=>'12 hours'));
        	?>

                <br clear="all"/>
        </section>
        </div>
            <br clear="all"/>
            <br clear="all"/>
        <!-- <div id="otherNewsContainer" class="otherNewsContainer">
    </div> -->