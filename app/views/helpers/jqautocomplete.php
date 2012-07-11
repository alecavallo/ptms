<?php
/**
 * @author Alejandro
 *
 *
 */
class JqautocompleteHelper extends AppHelper {

	var $helpers = array("Js", "Html", "Form");
	var $data;

	function searchbox($elmId, $data, $options = array(), $htmlOptions=array()) {
		$htmlOptions = array_merge($htmlOptions, array('type'=>"text",'div'=>false));
		$input = $this->Form->input($elmId,$htmlOptions);
		$dfltOptions = array(
			'asHtmlID'			=>	"false",
			'startText'			=>	"Ingrese el texto aquí",
			'emptyText'			=>	"No existen resultados",
			'preFill'			=>	"",
			'limitText'			=>	"No son permitidas mas selecciones",
			'selectedItemProp'	=>	"value",
			'selectedValuesProp'=>	"value",
			'searchObjProps'	=>	"value",
			'queryParam'		=>	"q",
			'retrieveLimit'		=>	"50",
			'extraParams'		=>	"",
			'matchCase'			=>	"false",
			'minChars'			=>	1,
			'keyDelay'			=>	400,
			'resultsHighlight'	=>	"true",
			'neverSubmit'		=>	"false",
			'selectionLimit'	=>	"false",
			'showResultList'	=>	"true",
			'start'				=>	"",
			'selectionClick'	=>	"",
			'selectionAdded'	=>	"",
			'selectionRemoved'	=>	"",
			'formatList'		=>	"",
			'beforeRetrieve'	=>	"",
			'retrieveComplete'	=>	"",
			'resultClick'		=>	"",
			'resultsComplete'	=>	""
		);
		$options = array_merge($dfltOptions, $options);
		$optList = "{";
		foreach ($options as $key=>$value) {
			if (!empty($value)) {
				$optList .= $key.": ";
				if (strpos(trim($value), "function(")===0) {
					$optList.= $value.", ";
				}else {
					if (is_numeric($value)) {
						;$optList .= $value.", ";
					}elseif (strtolower(trim($value)) == "true" || strtolower(trim($value)) == "false"){
						$optList .= $value.", ";
					}else{
						$optList .= "\"".$value."\", ";
					}

				}
			}
		}
		$optList = substr($optList, 0, -2);
		$optList .= "}";
		$searchbox="";
		if (!empty($data) && is_array($data)) {
			$this->set($data);
			$dataList = "data = {items: [";
			foreach ($data as $value) {
				$dataList .= "{value: \"{$value}\"},";
			}
			$dataList .= substr($searchbox, 0, count_chars($searchbox)-1);
			$dataList .= "]};";
			$this->Js->buffer($dataList);
			$elName = explode(".", $elmId);
			if (count($elName) == 1) {
				$domId = $elName;
			}else {
				$elName[1] = Inflector::camelize($elName[1]);
				$domId = implode("", $elName);
			}
			$searchbox .= "$(\"{$domId}\").autoSuggest(data.items, {$optList});";
			$this->Js->buffer($searchbox);

			//echo $this->Js->writeBuffer(array('inline'=>true, 'safe'=>true));
		}else {
			$elName = explode(".", $elmId);
			if (count($elName) == 1) {
				$domId = $elName;
			}else {
				$elName[1] = Inflector::camelize($elName[1]);
				$domId = implode("", $elName);
			}
			$searchbox = "$(\"#$domId\").autoSuggest(\"".Router::url($data,true)."\", {$optList});";
			$this->Js->buffer($searchbox);
			//echo $this->Js->writeBuffer(array('inline'=>true, 'safe'=>true));
		}
		echo $this->Html->css('autoSuggest', null, array('inline'=>false));
		echo $this->Html->script('jquery',array('inline'=>false,'once'=>true));
		echo $this->Html->script('jquery.autoSuggest.minified',array('inline'=>false,'once'=>true));



		//echo $this->Js->writeBuffer(array('inline'=>false, 'safe'=>true));
		/*$scripts = "";
		foreach ($this->Js->getBuffer(true) as $sentence) {
			$scripts .= $sentence ." \n ";
		}*/

		return $input;
	}
}
?>