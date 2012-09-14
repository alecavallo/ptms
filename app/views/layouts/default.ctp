<!DOCTYPE html>
<?php $city = $session->read('City');?>
<?php echo $this->Facebook->html();?>
<head>
<?php echo $this->Html->charset('utf-8'); ?>
<title>
<?php __("Posteamos.com :: {$title_for_layout}")?>
</title>

<!-- <link href='http://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic|Ubuntu:400,700' rel='stylesheet' type='text/css'> -->
<link href='http://fonts.googleapis.com/css?family=Arimo:400,400italic|Ubuntu:700' rel='stylesheet' type='text/css'>
<?php

		echo $this->Html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));

		echo $this->Html->css('main');

		echo $this->Html->css('menu');


		//echo $this->Html->script('prototype');
		//echo $this->Html->script('scriptaculous');
		//echo $this->Html->script('common');
echo $scripts_for_layout;

?>
<?php 
	if(empty($meta) || !array_key_exists('description', $meta)){
		//echo $this->Html->meta('description', "Un sitio de noticias interactivo y participativo");
		echo '<meta name="description" content="Posteamos.com, un sitio de noticias interactivo y participativo donde encontraras noticias publicadas a traves de medios, blogs y twitter" />';
	}else {
		echo $this->Html->meta('description', $meta['description']);
	}
?>
<?php 
	if(empty($meta) || !array_key_exists('keywords', $meta)){
		//echo $this->Html->meta('keywords', "posteamos,noticias,blogs,diarios,argentina,deportes,empresas,politica,economia,sociedad,tecnologia");
		echo '<meta name="keywords" content="posteamos,noticias,diarios,argentina,deportes,empresas,politica,economia,sociedad,tecnologia,twitter,medios,blogs,ultimas noticias" />';
	}else {
		echo $this->Html->meta('keywords', $meta['keywords']);
	}
?>
<!-- <meta itemprop="name" content="Posteamos.com">
<meta itemprop="description" content="Un sitio de noticias interactivo y participativo">
<meta itemprop="image" content="http://www.posteamos.com/img/logofooter.jpg" /> -->

