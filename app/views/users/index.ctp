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
			<label for="filterbox" class="greyTitle">Buscar: </label><input id="filterbox" type="text"/><span id="reset" class="greyTitle">&nbsp;X&nbsp;</span>
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
