<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $city = $session->read('City');?>
<?php echo $this->Facebook->html();?>
<head>
<?php echo $this->Html->charset('utf-8'); ?>
<title>
<?php __("Posteamos.com :: {$title_for_layout}")?>
</title>
<?php

		echo $this->Html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));

		echo $this->Html->css('main');

		echo $this->Html->css('menu');


		//echo $this->Html->script('prototype');
		//echo $this->Html->script('scriptaculous');
		//echo $this->Html->script('common');
echo $scripts_for_layout;

?>


<!-- <script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js"></script>
<script type="text/javascript" src="js/common.js"></script>  -->
</head>

<body>
<?php echo $this->Facebook->init();?>
<div class="header" id="header">
	<?php echo $html->link($html->image("logo_posteamos.png", array('alt'=>"Posteamos.com", 'id'=>"logo")),array('controller'=>"news",'action'=>'index', 'admin'=>false), array('escape'=>false))?>
	<?php echo $this->element('menu/adminMenu'/*, array('cache'=>'10 days')*/)?>
</div>
<br clear="all"/>

<div id="container">
	<?php //echo $this->Session->flash(); ?>
	<?php echo $this->Session->flash('email'); ?>



	<?php echo $content_for_layout; ?>

    <br clear="all"/>
</div>

<?php echo $this->element("footer",array('cache'=>'1 day'));?>
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
</body>
</html>
