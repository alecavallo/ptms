<?php 
echo $this->Html->css('columns', 'stylesheet', array('inline' => false ));
echo $this->Html->css('jscrollpane/jquery.jscrollpane', 'stylesheet', array('inline' => false ));
echo $this->Html->css('jscrollpane/jquery.jscrollpane.lozenge', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('tweeter/jquery', 'underscore', 'prototype', 'Marquee', 'columns/columns_controller'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('jscrollpane/jquery.mousewheel.min','jscrollpane/jquery.jscrollpane.min'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>
<div id="content">
	<div id="ads">
	
		<?php
		if(Router::url("/",true) != "http://posteamos.localhost.com/"){//
		?>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Banner Largo Vertical */
		google_ad_slot = "0183084197";
		google_ad_width = 160;
		google_ad_height = 600;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<?php }?>
	
	</div>
	<script type="text/javascript">
		jQuery(function(){
				jQuery('div#newsList').jScrollPane();
		});
	</script>
	<div id="newsList">
		<?php 
		$votes = $session->read('votes');
		$votes = !empty($votes)?$votes:array();
		foreach ($news as $row) {
			$image = !empty($user['User']['avatar'])?$user['User']['avatar']:"empty.jpg";
			$image = $this->Html->image($image, array('class'=>'avatar'));
			$section = $this->Html->tag('h4', $row['Category']['name'], array('class'=> "section grey"));
			if(!empty($row['News']['link'])){
				$title = $this->Html->link($this->Html->tag('h3', $row['News']['title']), $row['News']['link'], array('target'=>'blank', 'escape'=>false));
			}else{
				$title = $this->Html->link($this->Html->tag('h3', $row['News']['title']), "/columna/{$row[0]['alias']}/noticia/{$row['News']['id']}-".Inflector::slug($row['News']['title'],"-").".html", array('target'=>'blank', 'escape'=>false));
			}
			$heading = $this->Html->div('heading',$section.$title);
			
			$summary = $this->Html->para('summary', $this->Text->truncate($row['News']['summary'], 250, array('ending'=>"...", 'html'=>true, 'exact'=>false)));
			
			$date = strtotime($row['News']['created']);

			$usrData = $this->Html->div('usrData', "Por ".$user['User']['first_name']." ".$user['User']['last_name']." - ".date('d/m/y', $date));
			$up = $this->Html->image('OK.png', array("class"=>"vote")); 
			$down = $this->Html->image('NO.png', array("class"=>"votedown"));
			
			if (!in_array($row['News']['id'], $votes)) {
				$vote = $this->Html->div('vote_buttons',$up.$down);
			}else {
				$vote = $this->Html->div('vote_buttons',"");
			}
			$clear = $this->Html->div('clearFloat',"");
			$metadata = $this->Html->div('metadata',$usrData.$vote.$clear);
			
			echo $this->Html->div('newsRows', $heading.$image.$summary.$metadata);
		}
		?>
	</div>
	
	<div id="usrDesc">
		<?php 
			echo $this->Html->image($user['User']['avatar']);
		?>
		<h3><?php echo "{$user['User']['first_name']} {$user['User']['last_name']} -- {$user['User']['alias']}"?></h3>
		<p class="description">
			<?php echo $user['User']['description']?>
		</p>
		<p id="webPage">
			<?php //echo $this->Html->link($user['Source']['url'],$user['Source']['url'],array('target'=>"blank"))?>
		</p>
		<br/>
		<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
		<?php if(!empty($user['User']['alias'])){?>
		<script>
		new TWTR.Widget({
		  version: 2,
		  type: 'search',
		  search: 'from:@<?php echo $user['User']['alias']?> OR to:@<?php echo $user['User']['alias']?>',
		  interval: 40000,
		  title: 'Todo lo que se habla de',
		  subject: '@<?php echo $user['User']['alias']?>',
		  width: 'auto',
		  height: 300,
		  theme: {
		    shell: {
		      background: '#838281',
		      color: '#ffffff'
		    },
		    tweets: {
		      background: '#ffffff',
		      color: '#444444',
		      links: '#8ac33f'
		    }
		  },
		  features: {
		    scrollbar: false,
		    loop: true,
		    live: true,
		    timestamp: false,
		    behavior: 'default'
		  }
		}).render().start();
		</script>
		<?php }?>
	</div>
	<br clear="both"/>
	<br clear="both"/>
	<br clear="both"/>
	<?php
		if(Router::url("/",true) != "http://posteamos.localhost.com/"){//
	?>
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-6965617047977932";
	/* Footer-Bloque Anuncios */
	google_ad_slot = "6067688955";
	google_ad_width = 728;
	google_ad_height = 15;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<?php }?>
	<!-- Google Code for P&aacute;gina de publicidad Conversion Page -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 995381652;
	var google_conversion_language = "en";
	var google_conversion_format = "3";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "BFwtCLTz8wMQlKPR2gM";
	var google_conversion_value = 0;
	/* ]]> */
	</script>
	<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/995381652/?value=0&amp;label=BFwtCLTz8wMQlKPR2gM&amp;guid=ON&amp;script=0"/>
	</div>
	</noscript>
	
</div>