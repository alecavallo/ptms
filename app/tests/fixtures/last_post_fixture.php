<?php
/* LastPost Fixture generated on: 2010-07-08 17:07:29 : 1278621389 */
class LastPostFixture extends CakeTestFixture {
	var $name = 'LastPost';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 2, 'key' => 'primary'),
		'last_readed' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12),
		'last_inserted' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MEMORY')
	);

	var $records = array(
		array(
			'id' => 1,
			'last_readed' => 1,
			'last_inserted' => 1
		),
	);
}
?>