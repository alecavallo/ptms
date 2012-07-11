<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset('utf-8'); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Posteamos.com</title>
	<style>
	<!--
	div#footer hr{
		background-color: #cfcfcf;
		height: 1px;
		border-style:none;
	}
	-->
	</style>
</head>
<body>
	<div id="header" style="width=850px;height=82px;margin-left:auto;margin-right:auto">
		<img src="<?php echo Router::url("/",true)?>img/mail/top.jpg" width="850" height="82" />
	</div>
	<div id="container" style="width: 100%;clear: both;font-family: Arial, Helvetica, sans-serif; color: #000000; font-size:13px;">
		<?php echo $content_for_layout; ?>
	</div>
	<div id="footer" style="height:75px;background-color:#000000;font-family: Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:12px; text-align:center;">
	<hr noshade="noshade" style="background-color: #cfcfcf;height: 1px;border-style:none;"/>
		<p>
		Posteamos.com - Periodismo colaborativo
		</p>
		<p>
			Consultas y sugerencias: <a href="mailto:info@posteamos.com">info@posteamos.com</a>
			<br/>
			Problemas técnicos: <a href="mailto:support@posteamos.com">support@posteamos.com</a>
		</p>
	</div>
</body>
</html>