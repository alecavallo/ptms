<!-- Periodismo ciudadano y nacional. Agregador de noticias -->
<div id="contenedor">
	<div id="h_1">
		<div id="txt">Estamos en la fase de <strong>beta cerrada</strong>, realizando las &uacute;ltimas pruebas del sistema, si quieres testear la versi&oacute;n, haz <a href="javascript:login();">click aqui</a> y pide una invitaci&oacute;n.</div>
		<div id="txt2">Estamos en la fase de <strong>beta cerrada</strong>, realizando las &uacute;ltimas pruebas del sistema, si quieres testear la versi&oacute;n, haz click aqui y pide una invitaci&oacute;n.</div>
		<div id="slide">
			  <div id="login">
					<div id="campos">
					  <?php
						    //echo $session->flash('auth');
						    echo $this->Form->create('User', array('action' => 'login'),array('id'=>"fo4"));
						    $flds = $this->Form->input('email',array('autocomplete' => 'off','label'=>false,'class'=>"campo"));
						    $flds .= $this->Form->input('password',array('autocomplete' => 'off','label'=>false,'class'=>"campo"));
						    echo $this->Html->div('fieldsContainer', $flds, array('style'=>"float: left;"));
						    echo $this->Form->submit(' ',array('class'=>"ok"));
						    echo $this->Form->end();
						?>
					</div>
				</div>
				<div id="invitacion">
					<div id="form">
						<div id="mail">ingresa tu mail</div>
						<?php
						    //echo $session->flash('auth');
						    echo $this->Form->create('User', array('action' => 'invite'),array('id'=>"fo3"));
						    echo $this->Form->input('email',array('autocomplete' => 'off','label'=>false,'class'=>"campo", 'id'=>"email"));
							echo $this->Js->submit(' ', array('update' => '#confirmacion', 'url' => array('controller'=>"users",'action'=>"invite"), 'div' => false, 'type' => 'json', 'async' => false, 'class'=>"ok"));
						    echo $this->Form->end();
						?>
					</div>
				     <div id="confirmacion">
						muy pronto le enviaremos su invitacion, gracias.
					</div>
				</div>


		</div>
	</div>
<div id="h_2">
	<div id="c_video">

			<iframe src="http://player.vimeo.com/video/21000084?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="475" height="267" frameborder="0"></iframe>

	</div>
</div>
</div>
<?php echo $this->Js->writeBuffer();?>