<?php
class TwtrController extends AppController {

	var $name = 'Twtr';
	var $helpers = array('Text', 'Ajax', 'Javascript', 'Html', 'Cache');
	var $components = array('Phptwitter.Twitter');
	var $uses = array('Parameter', 'Feed');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('trends', 'getTimeline', 'makeFollows');
	}

	function connect() {
		$this->Twitter->setupApp('Ozo2rUAoY84Kjeo3wVq8g', 'Mfjf1FVto83uC45emTW2Rr4CpJBS3pKGmOsVQuY');
		$this->Twitter->connectApp('http://posteamos.localhost.com/twtr/authorization');
	}
	function authorization() {
		$this->autoLayout=false;
		$this->autoRender=false;
		$this->disableCache();
		$this->Twitter->authorizeTwitterUser($this->params['url']['oauth_token'], $this->params['url']['oauth_verifier']);
		debug($this->Twitter->getTwitterUser(false));
		debug($this->Twitter->accountVerifyCredentials());
	}

	function makeFollows() {
		//$this->autoLayout=false;
		$this->layout = 'ajax';
		//$this->autoRender=false;

		$twtrToken = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token')));
		$twtrToken = $twtrToken['Parameter']['value'];
		$twtrTokenPassword = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token-secret')));
		$twtrTokenPassword = $twtrTokenPassword['Parameter']['value'];
		$this->Twitter->loginTwitterUser($twtrToken, $twtrTokenPassword);
		$friendsIds = $this->Twitter->getFriendsIds('posteamos');

		$idsTxt = array();
		if (!empty($friendsIds)) {
			$idsTxt[0] = "";
			$i=0;
			$count = 0;
			foreach ($friendsIds as $value) {
				$idsTxt[$i] .= $value.",";
				$count++;
				if ($count >= 99) {
					$idsTxt[$i] = substr($idsTxt[$i], 0, -1);
					$i++;
					$count=0;
				}
			};
		}


		$response = array();
		foreach ($idsTxt as $query) {
			$aux = json_decode($this->Twitter->apiRequest('GET', '/1/users/lookup.json', array('user_id'=>$query)), true);
			$aux2 = array();
			foreach ($aux as $key => $value) {
				$aux2[$key] = $value['screen_name'];
			}
			//$response[] = $aux2;
			$response = array_merge($response, $aux2);
			$remainingTwttrQrys = $this->Twitter->accountRateLimitStatus();
			if ($remainingTwttrQrys['remaining_hits'] < 20) {
				$msg = 'El número de requests disponibles es menor a 20. Se suspende la operación';
				pr($msg);
				$this->log($msg, 'debug');
				break;
			}
		}

		$this->Feed->recursive = -1;
		$users = $this->Feed->find('all', array(
				'conditions'	=>	array(
					'Feed.content_type'	=>	3,
					'NOT'	=>	array(
						'Feed.url'	=> $response
					)
				),
				'fields'	=>	array('Feed.id', 'Feed.url')
			)
		);

		debug($users);
		$response = array();
		foreach ($users as $value) {
			$aux = $this->Twitter->createFriendship($value['Feed']['url']);
			debug($aux);
			$response[] = $aux;
			if ($this->Twitter->accountRateLimitStatus() < 20) {
				$msg = 'El número de requests disponibles es menor a 20. Se suspende la operación';
				pr($msg);
				$this->log($msg, 'debug');
				break;
			}
		}
		debug($response);

	}

	function getTimeline($twId = 0, $nonCached = false) {
		$this->autoLayout=false;
		//$this->layout = 'ajax';
		$this->autoRender=false;

		if ($nonCached || ($timeline = Cache::read ( "twtrTimeline{$twId}", 'vShort' )) === false) {
			$timeline = array();
			$twtrToken = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token')));
			$twtrToken = $twtrToken['Parameter']['value'];
			$twtrTokenPassword = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token-secret')));
			$twtrTokenPassword = $twtrTokenPassword['Parameter']['value'];
			$twtrConsumerKey = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-consumer-key')));
			$twtrConsumerKey = $twtrConsumerKey['Parameter']['value'];
			$twtrConsumerSecret = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-consumer-secret')));
			$twtrConsumerSecret = $twtrConsumerSecret['Parameter']['value'];
			$this->Twitter->loginTwitterUser($twtrToken, $twtrTokenPassword);
			$this->Twitter->setupApp($twtrConsumerKey, $twtrConsumerSecret);
			$tweets = $this->Twitter->homeTimeline();
			//$tweets = $this->Twitter->getDirectMessagesSent();
			//debug($tweets);
			//debug($this->Twitter->accountRateLimitStatus());

			$twitters = $this->Feed->find('all', array(
							'contain'	=>	array(
								'Source'	=>	array(),
								'Category' => array()
							),
							'conditions'=> "Feed.content_type=3",
						)
			);
			foreach ($tweets as $row) {
				$matched = false;
				if ($row['id_str'] <= $twId) {
					continue;
				}
				if (strlen($row['text'])< 70) { //eliminamos todos los tweets pequeños
					continue;
				}
				if (preg_match_all("/@[a-z]*[0-9]*/i", $row['text'], $matches) > 1) {
					continue;
				}

				$arTimezone = new DateTimeZone('America/Argentina/Buenos_Aires');
				$twTimezone = new DateTimeZone('GMT');
				$date = new DateTime($row['created_at'], $twTimezone);

				$offset = $arTimezone->getOffset($date);
				$category = "";
				$username = "";
				foreach ($twitters as $account) {
					if ($account['Feed']['url'] == $row['user']['screen_name']) {
						$category = $account['Category']['name'];
						$username = $account['Source']['name'];
						$matched = true;
						break;
					}
				}
				if (!$matched) {
					//debug($row);
					$this->log("[TWTR] Este usuario no ha sido registrado en la app: \n{$row['user']['id']}--{$row['user']['screen_name']}::{$row['user']['name']}",LOG_ERROR);
					continue;
				}
				$timeline[] = array(
					'id'		=>	$row['id_str'],
					'created'	=>	date('d/m H:i:s', $date->format('U')+$offset),
					'user'		=>	!empty($username)?$username:$row['user']['name'],
					'text'		=>	$row['text'],
					'response'	=>	!empty($row['in_reply_to_screen_name'])?$row['in_reply_to_screen_name']:null,
					'profile_img'	=>	$row['user']['profile_image_url'],
					'category'	=>	$category
				);
			}

				//$timeline = array_reverse($timeline);
			if (empty($timeline)) {
				$tweets = Cache::read ( "twtrTimelineBkp{$twId}", 'long' );
			}else {
				if (!$nonCached) {
					Cache::write("twtrTimelineBkp{$twId}", $timeline, 'long');
				}

			}
			if (!$nonCached) {
				Cache::write("twtrTimeline{$twId}", $timeline, 'vShort');
			}

		}
		//debug($timeline);
		if ($this->RequestHandler->isAjax()) {
			$timeline = array_reverse($timeline);
			$last = count($timeline)>0?count($timeline)-1:$twId;
			$this->set('twitters', $timeline);
			$this->set('last', $last);
			$this->layout='ajax';
			$this->render('jsonTweets');
		}else {
			//$last = count($timeline)>0?count($timeline)-1:$twId;
			$lastTweet = $timeline[0]['id'];
			$aux = array($timeline, $lastTweet);
			return $aux;
		}
	}
	
	function follows(){
		$this->autoRender="false";
		/*$twtrToken = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token')));
		$twtrToken = $twtrToken['Parameter']['value'];
		$twtrTokenPassword = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token-secret')));
		$twtrTokenPassword = $twtrTokenPassword['Parameter']['value'];*/
		$data = $this->Twitter->getFriendsIds("posteamos");
		$i=0;
		debug($data);
		foreach ($data['ids'] as $row) {
			$aux = $this->Twitter->showUser($row);
			debug($aux);
			if($i>=5){
				break;
			}
			$i++;
		}
		
	}

	function getList($twId = 0, $list = null, $nonCached = false) {
		$this->autoLayout=false;
		$this->autoRender=false;
		$twtrList = str_ireplace(" & ", "-", $list);

		$twtrList = urlencode($twtrList);

		if ($nonCached || ($timeline = Cache::read ( "twtr{$list}{$twId}", 'vShort' )) === false) {
			$timeline = array();
			$twtrToken = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token')));
			$twtrToken = $twtrToken['Parameter']['value'];
			$twtrTokenPassword = $this->Parameter->find('first',array('conditions'=>array('key'=>'twtr-oauth-token-secret')));
			$twtrTokenPassword = $twtrTokenPassword['Parameter']['value'];
			$this->Twitter->loginTwitterUser($twtrToken, $twtrTokenPassword);
			$tweets = $this->Twitter->apiRequest('get', "/1/lists/statuses.json?slug={$twtrList}&owner_screen_name=posteamos&include_entities=false&per_page=50", '');
			$tweets = json_decode($tweets, true);
			if (empty($tweets)) {//si hubo un fallo, reintento la operación
				$tweets = $this->Twitter->apiRequest('get', "/1/lists/statuses.json?slug={$twtrList}&owner_screen_name=posteamos&include_entities=false&per_page=50", '');
				$tweets = json_decode($tweets, true);
			}
			//debug($tweets);
			//debug($this->Twitter->accountRateLimitStatus());

			$twitters = $this->Feed->find('all', array(
							'contain'	=>	array(
								'Source'	=>	array(),
								'Category' => array()
							),
							'conditions'=> "Feed.content_type=3",
						)
			);
			foreach ($tweets as $row) {
				if ($row['id_str'] <= $twId) {
					continue;
				}
				if (strlen($row['text'])< 70) { //eliminamos todos los tweets pequeños
					continue;
				}
				if (preg_match_all("/@[a-z]*[0-9]*/i", $row['text'], $matches) > 2) {//eliminamos todos los que tiene menciones
					continue;
				}

				$arTimezone = new DateTimeZone('America/Argentina/Buenos_Aires');
				$twTimezone = new DateTimeZone('GMT');
				$date = new DateTime($row['created_at'], $twTimezone);

				$offset = $arTimezone->getOffset($date);
				$category = "";
				$username = "";
				foreach ($twitters as $account) {
					if ($account['Feed']['url'] == $row['user']['screen_name']) {
						$username = $account['Source']['name'];
						break;
					}
				}
				$timeline[] = array(
					'id'		=>	$row['id_str'],
					'created'	=>	date('d/m H:i:s', $date->format('U')+$offset),
					'user'		=>	!empty($username)?$username:$row['user']['name'],
					'text'		=>	$row['text'],
					'response'	=>	!empty($row['in_reply_to_screen_name'])?$row['in_reply_to_screen_name']:null,
					'profile_img'	=>	$row['user']['profile_image_url'],
					'category'	=>	$list
				);
			}

				//$timeline = array_reverse($timeline);
			if (empty($timeline)) {
				$tweets = Cache::read ( "twtrTimelineBkp{$list}{$twId}", 'long' );
			}else {
				if (!$nonCached) {
					Cache::write("twtrTimelineBkp{$list}{$twId}", $timeline, 'long');
				}

			}
			if (!$nonCached) {
				Cache::write("twtr{$list}{$twId}", $timeline, 'vShort');
			}

		}
		//debug($timeline);
		if ($this->RequestHandler->isAjax()) {
			$timeline = array_reverse($timeline);
			$last = count($timeline)>0?count($timeline)-1:$twId;
			$this->set('twitters', $timeline);
			$this->set('last', $last);
			$this->layout='ajax';
			$this->render('jsonTweets');
		}else {
			//$last = count($timeline)>0?count($timeline)-1:$twId;
			$lastTweet = $timeline[0]['id'];
			$aux = array($timeline, $lastTweet);
			return $aux;
		}
	}


	function search($qry) {

		if (!empty($this->params['requested'])) {
			//$this->cakeError('error404')
		}
		$this->autoLayout=false;
		$this->autoRender = false;

		$results = $this->Twitter->search($qry);
		return $results['results'];
	}


	function trends($woeid = '23424747') {
		$this->layout = false;
		if (empty($woeid)) {
			return array();
		}
		$xmlAsArray = Cache::read('woeid'.$woeid, 'default');
		if (!$xmlAsArray) {
			$url = "http://api.twitter.com/1/trends/{$woeid}.xml";
			debug($url);
			App::import('Core', 'HttpSocket');
			$HttpSocket = new HttpSocket();
			$results = $HttpSocket->get($url,null);
			$response = $HttpSocket->response;
			if ($response['status']['code'] != 200) {
				$this->log("No se puede obtener datos de twitter: {$response['raw']['header']}");
				$this->log("No se puede obtener datos de twitter: {$response['raw']['body']}");
				debug($response['raw']['header']);
			}

			App::import('Core', 'Xml');
			$xml = new Xml($results);
			$xmlAsArray = $xml->toArray();
			Cache::set(array('duration' => '+15 minutes'));
			Cache::write('woeid'.$woeid, $xmlAsArray, 'default');
		}else {
			//debug($xmlAsArray);
		}

		return $xmlAsArray['MatchingTrends']['Trends']['Trend'];
	}

	function getContacts() {
		$this->autoLayout=false;
		$this->autoRender=false;
		/*$this->Twitter->username = "posteamos";
		$this->Twitter->password = "27386066";
		$followers = $this->Twitter->statuses_followers();*/
		App::import('Vendor', 'tmhOAuth', array('file'=>"tmhOAuth".DS."tmhOAuth.php"));
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key' => 'posteamos',
		  'consumer_secret' => '27386066',
		));
		debug($tmhOAuth);
	}
}
?>