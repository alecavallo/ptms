<?php
class Category extends AppModel {
	var $name = 'Category';
	var $displayField = 'name';
	var $cacheQueries = true;
	var $actsAs = array('Tree');
	var $validate = array(

		'name' => array(
			/*'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'Debe introducir solo texto',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),*/
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

	var $hasMany = array(
		'Feed' => array(
			'className' => 'Feed',
			'foreignKey' => 'category_id',
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
		'ProposedCategory' => array(
			'className' => 'ProposedCategory',
			'foreignKey' => 'category_id',
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
		'News' => array(
			'className' => 'News',
			'foreignKey' => 'category_id',
			'dependent' => true,
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


	var $hasAndBelongsToMany = array(
		'Ad' => array(
			'className' => 'Ad',
			'joinTable' => 'categories_ads',
			'foreignKey' => 'category_id',
			'associationForeignKey' => 'ad_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
	);

	function getTree($id=null, $childrens=false){
		$this->recursive=-1;
		/*if ($this->verify() !== true) {
			$this->recover('parent');
		}*/
		$parameters = array(

		);
		Cache::config('short', array(
			'engine' => 'File',
			'duration'=> '+5 minutes',
			'probability'=> 100,
			'path' => CACHE . 'short' . DS,
		));
		$cates = $this->find('threaded', array('cache' => 'menuList', 'cacheConfig' => 'short'));
		return $cates;

	}

	function updateProposed($newsId, $categoryId){
		$dataSource = $this->getDataSource();

		$dataSource->begin($this);
		$this->News->id = $newsId;
		$ok = $this->News->saveField('category_id', $categoryId);
		$this->News->recursive=-1;
		$ok = $ok && $this->ProposedCategory->deleteAll(array('news_id'=>$newsId));
		if($ok) {
			$dataSource->commit($this);
		}else {
			$dataSource->rollback($this);
		}
	}

}
?>