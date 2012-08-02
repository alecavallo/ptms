<?php
/**
 * @author Alejandro
 *
 *
 */
class JqautocompleteHelper extends AppHelper {

	var $helpers = array("Js"=>"Jquery", "Html", "Form");
	var $data;
	

	function searchbox($elmId, $data, $isUrl=false, $options = array(), $htmlOptions=array()) {
		
    	$this->Js->JqueryEngine->jQueryObject = 'jQuery';
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
			'minChars'			=>	2,
			'keyDelay'			=>	200,
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
		if (!empty($data) && $isUrl==false) {
			$elName = explode(".", $elmId);
			if (count($elName) == 1) {
				$domId = $elName;
			}else {
				$elName[1] = Inflector::camelize($elName[1]);
				$domId = implode("", $elName);
			}
			//$searchbox .= "jQuery(document).ready(function(){jQuery(\"{$elmId}\").autoSuggest({$data}, {$optList})});";
			$searchbox .= "jQuery(\"#$domId\").autoSuggest({$data}, {$optList});";
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
			$searchbox = "jQuery(\"#$domId\").autoSuggest(\"".Router::url($data,true)."\", {$optList});";
			$this->Js->buffer($searchbox);
			//echo $this->Js->writeBuffer(array('inline'=>true, 'safe'=>true));
		}
		echo $this->Html->css('autoSuggest', null, array('inline'=>false));
		//echo $this->Html->script('jquery',array('inline'=>false,'once'=>true));
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