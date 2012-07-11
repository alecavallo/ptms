<?php
/* City Test cases generated on: 2010-06-19 15:06:20 : 1276972940*/
App::import('Model', 'City');

class CityTestCase extends CakeTestCase {
	var $fixtures = array('app.city', 'app.state', 'app.feed', 'app.news', 'app.user');

	function startTest() {
		$this->City =& ClassRegistry::init('City');
	}

	function endTest() {
		unset($this->City);
		ClassRegistry::flush();
	}

}
?>