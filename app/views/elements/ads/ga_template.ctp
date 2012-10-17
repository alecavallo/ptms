<?php 
if(!empty($gadw)){
?>
<script type="text/javascript"><!--
google_ad_client = "<?php echo $gadw['google_ad_client']?>";
/* publicidad de usuario */
google_ad_slot = "<?php echo $gadw['google_ad_slot'];?>";
google_ad_width = <?php echo $gadw['google_ad_width'];?>;
google_ad_height = <?php echo $gadw['google_ad_height'];?>;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?php 
}else {
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
<?php 
}
?>