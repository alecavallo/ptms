<?php
class LastPost extends AppModel {
	var $name = 'LastPost';
	var $displayField = 'type';
	var $validate = array(
		'last_readed' => array(
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
		'last_inserted' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
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

	function updateReads($type, $lastRead){
		if (strtolower(trim($type))=='news') {
			$type=1;
		}else{
			$type=2;
		}
		$sql = "insert into last_posts(type, last_read) values ({$type}, {$lastRead}) ON DUPLICATE KEY UPDATE last_read={$lastRead};";
		return $this->query($sql);
	}
	function updateWrites($type, $lastInserted){
		if (strtolower(trim($type))=='news') {
			$type=1;
		}else{
			$type=2;
		}
		$sql = "insert into last_posts(type, last_inserted) values ({$type}, {$lastInserted}) ON DUPLICATE KEY UPDATE last_read={$lastInserted};";
		return $this->query($sql);
	}
}
?>