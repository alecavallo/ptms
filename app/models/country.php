<?php
class Country extends AppModel {
	var $name = 'Country';
	var $displayField = 'name';
	var $actsAs = array('Containable');
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
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Source' => array(
			'className' => 'Source',
			'foreignKey' => 'country_id',
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
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'country_id',
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
		parent::afterFind($results,$primary);
		App::import('Vendor','geoplanet/geoplanet');
		$key = array_keys($results);
		$key = $key[0];
		if (is_numeric($key)) {
			foreach ($results as $k => $value) {
				if (array_key_exists('woeid', $value['Country']) && empty($value['Country']['woeid'])) {
					if (empty($value['Country']['name'])) {
						continue;
					}

					$yApiKey = $this->query("select value from parameters where `key` = 'yahoo_api_key'");
					$yApiKey = array('Parameter'=>array('value'=>$yApiKey[0]['parameters']['value']));
					$geoplanet = new GeoPlanet($yApiKey['Parameter']['value']);
					$placelist = $geoplanet->getPlaces("{$value['Country']['name']}");
					$placelist = array_key_exists(0, $placelist)?$placelist[0]:$placelist;
					$woeid = array_key_exists('woeid', $placelist)?$placelist['woeid']:null;
					$value['Country']['woeid'] = $woeid;
					$results[$k] = $value;
					if (empty($woeid)) {
						$this->log("No se puede obtener el woeid de "."{$value['Country']['name']}");
						continue;
					}

					//guardo el woeid
					$data = array(
						'Country'	=>	array(
							'id'	=>	$value['Country']['id'],
							'woeid'	=>	$woeid
						)
					);
					if(!$this->save($data, false, array('woeid'))){
						$this->log("[".__FILE__." -> ".__LINE__."] No se puede actualizar los datos de geolocalización");
					}
				}
			}
		}else {
			if (array_key_exists('woeid', $results) && empty($results['woeid'])) {
					$yApiKey = $this->query("select value from parameters where `key` = 'yahoo_api_key'");
					$yApiKey = array('Parameter'=>array('value'=>$yApiKey[0]['parameters']['value']));
					$geoplanet = new GeoPlanet($yApiKey['Parameter']['value']);
					$placelist = $geoplanet->getPlaces("{$results['name']}");
					$placelist = array_key_exists(0, $placelist)?$placelist[0]:$placelist;
					$woeid = $placelist['woeid'];
					$results['woeid'] = $woeid;

					//guardo el woeid
					$data = array(
						'Country'	=>	array(
							'id'	=>	$results['id'],
							'woeid'	=>	$woeid
						)
					);
					if(!$this->save($data, false, array('woeid'))){
						$this->log("[".__FILE__." -> ".__LINE__."] No se puede actualizar los datos de geolocalización");
					}
				}
		}
		return $results;
	}

}
?>