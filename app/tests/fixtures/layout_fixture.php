<?php
/* Layout Fixture generated on: 2010-06-19 15:06:06 : 1276973946 */
class LayoutFixture extends CakeTestFixture {
	var $name = 'Layout';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'parameters' => array('type' => 'binary', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'parameters' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>