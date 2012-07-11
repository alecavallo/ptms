<?php
/* Feeds Test cases generated on: 2010-06-20 17:06:55 : 1277066815*/
App::import('Controller', 'Feeds');

class TestFeedsController extends FeedsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class FeedsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.feed', 'app.source', 'app.country', 'app.state', 'app.category', 'app.city', 'app.news', 'app.user', 'app.preferred_layout', 'app.comment', 'app.ads', 'app.new', 'app.media', 'app.visit', 'app.news_category');

	function startTest() {
		$this->Feeds =& new TestFeedsController();
		$this->Feeds->constructClasses();
	}

	function endTest() {
		unset($this->Feeds);
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