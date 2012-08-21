<?php 
echo $this->Html->css('columns', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>
<div id="content">
	<div id="ads">
	
		<?php
		if(Router::url("/",true) != "http://posteamos.localhost.com/"){//
		?>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Anuncio columnas y pendientes 1 */
		google_ad_slot = "2925543696";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Anuncio columnas y pendientes 2a */
		google_ad_slot = "3802193888";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Anuncio columnas y pendientes 3 */
		google_ad_slot = "1111764142";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<?php }?>
	
	</div>
	<div id="newsList">
		<?php 
		foreach ($news as $row) {
			$image = !empty($user['User']['avatar'])?$user['User']['avatar']:"empty.jpg";
			$image = $this->Html->image($image);
			$section = $this->Html->tag('h4', $row['Category']['name'], array('class'=> "section grey"));
			if(!empty($row['News']['link'])){
				$title = $this->Html->link($this->Html->tag('h3', $row['News']['title']), $row['News']['link'], array('target'=>'blank', 'escape'=>false));
			}else{
				$title = $this->Html->link($this->Html->tag('h3', $row['News']['title']), "/columna/{$row[0]['alias']}/noticia/{$row['News']['id']}-".Inflector::slug($row['News']['title'],"-").".html", array('target'=>'blank', 'escape'=>false));
			}
			$heading = $this->Html->div('heading',$section.$title);
			
			$summary = $this->Html->para('summary', $this->Text->truncate($row['News']['summary'], 250, array('ending'=>"...", 'html'=>true, 'exact'=>false)));
			echo $this->Html->div('newsRows', $image.$heading.$summary);
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
</div>