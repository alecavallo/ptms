<?php
class CitiesController extends AppController {

	var $name = 'Cities';
	var $component = array('RequestHandler');
	var $uses = array('City', 'Parameter');

	function beforeFilter() {
		$this->Auth->allow('view');
		parent::beforeFilter();
	}

	function searchByStateId($id=0){
		if ($id == 0) {
			$id = $this->params['url']['id'];
		}
		//if($this->RequestHandler->isAjax()){
			$this->autoLayout=false;
			$this->autoRender=false;
		//}
		if (empty($id) || $id==0) {
			echo json_encode(array());
			return;
		}
		$this->disableCache();
		$this->layout='ajax';
		$this->City->recursive=-1;
		$cities = $this->City->find('all',array('conditions'	=>	array('state_id'=>$id), 'fields'=>array('id','name')));


		App::import('Vendor','geoplanet/geoplanet');
		$yApiKey = $this->Parameter->find('first',array('conditions'=>array('key'=>'yahoo_api_key')));
		$geoplanet = new GeoPlanet($yApiKey['Parameter']['value']);
		$this->City->State->contain('Country');
		$name = $this->City->State->find('first',array('conditions'=>array('State.id'=>$id)));
		$placelist = $geoplanet->getPlaces($name['State']['name'].", ".$name['Country']['name']);

		$coordinates['latitude'] = $placelist[0]['centroid']['lat'];
		$coordinates['longitude'] = $placelist[0]['centroid']['lng'];
		$response = array();
		$response['cities'] = $cities;
		$response['coordinates'] = $coordinates;


		header("Content-type: application/json");
		echo json_encode($response);
		return;
	}

	function getCoordinates($id=0){
		if ($id == 0) {
			$id = $this->params['url']['id'];
		}
		//if($this->RequestHandler->isAjax()){
			$this->autoLayout=false;
			$this->autoRender=false;
		//}
		if (empty($id) || $id==0) {
			echo json_encode(array());
			return;
		}
		$this->disableCache();
		$this->layout='ajax';
		$this->City->contain('State.Country');
		$cities = $this->City->find('first',array('conditions'	=>	array('City.id'=>$id)));


		App::import('Vendor','geoplanet/geoplanet');
		$yApiKey = $this->Parameter->find('first',array('conditions'=>array('key'=>'yahoo_api_key')));
		$geoplanet = new GeoPlanet($yApiKey['Parameter']['value']);
		$placelist = $geoplanet->getPlaces($cities['City']['name'].", ".$cities['State']['name'].", ".$cities['State']['Country']['name']);

		$coordinates['latitude'] = $placelist[0]['centroid']['lat'];
		$coordinates['longitude'] = $placelist[0]['centroid']['lng'];
		$response = array();
		$response['cities'] = $cities;
		$response['coordinates'] = $coordinates;


		header("Content-type: application/json");
		echo json_encode($response);
		return;
	}

	function index() {
		$this->City->recursive = 0;
		$this->set('cities', $this->paginate());
	}

	function view($id = null, $limit = null) {
		$this->disableCache();
		//if($this->RequestHandler->isAjax()){
			$this->autoLayout=false;
			$this->autoRender=false;
		//}
		if (empty($id)) {
			$id = $this->params['url']['q'];
		}
		if (empty($limit)) {
			$limit=empty($this->params['limit'])?null:$this->params['limit'];
		}
		if (!$id) {
			$this->Session->setFlash(__('Invalid city', true));
			$this->redirect(array('action' => 'index'));
		}
		$locations = explode(",", $id, 3);

		$conditions = array_key_exists('0', $locations)?"lower(City.name) LIKE '%{$locations[0]}%'":"";
		$conditions .= array_key_exists('1', $locations)?"AND State.name LIKE'%".trim($locations[1])."%'":"";
		$conditions .= array_key_exists('2', $locations)?"AND Country.name LIKE '%".trim($locations[2])."%'":"";
		$query=$this->City->find('all',array('conditions'=>$conditions, 'contain'=>array('State.Country')));

		$data=array();
		foreach ($query as $row) {
			$json = array();
			$json['value'] = $row['City']['name'].", ".$row['State']['name'].", ".$row['State']['Country']['name'];
			$json['id'] = $row['City']['id'];
			$data[] = $json;
		}
		header("Content-type: application/json");
		echo json_encode($data);
	}

	function add() {
		if (!empty($this->data)) {
			$this->City->create();
			if ($this->City->save($this->data)) {
				$this->Session->setFlash(__('The city has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.', true));
			}
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid city', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->City->save($this->data)) {
				$this->Session->setFlash(__('The city has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->City->read(null, $id);
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for city', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->City->delete($id)) {
			$this->Session->setFlash(__('City deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('City was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->City->recursive = 0;
		$this->set('cities', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid city', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('city', $this->City->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->City->create();
			if ($this->City->save($this->data)) {
				$this->Session->setFlash(__('The city has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.', true));
			}
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid city', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->City->save($this->data)) {
				$this->Session->setFlash(__('The city has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->City->read(null, $id);
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for city', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->City->delete($id)) {
			$this->Session->setFlash(__('City deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('City was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>