<?php
class Location extends AppModel {
	var $name = 'Location';
	var $displayField = 'ip';
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
		'ip' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			/*'ip' => array(
				'rule' => array('ip'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),*/
		),
		'city' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'country_code' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'latitude' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'longitude' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'exists' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cities_id' => array(
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
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function findByIp($ip) {
		//$ip = "190.18.173.38";
		//$ip="190.193.119.146"; Argentina -Santa Fe
		//$ip="190.127.119.146";	//Colombia
		//$ip="200.23.34.17";	//Colombia
		//$ip = "190.7.60.22";

		$ipSplitted = explode(".",$ip);
		if ($ipSplitted[0] == 10 || $ipSplitted[0] == 127 || $ipSplitted[0] == 192) {
			$this->log("Se esta accediendo al sitio desde una red privada. No se puede localizar {$ip}", LOG_DEBUG);
			$this->City->contain('State.Country');
			$response = $this->City->find('first',array('conditions'=>"ucase(City.name) like 'SANTA FE'"));
			return $response;
		}
		$this->contain('City.State.Country','Country');

		array_pop($ipSplitted);
		$network = implode(".",$ipSplitted).".0";
		$ipLocation = $this->find('first', array('conditions'=>"ip like '{$network}'"));

		if (empty($ipLocation)) {
			$result = $this->__getWhatIsMyIpAddress($ip);
			if (!empty($result['city'])) {
				$this->City->contain(
					array(
						'State'	=> array(
							'conditions'	=>	array('State.name'=>$result['state']),
							'Country'	=>	array('conditions'	=>	array('Country.name'=>$result['country']))
						)
					)
				);
				$location = $this->City->find('first',array('conditions'=>array('City.name'=>$result['city'])));

				if (!empty($location)) {//si existe registros en la DB creo el location
					$data = array('Location'	=>	array(
							'ip'	=>	$network,
							'city_id'	=>	$location['City']['id'],
							'latitude'	=>	$result['latitude'],
							'longitude'	=>	$result['longitude'],
							'exists'	=>	1
						)
					);
					$this->save($data);
					$this->contain('City.State.Country','Country');
					$ipLocation = $this->find('first', array('conditions'=>"ip like '{$network}'"));

					//return $this->save($data,true);
				}else { //sino creo primero los registros y luego el location
					//comienzo la transaccion
					$dataSource = $this->getDataSource();
					$dataSource->begin($this);
					//opero con el país
					$country_id = $this->Country->findByName($result['country']);

					if (empty($country_id)) {//si el pais no existe, lo creo;
						$rdo = $this->Country->save(array('Country'=>array('name'=>$result['country'])));
						if (!$rdo) {//
							$dataSource->rollback($this);
							return false;
						}
						$country_id = $this->Country->id;
					}else {
						$country_id = $country_id['Country']['id'];
					}

					//opero con la provincia/estado
					$state_id = $this->Country->State->findByName($result['state']);


					if (empty($state_id)) {//si la provincia/estado no existe, lo creo;
						$rdo = $this->Country->State->save(array('State'=>array('name'=>$result['state'],'country_id'=>$country_id)));
						if (!$rdo) {//
							$dataSource->rollback($this);
							return false;
						}
						$state_id = $this->Country->id;
					}else {
						$state_id = $state_id['State']['id'];
					}

					//opero con la ciudad
					//$result['city'] = utf8_encode($result['city']);
					$city_id = $this->Country->State->City->findByName($result['city']);
					if (empty($city_id)) {
						$data = array(
							'City'		=>	array('name'=>utf8_encode($result['city']),'state_id'=>$state_id,'latitude'=>$result['latitude'],'longitude'=>$result['longitude'])
						);
						//debug($data);
						$rdo = $this->Country->State->City->save($data);
						if (!$rdo) {//
							$dataSource->rollback($this);
							return false;
						}
						//debug($this->Country->State->City->invalidFields());
						$city_id = $this->Country->State->City->id;;
					}else {
						$city_id = $city_id['City']['id'];
					}

					//creo el location
					$data = array('Location'	=>	array(
							'ip'	=>	$network,
							'city_id'	=>	$city_id,
							'latitude'	=>	$result['latitude'],
							'longitude'	=>	$result['longitude'],
							'exists'	=>	1
						)
					);

					$return = $this->save($data,true);
					if ($return) {
						$dataSource->commit($this);
					}else {
						$dataSource->rollback($this);
						return false;
					}

					//debug($data);die('lala');
					$this->contain('City.State.Country','Country');
					$ipLocation = $this->find('first', array('conditions'=>"ip like '{$network}'"));
					//debug($ipLocation);
					return $ipLocation;


				}


			}elseif (!empty($result['country'])) { //si solo podemos obtener el país


				$this->Country->recursive=-1;
				$location = $this->Country->find('first',array('conditions'=>array('Country.name'=>$result['country'])));

				if (!empty($location)) {
					$data = array(
						'ip'	=>	$network,
						'country_id'	=>	$location['County']['id'],
						'latitude'	=>	$result['latitude'],
						'longitude'	=>	$result['longitude'],
						'exists'	=>	1
					);
					$this->contain('City.State.Country','Country');
					$ipLocation = $this->find('first', array('conditions'=>"ip like '{$network}'"));
					//return $this->save($data);
				}else {
					$data = array('Country'=>array('name'=>$result['country']));
					$this->Country->save($data);
					$country_id = $this->Country->id;
					$data = array(
						'ip'	=>	$network,
						'country_id'	=>	$country_id,
						'latitude'	=>	$result['latitude'],
						'longitude'	=>	$result['longitude'],
						'exists'	=>	1
					);
					$this->contain('City.State.Country','Country');
					$ipLocation = $this->find('first', array('conditions'=>"ip like '{$network}'"));
					//return $this->save($data);
				}


			}else {
				$this->log("No se puede geolocalizar la ip {$ip}");
				$this->City->contain('State.Country');
				$response = $this->City->find('first',array('conditions'=>"ucase(City.name) like 'CAPITAL FEDERAL'"));
				return $response;
			}
		}

		//si ya existe la localizacion en la DB, se retorna el rdo sin consultar ningun webservice
		return $ipLocation;

	}

	function __getWhatIsMyIpAddress($ip){
return array();
		App::import('Core', 'HttpSocket');
		$HttpSocket = new HttpSocket();
		$results = $HttpSocket->get("http://whatismyipaddress.com/ip/{$ip}");
		$doc = new DOMDocument("1.1", "iso-8859-1");
		@$doc->loadHTML($results);
		$respTable = $doc->getElementsByTagName('table');
		$rows =	$respTable->item(1)->getElementsByTagName('tr');
		$country="";
		$state="";
		$city="";
		$latitude="";
		$longitude="";
		foreach ($rows as $tr) {
			$cells = $tr->getElementsByTagName('th');
			switch ($cells->item(0)->nodeValue) {
				case 'Country:':
					$cells = $tr->getElementsByTagName('td');
					$country = trim($cells->item(0)->nodeValue);
				break;
				case 'State/Region:':
					$cells = $tr->getElementsByTagName('td');
					$state = trim($cells->item(0)->nodeValue);
					break;
				case 'City:':
					$cells = $tr->getElementsByTagName('td');
					$city = trim($cells->item(0)->nodeValue);
					break;
				case 'Latitude:':
					$cells = $tr->getElementsByTagName('td');
					$latitude = trim($cells->item(0)->nodeValue);
					break;
				case 'Longitude:':
					$cells = $tr->getElementsByTagName('td');
					$longitude = trim($cells->item(0)->nodeValue);
					break;
				default:

				break;
			}
		}

		$return = compact("country","state","city","latitude","longitude");
		if (empty($country) && empty($state) && empty($city)) {
			$this->log("No se puede localizar la ip {$ip}",LOG_ERROR);
		}
		return $return;
	}
}
?>
