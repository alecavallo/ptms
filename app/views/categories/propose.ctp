<?php
$msg = empty($message)?"Su propuesta ha sido recibida y será analizada ante una posterior recategorización":$message;

$this->Js->get('#catSelector');
$effect = $this->Js->effect('fadeOut');
$effect = str_replace("\"", "'", $effect);
echo $html->tag('br');
echo $html->para('message',$msg);

$this->Js->buffer("setTimeout(function(){ {$effect} $('testdiv').update(''); },5000);");
echo $this->Js->writeBuffer(array('safe'=>true));
?>