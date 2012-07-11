<?php
class ExcludedWord extends AppModel {
	var $name = 'ExcludedWord';
	var $displayField = 'word';
	var $validate = array(
		'word' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
?>