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

var m4 = new Marquee({
	element: "marquee",
	life: 5,
	change: function(){
		//$("ex4lst").down("li.active").removeClassName("active");
		//$("ex4lst").down(m4.current).addClassName("active");
	}
});

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
	    	  data.push({message: t.evaluate({msg:q.News.title, author:q.Feed.Source.name, category:q.Category.name, url:q.News.link, newsId:q.News.id})});
	    	  //alert('salió!!');
	      });
	      m4.load(data);
	      page++;
	    },
	    onFailure: function(){ alert('Volver marquesina al principio'); }
	  });
}

document.observe("dom:loaded", function (event) {
	getNews();
	$('prev').observe('click', function(){m4.previous();});
	$('next').observe('click', function(){m4.next();});
});

//-->
</script>