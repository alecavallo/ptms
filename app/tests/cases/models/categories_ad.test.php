<?php
/* CategoriesAd Test cases generated on: 2010-06-19 15:06:41 : 1276972661*/
App::import('Model', 'CategoriesAd');

class CategoriesAdTestCase extends CakeTestCase {
	var $fixtures = array('app.categories_ad', 'app.category', 'app.ads');

	function startTest() {
		$this->CategoriesAd =& ClassRegistry::init('CategoriesAd');
	}

	function endTest() {
		unset($this->CategoriesAd);
		ClassRegistry::flush();
	}

}
?>