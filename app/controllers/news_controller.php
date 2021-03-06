<?php
App::import('Sanitize');

class NewsController extends AppController {
	const write=1;
	const options=2;
	const preview=3;
	const publish=4;

	var $name = 'News';
	var $uses = array('News','LastPost', 'User', 'Vote','Parameter', 'ExcludedWord', 'YoutubeFavorite');
	var $components= array(/*'Security',*/'Phptwitter.Twitter','RequestHandler','Session','Auth', 'Twitter.Twitter');
	var $helpers = array('Text', 'Js' => array('Prototype'), 'Form', 'Paginator', 'Session');
	var $paginate = array('limit' => 1);
	
	/*se setea el tema para mobil*/
	var $view = 'Theme';

	function beforeFilter() {
		parent::beforefilter();
		
		if (!$this->Session->check('User.struct_home')) {
			//$this->Session->write('User.struct_home', true);
		}
	}

function getComment(){
		
		$this->autoRender=false;
		$this->layout='ajax';
		$txt = <<<SCR
<script>
var idcomments_acct = '19f7342c71062346f906e674904d040b';
var idcomments_post_id;
var idcomments_post_url;
</script>
<script type="text/javascript" src="http://www.intensedebate.com/js/genericLinkWrapperV2.js"></script>
SCR;
		echo $txt;
	}
	
