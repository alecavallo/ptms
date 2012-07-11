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
	function get($priority, $category=0){
		if(is_int($priority) && $priority!=4){//todas las columnas excepto el banner central
			$priority=array($priority, 5);
		}
		$conditions = array(
			'priority'	=>	$priority,
		);

		if ($category > 0) {
			//$conditions['category']	= $category;
		}

		if ($category==0) {
			$ads = $this->find('all',
				array(
					'conditions'	=>	$conditions,
					'contain'		=>	array()
				)
			);
		}else {
			$ads = $this->Category->find('first', array(
					'conditions'	=>	array('Category.id'	=>	$category),
					'contain'	=>	array(
						'Ad'	=>	array(
							'conditions'=>$conditions
						)
					)
				)
			);
			$ads = $ads['Ad'];
			$aux = array();
			foreach ($ads as $key=>$value) {
				$aux[$key]=array('Ad'=>$value);
			}
			$ads = $aux;
			unset($aux);
		}

		foreach ($ads as $key => $value) {
			$aux = $value;

			if (!empty($aux['Ad']['url'])) {
				$aux['Ad']['url']= str_replace("\\", "/", $aux['Ad']['url']);
				$folders = explode("/", $aux['Ad']['url']);
				
				if (strtolower($folders[0]) != "img" && strtolower($folders[1]) != "img") {
					$aux['Ad']['url'] = "/".'img'."/".$aux['Ad']['url'];
				}
			}
			
			$ads[$key] = $aux;
		}

		return $ads;
	}
}
?>