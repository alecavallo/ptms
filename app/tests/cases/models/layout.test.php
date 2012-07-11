<?php
/* Layout Test cases generated on: 2010-06-19 15:06:06 : 1276973946*/
App::import('Model', 'Layout');

class LayoutTestCase extends CakeTestCase {
	var $fixtures = array('app.layout', 'app.user', 'app.preferred_layout');

	function startTest() {
		$this->Layout =& ClassRegistry::init('Layout');
	}

	function endTest() {
		unset($this->Layout);
		ClassRegistry::flush();
	}

}
?>