<script type="text/javascript">
/* Modernizr 2.5.3 (Custom Build) | MIT & BSD
 * Build: http://www.modernizr.com/download/#-fontface-backgroundsize-borderradius-boxshadow-flexbox-multiplebgs-opacity-textshadow-cssanimations-csscolumns-generatedcontent-cssgradients-cssreflections-csstransforms-csstransforms3d-csstransitions-geolocation-shiv-cssclasses-teststyles-testprop-testallprops-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function A(a){j.cssText=a}function B(a,b){return A(n.join(a+";")+(b||""))}function C(a,b){return typeof a===b}function D(a,b){return!!~(""+a).indexOf(b)}function E(a,b){for(var d in a)if(j[a[d]]!==c)return b=="pfx"?a[d]:!0;return!1}function F(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:C(f,"function")?f.bind(d||b):f}return!1}function G(a,b,c){var d=a.charAt(0).toUpperCase()+a.substr(1),e=(a+" "+p.join(d+" ")+d).split(" ");return C(b,"string")||C(b,"undefined")?E(e,b):(e=(a+" "+q.join(d+" ")+d).split(" "),F(e,b,c))}var d="2.5.3",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l=":)",m={}.toString,n=" -webkit- -moz- -o- -ms- ".split(" "),o="Webkit Moz O ms",p=o.split(" "),q=o.toLowerCase().split(" "),r={},s={},t={},u=[],v=u.slice,w,x=function(a,c,d,e){var f,i,j,k=b.createElement("div"),l=b.body,m=l?l:b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),k.appendChild(j);return f=["&#173;","<style>",a,"</style>"].join(""),k.id=h,m.innerHTML+=f,m.appendChild(k),l||(m.style.background="",g.appendChild(m)),i=c(k,a),l?k.parentNode.removeChild(k):m.parentNode.removeChild(m),!!i},y={}.hasOwnProperty,z;!C(y,"undefined")&&!C(y.call,"undefined")?z=function(a,b){return y.call(a,b)}:z=function(a,b){return b in a&&C(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=v.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(v.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(v.call(arguments)))};return e});var H=function(a,c){var d=a.join(""),f=c.length;x(d,function(a,c){var d=b.styleSheets[b.styleSheets.length-1],g=d?d.cssRules&&d.cssRules[0]?d.cssRules[0].cssText:d.cssText||"":"",h=a.childNodes,i={};while(f--)i[h[f].id]=h[f];e.csstransforms3d=(i.csstransforms3d&&i.csstransforms3d.offsetLeft)===9&&i.csstransforms3d.offsetHeight===3,e.generatedcontent=(i.generatedcontent&&i.generatedcontent.offsetHeight)>=1,e.fontface=/src/i.test(g)&&g.indexOf(c.split(" ")[0])===0},f,c)}(['@font-face {font-family:"font";src:url("https://")}',["@media (",n.join("transform-3d),("),h,")","{#csstransforms3d{left:9px;position:absolute;height:3px;}}"].join(""),['#generatedcontent:after{content:"',l,'";visibility:hidden}'].join("")],["fontface","csstransforms3d","generatedcontent"]);r.flexbox=function(){return G("flexOrder")},r.geolocation=function(){return!!navigator.geolocation},r.multiplebgs=function(){return A("background:url(https://),url(https://),red url(https://)"),/(url\s*\(.*?){3}/.test(j.background)},r.backgroundsize=function(){return G("backgroundSize")},r.borderradius=function(){return G("borderRadius")},r.boxshadow=function(){return G("boxShadow")},r.textshadow=function(){return b.createElement("div").style.textShadow===""},r.opacity=function(){return B("opacity:.55"),/^0.55$/.test(j.opacity)},r.cssanimations=function(){return G("animationName")},r.csscolumns=function(){return G("columnCount")},r.cssgradients=function(){var a="background-image:",b="gradient(linear,left top,right bottom,from(#9f9),to(white));",c="linear-gradient(left top,#9f9, white);";return A((a+"-webkit- ".split(" ").join(b+a)+n.join(c+a)).slice(0,-a.length)),D(j.backgroundImage,"gradient")},r.cssreflections=function(){return G("boxReflect")},r.csstransforms=function(){return!!G("transform")},r.csstransforms3d=function(){var a=!!G("perspective");return a&&"webkitPerspective"in g.style&&(a=e.csstransforms3d),a},r.csstransitions=function(){return G("transition")},r.fontface=function(){return e.fontface},r.generatedcontent=function(){return e.generatedcontent};for(var I in r)z(r,I)&&(w=I.toLowerCase(),e[w]=r[I](),u.push((e[w]?"":"no-")+w));return A(""),i=k=null,function(a,b){function g(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function h(){var a=k.elements;return typeof a=="string"?a.split(" "):a}function i(a){var b={},c=a.createElement,e=a.createDocumentFragment,f=e();a.createElement=function(a){var e=(b[a]||(b[a]=c(a))).cloneNode();return k.shivMethods&&e.canHaveChildren&&!d.test(a)?f.appendChild(e):e},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+h().join().replace(/\w+/g,function(a){return b[a]=c(a),f.createElement(a),'c("'+a+'")'})+");return n}")(k,f)}function j(a){var b;return a.documentShived?a:(k.shivCSS&&!e&&(b=!!g(a,"article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}audio{display:none}canvas,video{display:inline-block;*display:inline;*zoom:1}[hidden]{display:none}audio[controls]{display:inline-block;*display:inline;*zoom:1}mark{background:#FF0;color:#000}")),f||(b=!i(a)),b&&(a.documentShived=b),a)}var c=a.html5||{},d=/^<|^(?:button|form|map|select|textarea)$/i,e,f;(function(){var a=b.createElement("a");a.innerHTML="<xyz></xyz>",e="hidden"in a,f=a.childNodes.length==1||function(){try{b.createElement("a")}catch(a){return!0}var c=b.createDocumentFragment();return typeof c.cloneNode=="undefined"||typeof c.createDocumentFragment=="undefined"||typeof c.createElement=="undefined"}()})();var k={elements:c.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:c.shivCSS!==!1,shivMethods:c.shivMethods!==!1,type:"default",shivDocument:j};a.html5=k,j(b)}(this,b),e._version=d,e._prefixes=n,e._domPrefixes=q,e._cssomPrefixes=p,e.testProp=function(a){return E([a])},e.testAllProps=G,e.testStyles=x,g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+u.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return o.call(a)=="[object Function]"}function e(a){return typeof a=="string"}function f(){}function g(a){return!a||a=="loaded"||a=="complete"||a=="uninitialized"}function h(){var a=p.shift();q=1,a?a.t?m(function(){(a.t=="c"?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){a!="img"&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l={},o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};y[c]===1&&(r=1,y[c]=[],l=b.createElement(a)),a=="object"?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),a!="img"&&(r||y[c]===2?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i(b=="c"?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),p.length==1&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&o.call(a.opera)=="[object Opera]",l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return o.call(a)=="[object Array]"},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,i){var j=b(a),l=j.autoCallback;j.url.split(".").pop().split("?").shift(),j.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]||h),j.instead?j.instead(a,e,f,g,i):(y[j.url]?j.noexec=!0:y[j.url]=1,f.load(j.url,j.forceCSS||!j.forceJS&&"css"==j.url.split(".").pop().split("?").shift()?"c":c,j.noexec,j.attrs,j.timeout),(d(e)||d(l))&&f.load(function(){k(),e&&e(j.origUrl,i,g),l&&l(j.origUrl,i,g),y[j.url]=2})))}function i(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var j,l,m=this.yepnope.loader;if(e(a))g(a,0,m,0);else if(w(a))for(j=0;j<a.length;j++)l=a[j],e(l)?g(l,0,m,0):w(l)?B(l):Object(l)===l&&i(l,m);else Object(a)===a&&i(a,m)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,b.readyState==null&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};
</script>

</head>

<body>
<?php echo $this->Facebook->init();?>
<div class="header" id="header">
	<?php echo $html->link($html->image("logo_posteamos.png", array('alt'=>"Posteamos.com", 'id'=>"logo")),"/", array('escape'=>false))?>

	<?php
		$search = $form->create('News', array('id'=>"topSearch", 'type'=>"post", 'url'=>array('controller'=>"news", 'action'=>"search")));
		$search .= $form->input('pattern', array('label'=>"",'size'=>25,'maxlength'=>150,'class'=>"search"));
		$search .= $form->submit('Buscar >', array('class'=>"submit"));
		$search .= $form->end();
		echo $this->Html->div('searchbox', $search, array('id'=>"searchContainer"));
	?>
	<div id="searchPopup" onmouseover="shake(this);" sytle="display:none;">
		<div id="popupContent">Probá los resultados de búsqueda y compará los distintos criterios editoriales sobre un tema!</div>
	</div>
	<?php echo $this->element('menu/generalMenu', array('city'=>$city/*, 'cache'=>'10 minutes'*/))?>

