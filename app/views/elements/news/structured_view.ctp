        	<?php
        		$ppl = $hNews[0];
        		//debug($ppl);
        		//debug($hNews);
        		$currDate = date_create($ppl['News']['created']);
        		$variables = array(
        			'category'		=>	$ppl['Category']['name'],
        			'pplTitle'			=>	$ppl['News']['title'],
        			'pplTitle_url'		=>	"view/".$ppl['News']['id'],
        			'new_photo'		=>	!empty($ppl['Media'])?$ppl['Media'][0]['url']:null,
        			'description'	=>	$ppl['News']['summary'],
        			'comments'		=>	count($ppl['Comment']),
        			'comments_url'	=>	"view/".$ppl['News']['id']."/#comments",
        			'created'		=>	date_format($currDate, "H:i")."h",
        			'photos'		=>	1,
        			'photos_url'	=>	"view/".$ppl['News']['id'],
        			'usr'			=>	$ppl['User']['alias'],
        			'votes'			=>	$ppl['News']['votes'],
        			'feedImg'		=>	$ppl['Feed']['image_url'],
        			'feedImgTitle'	=>	$ppl['Feed']['Source']['name'],
        			'feedImgLink'	=>	$ppl['Feed']['image_link']
        		);
        		echo $this->element("widgets".DS."ppl_new", $variables);
        	?>
            <div id="secNews">
				<?php
					array_shift($hNews);
					$i=0;
					foreach ($hNews as $new) {

		        		$currDate = date_create($new['News']['created']);
		        		$variables = array(
		        			'elmId'			=>	'new'.$i,
		        			'secCategory'	=>	$new['Category']['name'],
		        			'secTitle'		=>	$new['News']['title'],
		        			'secTitle_url'	=>	"view/".$new['News']['id'],
		        			'secNewsPhoto'	=>	!empty($new['Media'])?$new['Media'][0]['url']:null,
		        			'secDescription'	=>	$new['News']['summary'],
		        			'secComments'		=>	count($new['Comment']),
		        			'secComments_url'	=>	"view/".$new['News']['id']."/#comments",
		        			'secCreated'		=>	date_format($currDate, "H:i")."h",
		        			'secPhotos'		=>	1,
		        			'secPhotos_url'	=>	"view/".$new['News']['id'],
		        			'secUsr'			=>	$new['User']['alias'],
		        			'secVotes'			=>	$new['News']['votes'],
		        			'feedImg'			=>	$new['Feed']['image_url'],
		        			'feedImgTitle'		=>	$new['Feed']['Source']['name'],
		        			'feedImgLink'		=>	$new['Feed']['image_link']
		        		);
		        		echo $this->element("widgets".DS."sec_new", $variables);
		        		$i++;
					}
				?>

            </div>
            <div id="widgetContainer">
            	<?php
            		$par = $this->requestAction("news/getLocals");
            		//debug($par);
            		if(!empty($par[0])){
            			echo $this->element("widgets".DS."hlongwidget", array('par'=>$par));
            		}

            		$live = $this->requestAction("news/live");
					echo $this->element("widgets".DS."hsmallwidget", array('lNews'=>$live));
					echo $ajax->remoteTimer(
						array(
						'url' => array("controller"=>"news","action"=>"live",true,Configure::read('liveSync')),
						'update' => 'liveNewsContainer',
						'position' => 'top', 'frequency' => Configure::read('liveSync')
						)
					);


            	?>

                <br clear="left"/>
				<?php echo $this->element("widgets".DS."hlongimgwidget", array('par'=>array('wId'=>4,'wTitle'=>"La semana en imágenes")))?>

            </div>
            <br clear="all"/>
