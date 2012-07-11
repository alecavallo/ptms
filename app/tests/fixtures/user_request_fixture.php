<?php
/* UserRequest Fixture generated on: 2011-02-16 16:02:42 : 1297881522 */
class UserRequestFixture extends CakeTestFixture {
	var $name = 'UserRequest';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'pending' => array('type' => 'binary', 'null' => false, 'default' => '1', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'email' => 'Lorem ipsum dolor sit amet',
			'pending' => 'Lorem ipsum dolor sit ame'
		),
	);
}
?>