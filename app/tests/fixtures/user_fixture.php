<?php
/* User Fixture generated on: 2010-06-19 16:06:17 : 1276974617 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'alias' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'last_signup' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 6),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_users_cities1' => array('column' => 'city_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'first_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor sit amet',
			'created' => '2010-06-19 16:10:17',
			'last_signup' => '2010-06-19 16:10:17',
			'rating' => 1,
			'city_id' => 1
		),
	);
}
?>