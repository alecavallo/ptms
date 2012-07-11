<?php
if ($saved) {
	echo $html->image('tick.png',array('alt'=>"votos"));
	echo $votes ;
}else {
	echo $html->image('tick.png',array('alt'=>"votos"));
	echo "Error";
}

?>