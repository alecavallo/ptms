<?php
echo $this->Form->create('Feed', array('enctype' => 'multipart/form-data') );
echo $this->Form->file('Feed.submittedfile');
echo "<br/>";
echo $this->Form->end('Subir archivo');

?>