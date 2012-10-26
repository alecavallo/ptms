<?php
//echo $this->Xml->header();//XML header
?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php 
		foreach ($urls as $row) {
	?>
		<url>
			<loc><?php echo $row['loc']?></loc>
			<?php if (!empty($row['lastmod'])) {?>
				<lastmod><?php echo date('Y-m-d',$row['lastmod'])?></lastmod>
			<?php }?>
			<priority><?php echo $row['priority']?></priority>
			<changefreq><?php echo $row['changefreq']?></changefreq>
		</url>
	<?php
		}
	?>
				
	</urlset>