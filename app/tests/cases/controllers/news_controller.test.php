<?php
/* News Test cases generated on: 2010-06-20 17:06:23 : 1277066123*/
App::import('Controller', 'News');

class TestNewsController extends NewsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class NewsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.news', 'app.user', 'app.city', 'app.state', 'app.feed', 'app.source', 'app.country', 'app.category', 'app.preferred_layout', 'app.comment', 'app.ads', 'app.new', 'app.media', 'app.visit', 'app.news_category');

	function startTest() {
		$this->News =& new TestNewsController();
		$this->News->constructClasses();
	}

	function endTest() {
		unset($this->News);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
?>