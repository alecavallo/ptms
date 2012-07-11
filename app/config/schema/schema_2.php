<?php 
/* SVN FILE: $Id$ */
/* App schema generated on: 2010-08-17 22:08:16 : 1282096696*/
class AppSchema extends CakeSchema {
	var $name = 'App';

	var $file = 'schema_2.php';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $ads = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'url' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	var $categories_ads = array(
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'ad_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => array('category_id', 'ad_id'), 'unique' => 1), 'fk_categories_has_ads_categories1' => array('column' => 'category_id', 'unique' => 0), 'fk_categories_has_ads_ads1' => array('column' => 'ad_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $cities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_city_states1' => array('column' => 'state_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $comments = array(
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
	var $countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45, 'key' => 'unique'),
		'code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 5),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name_idx' => array('column' => 'name', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $feeds = array(
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
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_feeds_sources1' => array('column' => 'source_id', 'unique' => 0), 'fk_feeds_categories1' => array('column' => 'category_id', 'unique' => 0), 'fk_feeds_cities1' => array('column' => 'city_id', 'unique' => 0), 'fk_feeds_states1' => array('column' => 'state_id', 'unique' => 0), 'enabled' => array('column' => 'enabled', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $images = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'url' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'news_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_images_news1' => array('column' => 'news_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $last_posts = array(
		'last_read' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12),
		'last_inserted' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 12),
		'type' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'type', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MEMORY')
	);
	var $layouts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'parameters' => array('type' => 'binary', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $locations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'city' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'country_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 5),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'exists' => array('type' => 'binary', 'null' => false, 'default' => '0', 'length' => 1),
		'city_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_locations_cities1' => array('column' => 'city_id', 'unique' => 0), 'fk_locations_countries1' => array('column' => 'country_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $news = array(
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
		'hasImages' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_news_users1' => array('column' => 'user_id', 'unique' => 0), 'fk_news_cities1' => array('column' => 'city_id', 'unique' => 0), 'fk_news_states1' => array('column' => 'state_id', 'unique' => 0), 'fk_news_feeds1' => array('column' => 'feed_id', 'unique' => 0), 'fk_news_news1' => array('column' => 'related_news_id', 'unique' => 0), 'content_idx' => array('column' => array('title', 'summary', 'body'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'MyISAM')
	);
	var $news_categories = array(
		'news_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => array('news_id', 'category_id'), 'unique' => 1), 'fk_news_has_categories_news1' => array('column' => 'news_id', 'unique' => 0), 'fk_news_has_categories_categories1' => array('column' => 'category_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $preferred_layouts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'cookie_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'key' => 'unique'),
		'parameters' => array('type' => 'binary', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'layout_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'cookie_idx' => array('column' => 'cookie_id', 'unique' => 1), 'fk_preferred_layouts_users1' => array('column' => 'user_id', 'unique' => 0), 'fk_preferred_layouts_layouts1' => array('column' => 'layout_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $sources = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'url' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_sources_countires1' => array('column' => 'country_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name_idx' => array('column' => array('country_id', 'name'), 'unique' => 1), 'fk_states_countires1' => array('column' => 'country_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
	var $users = array(
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
}
?>