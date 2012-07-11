<?php
/* Vote Fixture generated on: 2011-01-25 21:01:20 : 1295998580 */
class VoteFixture extends CakeTestFixture {
	var $name = 'Vote';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'news_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_votes_users1' => array('column' => 'user_id', 'unique' => 0), 'fk_votes_news1' => array('column' => 'news_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'news_id' => 1
		),
	);
}
?>