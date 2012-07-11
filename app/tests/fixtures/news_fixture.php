<?php
/* News Fixture generated on: 2010-06-19 16:06:17 : 1276974197 */
class NewsFixture extends CakeTestFixture {
	var $name = 'News';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'summary' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'body' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'rating' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 6),
		'visits' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'votes' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'city_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'repeated_url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'feed_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'related_news_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'media_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'media_url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'media_title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'media_width' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'media_height' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'media_link' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'media_description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'link' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_news_users1' => array('column' => 'user_id', 'unique' => 0), 'fk_news_cities1' => array('column' => 'city_id', 'unique' => 0), 'fk_news_states1' => array('column' => 'state_id', 'unique' => 0), 'fk_news_feeds1' => array('column' => 'feed_id', 'unique' => 0), 'fk_news_news1' => array('column' => 'related_news_id', 'unique' => 0), 'content_idx' => array('column' => array('title', 'summary', 'body'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'title' => 'Lorem ipsum dolor sit amet',
			'summary' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'rating' => 1,
			'visits' => 1,
			'votes' => 1,
			'created' => '2010-06-19 16:03:17',
			'modified' => '2010-06-19 16:03:17',
			'user_id' => 1,
			'city_id' => 1,
			'state_id' => 1,
			'repeated_url' => 'Lorem ipsum dolor sit amet',
			'feed_id' => 1,
			'related_news_id' => 1,
			'media_type' => 'Lorem ipsum dolor sit amet',
			'media_url' => 'Lorem ipsum dolor sit amet',
			'media_title' => 'Lorem ipsum dolor sit amet',
			'media_width' => 1,
			'media_height' => 1,
			'media_link' => 'Lorem ipsum dolor sit amet',
			'media_description' => 'Lorem ipsum dolor sit amet',
			'link' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>