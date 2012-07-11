<?php
/* UserRequest Test cases generated on: 2011-02-16 16:02:42 : 1297881522*/
App::import('Model', 'UserRequest');

class UserRequestTestCase extends CakeTestCase {
	var $fixtures = array('app.user_request');

	function startTest() {
		$this->UserRequest =& ClassRegistry::init('UserRequest');
	}

	function endTest() {
		unset($this->UserRequest);
		ClassRegistry::flush();
	}

}
?>