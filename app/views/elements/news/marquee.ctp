<?php 
	echo $this->Html->script('Marquee');
	if (!isset($shown)) {
		$shown = array(0);
	}
?>
<div id="marqueeContainer">
	<div id="marquee" style="float: left;"></div><div style="float:right;"><span id="prev">&lt;</span> <span id="next">&gt;</span> </div>
</div>
<script type="text/javascript">
<!--
var page = 1;

var m = new Marquee();

function getNews(){

	var t = new Template('<a href="#{url}" target="_blank" onclick="new Ajax.Request(\'/visits/incrementaContador/#{newsId}\');"> <span style="font-weight: bold">#{author} - </span><span style="font-style: italic;">#{category} -- </span><span>#{msg}</span></a>');
	new Ajax.Request('/news/marquee/0/'+page,
	  {
	    method:'post',
	    parameters: {excludedNews : '<?php echo serialize($shown)?>', page: 1, category: '<?php echo empty($categoryId)?'':serialize($categoryId) ?>'}, 
	    onSuccess: function(transport){
	      var news = transport.responseText.evalJSON() || "";
	      var data = [];
	      $A(news).each(function(q, i){
		      //alert(q.News.title);
	    	  data.push({text: t.evaluate({msg:q.News.title, author:q.Feed.Source.name, category:q.Category.name, url:q.News.link, newsId:q.News.id})});
	    	  //alert('salió!!');
	      });
	      m.load(data, jQuery('#marquee'));
	      jQuery('#prev').click(function(){
	      	m.prev();
	      });
	      jQuery('#next').click(function(){
	      	m.next();
	      });
	      page++;
	    },
	    onFailure: function(){ alert('No se han podido cargar las noticias, por favor intente nuevamente mas tarde'); }
	  });
}

document.observe("dom:loaded", function (event) {
	getNews();
});

//-->
</script>