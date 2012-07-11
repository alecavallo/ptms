<?php
/* Ads Test cases generated on: 2010-06-20 17:06:51 : 1277065251*/
App::import('Controller', 'Ads');

class TestAdsController extends AdsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AdsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.ad', 'app.category', 'app.categories_ad');

	function startTest() {
		$this->Ads =& new TestAdsController();
		$this->Ads->constructClasses();
	}

	function endTest() {
		unset($this->Ads);
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