<?php
//echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>false, 'once'=>true));
//echo $this->Html->script(array('effects', 'common', 'scriptaculous'),array('inline'=>false, 'once'=>true));
?>
<div id="content">
		<h3 id="searchResult"> Resultados de la búsqueda: </h3>
    	<div id="colLeft">
			<h1 class="greyTitle" style="margin-bottom: 20px;">Twitters</h1>
			<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
			<div id="tweets">
			<?php
				$userTimezone = new DateTimeZone('America/Argentina/Buenos_Aires');
				$gmtTimezone = new DateTimeZone('GMT');
				foreach ($twitters as $row) {
					$aux['text'] = $row['text'];
					$aux['username'] = $row['from_user'];
					$aux['profile_img'] = $row['profile_image_url'];
					//$aux['Category'] = "";
					$aux['Category']['name'] = "";
					//$myDateTime = new DateTime($row['created_at']);
					$myDateTime = new DateTime($row['created_at'], $gmtTimezone);
					$offset = $userTimezone->getOffset($myDateTime);
					$date = date('d-m-Y H:i', $myDateTime->format('U') + $offset);
					$aux['created'] = $date;
					echo $this->element("widgets".DS."timeline_twitter", array('tweet'=>$aux));
				}

			?>

        	</div>
       </div>
        <div id="colCenter">
        	<h1 class="greyTitle">Medios</h1>
        	<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
        	<?php
				if (!empty($news)) {
					foreach ($news as $row) {
						if (array_key_exists('News', $row)) {
							$aux = $row['News'];
							$aux['Media'] = $row['Media'];
							$aux['User'] = $row['User'];
							$aux['Source'] = $row['Feed']['Source'];
							$aux['Feed'] = $row['Feed'];
							$aux['Category'] = $row['Category'];
							echo $this->element("widgets".DS."timeline_other_news", array('news'=>$aux));
						}elseif (array_key_exists('Ad', $row)){
							echo $this->element("widgets".DS."news_ads", array('ad'=>$row));
						}


					}
				}
			?>
			</div>

        <div id="colRight">
        	<h1 class="greyTitle">Blogs</h1>
        	<?php echo $html->image('degradee.png', array('alt'=>"", 'class'=>"degradee"));?>
        	<?php
        		//debug($blogs);
        		foreach ($blogs as $row) {
        			if (array_key_exists('News', $row)) {
						$aux = $row['News'];
						$aux['Media'] = $row['Media'];
						$aux['User'] = $row['User'];
						$aux['Source'] = $row['Feed']['Source'];
						$aux['Source']['icon'] = $row['Feed']['image_url'];
						$aux['Feed'] = $row['Feed'];
						$aux['Category'] = $row['Category'];
						echo $this->element("widgets".DS."timeline_other_news", array('news'=>$aux));
        			}elseif (array_key_exists('Ad', $row)){
						echo $this->element("widgets".DS."news_ads", array('ad'=>$row));
					}
				}
        	?>
        </div>
        <br clear="all"/>
    </div>