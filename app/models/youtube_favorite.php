<?php
class YoutubeFavorite extends AppModel {
	var $name = 'YoutubeFavorite';
	var $useTable = false;

	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
		//debug(paginate);
		if (array_key_exists('category',$conditions) && !empty($conditions['category'])) {
			$conditions = array_merge(array('country'=>"argentina",'time'=>"this_week",'type'=>"category"), $conditions);
			//$url = "https://gdata.youtube.com/feeds/api/videos?q={$conditions['country']}&v=2&category={$conditions['category']}&orderby=relevance&time=this_week";
			//debug($conditions);
			$url = "http://gdata.youtube.com/feeds/api/videos";
		}else {
			$defaults = array('country'=>"AR", 'type'=>'most_popular', 'time'=>'today', 'category'=>"");
			$conditions = array_merge($conditions, $defaults);
			
			$url="http://gdata.youtube.com/feeds/api/standardfeeds/{$conditions['country']}/{$conditions['type']}";
		}
		$page = $page-1;
		
		$categorySlug = md5($conditions['country'].$conditions['type'].$conditions['time'].str_ireplace(" & ", "%7C",$conditions['category']));

		if (($aux = Cache::read ( "youtube{$categorySlug}", 'long' )) === false) {
			
			App::import('Core', 'HttpSocket');
			$HttpSocket = new HttpSocket();
			if (array_key_exists('category',$conditions) && !empty($conditions['category'])) {
				
				$yParams = array(
					'q'	=>	$conditions['country'],
					'v'	=>	2,
					'category'	=>	str_ireplace(" & ", "%7C", $conditions['category']),
					'orderby'	=>	"relevance",
					'time'		=>	"this_week"
				);
				$results = $HttpSocket->get($url, $yParams);
				//debug($yParams);
				//debug($results);
			}else{
				$results = $HttpSocket->get($url, "time={$conditions['time']}");
				//debug($HttpSocket);
			}
			$status = $HttpSocket->response;
			if($status['status']['code']==200){
				App::import('Core', 'Xml');
				$xml = new Xml($results);

				$xmlArr = $xml->toArray();
				//debug($xmlArr);
				$updated = $xmlArr['Feed']['updated'];
				$items = $xmlArr['Feed']['Entry'];
				$aux = array();

				foreach ($items as $row) {
					if (!array_key_exists('Content', $row['Group'])) {
						continue;
					}
					$url = null;
					if (array_key_exists(0, $row['Group']['Content'])) {
						$url=$row['Group']['Content'][0]['url'];
					}elseif (array_key_exists('url', $row['Group']['Content'])){
						$url=$row['Group']['Content']['url'];
					}else {
						continue;
					}
					if (!is_array($row['title'])) {
						$title = $row['title'];
					}else{
						$title = $row['title']['value'];
					}
					$aux[] = array('title'=>$title, 'url'=>$url);
					
				}
			}else {
				die($status['status']['reason-phrase']);
			}
		}

		Cache::write ("youtube{$categorySlug}", $aux, 'long');
		$aux = array_slice($aux, $page, $limit);

