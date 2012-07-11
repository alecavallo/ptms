<?php
class StatesController extends AppController {

	var $name = 'States';
	var $uses = array('State', 'Parameter');

	function search($id = null, $limit = null) {
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
			$this->Session->setFlash(__('Invalid state', true));
			$this->redirect(array('action' => 'index'));
		}
		//$locations = explode(",", $id, 3);

		$conditions = "State.name LIKE'%".trim($id)."%'";
		$query=$this->State->find('all',array('conditions'=>$conditions, 'fields'=>array('id','name'),'contain'=>array()));

		$data=array();
		foreach ($query as $row) {
			$json = array();
			$json['value'] = $row['State']['name'];
			$json['id'] = $row['State']['id'];
			$data[] = $json;
		}
		header("Content-type: application/json");
		echo json_encode($data);
	}
	function index() {
		$this->State->recursive = 0;
		$this->set('states', $this->paginate());
	}
	function searchByCountryId($id=0){
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
		$this->State->recursive=-1;
		$states = $this->State->find('all',array('conditions'	=>	array('country_id'=>$id), 'fields'=>array('id','name')));


		App::import('Vendor','geoplanet/geoplanet');
		$yApiKey = $this->Parameter->find('first',array('conditions'=>array('key'=>'yahoo_api_key')));
		$geoplanet = new GeoPlanet($yApiKey['Parameter']['value']);
		$this->State->Country->recursive = -1;
		$name = $this->State->Country->read('name',$id);
		$placelist = $geoplanet->getPlaces($name['Country']['name']);

		$coordinates['latitude'] = $placelist[0]['centroid']['lat'];
		$coordinates['longitude'] = $placelist[0]['centroid']['lng'];
		$response = array();
		$response['states'] = $states;
		$response['coordinates'] = $coordinates;


		header("Content-type: application/json");
		echo json_encode($response);
		return;
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid state', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('state', $this->State->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->State->create();
			if ($this->State->save($this->data)) {
				$this->Session->setFlash(__('The state has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The state could not be saved. Please, try again.', true));
			}
		}
		$countries = $this->State->Country->find('list');
		$this->set(compact('countries'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid state', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->State->save($this->data)) {
				$this->Session->setFlash(__('The state has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The state could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->State->read(null, $id);
		}
		$countries = $this->State->Country->find('list');
		$this->set(compact('countries'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for state', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->State->delete($id)) {
			$this->Session->setFlash(__('State deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('State was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->State->recursive = 0;
		$this->set('states', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid state', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('state', $this->State->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->State->create();
			if ($this->State->save($this->data)) {
				$this->Session->setFlash(__('The state has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The state could not be saved. Please, try again.', true));
			}
		}
		$countries = $this->State->Country->find('list');
		$this->set(compact('countries'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid state', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->State->save($this->data)) {
				$this->Session->setFlash(__('The state has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The state could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->State->read(null, $id);
		}
		$countries = $this->State->Country->find('list');
		$this->set(compact('countries'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for state', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->State->delete($id)) {
			$this->Session->setFlash(__('State deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('State was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>