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
			<div id="tweets">
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
			<?php
				echo $this->element("templates".DS."timeline_twitter", array('cache'=>"1 hour"));
			?>
        	</div>
        	<?php echo $this->element("twitter_trends");?>
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
					'categoryId' => $blogs[0]['Category']['id']
					//'categoryId'	=>	"Posts en imágenes", die('errorororor');
				);
        		echo $this->element("widgets".DS. "hlongimgwidget", array('par'=>$parameters));
        		//$cate = Inflector::camelize($row['Category']['name']);
        		$cate = $blogs[0]['Category']['name'];
        		$param2 = array(
					'wId'	=>	"videos",
					'wTitle'	=>	"Videos populares de youtube",
        			//'category'	=>	str_ireplace(" & ", "%7C", strtolower($row['Category']['name']))
        			'category'	=>	$cate
				);
        		echo $this->element("widgets".DS. "hlongvidwidget", array('par'=>$param2));
        	?>

                <br clear="all"/>
        </section>
        </div>
            <br clear="all"/>
            <br clear="all"/>
    </div>

    <!-- <script type="text/javascript">
    var i=0;
    var page=1;
    var maxTweets = 15;
    var max = 17;
    var cont = [ ];
    var elem = null;
    var firstRun = true;
    var aux = [ ];
    var lastTweet = 0;
    function update(el, content){
		aux = content;
        elem = el;
        cont = content[0];
        //alert(content.length);
        if(cont != null){
        	max =  cont.length;
        }
        lastTweet = content[1];


		if(max > 0){
			r = cont[i];
    		Element.update(elem, r+elem.innerHTML);
    		i=i+1;
    		twts = $$('#tweets .twitterNews');
    		first = twts[0];
    		firstHeight = first.getHeight()+6;
    		first.height = firstHeight;
    		parentPosition = first.cumulativeOffset();
    		firstPosition = parentPosition.top-firstHeight;


    		//alert(twts.length);

    		first.setStyle({top: "-"+(firstHeight)+'px'});
    		diff = parentPosition.top-first.cumulativeOffset().top;
    		//alert("Pos Orig: "+parentPosition.top+" altura: "+firstHeight+" Pos Ahora: "+first.cumulativeOffset().top+" Diferencia: "+(diff));

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
         		{duration: 2}
         	);
		}else{
			setTimeout("new Ajax.Request('/twtr/getList/'+lastTweet+'/<?php echo $category['Category']['name'];?>',{ asynchronous:true, evalJSON:true, method: 'get', onSuccess: function(response){ response = eval(response.responseText); var elem = $('tweets'); i=0; update(elem, response);}})", 30000);
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
    		setTimeout("update($('tweets'), aux)", 6000);
    		return;
    	}else{
    		//alert('I mayor que max');
    	}

    	/*if(page == maxPages || max){
    		page=0;
    		i=max;
    	}*/
    	if((i>=max)){
    		new Ajax.Request('/twtr/getList/'+lastTweet+'/<?php echo $category['Category']['name']?>',{
				asynchronous:true,
				evalJSON:true,
				method: 'get',
				onSuccess: function(response){
					//alert('Llamo a update');
					response = eval(response.responseText);
					var elem = $('tweets');
					i=0;
					//if( response.length > 0){
						update(elem, response);
					//}
				}
			}

			);
    	}else{
        	//alert(max);

    	}
    }



		new Ajax.Request("/twtr/getList/<?php echo $lastTweet;?>/<?php echo $category['Category']['name']?>",{
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
	<?php echo $this->element("templates".DS."timeline_twitter", array('tweet'=>$aux));?>