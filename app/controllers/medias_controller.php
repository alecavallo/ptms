<?php
class MediasController extends AppController {

	var $name = 'Medias';
	var $helpers = array('Ajax', 'Text', 'Js' => array('Prototype'), 'Paginator');
	var $components = array('RequestHandler');
	var $paginate = array(
		'limit' => 1,
		'update' => "wimage"
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index','getPagImages', 'getPagVideos');
	}
	function index($categoryId=0) {
		//debug($this->params);
		//obtengo el número de página para agregarlo al nombre del cache
		$this->set('categoryId',$categoryId);
		$page = empty($this->params['named']['page'])?0:$this->params['named']['page'];
		$cacheConfig = "short";
		$cacheName = "imageSlideshow-{$page}";
		if($categoryId!=0){
			$categoryConditions = "AND News.category_id={$categoryId}";
			$cacheName = "imageSlideshow-{$categoryId}-{$page}";
		}else {
			$categoryConditions="";
			$cacheName = "imageSlideshow-{$page}";
		}
		if (($data = Cache::read ( $cacheName, $cacheConfig )) === false|| true) {
			
			$this->paginate = array(
				'limit'	=>	1,
				'fields'	=>	array('Media.id', 'Media.url', 'Media.news_id'),
				'conditions'	=> array('Media.type'=>1),
				'contain'	=>	array(
					'News'	=>	array(
						'fields'	=> array('News.id', 'News.title','News.rating', 'News.visits', 'News.votes', 'News.user_id', 'News.link'),
						'conditions'	=>	"News.created > DATE_SUB(NOW(),INTERVAL 7 DAY) ".$categoryConditions,
						'Category'	=>	array(
							//'conditions'=>$categoryConditions
						),
						'User'	=>	array(
							'fields'	=>	array('User.id', 'User.alias', 'User.first_name', 'User.rating')
						)
					),
				),
				'order'	=>	array('News.created'	=> 'desc')
			);
	
			$data = $this->paginate('Media');
			//debug($data);
			Cache::write ( $cacheName, $data, $cacheConfig );
		}

		if (!isset($this->params['requested'])) {
			$this->layout = 'ajax';
			if ($this->RequestHandler->isAjax()) {

			}
			$this->set(compact('data'));
			$this->set('paging', $this->params['paging']);
		}else {
			$this->autorender = false;
			return array('data'=>$data, 'paging'=>$this->params['paging']);
		}
	}

	function getPagImages($id){
		//$paginate = array('Media' => array('limit' => 1));
		$this->autoRender = false;
		$this->Media->contain('News');
		$this->paginate = array('Media' => array('limit' => 1));
		if (!isset($this->params['requested'])) { //si no es llamado por otro controlador, chequeo si viene por ajax
			if ($this->RequestHandler->isAjax()) {
				$this->set('tabID', 'fotos');
				$this->set('newsId', $id);
				$images = $this->paginate('Media', array("Media.news_id" => $id, "Media.type"=> PHOTO));
				$this->set('media', $images);
				$this->render("paginated");
			}
		}else { //si es llamado usando requestAction retorno el array que devuelve el paginador

			$ret = $this->paginate('Media', array("Media.news_id" => $id, "Media.type"=> PHOTO));
			$paginatorData = array('Image'=>$this->params['paging']['Media']);
			return array('data'=>$ret,'paginatorData'=>$paginatorData);
		}

	}
	function getPagVideos($id){
		$this->autoRender = false;
		$this->Media->contain('News');
		$this->paginate = array('Media' => array('limit' => 1));
		if (!isset($this->params['requested'])) { //si no es llamado por otro controlador, chequeo si viene por ajax
			if ($this->RequestHandler->isAjax()) {
				$this->set('tabID', 'videos');
				$this->set('newsId', $id);
				$videos = $this->paginate('Media', array("Media.news_id" => $id, "Media.type"=> VIDEO));
				//$paginatorData = array('Video'=>$this->params['paging']['Media']);
				//$this->params = $paginatorData;
				//debug($this->params);
				$this->set('media', $videos);
				$this->render("paginated");
			}
		}else { //si es llamado usando requestAction retorno el array que devuelve el paginador
			$ret = $this->paginate('Media', array("Media.news_id" => $id, "Media.type"=> VIDEO));
			$paginatorData = array('Video'=>$this->params['paging']['Media']);
			return array('data'=>$ret,'paginatorData'=>$paginatorData);
		}
	}
	function getPagAudios(){

	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('image', $this->Media->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Media->create();
			if ($this->Media->save($this->data)) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
			}
		}
		$news = $this->Media->News->find('list');
		$this->set(compact('news'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Media->save($this->data)) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Media->read(null, $id);
		}
		$news = $this->Media->News->find('list');
		$this->set(compact('news'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for image', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Media->delete($id)) {
			$this->Session->setFlash(__('Image deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Media->recursive = 0;
		$this->set('images', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('image', $this->Media->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Media->create();
			if ($this->Media->save($this->data)) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
			}
		}
		$news = $this->Media->News->find('list');
		$this->set(compact('news'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Media->save($this->data)) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Media->read(null, $id);
		}
		$news = $this->Media->News->find('list');
		$this->set(compact('news'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for image', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Media->delete($id)) {
			$this->Session->setFlash(__('Image deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>