		return $aux;

	}

	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		//debug('paginateCount');
		if (array_key_exists('category',$conditions)) {
			$conditions = array_merge(array('country'=>"argentina",'time'=>"this_week",'type'=>"category"), $conditions);
			$url = "http://gdata.youtube.com/feeds/api/videos";
		}else {
			$defaults = array('country'=>"AR", 'type'=>'most_popular', 'time'=>'today', 'category'=>"");
			$conditions = array_merge($conditions, $defaults);
			$url="http://gdata.youtube.com/feeds/api/standardfeeds/{$conditions['country']}/{$conditions['type']}";
		}
		
		//$categorySlug = md5($conditions['country'].$conditions['type'].$conditions['time'].$conditions['category']);
		$categorySlug = md5($conditions['country'].$conditions['type'].$conditions['time'].str_ireplace(" & ", "%7C",$conditions['category']));
		//debug($categorySlug);
		if (($aux = Cache::read("youtube{$categorySlug}", 'long' )) !== false) {
			return count($aux);
		}else {
			App::import('Core', 'HttpSocket');
			$HttpSocket = new HttpSocket();
			if (array_key_exists('category',$conditions) && !empty($conditions['category'])) {
				
				//$results = $HttpSocket->get($url,"q={$conditions['country']}&v=2&category={$conditions['category']}&orderby=relevance&time=this_week");
				$yParams = array(
					'q'	=>	$conditions['country'],
					'v'	=>	2,
					'category'	=>	str_ireplace(" & ", "%7C", $conditions['category']),
					'orderby'	=>	"relevance",
					'time'		=>	"this_week"
				);
				$results = $HttpSocket->get($url, $yParams);
			}else{
				$results = $HttpSocket->get($url, "time={$conditions['time']}");
			}
			
			$status = $HttpSocket->response;
			if($status['status']['code']==200){
				App::import('Core', 'Xml');
				$xml = new Xml($results);

				$xmlArr = $xml->toArray();
				$updated = $xmlArr['Feed']['updated'];
				$items = $xmlArr['Feed']['Entry'];
				$aux = array();
				foreach ($items as $row) {
					if (!array_key_exists('Content', $row['Group'])) {
						continue;
					}
					$url = null;
					if (array_key_exists(0, $row['Group']['Content'])) {
						$url=$row['Group']['Content'][0]['url'];
					}elseif (array_key_exists('url', $row['Group']['Content'])){
						$url=$row['Group']['Content']['url'];
					}else {
						continue;
					}
					if (!is_array($row['title'])) {
						$title = $row['title'];
					}else{
						$title = $row['title']['value'];
					}
					$aux[] = array('title'=>$title, 'url'=>$url);
				}
				return count($aux);
			}else {
				debug($status);
				debug($HttpSocket);
				die($status['status']['reason-phrase']);
			}
		}

	}
	
	function getVideos($conditions = array()) {

		if (array_key_exists('category',$conditions) && !empty($conditions['category'])) {
			$conditions = array_merge(array('country'=>"argentina",'time'=>"this_week",'type'=>"category"), $conditions);
			$url = "http://gdata.youtube.com/feeds/api/videos";
		}else {
			$defaults = array('country'=>"AR", 'type'=>'most_popular', 'time'=>'today', 'category'=>"");
			$conditions = array_merge($conditions, $defaults);
			$url="http://gdata.youtube.com/feeds/api/standardfeeds/{$conditions['country']}/{$conditions['type']}";
		}
		
		$categorySlug = md5($conditions['country'].$conditions['type'].$conditions['time'].str_ireplace(" & ", "%7C",$conditions['category']));

		if (($aux = Cache::read ( "youtube_list_{$categorySlug}", 'long' )) === false) {
			
			App::import('Core', 'HttpSocket');
			$HttpSocket = new HttpSocket();
			if (array_key_exists('category',$conditions) && !empty($conditions['category'])) {
				
				$yParams = array(
					'q'	=>	$conditions['country'],
					'v'	=>	2,
					'category'	=>	str_ireplace(" & ", "%7C", $conditions['category']),
					'orderby'	=>	"relevance",
					'time'		=>	"this_week"
				);
				$results = $HttpSocket->get($url, $yParams);
				//debug($yParams);
				//debug($results);
			}else{
				$results = $HttpSocket->get($url, "time={$conditions['time']}");
				//debug($HttpSocket);
			}
			$status = $HttpSocket->response;
			if($status['status']['code']==200){
				App::import('Core', 'Xml');
				$xml = new Xml($results);

				$xmlArr = $xml->toArray();
				//debug($xmlArr);
				$updated = $xmlArr['Feed']['updated'];
				$items = $xmlArr['Feed']['Entry'];
				$aux = array();

				foreach ($items as $row) {
					if (!array_key_exists('Content', $row['Group'])) {
						//continue;
					}
					$url = null;
					if (array_key_exists(0, $row['Group']['Content'])) {
						$url=$row['Group']['Content'][0]['url'];
					}elseif (array_key_exists('url', $row['Group']['Content'])){
						$url=$row['Group']['Content']['url'];
					}else {
						$url="";
					}
					$videoId=$row['Group']['videoid'];
					if (!is_array($row['title'])) {
						$title = $row['title'];
					}else{
						$title = $row['title']['value'];
					}
					$aux[] = array('title'=>$title, 'url'=>$url, 'videoid'=>$videoId);
					
				}
			}else {
				die($status['status']['reason-phrase']);
			}
			Cache::write ("youtube_list_{$categorySlug}", $aux, 'long');
		}

		return $aux;

	}


}
?>