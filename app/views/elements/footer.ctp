<?php $items = $this->requestAction('categories/getList');?>
<div id="footer">
<div id="footer_1"><div id="footer_menu" class="menufo" >
  <ul >
  	<?php
  	foreach ($items as $value) {
  		$a = $this->Html->link($value['Category']['name'],array('controller'=>"categories", 'action'=>"view",$value['Category']['id']));
  		echo $this->Html->tag('li',$a);
  	}
  	?>
  </ul>
  </div>
</div>
<div id="footer_2"></div>
<div id="footer_3" class="copy"><div id="termsContainer"><a href="/terminos-y-condiciones.html">Términos y condiciones</a>   l   <a href="/que-es-posteamos.html">Que es Posteamos?</a>   l   <a href="mailto:info@posteamos.com?subject=Contacto%20Publicidad" target="_blank">Publicidad</a></div></div>


</div>