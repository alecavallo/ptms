<?php
	echo $this->Html->script('prototype',array('inline'=>false));
	echo $this->Html->script('scriptaculous',array('inline'=>false));
	echo $this->Html->script('common',array('inline'=>false, 'once'=>true));

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
    $hora = date("H:i:s", $fecha);
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
<div id="content">
	<?php echo $this->element("news".DS."category_selector",array('selected'=>array_key_exists(0, $news['Category'])?$news['Category'][0]['id']:$news['Category']['id'],'newsId'=>$news['News']['id']))?>
	<h4 class="section aqua">
		<?php
			//echo $html->link($category,"#nogo",array('onclick'=>"$('catSelector').fadeIn();",'escape'=>false));
			$this->Js->get('#catSelector');
			$effect = $this->Js->effect('fadeIn');
			$effect = str_replace("\"", "'", $effect);
			echo $html->link($category,"#nogo",array('onclick'=>$effect,'escape'=>false));
		?>
	</h4>

	<h1 class="title colLeftSize"><?php echo $news['News']['title']; ?></h1>
	<br/>
	<hr class="black20" noshade="noshade" size="1" />
	<div id="news">
		<div id="NewscolLeft">
			<div class="newsData">
				<span class="date"> Por <?php echo empty($usr)?"RSS":$usr?> | <?php echo $date ?> | <?php echo $hora ?> Hs</span>
			</div>
			<div class="copete">
				<?php echo $news['News']['summary']?>
			</div>
			<?php $multimedia=null; echo $this->element("widgets".DS."multimedia", array('multimedia'=>$multimedia, 'newsId'=>$news['News']['id']));?>
			<?php echo nl2br(html_entity_decode($news['News']['body']))?>
			<br />
			<?php
				if (array_key_exists('Feed', $news) && array_key_exists('Source', $news['Feed'])) {
					echo $html->link("ver nota completa en <b>{$news['Feed']['Source']['name']}</b>...",$news['News']['link'], array('id'=>"n".$news['News']['id'], 'escape'=>false, 'class'=>"green right", 'style'=>"font-size: 12px;", 'target'=>"_blank"));
				}

				?>
			<br clear="all"/>
			<div class="NewsBar">
				<div id="ToolBar">
					<?php
						$img = $html->image('print-02.png',array('class'=>'link'));
						echo $html->link($img,"#nogo",array('onclick'=>"window.print()",'escape'=>false));
						echo $html->image('pipe-07.png',array('alt'=>"agregar imágen",'class'=>'separator'));
						$img = $html->image('photo-03.png',array('class'=>'link'));
						echo $html->link($img,"#nogo",array('onclick'=>"window.print()",'escape'=>false));
						echo $html->image('pipe-07.png',array('alt'=>"agregar imágen",'class'=>'separator'));
						$img = $html->image('mail-04.png',array('class'=>'link'));
						echo $html->link($img,"#nogo",array('onclick'=>"window.print()",'escape'=>false));
						echo $html->image('pipe-07.png',array('alt'=>"agregar imágen",'class'=>'separator'));
						$img = $html->image('comment-05.png',array('class'=>'link'));
						echo $html->link($img,"#comments",array('escape'=>false));
						echo $html->image('pipe-07.png',array('alt'=>"agregar imágen",'class'=>'separator'));
						$img = $html->image('report_error-06.png',array('class'=>'link'));
						echo $html->link($img,"#nogo",array('onclick'=>"window.print()",'escape'=>false));
					?>
				</div>
				<?php
				if (!isset($preview) || $preview == false) {
				?>
					<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'110fd1f9-35e1-4aa4-999d-45677dfd296d'});</script>
				<?php }?>
					<div id="SocialBar">
					<span class="st_twitter_vcount" displayText="Tweet"></span><span class="st_facebook_vcount" displayText="Share"></span><span class="st_email_vcount" displayText="Email"></span><span class="st_sharethis_vcount" displayText="Share"></span>
					<span>

				</span>
				</div>
			</div>
			<div id="comments">
				<?php
					if (!isset($preview) || $preview == false) {
						echo $facebook->comments(array('numpost'=>7));
					}else {
						$buttons = $this->Html->link(__('Anterior',true),array('controller'=>"news", 'action'=>"add", "step:2"), array('class'=>"prevBtn"));
						$buttons .= $this->Html->link(__('Publicar',true),array('controller'=>"news", 'action'=>"add", "publicar"), array('class'=>"nextBtn"));
						$buttons .= $this->Html->tag('br',null,array('clear'=>"both"));
						echo $this->Html->div('right',$buttons,array('style'=>"margin-right: 30px; margin-bottom: 15px; width: 309px; font-size: 15px"));
					}
				?>

			</div>
		</div>
	</div>

 	<div id="NewscolRight">
 	<?php
 	if (!isset($preview) || $preview == false) {
 		echo $facebook->recommendations(array('width'=>"264px"));
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
 	</div>
	<br clear="all"/>
</div>
<?php
	echo $js->writeBuffer(array('inline'=>true, 'safe'=>true));
?>
