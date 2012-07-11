<?php
/* Users Test cases generated on: 2010-12-30 09:12:55 : 1293709555*/
App::import('Controller', 'Users');

class TestUsersController extends UsersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UsersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.city', 'app.state', 'app.country', 'app.source', 'app.feed', 'app.category', 'app.ad', 'app.categories_ad', 'app.news', 'app.related_news', 'app.comment', 'app.ads', 'app.medias', 'app.visit', 'app.news_category', 'app.preferred_layout', 'app.location');

	function startTest() {
		$this->Users =& new TestUsersController();
		$this->Users->constructClasses();
	}

	function endTest() {
		unset($this->Users);
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