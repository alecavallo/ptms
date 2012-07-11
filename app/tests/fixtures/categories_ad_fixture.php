<?php
/* CategoriesAd Fixture generated on: 2010-06-19 15:06:41 : 1276972661 */
class CategoriesAdFixture extends CakeTestFixture {
	var $name = 'CategoriesAd';

	var $fields = array(
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'ads_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => array('category_id', 'ads_id'), 'unique' => 1), 'fk_categories_has_ads_categories1' => array('column' => 'category_id', 'unique' => 0), 'fk_categories_has_ads_ads1' => array('column' => 'ads_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'category_id' => 1,
			'ads_id' => 1
		),
	);
}
?>