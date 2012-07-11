<?php

class ParseCSVComponent extends Object {
	private $file;
	private $data;
	private $headers;
	private $encoding;

	function __construct() {
		$this->data = array();
		$this->headers = array();
	}

	function setEncoding($enc) {
		$this->encoding = $enc;
		mb_internal_encoding($enc);
	}

	function setFile($url,$has_header=true){
		if (($handle = fopen($url, "r")) !== FALSE) {
			while (($row = fgetcsv($handle, 2000, ";"))!==false) {

				if (!empty($this->encoding)) {
					foreach ($row as $key=>$val) {
						$row[$key] = mb_convert_encoding($val, $this->encoding,mb_detect_encoding($val, "UTF-8, ISO-8859-1", true));
					}
				}
				$this->data[]=$row;
			}
			$this->headers = array_shift($this->data);
			return true;
		}else {
			return false;
		}
	}

	function getData() {
		return array($this->headers, $this->data);
	}

	function __destruct() {
		unset($this->headers);
		unset($this->data);
		unset($this->file);
	}
}

/*$parser = new ParseCSV();
$parser->setFile("fuentes2.csv");
var_dump($parser->getData());*/

?>