<?php
class City extends AppModel {
	var $name = 'City';
	var $displayField = 'name';
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
		'name' => array(
			/*'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
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
		'state_id' => array(
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
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $hasOne = array(
		'Location'	=>	array(
			'className'	=>	'Location',
			'dependent'	=>	false
		)
	);

	var $hasMany = array(
		'Feed' => array(
			'className' => 'Feed',
			'foreignKey' => 'city_id',
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
			'foreignKey' => 'city_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'city_id',
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

	function afterFind($results, $primary) {
		//parent::afterFind($results,$primary);
		App::import('Vendor','geoplanet/geoplanet');
		$key = array_keys($results);
		$key = $key[0];
		//debug($results);
		if (empty($results) || empty($results[0]) || empty($results[0]['City']) || empty($results[0]['City']['id'])) {
			return $results;
		}
		
		if (is_numeric($key)) {
			foreach ($results as $k => $value) {
				if (array_key_exists('woeid', $value['City']) && empty($value['City']['woeid'])) {
					$this->State->contain('Country');
					$state = $this->State->find('first', array('conditions'=>array('State.id'=>$value['City']['state_id'])));
					$yApiKey = $this->query("select value from parameters where `key` = 'yahoo_api_key'");
					$yApiKey = array('Parameter'=>array('value'=>$yApiKey[0]['parameters']['value']));
					$geoplanet = new GeoPlanet($yApiKey['Parameter']['value']);
					$placelist = $geoplanet->getPlaces("{$value['City']['name']}, {$state['State']['name']}, {$state['Country']['name']}");
					$placelist = array_key_exists(0, $placelist)?$placelist[0]:$placelist;
					$woeid = array_key_exists('woeid', $placelist)?$placelist['woeid']:null;
					$value['City']['woeid'] = $woeid;
					if (empty($woeid)) {
						$this->log("No se puede obtener el woeid de "."{$value['City']['name']}, {$state['State']['name']}, {$state['Country']['name']}");
						continue;
					}
					$results[$k] = $value;

					//guardo el woeid
					$data = array(
						'City'	=>	array(
							'id'	=>	$value['City']['id'],
							'woeid'	=>	$woeid
						)
					);
					if(!$this->save($data, false, array('woeid'))){
						$this->log("[".__FILE__." -> ".__LINE__."] No se puede actualizar los datos de geolocalización");
					}
				}
			}
		}

		return $results;
	}

}
?>