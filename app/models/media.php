<?php
class media extends AppModel {
	var $name = 'Medias';
	var $displayField = 'url';
	var $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'La url no es válida',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			
		),
		'news_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'News' => array(
			'className' => 'News',
			'foreignKey' => 'news_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'type'	=>	'INNER'
		)
	);

	function imgListing($category_id=0, $count=100, $pag=1){
		if ($category_id==0) {
			$category_condition="";
		}else {
			$category_id = Sanitize::clean($category_id);
			$category_condition = "and news.category_id={$category_id}";
		}
		if ($count!=0) {
			
		$sql=<<<QRY
select distinct News.id, News.title, Media.url, Source.name from medias as Media
inner join news as News on News.id=Media.news_id
inner join feeds as Feed on Feed.id=News.feed_id
inner join sources as Source on Source.id=Feed.source_id
where News.created >= DATE_SUB(CURDATE(), INTERVAL 3 DAY) and Media.type=1 {$category_condition} and (Media.url like "%.jpg" or Media.url like "%.png" or Media.url like "%.gif" or Media.url like "%.jpeg")
order by News.rating desc, News.created desc, rand()
limit 1,120;
QRY;
		}
		
		return $this->query($sql);
	}
}
?>