<?php
/* Country Test cases generated on: 2010-06-19 15:06:57 : 1276973457*/
App::import('Model', 'Country');

class CountryTestCase extends CakeTestCase {
	var $fixtures = array('app.country', 'app.source', 'app.state');

	function startTest() {
		$this->Country =& ClassRegistry::init('Country');
	}

	function endTest() {
		unset($this->Country);
		ClassRegistry::flush();
	}

}
?>