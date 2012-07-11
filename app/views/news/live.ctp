<?php
	foreach ($lNews['News'] as $row) {
		if (!empty($row['user_id'])) {
			$class="userNews";
		}elseif (!empty($row['feed_id'])) {
			$class="rssNews";
		}else {
			$class="seed";
		}
		echo $html->tag('li',
			$html->tag("h3",
				$html->link(
					$text->truncate(__($row['title'],true), 80, array('ending'=>'[...]', 'exact'=>false, 'html'=>true)),
						array('action'=>"view", $row['id']),array('escape'=>false)
				),
				array('class'=>"wTitle")
			).$html->tag('span',!empty($row['User']['name'])?$row['User']['name']:"RSS"),
			array('class'=>$class)
		);
	}
?>
