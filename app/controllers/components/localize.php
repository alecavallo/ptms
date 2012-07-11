<?php

/**
 * @author Alejandro
 *
 *
 */
class LocalizeComponent extends Object {

	const WS = "http://xml.utrace.de/?query=";
	const WARN_QRY_LVL = 75;

	/**
	 * Consulta la localizaci�n de una IP y devuelve un arreglo con datos como ISP, region, pa�s, latitud, longitud, etc
	 * @param string $ip
	 * @return array or false in case of error
	 */
	function query($ip){
		$url = LocalizeComponent::WS;
		$xml = simplexml_load_file($url.$ip);
		if ($xml === false) {
			return false;
		}

		echo $xml->asXML();

		$response = array(
			'ip'			=>	$xml->ip,
			'isp'			=>	$xml->isp,
			'org'			=>	$xml->org,
			'region'		=>	$xml->region,
			'countryCode'	=>	$xml->countrycode,
			'latitude'		=>	$xml->latitude,
			'longitude'		=>	$xml->longitude,
			'queries'		=>	$xml->queries
		);
		if($xml->queries >= LocalizeComponent::WARN_QRY_LVL){
			$this->log("Se alcanzó el nivel máximo de consultas. Un total de {$xml->queries} sobre un total de 100");
		}
		return $response;
	}

}
?>