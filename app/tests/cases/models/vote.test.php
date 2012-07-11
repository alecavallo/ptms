<?php
/* Vote Test cases generated on: 2011-01-25 21:01:20 : 1295998580*/
App::import('Model', 'Vote');

class VoteTestCase extends CakeTestCase {
	var $fixtures = array('app.vote', 'app.user', 'app.city', 'app.state', 'app.country', 'app.source', 'app.feed', 'app.category', 'app.ad', 'app.categories_ad', 'app.news', 'app.related_news', 'app.comment', 'app.ads', 'app.medias', 'app.visit', 'app.news_category', 'app.preferred_layout');

	function startTest() {
		$this->Vote =& ClassRegistry::init('Vote');
	}

	function endTest() {
		unset($this->Vote);
		ClassRegistry::flush();
	}

}
?>