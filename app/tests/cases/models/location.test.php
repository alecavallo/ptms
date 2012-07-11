<?php
/* Location Test cases generated on: 2010-06-25 16:06:46 : 1277492566*/
App::import('Model', 'Location');

class LocationTestCase extends CakeTestCase {
	var $fixtures = array('app.location', 'app.cities', 'app.countries');

	function startTest() {
		$this->Location =& ClassRegistry::init('Location');
	}

	function endTest() {
		unset($this->Location);
		ClassRegistry::flush();
	}

}
?>