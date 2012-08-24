<?php
class News extends AppModel {
	var $name = 'News';
	var $actsAs = array('Containable');
	var $displayField = 'title';
	var $cacheQueries = true;
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
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El título no puede estar vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'summary' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El copete no puede estar vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El cuerpo de la noticia no puede estar vacío',
				'allowEmpty' => false,
				'required' => true,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rating' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'visits' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'votes' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modified' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Debe elegir una categoría',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'state_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'repeated_url' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'feed_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'related_news_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'media_type' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'media_url' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'media_title' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'media_description' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'link' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Feed' => array(
			'className' => 'Feed',
			'type'		=>	'INNER',
			'foreignKey' => 'feed_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RelatedNews' => array(
			'className' => 'RelatedNews',
			'foreignKey' => 'related_news_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'type'		=>	'INNER',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'news_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Media' => array(
			'className' => 'Media',
			'foreignKey' => 'news_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Visit' => array(
			'className' => 'Visit',
			'foreignKey' => 'news_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/*var $hasAndBelongsToMany = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'news_categories',
			'foreignKey' => 'news_id',
			'associationForeignKey' => 'category_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);*/
	
	function getUsersNews($hours=12, $limit=8, $page=0){
		$sql = <<<QRY
select News.id, News.title, News.summary, News.created, News.link, Category.id, Category.name, coalesce(User.id,Ruser.id) as User_id, coalesce(User.first_name,Ruser.first_name) as first_name, coalesce(User.last_name,Ruser.last_name) as last_name, coalesce(User.alias,User.posteamos_alias,Ruser.alias,Ruser.posteamos_alias) as alias, coalesce(User.avatar,Ruser.avatar) as avatar
from news News
left join feeds Feed on Feed.id=News.feed_id
left join sources Source on Source.id=Feed.source_id
inner join categories Category on Category.id=News.category_id
left join users User on User.id = News.user_id
left join users Ruser on Ruser.sources_id = Source.id
where
News.rating <= 30 AND News.created >= DATE_SUB(CURDATE(), INTERVAL {$hours} HOUR) AND (Feed.content_type=2 or Feed.content_type is null) and (User.id is not null or Ruser.id is not null)
order by User.registered desc, News.created desc, rand()
limit {$page},{$limit};
QRY;
	$result = $this->query($sql);
	
	return $result;
	}
	
	function usersNew($id, $page=0, $limit=10){
		$sql = <<<QRY
select News.id, News.title, News.summary, News.created, News.link, Category.id, Category.name, coalesce(User.id,Ruser.id) as User_id, coalesce(User.first_name,Ruser.first_name) as first_name, coalesce(User.last_name,Ruser.last_name) as last_name, coalesce(User.alias,User.posteamos_alias,Ruser.alias,Ruser.posteamos_alias) as alias, coalesce(User.avatar,Ruser.avatar) as avatar
from news News
left join feeds Feed on Feed.id=News.feed_id
left join sources Source on Source.id=Feed.source_id
inner join categories Category on Category.id=News.category_id
left join users User on User.id = News.user_id
left join users Ruser on Ruser.sources_id = Source.id
where
User.id = {$id} or Ruser.id = {$id}
order by User.registered desc, News.created desc, rand()
limit {$page},{$limit};
QRY;
	$result = $this->query($sql);
	
	return $result;
	}

	function getHomeNews($feedCount=1, $categoryCount=2){
		$sql = <<<QRY
select Source.id, Source.icon, Source.name, News.id,News.title,News.summary,News.link,News.rating,News.created,News.rating,News.votes,News.visits,Category.id,Category.name,User.first_name,User.last_name,User.alias,User.posteamos_alias,User.avatar
from 
	(select news.*,
	@num := if(@group = feed_id, @num + 1, 1) as row_number,
	@group := feed_id as dummy,
	@num2 := if(@group2 = user_id, @num2 + 1, 1) as usr_number,
	@group2 := user_id as dummy2
	from news
	where news.created >= DATE_SUB(CURDATE(), INTERVAL 12 HOUR) and rating > 1
	order by news.feed_id, news.user_id, news.rating desc, news.votes desc, news.visits desc) as News
left join feeds Feed on News.feed_id=Feed.id
left join sources Source on Source.id=Feed.source_id
left join categories Category on News.category_id=Category.id
left join users User on User.id=News.user_id
where (News.row_number <={$feedCount} and dummy is not null and Feed.content_type=1) or (News.usr_number <={$feedCount} and dummy2 is not null)
order by News.rating desc, News.votes desc, News.visits desc, News.created desc, Feed.rating desc;
QRY;

		$raw = $this->query($sql);
		 
		$result = array();
		$shownSources = array();
		$shownCategories = array();
		foreach ($raw as $value) {
			if (!in_array($value['Source']['id'], $shownSources)) {
				$cateCount = array_count_values($shownCategories);
				if(array_key_exists($value['Category']['id'], $cateCount)){
					if ($cateCount[$value['Category']['id']]<$categoryCount) {
						$shownCategories[] = $value['Category']['id'];
					}else {
						continue;
					}
				}else {
					$shownCategories[] = $value['Category']['id'];
				}
				$shownSources[]=$value['Source']['id'];
				
				
				$news['News']=$value['News'];
				$news['Feed']['Source']=$value['Source'];
				$news['Category']=$value['Category'];
				$news['User']=$value['User'];
				$result[] = $news;
			}
		}
		return $result;
	}
}
?>