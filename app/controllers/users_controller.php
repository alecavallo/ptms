<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('User','UserRequest', 'Feed');
	var $helpers = array('Text', 'Cache', 'Ajax', 'Session', 'Html', 'Js' => array('Prototype'), 'Menu', 'Jqautocomplete');
	//var $components = array('RequestHandler', 'Localize', 'Session', 'Facebook.Connect'=>array('createUser'=>false),'Auth'=>array('authorize'=>'controller','loginRedirect'=>array('controller' => 'news', 'action' => 'index')));
	var $components = array('Email','RequestHandler');
	var $view = 'Theme';

	function getUsername($alias){
		header('Content-type: application/json');
		header('Cache-Control: public, max-age=3600, s-maxage=3600');
		header('Pragma: public');
		//$this->layout='ajax';
		$this->autoLayout=false;
		$this->autoRender=false;
		$ret = Cache::read ( "un".$alias, 'usernames' );
		if (empty($ret)){
			$this->User->recursive = -1;
			$ret = $this->User->find('first',
				array(
					'conditions'=>array('alias'=>$alias),
					'fields'	=>	array('User.first_name','User.last_name','User.avatar')
				)
			);
			Cache::write ( "un".$alias, $ret, 'usernames' );
		}
		
		return json_encode($ret);
		
	}
	function beforeFilter() {
		parent::beforeFilter();
        $this->Auth->allow('register','invite');

    }

    function getAll($limit=null){
    	$this->autoRender=false;
    	$this->layout = 'ajax';
    	header('Content-type: application/json');
    	header('Charset: utf-8');
    	$this->User->recursive = -1;
    	$usrs = $this->User->usersWithNews();
    		//debug($usrs);
    	echo json_encode($usrs);
    }
	function login(){
		$this->layout="default";
		if($this->Connect->user()){
			if ($this->Connect->hasAccount) {
				$this->User->contain('City.State.Country');
				$this->data = $this->User->findByFacebookId($this->Connect->user('id'));
			}else {
				$this->data = $this->User->findByEmail($this->Connect->user('email'));
				if (empty($this->data['User']['id'])) {
					return false;
				}
				$this->User->id=$this->data['User']['id'];
				$this->User->saveField('facebook_id',$this->Connect->user('id'));
			}
		}

		if (!empty($this->data)) {
			//$this->data['User']['password'] = sha1($this->data['User']['password']);
			$this->data['User']['password_confirm'] = $this->Auth->password($this->data['User']['password']);
			$this->User->contain('City.State.Country');
			$usr = $this->User->find('first',array('conditions'=>array('email'=>$this->data['User']['email'],'password'=>$this->data['User']['password'])));
			if (!empty($usr)) {
				$redirect = $this->Session->read('Auth.redirect');
				if (empty($redirect)) {
					$redirect = $this->Auth->loginRedirect;
				}

				$this->Session->write('City.City',$usr['City']);
				//$this->Cache->clearCache();
				$this->redirect($redirect);
			}
		}else {
			return false;
		}
	}

	function admin_login() {
		$this->redirect("/users/login",302);
	}

	function logout(){
		$this->Auth->logout();
		$this->Session->delete('City');
		$this->redirect(Router::url("/",true));
	}

	function index($order="1-1") {
		$this->set("title_for_layout","Columnas & Pendientes");
		$meta = array(
			'keywords'	=>	"usuarios, columnistas,columnas,pendientes,ultimas noticias,periodismo ciudadano,blogs",
			'description'	=> "todas las noticias que podrían llegar a portada y los columnistas mas populares del sitio"
		);
		$this->set('meta', $meta);
		switch ($order){
			case '1-1':
				$order = "User.rating desc";
				break;
			case '11':
				$order	= "User.rating asc";
				break;
			case '21':
				$order = "User.first_name asc";
				break;
			case '2-1':
				$order = "User.first_name desc";
				break;
		}
		$this->User->recursive = 0;
		$this->paginate = array(
			'limit'	=>	7,
			'order'	=>	$order
		);
		$this->set('users', $this->paginate());
		$this->User->News->Category->recursive = -1;
		$categories = $this->User->News->Category->find('all');
		$this->set('categories', $categories);
		if ($this->RequestHandler->isAjax()) {
			$this->layout="ajax";
			$this->render('usr_list');
		}else{
			$this->render('index');
		}
	}

	function invite(){
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}
		$data = array(
			'UserRequest'=>array(
				'email'=>$this->data['User']['email']
			)
		);

		$this->layout = 'ajax';
		$this->disableCache();
		$count = $this->User->find('count',array('conditions'=>array('email'=>$this->data['User']['email'])));
		if ($count > 0) {
			$ok=false;
			$msg = __('No es posible asignarle un usuario. El email ya existe',true);
		}else {
			$ok=true;
			$save = $this->UserRequest->save($data);
			if (!$save) {
				$ok=false;
				$msg = $this->UserRequest->invalidFields();
				$msg = __($msg['email'],true);
			}else{
				$this->Email->delivery = 'mail';
				//$this->Email->delivery = 'smtp';
				$this->Email->from    = 'Posteamos <noreply@posteamos.com>';
				$this->Email->replyTo = 'Info <info@posteamos.com>';
				$this->Email->to      = $this->data['User']['email'];
				$this->Email->bcc = array('Info <info@posteamos.com>');
				$this->Email->subject = __("Bienvenido a Posteamos.com!",true);
				$this->Email->template = 'invite';
				$this->Email->sendAs = 'both';
				$this->set('usrMail',$this->data['User']['email']);
				$this->Email->send();

				$msg = __('El pedido ha sido enviado satisfactoriamente.<br/>A la brevedad estaremos enviándole las credenciales de acceso.',true);
			}
		}
		$this->set('msg',$msg);
		$this->set('ok',$ok);
	}

	function view($alias = null) {
		if (!$alias) {
			$this->Session->setFlash(__('El usuario no existe', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$user = $this->User->find('first', array(
			'conditions'=>array('User.alias'=>$alias),
			'contain'	=>	array(
				'City'	=>	array(
					'State'	=>	array()
				),
				'Source'	=>	array()
			)
		));
		
		$id = $user['User']['id'];
		/*$news = $this->User->News->find('all',array(
			'fields'	=>	array('News.id', 'News.title', 'News.summary', 'News.created', 'News.visits', 'News.votes', 'News.link'),
			'conditions'	=>	array('News.user_id'=>$id),
			'limit'	=>	7,
			'contain'	=>	array(
				'Category'	=>	array(
					'fields'	=>	array('Category.id','Category.name')
				),
				'Feed'	=>	array(),
			)
		));*/
		//debug($news);
		$news = $this->User->News->usersNew($id);

		
		//debug($news);
		$this->set('user', $user);
		$this->set('news', $news);
	}

	function register() {
		if (!empty($this->data)) {
			/*$city = $this->params['form']['as_values_city'];
			$city = substr($city, 0, -1);*/
			$this->data['User']['city_id']=null;
			/*encode password*/
			$this->data['User']['password_confirm'] = $this->Auth->password($this->data['User']['password_confirm']);
			$this->User->set($this->data);

			if($this->User->validates()){
				if (!empty($this->data['User']['avatar']['tmp_name'])) {
					$target = 60;
					$folderName = WWW_ROOT."img".DS."avatars";
					$filename = time().$this->data['User']['avatar']['name'];
					$filename = explode(".", $filename);
					$filename = $filename[0].".jpg";
					$tmpFile = $this->data['User']['avatar']['tmp_name'];
					$img = getimagesize($tmpFile);//obtengo datos de imagen
					//debug($img);
					$width = $img[0];
					$height = $img[1];
					if ($width > $height) {
						$percentage = ($target / $width);
					} else {
						$percentage = ($target / $height);
					}
					//obtengo nuevos valores ancho y alto de la imagen
					$width = round($width * $percentage);
					$height = round($height * $percentage);
					switch ($img['mime']) {//cargo en memoria imagen origen y destino
						case 'image/png':
							$dst = imagecreatetruecolor($width, $height);
							$orig = imagecreatefrompng($tmpFile);
						break;
						case 'image/jpeg':
							$dst = imagecreatetruecolor($width, $height);
							$orig = imagecreatefromjpeg($tmpFile);
						break;
						case 'image/gif':
							$dst = imagecreatetruecolor($width, $height);
							$orig = imagecreatefromgif($tmpFile);
						break;
						
						default:
							$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
							debug("No se pudo modificar el tamaño de la imágen");
							unlink($this->data['User']['avatar']['tmp_name']);
							return;
						break;
					}
					if(!imagecopyresampled($dst, $orig, 0, 0, 0, 0, $width, $height, $img[0], $img[1])){
						//$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
						debug("No se pudo modificar el tamaño de la imágen");
					}else {
						//debug($folderName.DS.$filename);
						if(imagejpeg($dst,$folderName.DS.$filename)){
							//$this->Session->setFlash("La imágen se ha guardado correctamente");
						}else {
							//$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
							debug("No se pudo modificar el tamaño de la imágen");
						}
					}
					$avatarUrl = str_ireplace(WWW_ROOT, '', $folderName.DS.$filename);
					$avatarUrl = str_ireplace("\\", "/", $avatarUrl);
					$this->data['User']['avatar'] = $avatarUrl;
				}else{
					$this->data['User']['avatar'] = "";
				}
			
			}else{
				$this->Session->setFlash("El archivo que intenta subir no es una imagen");
				debug($this->User->invalidFields());
				return ;
			}

			$this->data['User']['registered']=1;
			$this->User->create();
			if ($this->User->save($this->data, array('validate'=>false))) {
				$this->Session->setFlash(__('Bienvenido a posteamos! Por favor, introduzca su usuario y contraseña para comenzar a compartir!', true));
				$this->redirect(array('controller'=>"news",'action' => 'index'));
			} else {
				debug('no puedo grabar!');
				debug($this->data);
				$this->Session->setFlash(__('No se puede crear el usuario. Por favor revise los datos ingresados e intente nuevamente.', true));
			}
		}
	}

	function edit($id = null) {
		$loggedUser = $this->Auth->user();
		if ($loggedUser['User']['id'] != $id) {
			$this->cakeError('404');
		} 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		if (!empty($this->data['User']['avatar']['tmp_name'])) {
					$target = 60;
					$folderName = WWW_ROOT."img".DS."avatars";
					$filename = time().$this->data['User']['avatar']['name'];
					$filename = explode(".", $filename);
					$filename = $filename[0].".jpg";
					$tmpFile = $this->data['User']['avatar']['tmp_name'];
					$img = getimagesize($tmpFile);//obtengo datos de imagen
					//debug($img);
					$width = $img[0];
					$height = $img[1];
					if ($width > $height) {
						$percentage = ($target / $width);
					} else {
						$percentage = ($target / $height);
					}
					//obtengo nuevos valores ancho y alto de la imagen
					$width = round($width * $percentage);
					$height = round($height * $percentage);
					switch ($img['mime']) {//cargo en memoria imagen origen y destino
						case 'image/png':
							$dst = imagecreatetruecolor($width, $height);
							$orig = imagecreatefrompng($tmpFile);
						break;
						case 'image/jpeg':
							$dst = imagecreatetruecolor($width, $height);
							$orig = imagecreatefromjpeg($tmpFile);
						break;
						case 'image/gif':
							$dst = imagecreatetruecolor($width, $height);
							$orig = imagecreatefromgif($tmpFile);
						break;
						
						default:
							$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
							debug("No se pudo modificar el tamaño de la imágen");
							unlink($this->data['User']['avatar']['tmp_name']);
							return;
						break;
					}
					if(!imagecopyresampled($dst, $orig, 0, 0, 0, 0, $width, $height, $img[0], $img[1])){
						//$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
						debug("No se pudo modificar el tamaño de la imágen");
					}else {
						//debug($folderName.DS.$filename);
						if(imagejpeg($dst,$folderName.DS.$filename)){
							//$this->Session->setFlash("La imágen se ha guardado correctamente");
						}else {
							//$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
							debug("No se pudo modificar el tamaño de la imágen");
						}
					}
					/*$avatarUrl = str_ireplace(WWW_ROOT, '', $folderName.DS.$filename);
					$avatarUrl = str_ireplace("\\", "/", $avatarUrl);
					$this->data['User']['avatar'] = $avatarUrl;*/
				}else{
					$this->data['User']['avatar'] = null;
				}
				debug($this->data['User']['avatar']);
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El usuario no puede ser guardado. Intente nuevamente mas tarde', true));
				debug($this->User->invalidFields());
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$cities = $this->User->City->find('list');
		$this->set(compact('cities'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->User->find('all'));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		$cities = $this->User->City->find('list');
		$this->set(compact('cities'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$cities = $this->User->City->find('list');
		$this->set(compact('cities'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>