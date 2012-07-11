<div class="tNews">
	<?php
		echo $html->link(
			$html->image($ad['Ad']['url'], array('alt'=>$ad['Ad']['name'])),
			$ad['Ad']['link'],
			array('escape' => false,'target'=>"_blank", 'style'=>"display: block; width: 380px; margin-left: auto; margin-right: auto;")
		);
	?>
</div>