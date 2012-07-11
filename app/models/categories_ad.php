<?php
class CategoriesAd extends AppModel {
	var $name = 'CategoriesAd';
	var $displayField = 'ads_id';
	var $validate = array(
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El id de la categoría debe ser un número',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe indicar una categoría',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ads_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Debe indicar una publicidad existente',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe indicar unca publicidad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Ads' => array(
			'className' => 'Ads',
			'foreignKey' => 'ads_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>