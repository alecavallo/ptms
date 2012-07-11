<?php
/* Feed Test cases generated on: 2010-06-19 15:06:18 : 1276973718*/
App::import('Model', 'Feed');

class FeedTestCase extends CakeTestCase {
	var $fixtures = array('app.feed', 'app.source', 'app.category', 'app.city', 'app.state', 'app.news', 'app.user');

	function startTest() {
		$this->Feed =& ClassRegistry::init('Feed');
	}

	function endTest() {
		unset($this->Feed);
		ClassRegistry::flush();
	}

}
?>