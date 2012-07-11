<?php
//debug($ok);
if (!$ok) {
?>
<i style="font-size: 11px;"><?php echo $msg;?></i>
<?php
}else{
	$this->Js->get('#form');
	$this->Js->buffer($this->Js->effect('fadeOut'));
	$this->Js->Buffer("$('#invitacion').css(\"background\",\"#509c46 none\");");

	$invitacion = $this->Js->get('#invitacion');


	echo $this->Js->writeBuffer();
?>
<i style="font-size: 11px;"><?php echo $msg;?></i>
<?php

}?>