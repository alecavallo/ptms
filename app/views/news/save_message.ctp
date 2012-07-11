<?php
	echo $this->Html->script('prototype',array('inline'=>false));
?>
<div class="steps">
	<div id="scontainer">
		<div class="step completed">
			<div class="indicator" id="st1"><h3>1</h3></div>
			<h3 id="std1">Escribe el artículo</h3>
		</div>
		<div class="step completed">
			<div class="indicator" id="st2"><h3>2</h3></div>
			<h3 id="std2">Opciones</h3>
		</div>
		<div class="step completed">
			<div class="indicator" id="st3"><h3>3</h3></div>
			<h3 id="std3">Previsualizar</h3>
		</div>
		<div class="step completed">
			<div class="indicator" id="st4"><h3>4</h3></div>
			<h3 id="std4">Publicar o Guardar</h3>
		</div>
	</div>
</div>
<div id="news_content">

	<div id="colLeft">
		<?php echo $this->Session->flash();?>
		<h2>
		<?php
			if ($published === true) {
				__('Publicar');
			}else {
				__('Guardar');
			}
		?>
		</h2>
		<hr noshade="noshade" style="background-color: #999999; height: 1px; border-style:none;"/>
		<br/>
		<?php
		$message = "";
		if ($published == false) {
			$message .= $this->Html->para(null,__('Su nota se ha guardado con éxito. Puede publicarla dirigiéndose a edición',true));
		}else {
			$message .= $this->Html->para(null,__('Su nota se ha publicado con éxito. Podrá verla en el siguiente link:',true));
			$message .= $this->Html->tag('br');
			$message .= $this->Html->para(null,$this->Html->link($newsLink, $newsLink));
		}
		echo $this->Html->div('optionBox',$message);
		?>
	</div>
	<div id="colRight">
	<h2><?php __('Ayuda')?></h2>
	<hr noshade="noshade" style="background-color: #999999; height: 1px; border-style:none;"/>
	<br/>
	<div id="help" class="helpMessage">
		<p id="helpMsg"></p>
	</div>
	<br/>
	</div>
	<br clear="all"/>
</div>