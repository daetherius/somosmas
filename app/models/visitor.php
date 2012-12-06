<?php
class Visitor extends AppModel {
	var $name = 'Visitor';
	var $labels = array();
	var $belongsTo = array(
		'Question' => array(
			'className' => 'Question',
			'foreignKey'=>'item_id',
			'conditions'=>array('Visitor.item'=>'Question')
		),
		'Poll' => array(
			'className' => 'Poll',
			'foreignKey'=>'item_id',
			'conditions'=>array('Visitor.item'=>'Poll')
		)
	);
	var $validate = array(
		'ip' => array(
			'rule' => 'ip',
			'allowEmpty' => false,
			'message' => 'Ingrese una IP válida'
		)
	);
}
?>