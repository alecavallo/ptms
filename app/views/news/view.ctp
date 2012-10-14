<?php
	echo $this->Html->script(array('prototype','Marquee'),array('inline'=>false));
	echo $this->Html->script(array('tweeter/jquery'),array('inline'=>false, 'once'=>true));
	echo $this->Html->script('scriptaculous',array('inline'=>false));
	echo $this->Html->script('common',array('inline'=>false, 'once'=>true));
	echo $this->Html->css(array('idb-posteamos', 'relatedNews'));
	//$js->buffer($facebookInit);
	//$js->writeBuffer(array('inline'=>true, 'safe'=>true));

	$js->buffer("function sendRequest(){ {$this->Js->request('/visits/incrementaContador/'.$news['News']['id'])} }; setTimeout(sendRequest, 9000);");
	//$js->buffer("setTimeout(sendRequest, 9000)");
	//echo $this->Html->script('common',array('inline'=>false));
	//debug($news);
	$category = array_key_exists(0, $news['Category'])?$news['Category'][0]['name']:$news['Category']['name'];
	$date = $news['News']['created']>$news['News']['modified']?$news['News']['created']:$news['News']['modified'];
	$fecha= strtotime($date); // convierte la fecha de formato mm/dd/yyyy a marca de tiempo
    $diasemana=date("w", $fecha);// optiene el número del dia de la semana. El 0 es domingo
       switch ($diasemana)
       {
       case "0":
          $diasemana="Domingo";
          break;
       case "1":
          $diasemana="Lunes";
          break;
       case "2":
          $diasemana="Martes";
          break;
       case "3":
          $diasemana="Miércoles";
          break;
       case "4":
          $diasemana="Jueves";
          break;
       case "5":
          $diasemana="Viernes";
          break;
       case "6":
          $diasemana="Sábado";
          break;
       }
    $dia=date("d",$fecha); // día del mes en número
    $mes=date("m",$fecha); // número del mes de 01 a 12
       switch($mes)
       {
       case "01":
          $mes="Enero";
          break;
       case "02":
          $mes="Febrero";
          break;
       case "03":
          $mes="Marzo";
          break;
       case "04":
          $mes="Abril";
          break;
       case "05":
          $mes="Mayo";
          break;
       case "06":
          $mes="Junio";
          break;
       case "07":
          $mes="Julio";
          break;
       case "08":
          $mes="Agosto";
          break;
       case "09":
          $mes="Septiembre";
          break;
       case "10":
          $mes="Octubre";
          break;
       case "11":
          $mes="Noviembre";
          break;
       case "12":
          $mes="Diciembre";
          break;
       }
    $ano = date("Y",$fecha); // optenemos el año en formato 4 digitos
    //$hora = date("H:i:s", $fecha);
    $fecha = $diasemana.", ".$dia." de ".$mes." de ".$ano;

    $date = $fecha;
