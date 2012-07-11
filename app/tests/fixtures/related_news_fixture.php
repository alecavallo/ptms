<?php
/* RelatedNews Fixture generated on: 2010-08-16 17:08:26 : 1281990866 */
class RelatedNewsFixture extends CakeTestFixture {
	var $name = 'RelatedNews';

	var $fields = array(
		'news_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'related_new_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'unq_related_news' => array('column' => array('related_new_id', 'news_id'), 'unique' => 1), 'fk_news_has_news_news1' => array('column' => 'news_id', 'unique' => 0), 'fk_news_has_news_news2' => array('column' => 'related_new_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'news_id' => 1,
			'related_new_id' => 1,
			'id' => 1
		),
	);
}
?>