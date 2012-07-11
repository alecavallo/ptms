<?php
/* Locations Test cases generated on: 2010-06-25 16:06:23 : 1277492723*/
App::import('Controller', 'Locations');

class TestLocationsController extends LocationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class LocationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.location', 'app.cities', 'app.countries');

	function startTest() {
		$this->Locations =& new TestLocationsController();
		$this->Locations->constructClasses();
	}

	function endTest() {
		unset($this->Locations);
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