<?php
/* Categories Test cases generated on: 2010-06-20 17:06:27 : 1277067207*/
App::import('Controller', 'Categories');

class TestCategoriesController extends CategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.category', 'app.feed', 'app.source', 'app.country', 'app.state', 'app.city', 'app.news', 'app.user', 'app.preferred_layout', 'app.comment', 'app.ads', 'app.new', 'app.media', 'app.visit', 'app.news_category', 'app.ad', 'app.categories_ad');

	function startTest() {
		$this->Categories =& new TestCategoriesController();
		$this->Categories->constructClasses();
	}

	function endTest() {
		unset($this->Categories);
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