<?php
/* Cities Test cases generated on: 2011-01-03 19:01:38 : 1294088558*/
App::import('Controller', 'Cities');

class TestCitiesController extends CitiesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CitiesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.city', 'app.state', 'app.country', 'app.source', 'app.feed', 'app.category', 'app.ad', 'app.categories_ad', 'app.news', 'app.user', 'app.preferred_layout', 'app.comment', 'app.ads', 'app.related_news', 'app.medias', 'app.visit', 'app.news_category', 'app.location');

	function startTest() {
		$this->Cities =& new TestCitiesController();
		$this->Cities->constructClasses();
	}

	function endTest() {
		unset($this->Cities);
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