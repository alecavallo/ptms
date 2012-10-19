<?php
class CategoriesController extends AppController {

	var $name = 'Categories';
	var $helpers = array('Js'=>array('Prototype'), 'Text', 'Cache', 'Paginator');

	var $components= array('Phptwitter.Twitter');
	var $uses = array('News','Category', 'Parameter', 'YoutubeFavorite');
	
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
		/*$category = $this->find('first',array('conditions'=>array('id'=>$id)));
		$this->set("title_for_layout",$category['Category']['name']);*/
		$usr=$this->Auth->user();

		//$this->disableCache(); /*TODO desactivar??*/
		$this->loadModel('Ad');	
		$ads = array();
		$ads[1]['data'] = $this->Ad->get(1);
		$displayed = array();
		foreach ($ads[1]['data'] as $row) {
			$displayed[] = $row['Ad']['id'];
		}
		
		$ads[2]['data'] = $this->Ad->get(2,0,$displayed);
		foreach ($ads[2]['data'] as $row) {
			$displayed[] = $row['Ad']['id'];
		}
		
		$ads[3]['data'] = array();
		
		$ads[4]['data'] = $this->Ad->get(4,0,$displayed, 1);
		$ads[4]['displayed'] = array();
		
		$newsAds= $ads[1]['data'];
		$blogsAds=$ads[2]['data'];
		$banner = $ads[4]['data'];
		$this->set('banner', $banner);

		
		
		
				$news = Cache::read ( "news{$id}", 'long' );
				if (empty($news)){
					$newsPapers = array();
					$i=0;
					$news = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 20 HOUR) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 20 HOUR)) AND News.category_id={$id}",
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
					
					if (count($aux) <= 12 && count($aux)!=count($news)) {
						$aux = array_merge($aux,array_slice($news, count($aux), 10-count($aux)));
					}
					$news = array_slice($aux, 0, 12);
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
					if (count($aux)<12 && count($aux)!=count($blogs)) {
						$aux = array_merge($aux,array_slice($blogs, count($aux), 10-count($aux)));
					}
					$blogs = array_slice($aux, 0, 12);

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
				$ycategory = $category; 
				switch ($id) {
					case 3:
						$this->set("title_for_layout","Política");
						//$category = "Política";
						$meta = array(
							'keywords'	=>	"politica argentina,politica,pj,ucr,kirchnerismo,cfk,oposicion,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre política argentina"
						);
						$this->set('meta', $meta);
					break;
					case 4:
						$this->set("title_for_layout","Economía & Empresas");
						//$category = "Economía & Empresas";
						$meta = array(
							'keywords'	=>	"economia argentina,economia,empresas,dolar,bolsa,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre economía argentina"
						);
						$this->set('meta', $meta);
					break;
					case 7:
						$this->set("title_for_layout","Cultura & Espectáculos");
						//$category = "Cultura & Espectáculos";
						$meta = array(
							'keywords'	=>	"cultura argentina,cultura,espectaculos,farandula,famosos,libros,agenda cultural,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre espacios culturales y noticias del espectáculo de argentina"
						);
						$this->set('meta', $meta);
					break;
					case 8:
						$this->set("title_for_layout","Deportes");
						//$category = "Deportes";
						$meta = array(
							'keywords'	=>	"deportes argentina,deportes,futbol,basquet,tenis,primera,afa,olimìadas,mundial,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre deportes en argentina"
						);
						$this->set('meta', $meta);
					break;
					case 11:
						$this->set("title_for_layout","Tecno & Ciencia");
						$ycategory['Category']['name'] = "Tecnología & Ciencia";
						$meta = array(
							'keywords'	=>	"tecnologia,ciencia,iphone,apple,windows,android,diseño,blogs,twitter,diarios",
							'description'	=> "twitters, blogs y diarios sobre tecnología y ciencia"
						);
						$this->set('meta', $meta);
					break;
					case 16:
						$this->set("title_for_layout","Sociedad");
						//$category = "Sociedad";
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
				
				/*obtengo las primeras imágenes de la semana*/
				$imgs = $this->News->Media->imgListing($id);
				$img_array=array();
				for ($i = 0; $i <= count($imgs); $i=$i+3) {
					$aux=array();
					if (array_key_exists($i, $imgs)) {
						$aux[0]=$imgs[$i];
						$url = "/medios/".Inflector::slug($imgs[$i]['Source']['name'],"-")."/noticia/{$imgs[$i]['News']['id']}-".Inflector::slug($imgs[$i]['News']['title'],"-").".html";
						$aux[0]['News']['url'] = $url;
					}
					if (array_key_exists($i+1, $imgs)) {
						$aux[1]=$imgs[$i+1];
						$url = "/medios/".Inflector::slug($imgs[$i+1]['Source']['name'],"-")."/noticia/{$imgs[$i+1]['News']['id']}-".Inflector::slug($imgs[$i+1]['News']['title'],"-").".html";
						$aux[1]['News']['url'] = $url;
					}
					if (array_key_exists($i+2, $imgs)) {
						$aux[2]=$imgs[$i+2];
						$url = "/medios/".Inflector::slug($imgs[$i+2]['Source']['name'],"-")."/noticia/{$imgs[$i+2]['News']['id']}-".Inflector::slug($imgs[$i+2]['News']['title'],"-").".html";
						$aux[2]['News']['url'] = $url;
					}
					if(!empty($aux)){
						$img_array[]=$aux;
					}
				}
				
				$this->set('images',$img_array);
				
				$vids = $this->YoutubeFavorite->getVideos(array('category'=>$category['Category']['name']));
				$vids_array=array();
				for ($i = 0; $i <= count($vids); $i=$i+3) {
					$aux=array();
					if (array_key_exists($i, $vids)) {
						$aux[0]=$vids[$i];
					}
					if (array_key_exists($i+1, $vids)) {
						$aux[1]=$vids[$i+1];
					}
					if (array_key_exists($i+2, $vids)) {
						$aux[2]=$vids[$i+2];
					}
					if(!empty($aux)){
						$vids_array[]=$aux;
					}
				}
				$this->set('videos', $vids_array);

				$this->set('category', $category);

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