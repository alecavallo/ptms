<?php

//require_once ('cake\libs\view\helpers\app_helper.php');

/**
 * @author Alejandro
 *
 *
 */
class MenuHelper extends AppHelper {

	var $helpers = array('Ajax', 'Javascript', 'Html');
	private $text;

	public function generate($tree, $elmId, $ulClass="", $listClass="", $linkClass="", $optString=""){
		$elements = "";
		//debug($tree);
		foreach ($tree as $elem) {
			if (!empty($elem['children'])) {
				$elements .= $this->Html->tag('li', $this->Html->link((strtolower($elem['Category']['name'])),!empty($elem['Category']['url'])?$elem['Category']['url']:'', array('class'=>$linkClass)).$this->generate($elem['children'], null, null, $listClass, $linkClass), array('class'=>$listClass));
			}else {
				$elements .= $this->Html->tag('li', $this->Html->link((strtolower($elem['Category']['name'])),!empty($elem['Category']['url'])?$elem['Category']['url']:'', array('class'=>$linkClass)), array('class'=>$listClass));
			}
		}
		$this->text = $this->Html->tag("ul",$elements, array('id'=>$elmId));
		return $this->text;
	}

	public function add($name, $url, $menu, $pos="beginning", $linkClass="", $liClass=""){
		if (empty($menu)) {
			return false;
		}
		//$node = $this->Html->tag('li', $this->Html->link($name,$url, array('class'=>$linkClass)));
		$parsedMenu = new DOMDocument('1.0', 'utf-8');
		$menu = utf8_decode($menu);
		$parsedMenu->loadHTML($menu);
		
		if(stripos($name, "<img")!== false){
			$parsedImage = new DOMDocument();
			$image = utf8_decode($name);
			$parsedImage->loadHTML($image);
			$link = $parsedMenu->createElement('a', "ss");
			$link->appendChild($parsedImage);
		}else {
			$link = $parsedMenu->createElement('a', $name);
		}

		
		$link->setAttribute('href', Router::url($url));
		$link->setAttribute('class', $linkClass);
		$node = $parsedMenu->createElement('li');
		$node->setAttribute('class', $liClass);
		$node->appendChild($link);

		$ul = $parsedMenu->getElementsByTagName('ul')->item(0);

		switch ($pos) {
			case 'beginning':
				if ($ul->hasChildNodes()) {
				    $ul->insertBefore($node,$ul->firstChild);
				} else {
				    $ul->appendChild($node);
				}
			break;

			default:
				$ul->appendChild($node);
			break;
		}

		$ret = $parsedMenu->saveHTML();
		$ret = str_ireplace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $ret);
		$ret = str_ireplace('<html>', '', $ret);
		$ret = str_ireplace('<body>', '', $ret);
		$ret = str_ireplace('</html>', '', $ret);
		$ret = str_ireplace('</body>', '', $ret);
		
		return $ret;
	}

}

?>