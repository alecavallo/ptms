<?php 
echo $this->Html->css('columns', 'stylesheet', array('inline' => false ));
echo $this->Html->script(array('tweeter/jquery', 'underscore', 'prototype', 'Marquee', 'columns/columns_controller'),array('inline'=>false, 'once'=>true));
echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>

<script type="text/javascript">
<!--
	var users = <?php echo json_encode($users);?>;
//-->
</script>
<?php echo $this->element('betanotice'/*, array('cache'=>'30 minutes')*/)?>
<div id="content">
	<?php echo $this->element('news'.DS.'marquee')?>
	<div id="colLeft" class="colLeft">
		<h1 class="greyTitle" style="margin-bottom: 20px;">Columnas</h1>
		<img src="/img/degradee.png" alt="" class="degradee"/>
		<div id="filters">
			<label for="filterbox">Buscar: </label><input id="filterbox" type="text"/><span id="reset">&nbsp;X&nbsp;</span>
		</div>
		<div id="users">
		
		</div>
		
		<?php echo $this->element('templates'.DS.'usrlist_template')?>
		
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
