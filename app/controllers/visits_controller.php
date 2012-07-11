<?php

class VisitsController extends AppController {

var $name = 'Visits';
	var $components= array('Security','RequestHandler');
	var $uses = array('News', 'Visits');

	function beforeFilter() {
	 	$this->Security->validatePost=true;
	 	$this->Security->requirePost('IncrementaContador');
		$this->Auth->allow();
	}

	function incrementaContador($id){
		$this->autoRender=false;
		$this->layout='ajax';
		// esta funcion se ejecuta solo si se llama por post
		// y el token es válido

		if ($this->RequestHandler->isAjax()) {
			// Aumenta el contador de la noticia...
			$this->News->recursive=-1;
			$this->News->contain();
			$result = $this->News->updateAll(array('visits'=>'visits+1'),array('News.id' => $id));
		}
   }
}
?>
