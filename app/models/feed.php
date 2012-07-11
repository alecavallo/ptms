<?php
class Feed extends AppModel {
	var $name = 'Feed';
	var $displayField = 'url';
	var $cacheQueries = true;
	var $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El ID debe ser numérico',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'La URL no puede estar vacía',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'source_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Souce ID debe ser numérico',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Source ID no debe estar vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El feed debe pertenecer a una categoría',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
/*			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),*/
		),
		/*'city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El feed debe pertenecer a una ciudad',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'state_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El feed debe pertenecer a una provincia',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		'last_processing_date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'La fecha de último procesamiento no es correcta',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'image_title' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'El título de la imágen debe ser alfanumérico',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'image_link' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'El link de la imágen debe ser alfanumérico',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ttl' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El TTL debe ser numérico',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rating' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El rating debe ser un número',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'language' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'El idioma debe ser un texto',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'webmaster' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'El webmaster debe ser un texto',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'editor' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'El editor debe ser un texto',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content_type' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El tipo debe ser numérico',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Source' => array(
			'className' => 'Source',
			'foreignKey' => 'source_id',
			'type'		=>	'INNER',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'News' => array(
			'className' => 'News',
			'foreignKey' => 'feed_id',
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

}
?>