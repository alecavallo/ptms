<?php
/* Category Test cases generated on: 2010-06-20 17:06:18 : 1277067138*/
App::import('Model', 'Category');

class CategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.category', 'app.feed', 'app.source', 'app.country', 'app.state', 'app.city', 'app.news', 'app.user', 'app.preferred_layout', 'app.comment', 'app.ads', 'app.new', 'app.media', 'app.visit', 'app.news_category', 'app.ad', 'app.categories_ad');

	function startTest() {
		$this->Category =& ClassRegistry::init('Category');
	}

	function endTest() {
		unset($this->Category);
		ClassRegistry::flush();
	}

}
?>