?>
<?php
if (isset($preview) && $preview == true) {
?>
<div class="steps">
	<div id="scontainer">
		<div class="step completed">
			<div class="indicator" id="st1"><h3>1</h3></div>
			<h3 id="std1">Escribe el artículo</h3>
		</div>
		<div class="step completed">
			<div class="indicator" id="st3"><h3>2</h3></div>
			<h3 id="std3">Previsualizar</h3>
		</div>
		<div class="step">
			<div class="indicator" id="st4"><h3>3</h3></div>
			<h3 id="std4">Publicar o Guardar</h3>
		</div>
	</div>
</div>
<?php
}
?>
<input type="hidden" id="newsId" value="<?php echo $news['News']['id'];?>" />
<input type="hidden" id="categoryId" value="<?php echo $news['Category']['id'];?>" />
<div id="content">
	<?php //echo $this->element("news".DS."category_selector",array('selected'=>array_key_exists(0, $news['Category'])?$news['Category'][0]['id']:$news['Category']['id'],'newsId'=>$news['News']['id']))?>
	<h4 class="section grey">
		<?php
			//echo $html->link($category,"#nogo",array('onclick'=>"$('catSelector').fadeIn();",'escape'=>false));
			//$this->Js->get('#catSelector');
			//$effect = $this->Js->effect('fadeIn');
			//$effect = str_replace("\"", "'", $effect);
			//echo $html->link($category,"#nogo",array('onclick'=>$effect,'escape'=>false));
			echo $category
		?>
	</h4>

	<h1 class="title colLeftSize"><?php echo $news['News']['title']; ?></h1>
	<br/>
	<hr class="black20" />
	<div id="news">
		<div id="NewscolLeft">
			<div class="newsData">
				<?php 
					if (empty($news['User']['posteamos_alias']) && empty($news['User']['alias'])) {
						$usr = $news['Feed']['Source']['name'];
					}elseif (!empty($news['User']['posteamos_alias'])){
						$usr = $news['User']['posteamos_alias'];
					}else{
						$user = empty($news['User']['alias']);
					}
				?>
				<span class="date" itemscope itemtype="http://schema.org/Person"> Por <span itemprop="name"><?php echo $usr?></span> | <span><?php echo $date ?>
			</div>
			<div class="copete">
				<?php echo $news['News']['summary']?>
			</div>
			<?php 
			$multimedia=null; 
			if (!empty($images) && !empty($images[0]['Media']['url'])) {
				echo $this->element("widgets".DS."multimedia", array('multimedia'=>$multimedia, 'newsId'=>$news['News']['id']));
			}
			
			?>
			<script type="text/javascript">
				(function() {
					var img = $$('img.fittedImg');
					img.onload = function() {
					    if(img.height > img.width) {
					        img.setStyle({height: '100%', width: 'auto'});
					    }else{
					    	img.setStyle({height: 'auto', width: '100%'});
					    }
					};
				}());
			</script>
			<p id="body">
			<?php echo (html_entity_decode($news['News']['body']))?>
			</p>
			<?php
				if (array_key_exists('Feed', $news) && array_key_exists('Source', $news['Feed'])) {
					echo $html->link("ver nota completa en <b>{$news['Feed']['Source']['name']}</b>...",$news['News']['link'], array('id'=>"n".$news['News']['id'], 'escape'=>false, 'class'=>"green right", 'style'=>"font-size: 12px;", 'target'=>"_blank", 'rel'=>"nofollow"));
				}

				?>

			<div id="comments">
				<?php 
					if (!empty($related)) {
						echo "<h2 id=\"other-news-title\">Ésto dicen otras fuentes:</h2>";
						foreach ($related as $row) {
							$par = array(
								'image'=> "/img/".$row['Source']['icon'],
								'title'	=> $row['news']['title'],
								'summary'	=> $row['news']['summary'],
								'link'	=>	strtolower("/medios/".Inflector::slug($row['Source']['name'],"-")."/noticia/".$row['news']['id']."-".Inflector::slug($row['news']['title'],"-").".html"),
								'titleRating'	=> $row['relevancia_titulo'],
								'generalRating'	=> $row['relevancia_total'],
							);
							echo $this->element('news'.DS."related_news", array('params'=> $par));
						}
					}
					
				?>
				<div id="other-news">
				</div>
			</div>
			<div class="clearFloat">
		 	<script type="text/javascript">
				var idcomments_acct = '19f7342c71062346f906e674904d040b';
				var idcomments_post_id;
				var idcomments_post_url;
			</script>
			<script type="text/javascript" src="http://www.intensedebate.com/js/genericLinkWrapperV2.js"></script>
	 	</div>
	</div>

 	<div id="NewscolRight">
 	<?php
 	if (!isset($preview) || $preview == false) {
 		//echo $facebook->recommendations(array('width'=>"264px"));
 	}
 	if (!empty($news['News']['tags'])) {
 		$tweetData = array(
			'title'			=>	__('Comentarios en twitter sobre la noticia', true),
			'subtitle'		=>	__($news['News']['title'], true),
			'coordinates'	=>	"{$news['News']['latitude']},{$news['News']['longitude']},{$news['News']['ratio']}km",
			'search'		=>	str_ireplace("|#|", " OR ", $news['News']['tags'])
		);
		echo $this->Html->tag('br');
		echo $this->Html->tag('br');
		echo $this->Html->tag('br');
	 	echo $this->element('twitterFeed264px',array('tweetData'=>$tweetData));
 	}

 	?>
 	
 	<?php
		if(Router::url("/",true) != "http://posteamos.localhost.com/"){//
		?>
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6965617047977932";
		/* Banner Largo Vertical */
		google_ad_slot = "0183084197";
		google_ad_width = 160;
		google_ad_height = 600;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<?php }?>
 	
 	
 	</div>

 	<script type="text/javascript">
 		setTimeout("jQuery('div.clearFloat > a')[0].click();", 3700);
 	</script>
 	<div class="clearFloat"></div>
 	<?php
		if(Router::url("/",true) != "http://posteamos.localhost.com/"){//
	?>
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-6965617047977932";
	/* Footer-Bloque Anuncios */
	google_ad_slot = "6067688955";
	google_ad_width = 728;
	google_ad_height = 15;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<?php }?>
</div>
<?php
	echo $js->writeBuffer(array('inline'=>true, 'safe'=>true));
?>
