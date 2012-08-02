<div id="content">
	<br clear="all"/>
	<div class="greenBox">
		<h3>Introduc&iacute; tu nombre de usuario y contraseña</h3>
		<?php
		    echo $session->flash('auth');
		    echo $this->Form->create('User', array('action' => 'login'));
		    echo $this->Form->input('email',array('label'=>"Email:"));
		    echo "<br/>";
		    echo $this->Form->input('password',array('label'=>"Contraseña:"));
		    echo "<br/>";
		    echo $this->Form->end(' ');
		    echo $this->Facebook->login(array('perms'=>'email'));
		?>
		<br clear="all"/>
		<p id="toregister">
		<?php 
			echo $this->Html->link('No estas registrado?', "/registracion.html", array('target'=>"_self"));
		?>
		</p>
	</div>
	
</div>