</div>

<?php 
	/*$js->get('#searchPopup');
	$show = $this->Js->effect('slideIn', array('speed'=>"slow"));
	$hide = "function hide(){".$this->Js->effect('slideOut', array('speed'=>"slow"))."}";
	$hide .= "setTimeout(hide, 9000);";
	$js->buffer($show.$hide);*/
?>
<script>
function SDEffect(element){
	window.element = element;
	setTimeout("element.show()",3000);
	new Effect.SlideDown(element, {duration:4,delay:0});
	new Effect.SlideUp(element, {duration:5,delay:17});
}
function shake(element){
	new Effect.Shake(element);
}
document.observe("dom:loaded", function (event) {SDEffect($("searchPopup"));});
</script>
	<div id="user">
		<?php echo $this->element('users/loggedin', array('user'=>$user))?>
	</div>
	<div id="snetworks">
		<div>
			<!-- Place this tag where you want the +1 button to render. -->
			<div class="g-plusone" data-size="medium" data-href="http://www.posteamos.com/"></div>
			
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
			  window.___gcfg = {lang: 'es-419'};
			
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</div>
	
		<div>
			<div class="fb-like" data-href="http://www.posteamos.com" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false" data-font="segoe ui"></div>
		</div>
		<div>
			<a href="https://twitter.com/posteamos" class="twitter-follow-button" data-show-count="false" data-lang="es" data-show-screen-name="false">Seguir a @posteamos</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
	</div>
<div id="container">
	<?php //echo $this->Session->flash(); ?>
	<?php echo $this->Session->flash('email'); ?>



	<?php echo $content_for_layout; ?>

    <div id="divider"></div>
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
  _gaq.push(['_setDomainName', 'posteamos.com']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_trackPageLoadTime']);

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
<a href="http://www.posteamos.com/sitemap.xml" style="display: none"> </a>
</body>
</html>
