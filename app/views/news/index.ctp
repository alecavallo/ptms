<?php
echo $this->Html->script(array('tweeter/jquery',  'underscore', 'tweeter/feed', 'prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script('scriptaculous',array('inline'=>false));
//echo $this->Html->script('common',array('inline'=>false));
?>
<?php echo $this->element('news'.DS.'popup'/*, array('cache'=>'30 minutes')*/)?>
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
							echo $this->element("widgets".DS."timeline_other_news", array('news'=>$aux));
						}elseif (array_key_exists('Ad', $row)){
							if ($row['Ad']['socialnetwork']==0) {
								echo $this->element("widgets".DS."news_ads", array('ad'=>$row));
							}else {
								if ($row['Ad']['socialnetwork']==1) {
									$aux = $row['Ad'];
									$aux['image'] = $row['twitter']['image'];
									$aux['name'] = $row['twitter']['name'];
									$aux['nickname'] = $row['twitter']['nickname'];
									$aux['text'] = $row['twitter']['text'];
									$aux['snType'] = $row['Ad']['socialnetwork'];
									$aux['link'] = "https://twitter.com/#!/{$row['twitter']['nickname']}";
								}else {
									$aux = $row['Ad'];
									$aux['image'] = $row['facebook']['image'];
									$aux['name'] = $row['facebook']['name'];
									$aux['nickname'] = $row['facebook']['nickname'];
									$aux['text'] = $row['facebook']['text'];
									$aux['snType'] = $row['Ad']['socialnetwork'];
									$aux['link'] = !empty($row['facebook']['pubLink'])?$row['facebook']['pubLink']:"http://www.facebook.com/{$aux['nickname']}";
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
							if ($row['Ad']['socialnetwork']==1) {
								$aux = $row['Ad'];
								$aux['image'] = $row['twitter']['image'];
								$aux['name'] = $row['twitter']['name'];
								$aux['nickname'] = $row['twitter']['nickname'];
								$aux['text'] = $row['twitter']['text'];
								$aux['snType'] = $row['Ad']['socialnetwork'];
								$aux['link'] = "https://twitter.com/#!/{$row['twitter']['nickname']}";
							}else {
								$aux = $row['Ad'];
								$aux['image'] = $row['facebook']['image'];
								$aux['name'] = $row['facebook']['name'];
								$aux['nickname'] = $row['facebook']['nickname'];
								$aux['text'] = $row['facebook']['text'];
								$aux['snType'] = $row['Ad']['socialnetwork'];
								$aux['link'] = !empty($row['facebook']['pubLink'])?$row['facebook']['pubLink']:"http://www.facebook.com/{$aux['nickname']}";
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
        <div id="otherNewsContainer" class="otherNewsContainer">
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
    </div>