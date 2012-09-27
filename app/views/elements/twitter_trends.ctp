<div id="twtr_tr_container" style="float:left; width: 100%;">
<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script type="text/javascript">
//IMPORTANTE PONER UN LÍMITE DE TAMAÑO A LA PANTALLA (MIN-WIDTH)
var glbTCount = 0;
var tI = -1;
var glbTwitter;
var tWidget = new TWTR.Widget({
	  version: 2,
	  type: 'search',
	  search: "@posteamos",
	  interval: 30000,
	  title: "Temas del momento",
	  subject: '',
	  width: 261,
	  height: 218,
	  theme: {
	    shell: {
	      background: '#838281',
	      color: '#ffffff'
	    },
	    tweets: {
	      background: '#ffffff',
	      color: '#444444',
	      links: '#8ac33f'
	    }
	  },
	  features: {
	    scrollbar: false,
	    loop: true,
	    live: true,
	    hashtags: true,
	    timestamp: false,
	    avatars: true,
	    toptweets: true,
	    behavior: 'default'
	  }
	});

function parseTrends(twitterTrends){

	if(twitterTrends && tI == -1){
		glbTwitter = twitterTrends[0];
		glbTCount = glbTwitter.trends.length;
		tWidget.footerText = "";
	}
	if(tI < glbTCount-1){
		tI ++;
	}else{
		tI = 0;
	}

	renderWidget(glbTwitter.trends[tI].name, glbTwitter.trends[tI].name);

	window.setTimeout(parseTrends, 300000);
}

function renderWidget(search, title){
	tWidget.stop();
	tWidget.clear();
	tWidget.setSearch(search);
	tWidget.subject = title;
	tWidget.render().start();
}
</script>

<?php
	$woeid = 23424747;
	echo $this->Html->script("http://api.twitter.com/1/trends/{$woeid}.json?alt=json-in-script&amp;callback=parseTrends");
?>
</div>