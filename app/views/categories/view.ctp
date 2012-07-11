<div id="content">
	<div id="colLeft">
		<?php
			//debug($category);
			if (!empty($category['News'])) {
				$ppl = array_shift($category['News']);
				$currDate = date_create($ppl['created']);
				$variables = array(
					'category'		=>	$category['Category']['name'],
					'pplTitle'			=>	$ppl['title'],
					'pplTitle_url'		=>	"/news/view/".$ppl['id'],
					'new_photo'		=>	!empty($ppl['Media'][0]['url'])?$ppl['Media'][0]['url']:null,
					'description'	=>	Sanitize::clean(html_entity_decode($ppl['summary'],ENT_COMPAT,'UTF-8'),array('remove_html'=>true)),
					'comments'		=>	count($ppl['Comment']),
					'comments_url'	=>	"view/".$ppl['id']."/#comments",
					'created'		=>	date_format($currDate, "H:i")."h",
					'photos'		=>	1,
					'photos_url'	=>	"view/".$ppl['id'],
					'usr'			=>	!empty($ppl['User'])?$ppl['User']['alias']:'',
					'votes'			=>	$ppl['votes'],
					'feedImg'		=>	$ppl['Feed']['image_url'],
					'feedImgTitle'	=>	(array_key_exists('Source', $ppl['Feed']) && !empty($ppl['Feed']['Source']))?$ppl['Feed']['Source']['name']:null,
					'feedImgLink'	=>	$ppl['Feed']['image_link']
				);
				echo $this->element("widgets".DS."timeline_ppl_new", $variables);
				foreach ($category['News'] as $news) {
					echo $this->element("widgets".DS."timeline_other_news", array('news'=>$news));
				}
			}else {
				echo __("No existen noticias en esta categoría",true);
			}
		?>

	</div>
	<div id="colRight">
	</div>
	<br clear="all"/>
</div>