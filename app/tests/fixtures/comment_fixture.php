<?php
/* Comment Fixture generated on: 2010-06-19 15:06:48 : 1276973208 */
class CommentFixture extends CakeTestFixture {
	var $name = 'Comment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'contain' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500),
		'news_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'votes' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'ads_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_comments_news1' => array('column' => 'news_id', 'unique' => 0), 'fk_comments_users1' => array('column' => 'user_id', 'unique' => 0), 'fk_comments_ads1' => array('column' => 'ads_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'date' => '2010-06-19 15:46:48',
			'contain' => 'Lorem ipsum dolor sit amet',
			'news_id' => 1,
			'user_id' => 1,
			'votes' => 1,
			'ads_id' => 1
		),
	);
}
?>