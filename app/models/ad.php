<?php
class Ad extends AppModel {
	var $name = 'Ad';
	var $displayField = 'name';
	var $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El id debe ser un número',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El nombre no puede estar vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'link' => array(
		
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed


	var $hasAndBelongsToMany = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'categories_ads',
			'foreignKey' => 'ad_id',
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
	);


	function validateLink(){
		App::import('Lib', 'Facebook.FB');
		$fbr = FB::api('/sancorsalud/feed');
		$fbi = array();
		foreach ($fbr['data'] as $value) {
			if ($value['type']!='question' && $value['from']['id']==243670349013369) {
				$fbi[]=$value['message'];
			};
		}
	}
	function get($priority, $category=0, $excluded = array(), $limit = 2){
		//creo filtro por categoría si el parametro fue especificado
		if ($category != 0 && is_int($category)) {
			$category = " AND Ad.category = {$category}";
		}else {
			$category = "";
		}
		
		//creo filtro de publicidades ya mostradas si el parametro fue especificado
		if (!empty($excluded) && is_array($excluded)) {
			$excluded = implode(",", $excluded);
			$excluded = " AND id not in ({$excluded})";
		}else {
			$excluded = "";
		}
		if ($priority != 4) {
			$select = <<<TRN
SELECT `Ad`.`id`, `Ad`.`name`, `Ad`.`url`, `Ad`.`link`, `Ad`.`text`, `Ad`.`url_img`, `Ad`.`socialnetwork`
FROM ads Ad
WHERE Ad.enabled = 1 AND (Ad.priority=5 OR Ad.priority={$priority}){$category}{$excluded}
ORDER BY Ad.shows asc
LIMIT {$limit}
FOR UPDATE;
TRN;
		}else {
			$select = <<<TRN
SELECT Ad.id, Ad.name, Ad.url, Ad.link, Ad.text, Ad.url_img, Ad.socialnetwork 
FROM ads Ad
WHERE Ad.enabled = 1 AND Ad.priority=4{$category}{$excluded}
ORDER BY Ad.shows asc
LIMIT {$limit}
FOR UPDATE;
TRN;
		}

$this->query('START TRANSACTION;');
$ads = $this->query($select);
$ids = array();
	foreach ($ads as $row) {
		$ids[]= $row['Ad']['id'];
	}
	$ids = "(".implode(",", $ids).")";
	$update = <<<TRN
UPDATE ads SET shows = shows+1 WHERE ads.id in {$ids}
TRN;
		
		if (empty($ads) || $ads != FALSE) {
			$this->query($update);
			$this->query('COMMIT;');
		}else {
			$this->query('ROLLBACK;');
			$ads = array();
		}
		
		return $ads;
	}
}
?>