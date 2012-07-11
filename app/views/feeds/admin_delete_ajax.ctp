<?php echo $this->Html->script(array('prototype', 'scriptaculous'),array('inline'=>false, 'once'=>true));?>
<p> <?php echo $message;?> </p>
<?php 
if ($remove) {
	//efecto fade-out del mensaje de sistema
	$this->Js->get("{$update}");
	$fadeout = $this->Js->effect('fade', array('speed'=>"slow"));
	$this->Js->buffer("$('{$update}').show();$('{$update}').fade({duration: 3});$('{$row}').remove();");
	echo $this->Js->writeBuffer(array('inline'=>true));
}else {
	//efecto fade-out del mensaje de sistema
	$this->Js->buffer("$('{$update}').show();$('{$update}').fade({duration: 3});");
	echo $this->Js->writeBuffer(array('inline'=>true));
}
?>