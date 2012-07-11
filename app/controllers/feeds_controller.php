<?php
class FeedsController extends AppController {

	var $name = 'Feeds';
	var $helpers = array('Ajax', 'Javascript','Js' => array('Jquery'), 'Jqautocomplete');
	var $components = array('ParseCsv', 'RequestHandler');
	var $scaffold = 'admin';

	var $paginate = array(
		'limit' => 400,
		'order'	=>	array(
			'Source.name'	=>	'asc'
		)
	);


	function index() {
		$this->Feed->recursive = 0;
		$this->set('feeds', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid feed', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('feed', $this->Feed->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Feed->create();
			if ($this->Feed->save($this->data)) {
				$this->Session->setFlash(__('The feed has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feed could not be saved. Please, try again.', true));
			}
		}
		$sources = $this->Feed->Source->find('list');
		$categories = $this->Feed->Category->find('list');
		$cities = $this->Feed->City->find('list');
		$states = $this->Feed->State->find('list');
		$this->set(compact('sources', 'categories', 'cities', 'states'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid feed', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Feed->save($this->data)) {
				$this->Session->setFlash(__('The feed has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feed could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Feed->read(null, $id);
		}
		$sources = $this->Feed->Source->find('list');
		$categories = $this->Feed->Category->find('list');
		$cities = $this->Feed->City->find('list');
		$states = $this->Feed->State->find('list');
		$this->set(compact('sources', 'categories', 'cities', 'states'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for feed', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Feed->delete($id)) {
			$this->Session->setFlash(__('Feed deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Feed was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	/*function admin_index() {
		$this->Feed->recursive = 0;
		$this->set('feeds', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid feed', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('feed', $this->Feed->read(null, $id));
	}*/

  	function admin_index(){
  		$this->layout='admin';
  		$this->disableCache();
  		$this->paginate['contain']=array('Source','Category');
  		$this->paginate['fields']=array('Source.id','Source.name','Category.name', 'Source.url', 'Feed.id', 'Feed.url', 'Feed.enabled', 'Feed.content_type', 'Feed.enabled');
		$data = $this->paginate('Feed');
		$this->set('feeds', $data);
  	}

	function admin_add($bunch=0) {
		$this->layout='admin';
		$offset = $this->Session->read('offset');
		$length = $this->Session->read('conjunto');
		//debug($offset);
		echo "Procesados los {$offset}º";
		if ($bunch==1) {
			$this->autoRender = false;
			$count = count($this->data['Feed']['social_network']);
			$countries = array();
			$states = array();
			$cities = array();
			$sources = array();
			$feeds = array();
			$new = array();
			for ($i = 0; $i < $count; $i++) {
				$countryId = null;
				$stateId = null;
				$cityId = null;
				$sourceId = null;
				$feedId = null;
				//debug($this->data['Feed']['enabled']);
				if ($this->data['Feed']['enabled'][$i] == 1) { //si esta habilitado guardo los cambios
					//proceso el país
					if (!empty($this->data['Country']['name'][$i])){
						if (!empty($countries) || !array_key_exists($this->data['Country']['name'][$i], $countries)) {//si el dato existe en cache uso la misma
							$country = $this->Feed->Source->Country->find('first',array('fields'=>array('id','name'), 'conditions'=>"name = '{$this->data['Country']['name'][$i]}'", 'contain'=>array()));
							if (!empty($country)) {// si el país existe
								$countries[$country['Country']['name']]=$country['Country']['id'];
								$countryId = $country['Country']['id'];
							}else {//si el país no existe lo guardo
								$toSave = array('Country'=>array('name' => $this->data['Country']['name'][$i]));
								$this->Feed->Source->Country->create();
								$this->Feed->Source->Country->save($toSave);
								$countries[$this->data['Country']['name'][$i]]=$this->Feed->Source->Country->id;
								$countryId = $this->Feed->Source->Country->id;
								$new['Country'][$countryId]=$this->data['Country']['name'][$i];
							}

						}else {//obtengo los datos del cache
							$countryId = $countries[$this->data['Country']['name'][$i]];
						}
					}else {
						$message = "El país no es correcto... No se puede crear la entrada #{$i}, correspondiente a {$this->data['Source']['name'][$i]} => {$this->data['Source']['url'][$i]}";
						$this->flash($message, "/admin/feeds/addBunch/{$offset}/{$length}",7);
						return;
					}

					//proceso la provincia
					if (!empty($this->data['State']['name'][$i])) {//si está definida una provincia
						if (empty($states) || !array_key_exists($countryId, $states) || !array_key_exists($this->data['State']['name'][$i], $states[$countryId])) {//si el dato existe en cache uso la misma
							$state = $this->Feed->Source->Country->State->find('first',array('fields'=>array('id','name'), 'conditions'=>array("name" => $this->data['State']['name'][$i], "country_id"=>$countryId), 'contain'=>array()));
							if (!empty($state)) {// si la provincia existe
								$states[$countryId][$state['State']['name']]=$state['State']['id'];
								$stateId = $state['State']['id'];
							}else {//si la provincia no existe lo guardo
								$toSave = array('State'=>array('name' => $this->data['State']['name'][$i], 'country_id'=>$countryId));
								$this->Feed->Source->Country->State->create();
								$this->Feed->Source->Country->State->save($toSave);
								$states[$countryId][$this->data['State']['name'][$i]]=$this->Feed->Source->Country->State->id;
								$stateId = $this->Feed->Source->Country->State->id;
								$new['State'][$countryId][$stateId]=$this->data['State']['name'][$i];
							}

						}else {//obtengo los datos del cache
							$stateId = $states[$countryId][$this->data['State']['name'][$i]];
						}
					}

					//proceso la ciudad
					if (!empty($this->data['City']['name'][$i])) {//si está definida una provincia
						if ((empty($cities)) || !array_key_exists($stateId, $cities)|| !array_key_exists($this->data['City']['name'][$i], $cities[$stateId])) {//si el dato existe en cache uso la misma
						if (empty($cities[$stateId])) {
							//debug($cities);
							//die('carajo');
						}
							$city = $this->Feed->Source->Country->State->City->find('first',array('fields'=>array('id','name'), 'conditions'=>array("name" => $this->data['City']['name'][$i], "state_id"=>$stateId), 'contain'=>array()));
							if (!empty($city)) {// si la ciudad existe
								$cities[$stateId][$city['City']['name']]=$city['City']['id'];
								$cityId = $city['City']['id'];
							}else {//si la ciudad no existe lo guardo
								$toSave = array('City'=>array('name' => $this->data['City']['name'][$i], 'state_id'=>$stateId));
								$this->Feed->Source->Country->State->City->create();
								$this->Feed->Source->Country->State->City->save($toSave);
								$cities[$stateId][$this->data['City']['name'][$i]]=$this->Feed->Source->Country->State->City->id;
								$cityId = $this->Feed->Source->Country->State->City->id;
								$new['City'][$stateId][$cityId]=$this->data['City']['name'][$i];
							}
						}else {//obtengo los datos del cache
							$cityId = $cities[$stateId][$this->data['City']['name'][$i]];
						}
					}

					//proceso la fuente
					if (!empty($countryId)) {
						//busco si la fuente existe
						$matches = null;
						$returnValue = preg_match('/([a-z0-9\\.\\-_]+)/', $this->data['Source']['url'][$i], $matches);
						if ($returnValue > 0) {
							$this->data['Source']['url'][$i] = "http://".$matches[1];
						}
						if (array_key_exists($countryId, $sources) && array_key_exists($this->data['Source']['url'][$i], $sources[$countryId])) {//si existe en cache obtengo los datos desde ahí
							$sourceId = $sources[$countryId][$this->data['Source']['url'][$i]];
						}else {//si no está en cache
							if (empty($this->data['Source']['url'][$i]) || empty($this->data['Source']['name'][$i])) {
								$message = "No se ha podido obtener la url de la fuente o su nombre... No se puede crear la entrada #{$i}, correspondiente a {$this->data['Feed']['url'][$i]}";
								$this->flash($message, "/admin/feeds/addBunch/{$offset}/{$length}",7);
								return ;
							}
							$source = $this->Feed->Source->find('first',array('conditions'=>array("country_id"=>$countryId,"url LIKE"=>"%".$this->data['Source']['url'][$i]."%"),'contain'=>array()));
							if (empty($source)) {//si la fuente no existe la creo
								$toSave = array(
									'Source'=>array(
										'name'=>$this->data['Source']['name'][$i],
										'url'=>$this->data['Source']['url'][$i],
										'country_id'=>$countryId
									)
								);
								$this->Feed->Source->create();
								$aux = $this->Feed->Source->save($toSave,true,array('name','url','country_id'));
								if (!$aux) {
									$msg = $this->Feed->Source->invalidFields();
									debug($toSave);
									debug($msg);
									//die('Error al guardar');
									return ;
								}
								$sourceId = $this->Feed->Source->id;
								//debug($sourceId);
								$sources[$countryId][$this->data['Source']['url'][$i]] = $sourceId;
								$new['Source'][$countryId][$sourceId]=array('name'=>$this->data['Source']['name'],'url'=>$this->data['Source']['url'][$i]);
							}else {//si la fuente existe la obtengo del cache
								$sourceId = $source['Source']['id'];
								//$sourceId = $sources[$countryId][$this->data['Source']['url'][$i]];
							}
						}
					}else {
						$message = "No se ha podido obtener el id de país... No se puede crear la entrada para la fuente #{$i}, correspondiente a {$this->data['Source']['name'][$i]} => {$this->data['Source']['url'][$i]}";
						$this->flash($message, "/admin/feeds/addBunch/{$offset}/{$length}",7);
						return ;
					}

					//proceso el feed
					if (!empty($this->data['Feed']['url'][$i]) || empty($sourceId)) {//si el feed tiene la url
						if (array_key_exists($sourceId, $feeds) && array_key_exists($this->data['Feed']['url'][$i], $feeds[$sourceId])) {//el feed ya existe en cache, no lo creo
							continue;
						}

						$feed = $this->Feed->find('first',array('conditions'=>array('url'=>$this->data['Feed']['url'][$i]),'contain'=>array()));
						if (!empty($feed)) {//si el feed ya existe en la DB, almaceno la entrada en cache y omito el procesamiento
							$feeds[$sourceId][$feed['Feed']['url']] = $feed['Feed']['id'];
							continue;
						}

						//si todo esta OK creo el feed y lo almaceno en cache
						$categoryId = $this->data['Category']['id'][$i];
						$toSave = array(
								'Feed'	=>	array(
								'url'		=>	$this->data['Feed']['url'][$i],
								'source_id'	=>	$sourceId,
								'category_id'	=> $categoryId,
								'city_id'		=>	$cityId,
								'state_id'		=>	$stateId,
								'enabled'		=>	1,
								'social_network'=>	$this->data['Feed']['social_network'][$i]
							)
						);
						$this->Feed->create();
						if(!$this->Feed->save($toSave)){
							$msg = $this->Feed->invalidFields();
							debug($msg);
							debug($toSave);
							$message = "No se ha podido guardar el feed... No se puede crear la entrada #{$i}, correspondiente a {$this->data['Source']['name'][$i]} => {$this->data['Source']['url'][$i]}";
							$this->flash($message, "/admin/feeds/addBunch/{$offset}/{$length}",7);
							return ;
						}
						$feeds[$sourceId][$this->data['Feed']['url'][$i]] = $this->Feed->id;
					}else {
						$message = "No se ha podido obtener la url del feed o el id de la fuente... No se puede crear la entrada #{$i}, correspondiente a {$this->data['Source']['name'][$i]} => {$this->data['Source']['url'][$i]}";
						$this->flash($message, "/admin/feeds/addBunch/{$offset}/{$length}",7);
						return ;
					}
				}
			}

			$msg = Debugger::exportVar($new);
			$this->log($msg,LOG_DEBUG);
			$message = "Se ha procesado correctamente, se continúa con los siguientes {$length} registros.";
			$this->flash($message, "/admin/feeds/addBunch/".($offset+1)."/{$length}", 7);
			return ;
		}
	}

	function admin_AddBunch($offset=0,$length=70){
		if (empty($this->data) && !$this->Session->check('fdata')) {
			$this->render('upload');
			return ;
		}

		if (@array_key_exists('Feed', $this->data)) {
			$csv_file = $this->data['Feed']['submittedfile']['tmp_name'];
			//$this->Session->write('csv_file',$csv_file);
		}
		$length = is_numeric($length)?$length:100;
		$this->Session->write('offset',$offset);
		$this->Session->write('conjunto',$length);
		//debug($this->Session->read('offset'));

			if (!$this->Session->check('fdata')) {
				$this->ParseCsv->setEncoding("UTF-8");
				$this->ParseCsv->setFile($csv_file);
				$fdata = $this->ParseCsv->getData();
				$this->Session->write('fdata',$fdata);
			}else {
				$fdata = $this->Session->read('fdata');
			}

			//$this->ParseCsv->setFile(APP.WEBROOT_DIR.DS."fuentes3.csv");

			/*$fdata = Sanitize::clean($this->ParseCsv->getData(),
				array(
					'odd_spaces'	=> true,
					'dollar'		=> false,
					'carriage'		=>	false,
					'unicode'		=>	true,
					'encode'		=>	true,
					'remove_html'	=>	true
				)

			);*/

			$fdata = array($fdata[0], array_slice($fdata[1], $offset*$length, $length));
			if (empty($fdata)) {
				die('Se procesaron todos los datos del archivo');
			}
			$categories = $this->Feed->Category->find('list',array('fields'=>array('id','name'),'contain'=>array()));
			$this->set('categories',$categories);
			$this->set('fdata',$fdata);
			$this->render('admin_add_bunch');

	}

	/*function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid feed', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Feed->save($this->data)) {
				$this->Session->setFlash(__('The feed has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feed could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Feed->read(null, $id);
		}
		$sources = $this->Feed->Source->find('list');
		$categories = $this->Feed->Category->find('list');
		$cities = $this->Feed->City->find('list');
		$states = $this->Feed->State->find('list');
		$this->set(compact('sources', 'categories', 'cities', 'states'));
	}*/

	function admin_delete($id = null, $ajaxUpdate=null, $rowId=null) {
		$this->layout='admin';
		if (!$id) {
			if(!$this->RequestHandler->isAjax()){
				$this->Session->setFlash(__('Invalid id for feed', true));
				$this->redirect(array('action'=>'index'));
			}else{
				$this->layout='ajax';
				$this->autoRender = false;
				$this->set('message',"ID de feed inválido, no se ha borrado ningún feed");
				$this->set('remove', false);
				$this->set('update', $ajaxUpdate);
				$this->set('row',$rowId);
				$this->render('admin_delete_ajax');
			}
		}
		if ($this->Feed->delete($id)) {
			if(!$this->RequestHandler->isAjax()){
				$this->Session->setFlash(__('Feed deleted', true));
				$this->redirect(array('action'=>'index'));
			}else {
				$this->layout='ajax';
				$this->autoRender = false;
				$this->set('message', "Se ha borrado el feed");
				$this->set('remove', true);
				$this->set('update', $ajaxUpdate);
				$this->set('row',$rowId);
				$this->render('admin_delete_ajax');
			}
			
		}else{
			if(!$this->RequestHandler->isAjax()){
				$this->Session->setFlash(__('Feed was not deleted', true));
				$this->redirect(array('action' => 'index', 'admin'=>true));
			}else{
				$this->layout='ajax';
				$this->autoRender = false;
				$this->set('message',"El feed no se ha podido borrar");
				$this->set('remove', false);
				$this->set('update', $ajaxUpdate);
				$this->set('row',$rowId);
				$this->render('admin_delete_ajax');
			}
				
		}
		
	}
}
?>