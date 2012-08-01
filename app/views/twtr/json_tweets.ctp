<?php
if (!empty($twitters)) {
	$block= array();
	$lastId = 0;
	foreach ($twitters as $row) {
		$lastId = $row['id'] > $lastId?$row['id']:$lastId;
		$aux['text'] = $row['text'];
		$aux['username'] = $row['user'];
		$aux['profile_img'] = $row['profile_img'];
		$aux['Category']['name'] = $row['category'];;
		$aux['created'] = $row['created'];
		$block[0][] = $this->element("widgets".DS."timeline_twitter", array('tweet'=>$aux, 'customStyle'=> ""));
	}
	$block[1]=$lastId;
}else {
	$block = array(array(),$last);
}

echo json_encode($block);
?>