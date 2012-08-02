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
			<h1 class="greyTitle" style="margin-bottom: 20px;">Twitters</h1>
			<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
			<cake:nocache>
			<div id="tweets">
			<?php
				echo $this->element("templates".DS."timeline_twitter");
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					window.t = new Twitter();
					t.getHomeFeed(0);
				});
			</script>
        	</div>
        	</cake:nocache>
        	<?php echo $this->element("twitter_trends", array('cache'=>'3 minutes'));?>
       </div>
        <div id="colCenter">
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
			</div>

        <div id="colRight">
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
        </div>
        <div id="adsContainer">
        	<?php 
        	if (!empty($banner)) {
        		echo $html->link($html->image($banner[0]['Ad']['url'], array('alt'=>$banner[0]['Ad']['name'], 'style'=>"display: block; position: relative; width: 100%;")), $banner[0]['Ad']['link'], array('escape'=>false));
        	}
        	?>
        </div>
        <div id="otherNewsContainer" class="otherNewsContainer">
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
        </div>
            <br clear="all"/>
            <br clear="all"/>
    </div>

    <!-- <script type="text/javascript">
    var i=0;
    var page=1;
    var maxTweets = 14;
    //var max = 15;
    var max = maxTweets;
    var cont = [ ];
    var elem = null;
    var firstRun = true;
    var aux = [ ];
    var lastTweet = 0;
    var ready = true;
    function update(el, content){
        
		aux = content;
        elem = el;
        cont = content[0];
        if(cont != null){
        	max =  cont.length; //el máximo es igual a la cantidad de tweets recuperados
        }
        lastTweet = content[1];


		if(max > 0){
			ready = false;
			r = cont[i];
    		Element.update(elem, r+elem.innerHTML); //concateno el primer tweet obtenido con los ya existentes
    		i=i+1;
    		twts = $$('#tweets .twitterNews');
    		first = twts[0];
    		if (first.getHeight()+parseInt(first.getStyle('margin-bottom'), 10) > 0){
    			firstHeight = first.getHeight()+parseInt(first.getStyle('margin-bottom'), 10);
    		}
    		parentPosition = first.cumulativeOffset();
    		firstPosition = parentPosition.top-firstHeight;


    		//alert(twts.length);

    		first.setStyle({top: "-"+(firstHeight)+'px'});
    		diff = parentPosition.top-first.cumulativeOffset().top;
    		//if(diff<33){
    			//alert("Pos Orig: "+parentPosition.top+" altura: "+firstHeight+" Pos Ahora: "+first.cumulativeOffset().top+" Diferencia: "+(diff));
    		//}

    		var effects = [ ];
        	effects.push(new Effect.MoveBy(first, diff, 0, { sync: true }));
         	effects.push(new Effect.Opacity(first, {duration:1, from:0, to:1.0}));
    		if( firstRun==false){
            	last = twts[twts.length-1];
             	effects.push(new Effect.DropOut(last, {duration:3}));
             	setTimeout("last.remove()", 3500);
            }
    		twts.each( function(tel){
        			effects.push(new Effect.MoveBy(tel, diff, 0, { sync: true }));
	    		}
	        );
    		new Effect.Parallel(
         		effects,
         		{duration: 1}
         	);
         	ready = true;
		}else{
			while (ready == false){
				//do nothing
			}
			setTimeout("new Ajax.Request('/twtr/getTimeline/'+lastTweet,{ asynchronous:true, evalJSON:true, method: 'get', onSuccess: function(response){ response = eval(response.responseText); var elem = $('tweets'); i=0; update(elem, response);}})", 40000);
			//new Ajax.Request('/twtr/getTimeline/'+lastTweet,{ asynchronous:true, evalJSON:true, method: 'get', onSuccess: function(response){ response = eval(response.responseText); var elem = $('tweets'); i=0; update(elem, response);}});
			return;
		}

		if((twts.length-1)>= (maxTweets-1)){
			//alert('A borrar: '+(twts.length-1));
			firstRun = false;
		}else{
			//alert(twts.length-1);
		}
    	//i=i+1;
    	if ( i < max){
    		//alert('Llamo a update desde script');
    		/*if(max > 17){
            	alert(cont);
        	}*/
        	//alert(content);
    		while (ready == false){
				//do nothing
			}
    		setTimeout("update($('tweets'), aux)", 10000);
    		return;
    	}else{
    		//alert('I mayor que max');
    	}

    	/*if(page == maxPages || max){
    		page=0;
    		i=max;
    	}*/
    	if((i>=max)){
    		while (ready == false){
				//do nothing
			}
    		setTimeout("new Ajax.Request('/twtr/getTimeline/'+lastTweet,{ asynchronous:true, evalJSON:true, method: 'get', onSuccess: function(response){ response = eval(response.responseText); var elem = $('tweets'); i=0; update(elem, response);}})", 40000);
    		/*new Ajax.Request('/twtr/getTimeline/'+lastTweet,{
				asynchronous:true,
				evalJSON:true,
				method: 'get',
				onSuccess: function(response){
					response = eval(response.responseText);
					var elem = $('tweets');
					i=0;
					update(elem, response);
				}
			}

			);*/
    	}else{
        	//alert(max);

    	}
    }



		new Ajax.Request("/twtr/getTimeline/<?php echo $lastTweet;?>",{
				asynchronous:true,
				evalJSON:true,
				method: 'get',
				onSuccess: function(response){
					response = eval(response.responseText);
					var elem = $('tweets');
					//alert('llamo luego de ajax');
					update(elem, response);
				}
			}

		);
	</script> -->