<?php
/* Media Test cases generated on: 2010-06-25 15:06:46 : 1277492206*/
App::import('Model', 'Media');

class MediaTestCase extends CakeTestCase {
	var $fixtures = array('app.media', 'app.news', 'app.user', 'app.city', 'app.state', 'app.feed', 'app.source', 'app.country', 'app.category', 'app.ad', 'app.categories_ad', 'app.news_category', 'app.preferred_layout', 'app.comment', 'app.ads', 'app.new', 'app.visit');

	function startTest() {
		$this->Media =& ClassRegistry::init('Media');
	}

	function endTest() {
		unset($this->Media);
		ClassRegistry::flush();
	}

}
?>