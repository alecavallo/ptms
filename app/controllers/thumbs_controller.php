<?php
class ThumbsController extends AppController {

	var $name = 'Thumbs';
	var $components = array('WebThumb');
	var $uses = array();



	function get(){
		$this->autoRender=false;
		$this->layout='ajax';

		if ($this->RequestHandler->isAjax()) {
			//debug($this->params);
			$url = $this->params['form'][0];
			//debug($url);
			$rand = rand(1, 1000);
			$SaveFileAs = WWW_ROOT.DS.'img'.DS.'tmp'.DS."screenshot{$rand}.jpg";
			if (!$this->WebThumb->getAndSave($SaveFileAs,$url)) {
				return false;
	        }else {
	        	return "/img/tmp/screenshot{$rand}.jpg";
	        }
		}else {
			$this->cakeError('404');
		}


	}
}
?>