<?php
/* RelatedNews Test cases generated on: 2010-08-16 17:08:28 : 1281990868*/
App::import('Model', 'RelatedNews');

class RelatedNewsTestCase extends CakeTestCase {
	var $fixtures = array('app.related_news', 'app.news', 'app.user', 'app.city', 'app.state', 'app.country', 'app.source', 'app.feed', 'app.category', 'app.ad', 'app.categories_ad', 'app.news_category', 'app.preferred_layout', 'app.comment', 'app.ads', 'app.new', 'app.media', 'app.visit');

	function startTest() {
		$this->RelatedNews =& ClassRegistry::init('RelatedNews');
	}

	function endTest() {
		unset($this->RelatedNews);
		ClassRegistry::flush();
	}

}
?>