<?php
class CategoriesController extends AppController {

	var $name = 'Categories';
	var $helpers = array('Js'=>array('Prototype'), 'Text', 'Cache', 'Paginator');

	var $components= array('Phptwitter.Twitter');
	var $uses = array('News','Category', 'Parameter');
	
	/*se setea el tema para mobil*/
	var $view = 'Theme';


	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('getList');
	}

	function index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}


	function getPplNews($id = null, $count = 10, $object = true){
		if (!$id) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		} else{
			$pNews = $this->News->Category->find('first', array(
				'conditions'	=>	array('Category.id'	=>	$id),
				'contain'	=>	array(
					'News'	=>	array(
						'order'	=>	'News.rating DESC, votes DESC, visits DESC, modified DESC, News.created DESC, RAND()',
						'fields'=> 'News.id,News.title,News.url',
						'limit' => $count)
					)
				)
			);
		}

		if ($object){
			return $pNews['News'];
		}else{
			$this->set('pNews',$pNews['News']);
		}
	}

	function view($id = null, $count = 20) {
		$this->set("title_for_layout","Categorías");
		$usr=$this->Auth->user();

		//$this->disableCache(); /*TODO desactivar??*/

		
		if($this->Session->check('ads')){//si existe la variable de sesión la uso
			$ads = $this->Session->read("cate_{$id}_ads");
		}else{ //sino trato de recuperarla de cache
			$ads = Cache::read ( "cate_{$id}_ads", 'vLong' );
		}
		$this->loadModel('Ad');
		if (empty($ads)){
			$this->loadModel('Ad');
			$ads = array();
			$ads[1]['data'] = $this->Ad->get(1,$id);
			$ads[1]['displayed'] = array();
			foreach ($ads[1]['data'] as $key => $value) {
			if($value['Ad']['socialnetwork']!=0){
					$aux=array();
					switch ($value['Ad']['socialnetwork']) {
						case 1: //twitter
							$tweet = $this->Twitter->showUser($value['Ad']['link']);
							$aux = array(
								'name'=>$tweet['name'],
								'nickname'=>$tweet['screen_name'],
								'image'=>$tweet['profile_image_url'],
								'text'=>$tweet['status']['text']
							);
							$ads[1]['data'][$key]['twitter']= $aux;
							if (empty($value['Ad']['snid'])){
								$this->Ad->read(null,$value['Ad']['id']);
								$this->Ad->set('snid', $tweet['id_str']);
								$this->Ad->save();
							}
						break;
						
						case 2: //facebook
							
							$facebook = FB::api("/{$value['Ad']['link']}/"); //obtengo los datos identificatorios de la cuenta
							$facebook['picture'] = "http://graph.facebook.com/{$facebook['username']}/picture/";
							$aux = array(
								'name' => $facebook['name'],
								'nickname' => $facebook['username'],
								'image'	=>	$facebook['picture'],
								'link'	=>	$facebook['link'],
								'id'	=>	$facebook['id']
							);
							
							$facebook = FB::api("/{$value['Ad']['link']}/feed");
							//debug($facebook);
							foreach ($facebook['data'] as $value) {
								
								if ($value['type']!='question' && $value['type']!='link' && $value['from']['id']==$aux['id'] && array_key_exists('message', $value) && !empty($value['message'])) {
									//debug($value['message']);
									//$aux['text']=nl2br($value['message']);
									$aux['text']=str_ireplace("\n", " ", $value['message']); 
									$aux['pubLink']=array_key_exists('actions', $value)?$value['actions'][0]['link']:$aux['link'];
									break;
								}
							}
							$ads[1]['data'][$key]['facebook']= $aux;
							
						break;
					}
					
					
				}
				$ads[1]['displayed'][$key] = rand(0, 2);
			}
			array_multisort($ads[1]['displayed'], SORT_ASC, $ads[1]['data']);
			
			$ads[2]['data'] = $this->Ad->get(2,$id);
			$ads[2]['displayed'] = array();
			foreach ($ads[2]['data'] as $key => $value) {
			if($value['Ad']['socialnetwork']!=0){
					$aux=array();
					switch ($value['Ad']['socialnetwork']) {
						case 1: //twitter
							$tweet = $this->Twitter->showUser($value['Ad']['link']);
							$aux = array(
								'name'=>$tweet['name'],
								'nickname'=>$tweet['screen_name'],
								'image'=>$tweet['profile_image_url'],
								'text'=>$tweet['status']['text']
							);
							$ads[2]['data'][$key]['twitter']= $aux;
							if (empty($value['Ad']['snid'])){
								$this->Ad->read(null,$value['Ad']['id']);
								$this->Ad->set('snid', $tweet['id_str']);
								$this->Ad->save();
							}
						break;
						
						case 2: //facebook
							
							$facebook = FB::api("/{$value['Ad']['link']}/"); //obtengo los datos identificatorios de la cuenta
							$facebook['picture'] = "http://graph.facebook.com/{$facebook['username']}/picture/";
							$aux = array(
								'name' => $facebook['name'],
								'nickname' => $facebook['username'],
								'image'	=>	$facebook['picture'],
								'link'	=>	$facebook['link'],
								'id'	=>	$facebook['id']
							);
							
							$facebook = FB::api("/{$value['Ad']['link']}/feed");
							
							foreach ($facebook['data'] as $value) {
								
								if ($value['type']!='question' && $value['type']!='link' && $value['from']['id']==$aux['id'] && array_key_exists('message', $value) && !empty($value['message'])) {
									//debug($value);
									$aux['text']=str_ireplace("\n", " ", $value['message']);
									$aux['pubLink']=array_key_exists('actions', $value)?$value['actions'][0]['link']:$aux['link'];
									break;
								}else{
									//debug("{$aux['name']} - {$value['type']} - {$value['message']}");
								}
							}
							$ads[2]['data'][$key]['facebook']= $aux;
							
						break;
					}
					
					
				}
				$ads[2]['displayed'][$key] = rand(0, 2);
			}
			
			array_multisort($ads[2]['displayed'], SORT_ASC, $ads[2]['data']);
			
			$ads[3]['data'] = $this->Ad->get(3,$id);
			$ads[3]['displayed'] = array();
			foreach ($ads[3]['data'] as $key => $value) {
				if($value['Ad']['socialnetwork']==1){
					$aux=array();
					$tweet = $this->Twitter->showUser($value['Ad']['link']);
					$aux = array(
						'name'=>$tweet['name'],
						'nickname'=>$tweet['screen_name'],
						'image'=>$tweet['profile_image_url'],
						'text'=>$tweet['status']['text']
					);
					$ads[3]['data'][$key]['twitter']= $aux;
					if (empty($value['Ad']['twtrid'])){
						$this->Ad->read(null,$value['Ad']['id']);
						$this->Ad->set('twtrid', $tweet['id_str']);
						$this->Ad->save();
					}
				}
				$ads[3]['displayed'][$key] = rand(0, 2);
			}
			array_multisort($ads[3]['displayed'], SORT_ASC, $ads[3]['data']);
			
			$ads[4]['data'] = $this->Ad->get(4,$id);
			$ads[4]['displayed'] = array();
			foreach ($ads[4]['data'] as $key => $value) {
				$ads[4]['displayed'][$key] = rand(0, 2);
			}
			
			array_multisort($ads[4]['displayed'], SORT_ASC, $ads[4]['data']);
			
			$ads[5]['data'] = $this->Ad->get(5,$id);
			//if(!empty($ads[1]['data']) || !empty($ads[2]['data'])){
				Cache::write ( "cate_{$id}_ads", $ads, 'vLong' );
			//}
		}else {
			//$ads = $this->Session->read('ads');
		}
		

		//obtengo las publicidades
		$maxAds = 2;
		$adsToShow = array();
		//publicidades en medios
		$excludedAds = array();
		if(!empty($ads[1]['data'])){
			$maxAds = count($ads[1]['data'])>=$maxAds?$maxAds:count($ads[1]['data']);
			for ($i = 0; $i < $maxAds; $i++) {
				$adsToShow[1][] = $ads[1]['data'][$i];
				$excludedAds[]=$ads[1]['data'][$i]['Ad']['id'];
				//incremento el contador de cantidad de visualizaciones
				$ads[1]['displayed'][$i]++;
			}
			if(!empty($excludedAds)){
				$this->Ad->updateAll(array('Ad.shows'=>"Ad.shows+1"), array('Ad.id'=>$excludedAds));
			}
		}else {
			$adsToShow[1] = array();
		}
		//ordeno nuevamente el array de publicidades
		array_multisort($ads[1]['displayed'], SORT_ASC, $ads[1]['data']);
		
		//publicidades en blogs
		if(!empty($ads[2]['data'])){
			$maxAds = 2;
			$maxAds = count($ads[2]['data'])>=$maxAds?$maxAds:count($ads[2]['data']);
			$i=0;
			$adsToUpdate=array();
			foreach ($ads[2]['data'] as $key => $ad) {
				if($i >= $maxAds){
					break;
				}
				if(!in_array($ad['Ad']['id'], $excludedAds)){
					$adsToUpdate[]=$ad['Ad']['id'];
					$adsToShow[2][] = $ad;
					$ads[2]['displayed'][$key]++;
					$i++;
				}	
			}
			if(!empty($adsToUpdate)){
				$this->Ad->updateAll(array('Ad.shows'=>"Ad.shows+1"), array('Ad.id'=>$adsToUpdate));
			}
		}else {
			$adsToShow[2] = array();
		}
		//ordeno nuevamente el array de publicidades
		array_multisort($ads[2]['displayed'], SORT_ASC, $ads[2]['data']);
		
		//publicidades en twitter
		if(!empty($ads[3]['data'])){
			$maxAds = count($ads[3]['data'])>=$maxAds?$maxAds:count($ads[3]['data']);
			for ($i = 0; $i < $maxAds; $i++) {
				$adsToShow[3][] = $ads[3]['data'][$i];
				//incremento el contador de cantidad de visualizaciones
				$ads[3]['displayed'][$i]++;
			}
		}else {
			$adsToShow[3] = array();
		}
		//ordeno nuevamente el array de publicidades
		array_multisort($ads[3]['displayed'], SORT_ASC, $ads[3]['data']);
		
		//publicidades en banner grande
		if(!empty($ads[4]['data'])){
			$maxAds= 1;
			$maxAds = count($ads[4]['data'])>=$maxAds?$maxAds:count($ads[4]['data']);
			for ($i = 0; $i < $maxAds; $i++) {
				$adsToShow[4][] = $ads[4]['data'][$i];
				//incremento el contador de cantidad de visualizaciones
				$ads[4]['displayed'][$i]++;
			}
		}else {
			$adsToShow[4] = array();
		}
		//ordeno nuevamente el array de publicidades
		array_multisort($ads[4]['displayed'], SORT_ASC, $ads[4]['data']);
		
		$this->Session->write("cate_{$id}_ads", $ads);

		//obtengo las publicidades a mostrar por columna
		//$newsAds = array_slice($ads['data'], 0, $adsPerColumn+1);
		//$blogsAds = array_slice($ads['data'], $adsPerColumn+1, $adsPerColumn);
		$newsAds= $adsToShow[1];
		$blogsAds=$adsToShow[2];
		$banner = $ads[4]['data'];
		$this->set('banner', $banner);

		
		
		
				$news = Cache::read ( "news{$id}", 'long' );
				if (empty($news)){
					$newsPapers = array();
					$i=0;
					$news = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 16 HOUR) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 16 HOUR)) AND News.category_id={$id}",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>1),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							//'limit'	=>	300,
							'order'	=>	"News.rating desc, News.created desc, News.visits desc, rand()"
						)
					);
					//debug($news);
					$aux=array();
					$includedIds = array();
					foreach ($news as $key=>$value) {
						/*debug($value['News']['feed_id']);
						debug($includedIds);*/
						if(!in_array($value['News']['feed_id'], $includedIds)){
							
							$includedIds[]=$value['News']['feed_id'];
							$aux[]=$value;
						}						
					}
					
					if (count($aux)<10 && count($aux)!=count($news)) {
						$aux = array_merge($aux,array_slice($news, count($aux), 10-count($aux)));
					}
					$news = array_slice($aux, 0, 8);
					Cache::write ( "news{$id}", $news, 'long' );
				}
				$shown=array();
				foreach ($news as $row) {
					$shown[]=$row['News']['id'];
				}

				//agrego publicidad en posición aleatoria
				if(!empty($newsAds)){
					array_splice($news, rand(1, 4), 0, array('Ad'=>$newsAds[0]));
					array_splice($news, rand(6, 8), 0, array('Ad'=>$newsAds[1]));
				}
				
				$this->set('news',$news);


				$blogs = Cache::read ( "blogs{$id}", 'long' );
				if (empty($blogs)){
					$blogs = array();
					$i=0;
					$blogs = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 5 DAY) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)) AND News.category_id={$id}",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>2),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							'limit'	=>	50,
							'order'	=>	"News.rating desc, News.visits desc, rand()"
						)
					);
					
					//debug($news);
					$aux=array();
					$includedIds = array();
					foreach ($blogs as $value) {
						if(!in_array($value['News']['feed_id'], $includedIds)){
							$includedIds[]=$value['News']['feed_id'];	
							$aux[]=$value;
						}						
					}
					if (count($aux)<10 && count($aux)!=count($blogs)) {
						$aux = array_merge($aux,array_slice($blogs, count($aux), 10-count($aux)));
					}
					$blogs = array_slice($aux, 0, 8);

					Cache::write ( "blogs{$id}", $blogs, 'long' );
				}

				foreach ($blogs as $row) {
					$shown[]=$row['News']['id'];
				}
				//genero el conjunto de ids para el SQL
				$this->set('shown',$shown);
				//agrego publicidad en posición aleatoria
				if (!empty($blogsAds)) {
					//$a= array_splice($blogs, rand(2,4), 0, array('Ad'=>$blogsAds[0]));
					array_splice($blogs, rand(1, 3), 0, array('Ad'=>$blogsAds[0]));
					array_splice($blogs, rand(5, 8), 0, array('Ad'=>$blogsAds[1]));
				}
				$this->set('blogs',$blogs);

				$this->Category->recursive=-1;
				$category = $this->Category->find('first', array('conditions'=>array('id'=>$id)));
				switch ($id) {
					case 3:
						$this->set("title_for_layout","Política");
						$meta = array(
							'keywords'	=>	"politica argentina,politica,pj,ucr,kirchnerismo,cfk,oposicion,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre política argentina"
						);
						$this->set('meta', $meta);
					break;
					case 4:
						$this->set("title_for_layout","Economía & Empresas");
						$meta = array(
							'keywords'	=>	"economia argentina,economia,empresas,dolar,bolsa,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre economía argentina"
						);
						$this->set('meta', $meta);
					break;
					case 7:
						$this->set("title_for_layout","Cultura & Espectáculos");
						$meta = array(
							'keywords'	=>	"cultura argentina,cultura,espectaculos,farandula,famosos,libros,agenda cultural,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre espacios culturales y noticias del espectáculo de argentina"
						);
						$this->set('meta', $meta);
					break;
					case 8:
						$this->set("title_for_layout","Deportes");
						$meta = array(
							'keywords'	=>	"deportes argentina,deportes,futbol,basquet,tenis,primera,afa,olimìadas,mundial,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre deportes en argentina"
						);
						$this->set('meta', $meta);
					break;
					case 11:
						$this->set("title_for_layout","Tecno & Ciencia");
						$meta = array(
							'keywords'	=>	"tecnologia,ciencia,iphone,apple,windows,android,diseño,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre tecnología y ciencia"
						);
						$this->set('meta', $meta);
					break;
					case 16:
						$this->set("title_for_layout","Sociedad");
						$meta = array(
							'keywords'	=>	"argentina,sociedad,sociales,policiales,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre noticias sociales en argentina"
						);
						$this->set('meta', $meta);
					break;
					
					default:
						;
					break;
				}

				//$tweets = $this->requestAction("twtr/getList/0/".($category['Category']['name']));

				$this->set('category', $category);
				//$this->set('twitters', $tweets[0]);
				//$this->set('lastTweet', $tweets[1]);

				$this->render('index');
	}

	function add() {
		$this->Category->recursive = 0;
		if (!empty($this->data)) {
			$this->Category->create();
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Category->read(null, $id);
		}
		$ads = $this->Category->Ad->find('list');
		$news = $this->Category->News->find('list');
		$this->set(compact('ads', 'news'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('Category deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Category was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function getList($parent_id=null){
		//Configure::write('debug', 0);
		$this->Category->recursive=0;
		$this->autoRender=false;
		//$list=array();
		//if (empty($parent_id)) {
		$parameters = array(
			'fields'=> array('Category.name')
		);
			$list = $this->Category->getTree();
			//debug($list);
			return $list;
		//}
		//return $list;
	}

	function propose() {
		$this->layout="ajax";

		$category = $this->data;
		$usr=$this->Auth->user();
		$this->Category->ProposedCategory->recursive=-1;
		$count = $this->Category->ProposedCategory->find('count', array('conditions'=>array('user_id'=>$usr['User']['id'], 'news_id'=>$this->data['News']['id'])));
		if ($count>0) {
			$message = "Usted ya ha propuesto una categoría para esta noticia";
			$this->set('message', $message);
			$this->render();
			return;
		}

		$data = array(
			'ProposedCategory'=>array(
				'user_id'=>$usr['User']['id'],
				'news_id'=>$this->data['News']['id'],
				'category_id'=>$this->data['Category']['id']
			)
		);
		$this->Category->ProposedCategory->set($data);
		if (!$this->Category->ProposedCategory->validates()) {
			$message = "Ha ocurrido un error al intentar guardar la propuesta. Intente nuevamente mas tarde.";
			$this->set('message', $message);
			$validation = $this->ModelName->invalidFields();
			$validation = implode(", ", $validation);
			CakeLog::write('ProposedCategory',"Error en la validación: ".$validation);
			$this->render();
			return;
		}
		$this->Category->ProposedCategory->save($data, array('validate'=>false));
		$this->set('message', "Su propuesta ha sido recibida y será analizada ante una posterior recategorización");
		$maxProposedCategories = $this->Parameter->find('first',array('conditions'=>array('key'=>"MaxProposedCategories")));
		$this->Category->ProposedCategory->recursive=-1;
		$count = $this->Category->ProposedCategory->find('count', array('conditions'=>array('news_id'=>$this->data['News']['id'], 'category_id'=>$category['Category']['id'])));
		if ($count > $maxProposedCategories) {
			$this->Category->updateProposed($this->data['News']['id'], $this->data['Category']['id']);
		}
		$this->render();
	}

	function admin_index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Category->create();
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
		$ads = $this->Category->Ad->find('list');
		$news = $this->Category->News->find('list');
		$this->set(compact('ads', 'news'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Category->read(null, $id);
		}
		$ads = $this->Category->Ad->find('list');
		$news = $this->Category->News->find('list');
		$this->set(compact('ads', 'news'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('Category deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Category was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>