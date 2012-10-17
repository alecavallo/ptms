<?php 
	echo $this->Html->script(array('tweeter/jquery','prototype', 'effects'),array('inline'=>false, 'once'=>true));
	print $this->Html->scriptBlock('var jQuery = jQuery.noConflict();',array('inline' => false));
?>
<script type="text/javascript">
jQuery.ajax({
	  url: '/cities/getAll',
	  async: false,
	  success: function (data,textStatus){
		  window.cityList = data;
	  },
	  failure: function(data, textStatus){
		  window.cityList = new Array();
		  console.log('Error conectandose al servidor. posteamos');
	  },
	  dataType: "json"
});
</script>
<div id="content">
<br/>
	<?php echo $this->Session->flash(); ?>
	<div class="users form">
		<h1><?php __('Edicion de usuario')?></h1>
		<hr noshade="noshade"/>
		<?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data'));?>
			<?php
				echo $this->Form->input('email',array('label'=>__('E-mail:',true),'div'=>false));
				//echo $this->Form->input('password',array('label'=>__('Contraseña:',true),'div'=>false, 'value' => ''));
				//echo $this->Form->input('password_confirm',array('label'=>__('Confirmación:',true),'id'=>"password_confirm",'type'=>"password",'div'=>false, 'value' => ''));
				//echo $jqautocomplete->searchbox('User.city_id','window.cityList', false, array('startText'=>"Ciudad,Provincia,País",'minChars'=>2, 'key_delay'=>100, 'selectionLimit'=>1, 'limitText'=>"Para obtener una lista de ciudades debe introducir los datos de la siguiente manera: <b>ciduad,provincia,país</b>",'asHtmlID'=>"city",'selectedValuesProp'=>"id"), array('label'=>__('Ciudad:', true),'div'=>false));
				echo $this->Form->input('alias',array('label'=>__('Twitter alias:',true),'div'=>false));
				echo $this->Form->input('posteamos_alias',array('label'=>__('Nick:',true),'div'=>false));
				echo $this->Form->input('first_name',array('label'=>__('Nombre:',true),'div'=>false));
				echo $this->Form->input('last_name',array('label'=>__('Apellido:',true),'div'=>false));
				echo $this->Form->input('avatar', array('label'=>__('Foto:',true),'div'=>false,'type'=>'file'));
				echo $this->Form->input('description',array('label'=>__('Descripción de tu perfil:',true),'div'=>false, 'type'=>"textarea"));
				echo $this->Form->input('gadw_code',array('label'=>__('Código Adwords:',true),'div'=>false, 'type'=>"textarea"));
			?>
			<br clear="all"/>
			<hr noshade="noshade"/>
		<?php echo $this->Form->end(__(' ', true));?>
		<?php echo $this->Html->link('Cambiar contraseña', "/users/pwdchange/{$userid}")?>
	</div>
	<br clear="all"/>
	<?php //echo $this->Js->writeBuffer();?>
</div>