	function index() {
		$this->set("title_for_layout","Portada - twitter, medios y blogs");
		$this->helpers[] = 'Cache';

		
		$usr=$this->Auth->user();

		//$this->disableCache(); //TODO desactivar??
		
		
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

		/*debug($newsAds);
		debug($blogsAds);
		debug($ads['data']);*/


				$newsPapers = Cache::read ( "newsPapers", 'long' );
				if (empty($newsPapers)){
				$newsPapers = $this->News->getHomeNews();
				$newsPapers = array_slice($newsPapers, 0, 12);
				//debug($newsPapers);
				shuffle($newsPapers);
				Cache::write ( "newsPapers", $newsPapers, 'long' );
				}
				//debug($newsPapers);
				
				//agrego publicidad en posición aleatoria
				if(!empty($newsAds)){
					$pos = rand(1, 4);
					$items = array($newsAds[0]);
					array_splice($newsPapers, $pos, 0, $items);
					$pos = rand(6, 8);
					$items = array($newsAds[1]);
					array_splice($newsPapers, $pos, 0, $items);
				}
				//debug(count($newsPapers));
				$this->set('news',$newsPapers);
				//debug($newsPapers);
				


				$blogs = Cache::read ( "blogs", 'long' );
				if (empty($blogs)){
					$excludedSources=array(-1,0); //almaceno las fuentes que ya mostre
					$blogs = array();
					$i=0;
					$blogsPol = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 4 DAY) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)) AND News.category_id=3",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>2, 'Feed.source_id not'=>$excludedSources),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							'limit'	=>	2,
							'order'	=>	"News.rating desc, News.visits desc",
							'group'	=>	"News.feed_id"
						)
					);
					//debug($blogsPol);
					
					foreach ($blogsPol as $row) {
						if (!in_array($row['Feed']['source_id'], $excludedSources)) {
							$excludedSources[]=$row['Feed']['source_id'];
						}
					}
					
					$blogsEcono = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 4 DAY) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)) AND News.category_id=4",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>2, 'Feed.source_id not'=>$excludedSources),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							'limit'	=>	2,
							'order'	=>	"News.rating desc, News.visits desc",
							'group'	=>	"News.feed_id"
						)
					);
					foreach ($blogsEcono as $row) {
						if (!in_array($row['Feed']['source_id'], $excludedSources)) {
							$excludedSources[]=$row['Feed']['source_id'];
						}
					}
					$blogsCult = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 4 DAY) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)) AND News.category_id=7",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>2, 'Feed.source_id not'=>$excludedSources),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							'limit'	=>	2,
							'order'	=>	"News.rating desc, News.visits desc",
							'group'	=>	"News.feed_id"
						)
					);
					foreach ($blogsCult as $row) {
						if (!in_array($row['Feed']['source_id'], $excludedSources)) {
							$excludedSources[]=$row['Feed']['source_id'];
						}
					}
					$blogsDepo = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 4 DAY) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)) AND News.category_id=8",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>2, 'Feed.source_id not'=>$excludedSources),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							'limit'	=>	2,
							'order'	=>	"News.rating desc, News.visits desc",
							'group'	=>	"News.feed_id"
						)
					);
					foreach ($blogsDepo as $row) {
						if (!in_array($row['Feed']['source_id'], $excludedSources)) {
							$excludedSources[]=$row['Feed']['source_id'];
						}
					}
					$blogsTecno = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 4 DAY) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)) AND News.category_id=11",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>2, 'Feed.source_id not'=>$excludedSources),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							'limit'	=>	2,
							'order'	=>	"News.rating desc, News.visits desc",
							'group'	=>	"News.feed_id"
						)
					);
					foreach ($blogsTecno as $row) {
						if (!in_array($row['Feed']['source_id'], $excludedSources)) {
							$excludedSources[]=$row['Feed']['source_id'];
						}
					}
					$blogsSoc = $this->News->find('all',array(
							'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 4 DAY) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)) AND News.category_id=16",
							'contain'	=>	array(
								'Feed'	=>	array(
									'conditions'	=>	array('Feed.content_type'=>2, 'Feed.source_id not'=>$excludedSources),
									'Source'	=>	array(
										'conditions'	=>	array("Source.country_id"=>1)
									)
								),
								'Category'	=>	array(),
								'User'		=>	array(),
								'Media'		=>	array()
							),
							'limit'	=>	2,
							'order'	=>	"News.rating desc, News.visits desc",
							'group'	=>	"News.feed_id"
						)
					);

					$i=0;
					while ($i < 12){
						$j = rand(0, 5);
						$aux = null;
						switch ($j) {
							case 0:
								$aux = array_shift($blogsPol);
							break;
							case 1:
								$aux = array_shift($blogsEcono);
							break;
							case 2:
								$aux = array_shift($blogsCult);
							break;
							case 3:
								$aux = array_shift($blogsDepo);
							break;
							case 4:
								$aux = array_shift($blogsTecno);
							break;
							case 5:
								$aux = array_shift($blogsSoc);
							break;

							default:
								$aux = null;
							break;
						}

						if (!empty($aux)) {
							$blogs[]=$aux;
							$i ++;
						}
						if (empty($blogsCult) && empty($blogsDepo) && empty($blogsEcono) && empty($blogsPol) && empty($blogsSoc) && empty($blogsTecno)) {
							break;
						}
					}
					Cache::write ( "blogs", $blogs, 'long' );
				}
				
				
				//agrego los blogs mostrados en portada
				$shown = array();
				foreach ($blogs as $row) {
					$shown[]=$row['News']['id'];
				}
				
				//genero el conjunto de ids para el SQL
				$this->set('shown',$shown);
				
				$blogs = array_slice($blogs, 0,12);
				//agrego publicidad en posición aleatoria
				if (!empty($blogsAds)) {
					$pos = rand(1, 3);
					$items = array($blogsAds[0]);
					array_splice($blogs, $pos, 0, $items);
					$pos = rand(5, 8);
					$items = array($blogsAds[1]);
					array_splice($blogs, $pos, 0, $items);
				}
				
				$this->set('blogs',$blogs);
				//debug($blogs);
				$tweets = $this->requestAction(array('controller'=>"twtr",'action'=>"getTimeline"));
				
				/*obtengo las primeras imágenes de la semana*/
				$img_array = Cache::read ( "images", 'long' );
				if($img_array===false){
					$imgs = $this->News->Media->imgListing(0, 60);
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
					Cache::write ( "images", $img_array, 'long' );
				}
				
				$this->set('images',$img_array);
				
				
				$vids = $this->YoutubeFavorite->getVideos();
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
				
				
				$this->set('twitters', $tweets[0]);
				$this->set('lastTweet', $tweets[1]);
				$this->render('index');
	}
	
	function marquee($excludedNews=array(0), $page=1, $type=0, $category=0){
		header('Content-type: application/json');
		$this->layout = 'ajax';
		$this->autoRender = false;
		if ($excludedNews[0]==0) {
			$excludedNews = unserialize($_POST['excludedNews']);
			$page = $_POST['page'];
		}
		if (array_key_exists('category', $_POST)&& !empty($_POST['category'])) {
			$category = unserialize($_POST['category']);
			$category = mysql_real_escape_string($category);
			$categoryCond = "and News.category_id = {$category}";
		}else {
			$categoryCond="";
		}
		
		
		$shown = "(".implode(",", $excludedNews).")";
		$shown = mysql_real_escape_string($shown);
		//obtengo noticias a mostrarse en marquesina
		$marquee =  Cache::read ( "marqueeOtherNews{$category}", 'long' );
		if (empty($marquee)) {
			$marquee = $this->News->find('all',array(
					//'fields'	=>	array('id', 'title', 'rating', 'visits', 'created', 'feed_id', 'link'),
					'fields'	=>	array('id', 'title', 'feed_id', 'link'),
					'conditions'=>"(News.created >= DATE_SUB(CURDATE(), INTERVAL 12 HOUR) or News.modified >= DATE_SUB(CURDATE(), INTERVAL 12 HOUR)) AND News.id not in {$shown} {$categoryCond}",
					'contain'	=>	array(
						'Feed'	=>	array(
							'fields'	=>	array('id','source_id', 'image_url'),
							//'conditions'	=>	array('Feed.content_type'=>1),
							'Source'	=>	array(
								'fields'	=>	array('name'),
								'conditions'	=>	array("Source.country_id"=>1)
							)
						),
						'Category'	=>	array(
							'fields'=>array('id','name')
						),
					),
					'limit'	=>	"{$page},100",			
					//'order'	=>	"News.created desc, News.rating asc"
				)
			);
			//desordeno el resultado
			shuffle($marquee);
			$marquee = json_encode($marquee);
			
			//guardo en cache
			Cache::write ( "marqueeOtherNews", $marquee, 'long' );
		}
		

		return $marquee;		
	}

