<?php
class SourcesController extends AppController {

	var $name = 'Sources';
	var $scaffold = 'admin';
	//var $helpers = array('Paginator', 'Html', 'Js' => array('Prototype'), 'Form', 'FileUpload.FileUpload');
	var $components = array('FileUpload.FileUpload');


	var $paginate = array(
		'limit' => 50,
		'order'	=>	array(
			'Source.name'	=>	'asc'
		)
	);

	function beforeFilter(){
    	parent::beforeFilter();
    	$this->FileUpload->fileModel(null);
    	$this->FileUpload->fileVar('SourceIcon');
    	//$this->FileUpload->allowedTypes = array('image/jpeg','image/png', 'image/gif');
    	$this->FileUpload->uploadDir('img'.DS.'icons');
    	$this->FileUpload->allowedTypes(array(
            'jpg' => array('image/jpeg','image/pjpeg'),
            'png' => array('image/png'),
            'gif' => array('image/gif'),
        ));
  	}

  	function admin_index(){
  		$this->layout='admin';
  		$this->disableCache();
  		$this->paginate['contain']=array();
  		$this->paginate['fields']=array('id','name', 'url');
		$data = $this->paginate('Source');
		$this->Source->recursive = -1;
		$this->set('sources', $data);
  	}

  	function admin_edit($id){
  		$this->layout='admin';
  		if (empty($id)) {
  			$this->Session->setFlash('No existe la fuente seleccionada');
  			$this->redirect(array('action'=>"admin_index"));
  		}

  	if (!empty($this->data)) {
			if($this->FileUpload->success){
				$srcIcon = $this->FileUpload->finalFile;
			}else {
				$srcIcon = null;
				$this->Session->setFlash($this->FileUpload->showErrors());
			}
			$data = $this->data;
			//debug($data);
			$data['Source']['icon'] = $srcIcon;
			$data['Source']['country_id'] = 1;

			$dataSource = $this->Source->getDataSource();
			$dataSource->begin($this);
			$this->Source->id=$id;
			if(!$this->Source->save($data['Source'])){
				$errors = $this->Source->invalidFields();
				foreach ($errors as $key=>$value) {
					$this->set("source_{$key}_error", $value);
				}
				$this->Session->setFlash('No se ha podido aplicar el cambio');
				$dataSource->rollback($this->Source);
				return;

			}else {
				$source_id = $id;
				foreach ($data['Feed'] as $row) {
					if (!empty($row['url'])) {
						$row['icon']="icons/{$row['icon']}";
						$this->Source->Feed->create();
						$aux = array();
						$aux['Feed'] = $row;

						if (!empty($aux['Feed']['id'])) {
							$this->Source->Feed->id=$row['id'];
							if(!$this->Source->Feed->save($row)){
								$errors = $this->Source->Feed->invalidFields();
								debug($errors);
								$this->Session->setFlash('No se ha podido aplicar el cambio');
								$dataSource->rollback($this->Source->Feed);
								return;
							}


						}else {
							$aux['Feed']['source_id'] = $source_id;
							unset($aux['Feed']['id']);
							if(!$this->Source->Feed->save($aux)){
								$errors = $this->Source->Feed->invalidFields();
								debug($errors);
								$this->Session->setFlash('No se ha podido aplicar el cambio');
								$dataSource->rollback($this->Source->Feed);
								return;
							}

						}


					}
				}

			}
			$dataSource->commit($this->Source->Feed);
			$dataSource->commit($this->Source);
			$this->Session->setFlash('El cambio se ha realizado exitosamente');
			$this->redirect(array('action'=>"admin_index"));
			return;

		}





  		$this->Source->contain(array(
  			'Feed'	=>array(
  				'fields'=>array('id', 'url', 'content_type'),
  				'Category'=>array()
  			)

  		)

  		);
  		$categories = $this->Source->Feed->News->Category->find ( 'list' );
		$this->set ('categories', $categories );
  		$data = $this->Source->find('first',array('conditions'=>array('id'=>$id)));
  		if (empty($data)) {
  			$this->Session->setFlash('No existe la fuente seleccionada');
  			$this->redirect(array('action'=>"admin_index"));
  		}else {
  			$this->data = $data;
  		}
  	}
	function admin_add() {
		$this->layout='admin';
		$this->Source->Feed->News->Category->recursive = - 1;
		$categories = $this->Source->Feed->News->Category->find ( 'list' );
		$this->set ( 'categories', $categories );
		if (!empty($this->data)) {
			if($this->FileUpload->success){
				$srcIcon = $this->FileUpload->finalFile;
			}else {
				$this->Session->setFlash($this->FileUpload->showErrors());
			}
			$data = $this->data;
			$data['Source']['icon'] = $srcIcon;
			$data['Source']['country_id'] = 1;

			$dataSource = $this->Source->getDataSource();
			$dataSource->begin($this);
			if(!$this->Source->save($data['Source'])){
				$errors = $this->Source->invalidFields();
				foreach ($errors as $key=>$value) {
					$this->set("source_{$key}_error", $value);
				}

				$dataSource->rollback($this->Source);
				return;

			}else {
				$source_id = $this->Source->getLastInsertId();
				foreach ($data['Source']['Feed'] as $row) {
					if (!empty($row['url'])) {
						$aux = array();
						$aux['Feed'] = $row;
						$aux['Feed']['source_id'] = $source_id;
						$this->Source->Feed->create($aux);
						if(!$this->Source->Feed->save()){
							$errors = $this->Source->invalidFields();
							debug($errors);
							$dataSource->rollback($this->Source->Feed);
							return;
						}
					}
				}

			}
			$dataSource->commit($this->Source->Feed);
			$dataSource->commit($this->Source);

		}

	}

}
?>