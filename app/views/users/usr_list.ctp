<?php 
    $this->Paginator->options(array(
    'update' => 'colLeft',
    'evalScripts' => true
    ));
?>
<?php echo $this->element('users'.DS.'usr_list',array('users', $users))?>