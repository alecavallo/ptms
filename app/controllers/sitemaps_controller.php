<?php

class SitemapsController extends AppController {

var $name = 'Sitemaps';
	var $components= array('Security','RequestHandler');
	var $helpers = array('Xml', 'Time');
	var $uses = array('News', 'User');

	function index(){
		header ("content-type: text/xml");
		$this->autoLayout='false';
		$sitemap = Cache::read ( "sitemap", 'vLong' );
		if(empty($sitemap)){
			App::Import('Core','Xml');
			$filename = WWW_ROOT.'sitemap_basic.xml';
			$xmlHandle = fopen($filename, "r");
			$xml_base = fread($xmlHandle, filesize($filename));
			fclose($xmlHandle);
			$xml = new Xml($xml_base);
			$sitemap = $xml->toArray();
			/* valores admitidos para changefreq
			 * always
			   hourly
			   daily
			   weekly
			   monthly
			   yearly
			   never
			 */
			//obtengo los usuarios que tienen creadas noticias para ser indizados
			$usrs = $this->User->usersWithNews();
			$domain = Router::url('/', true);
			//agrego los usuarios al sitemap base
			foreach ($usrs as $row) {
				$alias = !empty($row['User']['alias'])?$row['User']['alias']:$row['User']['posteamos_alias'];
				$aux = array(
					'loc' => $domain.'columna/'.$alias.".html",
					'priority' => 1,
					'changefreq'	=> "weekly",
					'lastmod'	=>	time()
				);
				$sitemap['Urlset']['Url'][]=$aux;
			}
			$sitemap = $sitemap['Urlset']['Url'];
			Cache::write ( "sitemap", $sitemap, 'vLong' );
			
			//hago ping a los buscadores (por ahora google y bing)
			App::import('Core', 'HttpSocket');
			$HttpSocket = new HttpSocket();
			$results = $HttpSocket->get('http://www.google.com/ping', "sitemap={$domain}sitemap.xml");
			$response = $HttpSocket->response;
			CakeLog::write('debug', "Enviado sitemap a Google. Resultado: {$response['raw']['status-line']}");
			$results = $HttpSocket->get('http://www.bing.com/ping', "sitemap={$domain}sitemap.xml");
			debug($HttpSocket->response);
			CakeLog::write('debug', "Enviado sitemap a Bing. Resultado: {$response['raw']['status-line']}");
			CakeLog::write('debug', 'Something did not work');
		}
		$this->set('urls', $sitemap);
		$this->render('sitemap');
   }
}
?>
