<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset('utf-8'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Posteamos.com se proyecta como un sitio web de noticias, interactivo y participativo, que se nutre de contenido posteado por sus usuarios y la sindicaci�n de contenido de medios tradicionales, Blogs y Tweets. Los usuarios pueden escribir art�culos, enlaces a contenido externo y comentar, o comparar noticias presentadas por otros usuarios, medios o periodistas.">
<meta name="keywords" content="Posteamos, posteamos, Posteamos.com, posteamos.com, postea, posteá, posta, noticias, información, informacion, actualidad, Argentina, argentina, Latinoamérica, Latinoamerica, latinoamérica, latinoamerica, sucesos, novedades, tecnología, política, espectáculos, paparazzi, farándula, diarios, santa fe, noticias locales, periodismo ciudadano, agregador de noticias">

<title>Posteamos.com | Un sitio de noticias interactivo y participativo</title>
<?php
	echo $this->Html->css('splash');
	echo $this->Html->script('jquery');

	echo $scripts_for_layout;

?>

<script type="text/javascript">
//<![CDATA[
$(function(){
  $("#video").mouseenter(function(){
  $(this).stop().fadeTo("slow", 0);
}).mouseleave(function(){
  $(this).stop().fadeTo("slow", 1);
});
});

function login(){
$("#slide").animate({"left": "-=423px"}, 500);
document.getElementById('txt').style.display = 'none';
document.getElementById('txt2').style.display = 'block';
};
function ok(){
		$("#slide").animate({"left": "-=423px"}, 500);
		setTimeout(function(){ ya();},2000);

};
function ya(){
		 $("#slide").fadeOut('500');
		setTimeout(function(){ yes();},600);
};
function yes(){
		 $("#slide").animate({"left": "22px"}, 5);
		setTimeout(function(){ $("#slide").fadeIn('500');  },6);
};



$(document).ready(function () {
    $().ajaxStart(function() {

    }).ajaxStop(function() {
		ok();
    });
    $('#fo3').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);

            }
        });

        return false;
    });
});

$(document).ready(function () {
$('#fo4').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
               $('#txt,#txt2 ').html(data);
			   split;
            }
        });

        return false;
    });
});
//]]>
</script>
</head>
<body>
	<?php echo $content_for_layout; ?>
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
