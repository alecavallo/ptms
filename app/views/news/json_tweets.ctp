<?php
$block= array();
foreach ($twitters as $row) {
	$aux['text'] = $row['text'];
	$aux['username'] = $row['user'];
	$aux['profile_img'] = $row['profile_img'];
	$aux['Category']['name'] = $row['category'];;
	$aux['created'] = $row['created'];
	$block[] = $this->element("widgets".DS."timeline_twitter", array('tweet'=>$aux));
}
echo json_encode($block);
?>