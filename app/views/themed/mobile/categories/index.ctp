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
	<li class="normal" onclick="$$('li.normal').each(function(e){e.removeClassName('selected');});$(this).addClassName('selected');$('colLeft').hide();$('colCenter').hide();$('colRight').show()">Tweeter</li>
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
    	<div id="colRight" style="display: none">
    		<!-- <div class="title">
				<h1 class="greyTitle">Twitters</h1>
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
       </div>
        

        
        <div id="adsContainer"></div>
        <div id="otherNewsContainer" class="otherNewsContainer">
			<?php
				$parameters = array(
					'wId'	=>	"images",
					'wTitle'	=>	"Posts en imágenes",
				);
        		//echo $this->element("widgets".DS. "hlongimgwidget", array('par'=>$parameters));
        		$param2 = array(
					'wId'	=>	"videos",
					'wTitle'	=>	"Videos populares de youtube",
				);
        		//echo $this->element("widgets".DS. "hlongvidwidget", array('par'=>$param2));
				//echo $this->element("twitter_trends");
        	?>

                <br clear="all"/>
        </div>
            <br clear="all"/>
            <br clear="all"/>
    </div>

    <script type="text/javascript">
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



		/*new Ajax.Request("/twtr/getList/<?php echo $lastTweet;?>/<?php echo $category['Category']['name']?>",{
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

		);*/
	</script>