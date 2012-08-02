<?php
class AdsController extends AppController {

	var $name = 'Ads';
	var $helpers = array('Ajax', 'Javascript', 'AjaxUpload');
	var $components = array('RequestHandler');
	var $paginate = array(
		'limit' => 25,
		'contain'	=>	array('Category'),
		'order' => array(
			'Ad.name' => 'asc'
		)
	);

	function index() {
		$this->Ad->recursive = 0;
		$this->set('ads', $this->paginate());
	}


	function click($id){
		if($this->RequestHandler->isAjax()){
			$this->layout='ajax';
			$this->autoRender=false;
		}else {
			$this->cakeError('error404');
		}
		$clickList = Cache::read('clicklist', 'long');
		debug($clickList);
		if(empty($clickList)){
			$clickList = array();
		}
		$count = 0;
		foreach ($clickList as $row) {
			if ($id == $row['adId'] && $_SERVER['HTTP_USER_AGENT'] == $row['browser'] && $_SERVER['REMOTE_ADDR'] == $row['ip'] && $count >= 5) {
				return 0;
				break;
			}elseif($id == $row['adId'] && $_SERVER['HTTP_USER_AGENT'] == $row['browser'] && $_SERVER['REMOTE_ADDR'] == $row['ip'] && $count < 5){
				$count++;
			}
		}

		$clickList[] = array(
			'browser' => $_SERVER['HTTP_USER_AGENT'],
			'ip'	=>	$_SERVER['REMOTE_ADDR'],
			'adId'	=>	$id
		);
		
		$this->Ad->updateAll(array('Ad.clicks'=>"Ad.clicks+1"), array('Ad.id'=>$id));		
		Cache::write('clicklist', $clickList, 'long');
		//debug($_SERVER);
		return 1;
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ad', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ad', $this->Ad->read(null, $id));
	}

	function add() {
		$this->flash("Acción no válida", "/");
		return;
		if (!empty($this->data)) {
			$this->Ad->create();
			if ($this->Ad->save($this->data)) {
				$this->Session->setFlash(__('The ad has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ad could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Ad->Category->find('list');
		$this->set(compact('categories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ad', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Ad->save($this->data)) {
				$this->Session->setFlash(__('The ad has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ad could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Ad->read(null, $id);
		}
		$categories = $this->Ad->Category->find('list');
		$this->set(compact('categories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ad', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ad->delete($id)) {
			$this->Session->setFlash(__('Ad deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ad was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->layout="admin";
		$data = $this->paginate();
		//debug($data);
		$this->set('ads', $data);
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ad', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ad', $this->Ad->read(null, $id));
	}

	function admin_tmpUpload(){
		$this->layout='ajax';
		$this->autoRender=false;

		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		App::import('Vendor', 'ajaxuploader/php');
		$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
		// max file size in bytes
		$sizeLimit = 10 * 1024 * 1024;
		
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload(WWW_ROOT.DS.'img'.DS."ads".DS."tmp".DS);
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);		
	}
	
	function admin_add() {
		$this->layout="admin";
		if (!empty($this->data)) {
			//debug($this->data); die('puta carajo!');
			if($this->data['Ad']['socialnetwork']==0){
				$filename = explode("/", $this->data['Ad']['url'][1]);
				$filename = end($filename);
				switch ($this->data['Ad']['priority']) {
					case 1:
						$width=380;
						$height=124;
						$folderName = WWW_ROOT."img".DS."ads".DS."small_293";
						$url = "ads".DS."small_293";
						
					break;
					case 2:
						$width=380;
						$height=124;
						$folderName = WWW_ROOT."img".DS."ads".DS."small_293";
						$url = "img".DS."ads".DS."small_293";
					break;
					case 3:
						$width=380;
						$height=124;
						$folderName = WWW_ROOT."img".DS."ads".DS."small_293";
						$url = "ads".DS."small_293";
					break;
					case 4:
						$width= 1220;
						$height=144;
						$folderName = WWW_ROOT."img".DS."ads".DS."large";
						$url = "ads".DS."large";
					break;
					
					default:
						$width=380;
						$height=124;
						$folderName = WWW_ROOT."img".DS."ads".DS."small_293";
						$url = "ads".DS."small_293";
					break;
				}
				$url = $url.DS.$filename;
				if (file_exists($folderName.DS.$filename)) {
					$this->Session->setFlash("El archivo ya existe. Ingrese uno con un nombre distinto");
					debug("El archivo ya existe. Ingrese uno con un nombre distinto");
					$categories = $this->Ad->Category->find('list');
					$this->set(compact('categories'));
					return;
				}
				$img = getimagesize(WWW_ROOT.DS.$this->data['Ad']['url'][1]);
				switch ($img['mime']) {
					case 'image/png':
						$dst = imagecreatetruecolor($width, $height);
						$orig = imagecreatefrompng(WWW_ROOT.DS.$this->data['Ad']['url'][1]);
					break;
					case 'image/jpeg':
						$dst = imagecreatetruecolor($width, $height);
						$orig = imagecreatefromjpeg(WWW_ROOT.DS.$this->data['Ad']['url'][1]);
					break;
					case 'image/gif':
						$dst = imagecreatetruecolor($width, $height);
						$orig = imagecreatefromgif(WWW_ROOT.DS.$this->data['Ad']['url'][1]);
					break;
					
					default:
						$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
						debug("No se pudo modificar el tamaño de la imágen");
						unlink(WWW_ROOT.DS.$this->data['Ad']['url'][1]);
						return;
					break;
				}
				
				if ($img[0] != $width || $img[1] != $height) {
					if(!imagecopyresampled($dst, $orig, 0, 0, 0, 0, $width, $height, $img[0], $img[1])){
						$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
						debug("No se pudo modificar el tamaño de la imágen");
					}else {
						
						switch ($img['mime']) {
							case 'image/png':
								if(imagepng($dst,$folderName.DS.$filename)){
									$this->Session->setFlash("La imágen se ha guardado correctamente");
								}else {
									$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
									debug("No se pudo modificar el tamaño de la imágen");
								}
							break;
							case 'image/jpeg':
								if(imagejpeg($dst,$folderName.DS.$filename)){
									$this->Session->setFlash("La imágen se ha guardado correctamente");
								}else {
									$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
									debug("No se pudo modificar el tamaño de la imágen");
								}
							break;
							case 'image/gif':
								if(imagegif($dst,$folderName.DS.$filename)){
									$this->Session->setFlash("La imágen se ha guardado correctamente");
								}else {
									$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
									debug("No se pudo modificar el tamaño de la imágen");
								}
							break;
							
							default:
								$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
								debug("No se pudo modificar el tamaño de la imágen");
								unlink(WWW_ROOT.DS.$this->data['Ad']['url'][1]);
							break;
						}
						
					}
				
				}else {
					if (rename(WWW_ROOT.DS.$this->data['Ad']['url'][1], $folderName.DS.$filename)) {
						$this->Session->setFlash("La imágen se ha guardado correctamente");
					}else {
						$this->Session->setFlash("No se ha podido guardar la imágen");
						debug("No se ha podido guardar la imágen");
					}
				}
				//elimino el archivo temporal
				unlink(WWW_ROOT.DS.$this->data['Ad']['url'][1]);
				
				$this->data['Ad']['url'] = $url; 
			}

			$this->data = Sanitize::clean($this->data, array('odd_spaces'=>true, 'encode'=>true, 'dollar'=>true, 'carriage'=>true, 'unicode'=>true, 'escape'=>true, 'remove_html'=>true));
			$this->Ad->create();
			
			if ($this->Ad->saveAll($this->data)) {
				$this->Session->setFlash(__('La publicidad se ha guardado correctamente', true));
				//$this->redirect(array('action' => 'index'));
				$this->data=null;
			}else{
				debug($this->Ad->invalidFields());
				$this->Session->setFlash(__('La publicidad no pudo ser guardada. Contacte al administrador del sistema', true));
				unlink($folderName.DS.$filename);
			}
		}
		$categories = $this->Ad->Category->find('list');
		$this->set('categories', $categories);
	}

	function admin_edit($id = null) {
		$this->layout="admin";
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('La publicidad no existe', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Ad->save($this->data)) {
				$this->Session->setFlash(__('La publicidad se ha guardado correctamente', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La publicidad no se ha podido guardar...', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Ad->read(null, $id);
		}
		$categories = $this->Ad->Category->find('list');
		$this->set(compact('categories'));
		$this->render('admin_add');
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('La publicidad que intenta borrar no existe', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ad->delete($id)) {
			$this->Session->setFlash(__('La publicidad se ha borrado correctamente', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('No se ha podido borrar la publicidad', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>