function getTweets($page=1, $trpp = 200, $resPage=0, $rpp=15){
	$this->autoRender=false;

	if (($timeline = Cache::read ( "twitterTl{$page}", 'short' ))) {
				$twitters = $this->News->Feed->find('all', array(
						'contain'	=>	array(
							'Source'	=>	array(),
							'Category' => array()
						),
						'conditions'=> "Feed.content_type=3",
						'limit'	=> 25
					)
				);

				$tQry = "";

				foreach ($twitters as $row) {
					$tQry .= "from:{$row['Feed']['url']} OR ";
				}
				if (empty($tQry)) {
					return array();
				}else{
					$tQry =  substr($tQry, 0, -3);
				}
				//debug($tQry);
				$response = $this->Twitter->search($tQry, null, $trpp,$page,null);
				$tweets = array();
				$timeline = array();
				if (!empty($response)) {//en caso de no obtener respuestas de twitter uso los datos en el cache de respaldo
					$tweets = $response->results;
					if (empty($tweets)) {
						$timeline = Cache::read ( "bkptwitterTl{$page}", 'long' );;
					}
				}else {
					$timeline = Cache::read ( "bkptwitterTl{$page}", 'long' );
				}

				if (empty($timeline)) {
					$arTimezone = new DateTimeZone('America/Argentina/Buenos_Aires');
					$twTimezone = new DateTimeZone('GMT');
					foreach ($tweets as $row) {
						if (strlen($row->text)< 70) { //eliminamos todos los tweets pequeños
							continue;
						}
						if (preg_match_all("/@[a-z]*[0-9]*/i", $row->text, $matches) > 1) {
							continue;
						}
						$date = new DateTime($row->created_at, $twTimezone);
						$offset = $arTimezone->getOffset($date);
						$category = "";
						$username = "";
						foreach ($twitters as $account) {
							if ($account['Feed']['url'] == $row->from_user) {
								$category = $account['Category']['name'];
								$username = $account['Source']['name'];
								break;
							}
						}
						$timeline[] = array(
							'created'	=>	date('d/m H:i:s', $date->format('U')+$offset),
							'user'		=>	!empty($username)?$username:$row->from_user,
							'type' 		=>	$row->metadata->result_type,
							'text'		=>	$row->text,
							'response'	=>	property_exists($row, 'to_user')?$row->to_user:null,
							'profile_img'	=>	$row->profile_image_url,
							'category'	=>	$category
						);
					}
					$timeline = array_reverse($timeline);



					Cache::write ( "twitterTl{$page}", $timeline, 'short' );
					Cache::write ( "bkptwitterTl{$page}", $timeline, 'long' );

				}

	}

	if (($resPage*$rpp) < 200) {
		$pg = $resPage*$rpp;
	}else {
		$pg = $rpp * -1;
	}
	$timeline = array_slice($timeline, $pg, $rpp);
	//debug($timeline);

	if ($this->RequestHandler->isAjax()) {
		$this->set('twitters', $timeline);
		$this->layout='ajax';
		$this->render('jsonTweets');
	}else {
		return $timeline;
	}


}

function getPopularVideos($category="") {
	$this->layout='ajax';
	//$this->autoRender=false;
	$this->paginate = array(
		'limit'	=>	1,
		//'fields'	=>	array('Media.id', 'Media.url', 'Media.news_id'),
		'conditions'	=> array('category'=>$category),
	);
	$data = $this->paginate('YoutubeFavorite');
	//debug($data);
	$data = $data[0];
	

	if (!isset($this->params['requested'])) {
		//$this->layout = 'ajax';
		if ($this->RequestHandler->isAjax()) {
			/*$this->layout='default';
			debug($data);*/
		}
		//$this->set('paging',$this->params['paging']);
		$param2 = array(
			'wId'	=>	"videos",
			'wTitle'	=>	"Videos populares de youtube",
			'category'	=>	$category
		);
		
		$this->set('par', $param2);
		$this->set('data', $data);
		//debug(array('data'=>$data, 'paging'=>$this->params['paging']));
	}else {
		$this->autorender = false;
		//debug($this->params['paging']);
		return array('data'=>$data, 'paging'=>$this->params['paging']);
	}

	//return array('data'=>$data[0], 'paging'=>$this->params['paging']);
}

	function listNews($categoryId=0, $count=7){

		$data = $this->News->getUsersNews(12, $categoryId, $count);
		$this->layout = "ajax";
		if (!$this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			return $data;
		}else {
			$this->News->Category->recursive = -1;
			$categories = $this->News->Category->find('all');
			$selected = $this->News->Category->find('first', array('conditions'=>array('Category.id'=>$categoryId)));
			$this->set('selected', $selected['Category']['name']);
			$this->set('categories', $categories);
			$this->set('data',$data);
		}
	}

