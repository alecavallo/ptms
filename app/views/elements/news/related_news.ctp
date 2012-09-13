<div class="relNews">
	<article>
	<div class="photo"><img alt="" src="<?php echo $params['image'] ?>" /> </div>
	<div class="newsContent">
		<header>
		<h3><a href="<?php echo $params['link'] ?>" target="_self"><?php echo $params['title'] ?></a></h3>
		</header>
		<p><?php echo $params['summary'] ?></p>
		<input type="hidden" id="newsId" value="<?php echo $params['titleRating'] ?> -- <?php echo $params['generalRating'] ?>" />
	</div>
	</article>
</div>