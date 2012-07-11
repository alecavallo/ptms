<?php
/* Location Fixture generated on: 2010-06-25 16:06:46 : 1277492566 */
class LocationFixture extends CakeTestFixture {
	var $name = 'Location';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'city' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'country_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 5),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'exists' => array('type' => 'binary', 'null' => false, 'default' => '0', 'length' => 1),
		'cities_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'countries_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_locations_cities1' => array('column' => 'cities_id', 'unique' => 0), 'fk_locations_countries1' => array('column' => 'countries_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'ip' => 'Lorem ipsum dolor ',
			'city' => 'Lorem ipsum dolor sit amet',
			'country_code' => 'Lor',
			'latitude' => 1,
			'longitude' => 1,
			'exists' => 'Lorem ipsum dolor sit ame',
			'cities_id' => 1,
			'countries_id' => 1
		),
	);
}
?>