function search(){

	if (empty($this->data)) {
		$this->render('search2');
		return true;
	}
	App::import('Sanitize');
	$pattern = Sanitize::escape($this->data['News']['pattern']);
	$results = array();
	//$this->News->recursive = -1;
	$news = $this->News->find('all',
		array(
			'conditions'=>"match(News.title, News.summary, News.body) AGAINST ('{$pattern}' IN BOOLEAN MODE)",
			'contain'	=>	array(
				'Feed'	=>	array(
					'conditions'	=>	array('Feed.content_type'=>1),
					'Source'
				),
				'Category'	=>	array(),
				'User'		=>	array(),
				'Media'		=>	array()

			),
			'limit'	=>	13,
			'order'	=>	"News.created desc, News.visits desc, News.rating desc"
		)
	);
	$this->set('news', $news);
	$blogs = $this->News->find('all',
		array(
			'conditions'=>"match(News.title, News.summary, News.body) AGAINST ('{$pattern}' IN BOOLEAN MODE)",
			'contain'	=>	array(
				'Feed'	=>	array(
					'conditions'	=>	array('Feed.content_type'=>2),
					'Source'
				),
				'Category'	=>	array(),
				'User'		=>	array(),
				'Media'		=>	array()

			),
			'limit'	=>	13,
			'order'	=>	"News.created desc, News.visits desc, News.rating desc"
		)
	);
	$this->set('blogs', $blogs);

	//$tweets = $this->Twtr->search($pattern);
	$pattern = urlencode($pattern);
	$tweets = $this->requestAction("twtr/search/{$pattern}");
	$this->set('twitters', $tweets);
	$this->render('search2');


}


	function vote($id,$multiplier=1){
		$this->autoRender=false;
		$this->layout='ajax';
		// esta funcion se ejecuta solo si se llama por post
		// y el token es válido

		if ($this->RequestHandler->isAjax()) {
			// Aumenta el contador de la noticia...
			$usrVotes = $this->Session->read('votes');
			$usrVotes = !empty($usrVotes)?$usrVotes:array();
			if (!in_array($id, $usrVotes)) {
				$this->News->recursive=-1;
				$result = $this->News->updateAll(array('votes'=>'votes+'.$multiplier),array('News.id' => $id));
				if($result != false){
					$usrVotes[]=$id;
					$this->Session->write('votes',$usrVotes);
				}
			}else {
				return json_encode(false);
			}
		}
		return json_encode(true);
   }
   
   function getRelated($newsId){
   		$this->autoRender=false;
		$this->layout='ajax';
   		//return json_encode($this->params);
		if ($this->RequestHandler->isAjax()) {
			header('Content-type: application/json');
			$minRelevance = 25;
			$datetime = date("Y-m-d H:i:s", strtotime("-2 day"));
			$related = $this->News->getRelated($newsId, $this->params['form']['category'], $datetime, $this->params['form']['title'], $this->params['form']['fulltext'], $minRelevance);
			if(empty($related)){
				return json_encode($this->params['form']);
			}
			return json_encode($related);
			
		}elseif(!empty($this->params['requested']) && $this->params['requested']==1){
			$this->autoRender=false;
			return $related;
		}
		
   }

	/*DEPRECATED*/

	function getLocals(){
		$this->autoRender = false;
		$city = $this->Session->read('City');
		if (!array_key_exists('State', $city['City'])) {
			$city['City']['State'] = $city['State'];
		}
		$localNews = $this->News->find('all',
			array(
				'conditions'	=>	array(
					"OR"	=>	array(
									'News.city_id'	=>	$city['City']['id'],
									'News.state_id'	=>	$city['City']['State']['id'],
									'News.country_id'	=> $city['City']['State']['Country']['id'],
								)
				),
				'order'		=>	"if(News.city_id = {$city['City']['id']}, 1,0) DESC, if(News.state_id = {$city['City']['State']['id']}, 1,0) DESC, modified DESC, News.created DESC",
				'limit'		=> 5,
				'contain'=>array(
					//'Media'
				)
			)
		);
		$localNews['w_title'] = __('Noticas Locales', true);
		$localNews['config_content'] = "BLA BL bla bla bla";
		$localNews['wid'] = 1;
		//echo Sanitize::html(html_entity_decode($localNews['News'][0]['summary']), array('remove'=>true));
		Sanitize::clean($localNews);
		//debug($localNews);
		return $localNews;
	}

	function live($ajax=false, $last=0){

		if ($last !=0 ) {
			$timeLimit = strtotime("-{$last} seconds");
			$mysqldate = date( 'Y-m-d H:i:s', $timeLimit );
			$lastId = $this->LastPost->find('first',array('conditions'=>array('LastPost.type'=>1)));
			$liveNews = $this->News->City->find('first',
				array(
					'contain'=>array(
						'State.Country',
						'News'	=>	array(
							'conditions'	=>	"News.id > {$lastId['LastPost']['last_read']}",
							'order'	=>	"modified DESC, News.created DESC",
							'limit'	=>	5,

							'User'	=>	array(),
							'Category'	=>	array()
						)
					)
				)
			);
		}else {
			$liveNews = $this->News->City->find('first',
				array(
					'contain'=>array(
						'State.Country',
						'News'	=>	array(
							'order'	=>	"modified DESC, News.created DESC",
							'limit'	=>	5,
							'User'	=>	array(),
							'Category'	=>	array()
						)
					)
				)
			);
		}

		if (!empty($liveNews['News'])) {
			$this->News->recursive=-1;
			$lastPost = $this->News->find('first',array('fields'=>'id', 'order'=>"News.id DESC"));
			$this->LastPost->updateReads('news', $lastPost['News']['id']);
		}


		$liveNews['sTitle'] = "En Vivo";
		$liveNews['wid'] = 2;
		$liveNews['conf_content'] = "";
		if ($ajax) {
			$this->layout='ajax';
			$this->set('lNews',$liveNews);
		}else{
			//debug($liveNews);
			$this->autorender = false;
			return $liveNews;
		}
	}

	function view($id = null, $title="") {
		if (!$id) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}else{
			// Datos de la Noticia
			$noticia = $this->News->find('first',array(
													 'conditions' => array("News.id" => $id),
													 'contain' => array('Feed.Source', 'Category' => array('limit' => 1),
																		'User'
														)
													));
			if (empty($noticia)) {
				$noticia = $this->News->find('first',array(
							 'conditions' => array("News.id" => $id),
							 'contain' => array('Category' => array('limit' => 1),
												'User'
								)
							));
			}


			// Esta en el arreglo de la noticia pero , se envia en vairable separada
			$usuario = $noticia['User']['alias'];

			// Categoria de la noticia
			$categoria = '';
			if (array_key_exists('category', $noticia) && array_key_exists(0, $noticia['Category'])){
				$categoria =$noticia['Category'][0]['name'] ;
			}

			// Números de visita de la noticia (se podria sacar de la consulta anterior)
			$visitas = $this->News->Visit->field('count', 'Visit.news_id = '.$id, 'id');

			//media
			//$images = $this->paginate('Media', array("Media.news_id" => $id, "Media.type"=> PHOTO));
			$pag = $this->requestAction("medias/getPagImages/$id");
			$images = $pag['data'];
			if (array_key_exists('paging',$this->params)) {
				$this->params['paging'] = array_merge_recursive($this->params['paging'], $pag['paginatorData']);
			}else{
				$this->params['paging'] = $pag['paginatorData'];
			}

			$pag = $this->requestAction("medias/getPagVideos/$id");
			$videos = $pag['data'];
			if (array_key_exists('paging',$this->params)) {
				$this->params['paging'] = array_merge($this->params['paging'], $pag['paginatorData']);
			}else{
				$this->params['paging'] = $pag['paginatorData'];
			}
			
			/*se setean los datos para las noticias relacionadas*/
			$datetime = date("Y-m-d", strtotime("-2 day"));
			$related = $this->News->getRelated($noticia['News']['id'], $noticia['Category']['id'], $datetime, $noticia['News']['title'], $noticia['News']['title']." ".$noticia['News']['summary']." ".$noticia['News']['body'], 27,1);
			$this->set('related',$related);

			$this->set("title_for_layout",$noticia['News']['title']);
			$aux['description'] = Sanitize::html($noticia['News']['summary'], array('remove' => true));
			$meta = array();
			if (!empty($noticia['News']['summary'])) {
				$meta['description'] = $noticia['News']['summary'];
			}
			
			if (!empty($noticia) && !empty($noticia['News']['title'])) {
				$meta['og:title'] = $noticia['News']['title'];
			}
			if (!empty($images) && !empty($images[0]['Media']['url'])) {
				$meta['og:image'] = $images[0]['Media']['url'];
			}else {
				$meta['og:image'] = Router::url("/",true)."img/logo-con-fondo.jpg";
			}
			$meta['og:type']="article";
			$meta['article:published_time']=$noticia['News']['created'];
			$category = array_key_exists(0, $noticia['Category'])?$noticia['Category'][0]['name']:$noticia['Category']['name'];
			$meta['article:section']=$category;
			if (!empty($noticia['News']['tags']) && false) {//deshabilitado por el momento
				$aux = explode(",", $noticia['News']['tags']);
				foreach ($aux as $value) {
					$meta['article:tag']='';
				}
			}
			$this->set("meta",$meta);
			$this->set('category', $categoria);
			$this->set('usr', $usuario);
			$this->set('nVisits', $visitas);
			$this->set('news', $noticia);
			$this->set('images', $images);
			$this->set('videos', $videos);
		}
	}

	function getRelatedd($id, $count = 4) {

		$idRelatedNew = $this->News->field('related_news_id', 'News.id = '.$id,'id');
		$noticias =	$this->News->RelatedNews->find('all', array('conditions' => array('RelatedNews.id'=> $idRelatedNew),
																'fields'=> array('News.id,News.title, News.url'),
																'limit'=> $count,
																'order'=>'News.rating DESC, votes DESC, visits DESC, modified DESC, News.created DESC'));
		$this->set('relatedNews', $noticias);

	}


	function write(){
		$this->layout="default";
		$this->set("title_for_layout","Escribe tu noticia");
		if ($this->Session->check('newsAdd') && $this->referer() == "/news/add/step:2") {
			$this->data = $this->Session->read('newsAdd');
		}
		//debug($this->data);
		$ckeditorClass = 'CKEDITOR';
		$this->set('ckeditorClass', $ckeditorClass);

		$ckfinderPath = 'js/ckfinder/';
   		$this->set('ckfinderPath', $ckfinderPath);
   		
   		$categories = $this->News->Category->find('list');
		$this->set('categories',$categories);

		if (!empty($this->data)) {
			$encoding = getEncoding($this->data['News']['title']." ".$this->data['News']['summary']." ".$this->data['News']['body']);
			$this->data['News']['title'] = @html_entity_decode($this->data['News']['title'],ENT_QUOTES,$encoding);
			$aux = trim($this->data['News']['summary']);
			if (!empty($aux)) {
				$this->data['News']['summary'] = @html_entity_decode($this->data['News']['summary'],ENT_QUOTES,$encoding);
			}else {
				$start = strpos($this->data['News']['body'], "<p ");
				if ($start === FALSE) {
					$start = strpos($this->data['News']['body'], "<p ");
				}
				$end = strpos($this->data['News']['body'], '</p>', $start);
				$paragraph = substr($this->data['News']['body'], $start, $end-$start+4);
				$paragraph = @html_entity_decode($paragraph,ENT_QUOTES,$encoding);
				$paragraph = strip_tags($paragraph);
				$this->data['News']['summary'] = trim($paragraph);
				$this->data['News']['body'] = substr($this->data['News']['body'],$end);
			}

			$this->data['News']['body'] = @html_entity_decode($this->data['News']['body'],ENT_QUOTES,$encoding);
			$usr = $this->Auth->user();
			$this->data['News']['user_id'] = $usr['User']['id'];
			
			$this->data['News']['category_id'] = $this->data['News']['Category'];
			
			/*analisis de imagen subida*/
			$badImage = false;
		if (!empty($this->data['News']['photo']['tmp_name'])) {
					$target = 317;
					$folderName = WWW_ROOT."img".DS."usrphotos";
					$this->data['News']['photo']['name'] = Inflector::slug($this->data['News']['photo']['name']);
					$filename = "tmp_".time()."_".$this->data['News']['user_id']."_".$this->data['News']['photo']['name'];
					$filename = explode(".", $filename);
					$filename = $filename[0].".jpg";
					$tmpFile = $this->data['News']['photo']['tmp_name'];
					$img = getimagesize($tmpFile);//obtengo datos de imagen
					if (stripos($img['mime'], 'image') === false) {
						$badImage = true;
						$this->Session->setFlash("Formato de imágen no soportado");
					}else{
					
						//debug($img);
						$width = $img[0];
						$height = $img[1];
						if ($width > $height) {
							$percentage = ($target / $width);
						} else {
							$percentage = ($target / $height);
						}
						if ($width < $target && $height < $target) {//si la foto es mas chica no la redimensiono
							$percentage=1;
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
								if(!$badImage){
									$this->Session->setFlash("No se pudo modificar el tamaño de la imágen");
									$badImage = true;
								}
								debug("No se pudo modificar el tamaño de la imágen");
								unlink($this->data['News']['photo']['tmp_name']);
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
						$avatarUrl = "/".$avatarUrl;
						$this->data['News']['photo'] = $avatarUrl;
						$this->data['Media']['url'] = $avatarUrl;
						$this->data['Media']['type'] = 1;
						unset($this->data['News']['photo']);
					}
				}
			
			

			
			
			
			$this->News->create($this->data);
			if ($this->News->validates() && !$badImage) {
				$this->Session->write('newsAdd',$this->data);
				$this->set('errors', null);
				if($this->referer() != "/news/add/step:2"){
					$this->redirect(array('controller'=>"news",'action' => 'add','step:2'));
				}
			} else {
				$errors = $this->News->invalidFields();
				debug($errors);
				$this->set('errors', $errors);
				$this->Session->setFlash(__('Debe elegir una categoría', true));
			}
		}else {
			//$this->Session->flash('');
		}
	}

	function options(){
		$createdNews = $this->Session->read('newsAdd');

		if (!empty($this->data)) {
			//debug($this->data);
			$coordinates = explode(",", $this->data['News']['coordinates']);
			$createdNews['News']['latitude'] = floatval($coordinates[0]);
			$createdNews['News']['longitude'] = floatval($coordinates[1]);
			$createdNews['News']['ratio'] = floatval($coordinates[2]);
			$createdNews['News']['category_id'] = $this->data['News']['Category'];
			if (empty($this->data['News']['TagsList'])) {
				$excluded = $this->ExcludedWord->find('list');
				$popWords = getPopularWords(strip_tags($createdNews['News']['title'].$createdNews['News']['summary'].$createdNews['News']['body']), $excluded);
				$tags = array_slice($popWords, 0, 6);
				$tags = array_keys($tags);
				foreach ($tags as $key=>$value) {
					$tags[$key]=utf8_encode($value);
				}
				$tags = implode("|#|", $tags);
				$createdNews['News']['tags']= $tags;
			}else {
				$createdNews['News']['tags'] = $this->data['News']['TagsList'];
			}
			$this->News->create($createdNews);
			if ($this->News->validates()) {
				$this->Session->write('newsAdd',$createdNews);
				$this->set('errors', null);
				$this->redirect(array('controller'=>"news",'action' => 'add','step:3'));
			}else {
				$errors = $this->News->invalidFields();
				$this->set('errors', $errors);
				$this->Session->setFlash(__('No se ha podido actualizar la noticia. Corrija los errores e intente nuevamente', true));
			}
			//debug($createdNews);
		}

		App::import('Vendor','geoplanet/geoplanet');
		$yApiKey = $this->Parameter->find('first',array('conditions'=>array('key'=>'yahoo_api_key')));
		$this->News->City->contain();
		$city = $this->Session->read('City');
		//$location = $this->News->City->find('first',array('conditions'=>array('name'=>$city['City']['name'])));
		$coordinates = array();
		if (empty($city['City']['latitude']) || empty($city['City']['longitude'])) {
			$geoplanet = new GeoPlanet($yApiKey['Parameter']['value']);
			$placelist = $geoplanet->getPlaces("{$city['City']['name']}, {$city['City']['State']['name']}, {$city['City']['State']['Country']['name']}");
			$placelist = array_key_exists(0, $placelist)?$placelist[0]:$placelist;
			$coordinates['latitude'] = $placelist['centroid']['lat'];
			$coordinates['longitude'] = $placelist['centroid']['lng'];
			$this->News->City->read(null, $city['City']['id']);
			$this->News->City->set(
				array(
					'latitude'	=>	$coordinates['latitude'],
					'longitude'	=>	$coordinates['longitude']
				)
			);
			if(!$this->News->City->save()){
				$this->log("[".__FILE__." -> ".__LINE__."] No se puede actualizar los datos de geolocalización");
			}
		}else {
			$coordinates['latitude'] = $city['City']['latitude'];
			$coordinates['longitude'] = $city['City']['longitude'];
		}

		$this->layout="admin";
		$categories = $this->News->Category->find('list');
		$this->set('categories',$categories);
		$countries = $this->News->State->Country->find('list');
		$this->set('countries',$countries);
		$curr_city = $this->Session->read('City');
		$this->set('curr_city',$curr_city);
		$this->set('coordinates',$coordinates);
	}

	function preview($action){
		$this->layout="default";
		if (!$this->Session->check('newsAdd') && $action=="step:3") {
			$this->flash(__("No se puede previsualizar la noticia. Intentelo nuevamente", true), "/postea.html");
			return ;
		}elseif(!$this->Session->check('newsAdd')) {
			$this->flash(__("Su noticia ya ha sido procesada...", true), "/postea.html");
			return ;
		}
		$news = $this->Session->read('newsAdd');
		
		switch ($action) {
			case 'guardar':
			 $news['News']['published']=0;
			 if ($this->News->save($news)) {
			 	$this->set('newsLink',Router::url(array('controller'=>"news",'action'=>"view",$this->News->id),true));
			 	$this->set('published',false);
			 	$this->Session->delete('newsAdd');
			 	$this->flash("La noticia se ha cargado correctamente!", "/columnas-pendientes.html", 3);
			 }else {
			 	$this->set('newsLink',null);
			 	$this->Session->setFlash(__('No se ha podido crear la noticia. Inténtelo nuevamente más tarde...', true));
			 }
			 $this->render('saveMessage');
			break;
			case 'publicar':
			 $news['News']['published']=1;
			 $tmpimgurl = $news['Media']['url'];
			 $news['Media']['url'] = str_ireplace("tmp_", "", $news['Media']['url']);
			 rename(WWW_ROOT.str_ireplace("/", "\\", $tmpimgurl), WWW_ROOT.str_ireplace("/", "\\", $news['Media']['url']));
			 if ($this->News->save($news)) {
			 	$newsId =$this->News->id;
			 	$media['Media'] = $news['Media'];
			 	$media['Media']['news_id'] =  $newsId;
			 	//debug($media);
			 	$this->News->Media->create($media);
			 	if(!$this->News->Media->save()){
			 		debug($this->News->Media->invalidFields());
			 	}
			 	$this->set('newsLink',Router::url(array('controller'=>"news",'action'=>"view",$this->News->id),true));
			 	$this->set('published',true);
			 	$this->Session->delete('newsAdd');
			 	$this->flash("La noticia se ha cargado correctamente!", "/columnas-pendientes.html", 3);
			 	return;
			 }else {
			 	$this->set('newsLink',null);
			 	$this->Session->setFlash(__('No se ha podido crear la noticia. Inténtelo nuevamente más tarde...', true));
			 }
			 $this->render('saveMessage');
			break;
			default:
				//nada que hacer;
			break;
		}


		$this->News->Category->recursive = -1;
		$category = $this->News->Category->find('first',array('conditions'=>array('id'=>$news['News']['category_id'])));
		$news['Category'][0] = $category['Category'];
		$news['News']['id']=0;
		$news['News']['created'] = date('Y M D H:i:s');
		$news['News']['modified'] = date('Y M D H:i:s');
		//debug($news);
		$this->set('news',$news);
		$usr = $this->Auth->user();
		$this->set('usr', $usr['User']['alias']);
		$this->set('votes',0);
		$pag = $this->requestAction("medias/getPagImages/-1");
		$this->params['paging'] = $pag['paginatorData'];
		if (array_key_exists('Media', $news)) {
			$this->set('images', array(array('Media'=>$news['Media'])));
		}else {
			$this->set('images', null);
		}
		
		$this->set('videos', $pag['data']);
		$this->set('relatedNews', $pag['data']);
		$this->set('preview',true);
		$this->render('view');
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
		$users = $this->News->User->find('list');
		$cities = $this->News->City->find('list');
		$states = $this->News->State->find('list');
		$feeds = $this->News->Feed->find('list');
		$relatedNews = $this->News->RelatedNews->find('list');
		$news = $this->News->New->find('list');
		$categories = $this->News->Category->find('list');
		$this->set(compact('users', 'cities', 'states', 'feeds', 'relatedNews', 'news', 'categories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for news', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->News->delete($id)) {
			$this->Session->setFlash(__('News deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('News was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}


	/*************************************************************************/







	function admin_index() {
		$this->set("title_for_layout","Portal de administración");
		$this->layout = "admin";
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('news', $this->News->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
			}
		}
		$users = $this->News->User->find('list');
		$cities = $this->News->City->find('list');
		$states = $this->News->State->find('list');
		$feeds = $this->News->Feed->find('list');
		$relatedNews = $this->News->RelatedNews->find('list');
		$news = $this->News->New->find('list');
		$categories = $this->News->Category->find('list');
		$this->set(compact('users', 'cities', 'states', 'feeds', 'relatedNews', 'news', 'categories'));
	}


	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
		$users = $this->News->User->find('list');
		$cities = $this->News->City->find('list');
		$states = $this->News->State->find('list');
		$feeds = $this->News->Feed->find('list');
		$relatedNews = $this->News->RelatedNews->find('list');
		$news = $this->News->New->find('list');
		$categories = $this->News->Category->find('list');
		$this->set(compact('users', 'cities', 'states', 'feeds', 'relatedNews', 'news', 'categories'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for news', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->News->delete($id)) {
			$this->Session->setFlash(__('News deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('News was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
	
?>