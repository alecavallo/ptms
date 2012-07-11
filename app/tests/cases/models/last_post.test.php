<?php
/* LastPost Test cases generated on: 2010-07-08 17:07:29 : 1278621389*/
App::import('Model', 'LastPost');

class LastPostTestCase extends CakeTestCase {
	var $fixtures = array('app.last_post');

	function startTest() {
		$this->LastPost =& ClassRegistry::init('LastPost');
	}

	function endTest() {
		unset($this->LastPost);
		ClassRegistry::flush();
	}

}
?>