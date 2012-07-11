<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=1"/> <!--320-->
<?php $city = $session->read('City');?>
<?php //echo $this->Facebook->html();?>
<head>
<link href='http://fonts.googleapis.com/css?family=Arimo:400,400italic|Ubuntu:700' rel='stylesheet' type='text/css'>
<?php

		echo $this->Html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));

		echo $this->Html->css('main');

		echo $this->Html->css('menu');

		echo $scripts_for_layout;

?>
<?php echo $this->Html->charset('utf-8'); ?>
<title>
<?php __("Posteamos.com :: {$title_for_layout}")?>
</title>

</head>

<body>
<?php echo $this->Facebook->init();?>
<div class="header" id="header">
	<?php echo $html->link($html->image("logo_posteamos.png", array('alt'=>"Posteamos.com", 'id'=>"logo")),array('controller'=>"news",'action'=>'index'), array('escape'=>false))?>

	<?php
		$image = $html->image('search.png', array('alt'=>"Buscar", 'id'=>"search"));
		$search = $html->link($image, '#nogo', array('class'=>"submit", 'escape'=>false, 'onclick'=>"document.getElementById('searchContainer').style.display='block'; return false;"));
		echo $this->Html->div('searchbox', $search, array('id'=>"searchIconContainer"));
	?>


</div>
<?php
	$search = $html->tag('h3',"Introduzca el texto a buscar", array('class'=>"searchLabel"));
	$search .= $form->create('News', array('id'=>"topSearch", 'type'=>"post", 'controller'=>"news", 'action'=>"search"));
	$search .= $form->input('pattern', array('label'=>"",'size'=>25,'maxlength'=>150,'class'=>"search"));
	$search .= $form->submit('Buscar', array('class'=>"submit", "onClick"=>"Effect.Fade($('searchContainer'), { duration: 1.0 });"));
	echo $this->Html->div('searchbox', $search, array('id'=>"searchContainer", 'style'=>"display: none;"));
?>
<?php echo $this->element('menu/generalMenu', array('city'=>$city/*, 'cache'=>'10 minutes'*/))?>
<div id="container">
	<?php echo $this->Session->flash('email'); ?>
	<?php echo $content_for_layout; ?>
    <br clear="all"/>
    <div id="footerMobile">
    	<a href="#nogo" onclick="setCookie('webEnabled', 1, 30); window.location.reload(); return false;">Ver versión completa</a>
    </div>
</div>

<?php //echo $this->element("footer",array('cache'=>'1 day'));?>
<div id="debug">

<?php echo $this->element('sql_dump'); ?>

</div>

<?php
	echo $js->writeBuffer();
?>
<script type="text/javascript">
//<![CDATA[
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23677899-1']);
  _gaq.push(['_setDomainName', '.posteamos.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
//]]>
</script>
<script type="text/javascript">
//API init code is omitted

</script>
</body>
</html>
