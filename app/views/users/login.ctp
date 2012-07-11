<div id="content">
	<div class="greenBox">
		<h3>Introduzca su nombre de usuario y contraseña</h3>
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
	</div>
</div>