<div class="smallWidget" style="float:right;">
                	<div id="enVivo" class="widgetTitle">
                    	<h4 class="title"> <?php __($lNews['sTitle'])?> </h4>
                        <span class="controls"><a href="#nogo" id="mx<?php echo $lNews['wid']?>" class="minimize" onclick="expCol('mx<?php echo $lNews['wid']?>','w<?php echo $lNews['wid']?>',300);"></a><a href="#nogo" id="cf<?php echo $lNews['wid']?>" class="configure" onclick="showPopup('cfb<?php echo $lNews['wid']?>', 3)"></a></span>
                        <div id="cfb<?php echo $lNews['wid']?>" class="configBox" style="display:none;">
                        	<a href="#nogo" onclick="Effect.Fade('cfb<?php echo $lNews['wid']?>', {duration: 1.0});" style="float:right;"> <?php __('Cerrar')?> </a><br/><br/>
                        	<?php echo $lNews['conf_content']?>

                        </div>
                    </div>

              <div class="widgetContent" id="w<?php echo $lNews['wid']?>">
                    	<div class="wRow oNews">
                        	<ul id="liveNewsContainer">
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
                            </ul>
                        </div>
                    </div>
                  <div class="widgetLowerBorder" id="wl<?php echo $lNews['wid']?>"></div>
                </div>