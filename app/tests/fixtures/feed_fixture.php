<?php
/* Feed Fixture generated on: 2010-06-19 15:06:18 : 1276973718 */
class FeedFixture extends CakeTestFixture {
	var $name = 'Feed';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'url' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'source_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'city_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'last_processing_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'image_url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'image_title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'image_link' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'image_width' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'image_height' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'copyright' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'ttl' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'rating' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'language' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10),
		'webmaster' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'editor' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_feeds_sources1' => array('column' => 'source_id', 'unique' => 0), 'fk_feeds_categories1' => array('column' => 'category_id', 'unique' => 0), 'fk_feeds_cities1' => array('column' => 'city_id', 'unique' => 0), 'fk_feeds_states1' => array('column' => 'state_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'url' => 'Lorem ipsum dolor sit amet',
			'source_id' => 1,
			'category_id' => 1,
			'city_id' => 1,
			'state_id' => 1,
			'last_processing_date' => '2010-06-19 15:55:18',
			'image_url' => 'Lorem ipsum dolor sit amet',
			'image_title' => 'Lorem ipsum dolor sit amet',
			'image_link' => 'Lorem ipsum dolor sit amet',
			'image_width' => 1,
			'image_height' => 1,
			'copyright' => 'Lorem ipsum dolor sit amet',
			'ttl' => 1,
			'rating' => 1,
			'language' => 'Lorem ip',
			'webmaster' => 'Lorem ipsum dolor sit amet',
			'editor' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>