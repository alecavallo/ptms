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
<style type="text/css">				
#holder {
	position: relative;   /* leave as "relative" to keep timer centered on 
				 your page, or change to "absolute" then change
				 the values of the "top" and "left" properties to 
				 position the timer */
	top: 10px;            /* change to position the timer; must also change
				 position to "absolute" above */
	left: 0px;  	      /* change to position the timer; must also change
				 position to "absolute" above */
	width: 270px;
	height: 60px;
	border: none;
	margin: 0px auto;
}

#title, #note {
	color: lime;	      /* this determines the color of the DAYS, HRS, MIN, 
				 SEC labels under the timer and the color of the 
				 note that displays after reaching the target date
				 and time; if using the blue digital images,
				 change to #52C6FF; for the red images,
				 change to #FF6666; for the white images,
				 change to #BBBBBB; for the yellow images,
				 change to #FFFF00 */
}

#note {
	position: relative;
	top: 6px;
	height: 20px;
	width: 260px;
	margin: 0 auto;
	padding: 0px;
	text-align: center; 
	font-family: Arial; 
	font-size: 18px;
	font-weight: bold;    /* options are normal, bold, bolder, lighter */
	font-style: normal;   /* options are normal or italic */
	z-index: 1;
}

.title {
	border: none;
	padding: 0px;
	margin: 0px;
	width: 30px;
	text-align: center;
	font-family: Arial;
	font-size: 10px;
	font-weight: normal;    /* options are normal, bold, bolder, lighter */
	background-color: transparent; 
}

#timer {
	position: relative; 
	top: 0px; 
	left: 0px; 
	margin: 5px auto; 
	text-align: center; 
	width: 260px;
	height: 26px;
	border: none;
	padding: 10px 5px 20px 5px; 
	background: #000000;      /* may change to another color, or to "transparent" */
	border-radius: 20px;
	box-shadow: 0 0 10px #000000;  /* change to "none" if you don't want a shadow */
}
</style>

<script type="text/javascript">		
/*
Count down until any date script-
By JavaScript Kit (www.javascriptkit.com)
Over 200+ free scripts here!
Modified by Robert M. Kuhnhenn, D.O. 
(www.rmkwebdesign.com/Countdown_Timers/)
on 5/30/2006 to count down to a specific date AND time,
on 10/20/2007 to a new format, on 1/10/2010 to include
time zone offset, and on 7/12/2012 to digital numbers.
*/

/*  
CHANGE THE ITEMS BELOW TO CREATE YOUR COUNTDOWN TARGET DATE AND ANNOUNCEMENT 
ONCE THE TARGET DATE AND TIME ARE REACHED.
*/
var note="Esper&aacute;! S&oacute;lo unos segs";	/* -->Enter what you want the script to 
				      display when the target date and time 
				      are reached, limit to 25 characters */
var year=2012;      /* -->Enter the count down target date YEAR */
var month=08;       /* -->Enter the count down target date MONTH */
var day=13;         /* -->Enter the count down target date DAY */
var hour=15;         /* -->Enter the count down target date HOUR (24 hour clock) */
var minute=00;      /* -->Enter the count down target date MINUTE */
var tz=-3;          /* -->Offset for your timezone in hours from UTC (see 
			  http://wwp.greenwichmeantime.com/index.htm to find 
			  the timezone offset for your location) */

//-->    DO NOT CHANGE THE CODE BELOW!    <--	
d1 = new Image(); d1.src = "/digital-numbers/1.png";
d2 = new Image(); d2.src = "/digital-numbers/2.png";
d3 = new Image(); d3.src = "/digital-numbers/3.png";
d4 = new Image(); d4.src = "/digital-numbers/4.png";
d5 = new Image(); d5.src = "/digital-numbers/5.png";
d6 = new Image(); d6.src = "/digital-numbers/6.png";
d7 = new Image(); d7.src = "/digital-numbers/7.png";
d8 = new Image(); d8.src = "/digital-numbers/8.png";
d9 = new Image(); d9.src = "/digital-numbers/9.png";
d0 = new Image(); d0.src = "/digital-numbers/0.png";
bkgd = new Image(); bkgd.src = "/digital-numbers/bkgd.gif";

var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

function countdown(yr,m,d,hr,min){
	theyear=yr;themonth=m;theday=d;thehour=hr;theminute=min;
	var today=new Date();
	var todayy=today.getYear();
	if (todayy < 1000) {todayy+=1900;}
	var todaym=today.getMonth();
	var todayd=today.getDate();
	var todayh=today.getHours();
	var todaymin=today.getMinutes();
	var todaysec=today.getSeconds();
	var todaystring1=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec;
	var todaystring=Date.parse(todaystring1)+(tz*1000*60*60);
	var futurestring1=(montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min);
	var futurestring=Date.parse(futurestring1)-(today.getTimezoneOffset()*(1000*60));
	var dd=futurestring-todaystring;
	var dday=Math.floor(dd/(60*60*1000*24)*1);
	var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);
	var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
	var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
	if(dday<=0&&dhour<=0&&dmin<=0&&dsec<=0){
		document.getElementById('note').innerHTML=note;
		document.getElementById('note').style.display="block";
		document.getElementById('countdown').style.display="none";
		clearTimeout(startTimer);
		return;
	}
	else {
		document.getElementById('note').style.display="none";
		document.getElementById('timer').style.display="block";
		startTimer = setTimeout("countdown(theyear,themonth,theday,thehour,theminute)",500);
	}
	convert(dday,dhour,dmin,dsec);
}

function convert(d,h,m,s) {
	if (!document.images) return;
	if (d <= 9) {
		document.images.day1.src = bkgd.src;
		document.images.day2.src = bkgd.src;
		document.images.day3.src = eval("d"+d+".src");
	}
	else if (d <= 99) {
		document.images.day1.src = bkgd.src;
		document.images.day2.src = eval("d"+Math.floor(d/10)+".src");
		document.images.day3.src = eval("d"+(d%10)+".src");
	}
	else {
		document.images.day1.src = eval("d"+Math.floor(d/100)+".src");
		var day = d.toString();
		day = day.substr(1,1);
		day = parseInt(day);
		document.images.day2.src = eval("d"+day+".src");
		document.images.day3.src = eval("d"+(d%10)+".src");
	}
	if (h <= 9) {
		document.images.h1.src = d0.src;
		document.images.h2.src = eval("d"+h+".src");
	}
	else {
		document.images.h1.src = eval("d"+Math.floor(h/10)+".src");
		document.images.h2.src = eval("d"+(h%10)+".src");
	}
	if (m <= 9) {
		document.images.m1.src = d0.src;
		document.images.m2.src = eval("d"+m+".src");
	}
	else {
		document.images.m1.src = eval("d"+Math.floor(m/10)+".src");
		document.images.m2.src = eval("d"+(m%10)+".src");
	}
	if (s <= 9) {
		document.images.s1.src = d0.src;
		document.images.s2.src = eval("d"+s+".src");
	}
	else {
		document.images.s1.src = eval("d"+Math.floor(s/10)+".src");
		document.images.s2.src = eval("d"+(s%10)+".src");
	}
}
</script>
</head>
<body onload="countdown(year,month,day,hour,minute)">
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
