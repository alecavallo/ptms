<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'alias';
	var $cacheQueries = true;
	var $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Debe especificar un numero entero',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El nombre no puede ser vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alphanumeric' => array(
				'rule' => array('onlyLetters','first_name'),
				'message' => 'El nombre solo puede contener letras',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El apellido no puede ser vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alphanumeric' => array(
				'rule' => array('onlyLetters', 'last_name'),
				'message' => 'El apellido solo puede contener letras',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'alias' => array(
			'alphanumeric' => array(
				'rule' => array('onlyLetters','alias'),
				'message' => 'El nick solo debe contener letras',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El Nick name no puede ser vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
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
		'city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'rule' => array('email', true),
			'message' => 'Ingrese una dirección de correo válida',
			'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('alphanumeric', true),
				'message' => 'La contraseña solo puede contener alfanuméricos y no debe ser vacía',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('alphanumeric', true),
				'message' => 'La contraseña solo puede contener alfanuméricos y no debe ser vacía',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password_confirm' => array(
			'rule' => array('identicalValues', 'password'),
			'message' => 'La contraseñas no coinciden',
			'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'home_layout' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Debe especificar un numero entero',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasOne = array(
		'PreferredLayout' => array(
			'className' => 'PreferredLayout',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $belongsTo = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Source' => array(
			'className' => 'Source',
			'foreignKey' => 'sources_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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

	function identicalValues( $field=array(), $compare_field=null ){
        foreach( $field as $key => $value ){
            $v1 = $value;
            $v2 = $this->data[$this->name][ $compare_field ];
            if($v1 !== $v2) {
                return FALSE;
            } else {
                continue;
            }
        }
        return TRUE;
    }

	function onlyLetters($value,$field){
		$value = $value[$field];
		$value = html_entity_decode($value, ENT_QUOTES);
		$pattern = '(^[a-z|ñ|Ñ|á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û][a-z|ñ|Ñ| |á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û]*\'?[a-z|ñ|Ñ| |á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û]*[a-z|ñ|Ñ|á|é|í|ó|ú|à|è|ì|ò|ù|ä|ë|ï|ö|ü|â|ê|î|ô|û]$)';
		//$pattern=utf8_encode($pattern);
		$aux=eregi($pattern,$value);

		return $aux;
	}
}
?>