<?php 
echo $this->Html->css('columns', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>
<div id="content">
	<?php echo $this->element('news'.DS.'marquee')?>
	<div id="colLeft" class="colLeft">
		<?php 
		    $this->Paginator->options(array(
		    'update' => 'colLeft',
		    'evalScripts' => true
		    ));
		?>
		<?php echo $this->element('users'.DS.'usr_list',array('users', $users))?>
		
	</div>
	<div id="pending">
		<?php echo $this->element('news'.DS.'pendings', array('categories'=>$categories))?>
	</div>
	<div id="pendingAds" class="colRight">
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
	
	<br clear="all"/>
</div>
