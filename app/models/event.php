<?php
class Event extends AppModel {
	var $name = 'Event';
	var $labels = array(
		'comment_count'=>'comentarios',
		'eventimg_count'=>'Imágenes',
		'category_id'=>'Programa'
	);
	var $belongsTo = array(
		'Category'=>array('className' => 'Category'),
		'Pcategory' => array(
			'className' => 'Category',
			'foreignKey' => false,
			'conditions' => 'Pcategory.id = Category.parent_id'
		)
	);
	var $hasMany = array(
		'Comment'=>array(
			'className'=>'Comment',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Comment.parent'=>'Event'),
			'dependent'=>true
		),
		'Eventimg'=>array(
			'className'=>'Eventimg',
			'order'=>'Eventimg.id desc',
			'dependent'=>true
		)
	);
	var $hasOne = array(
		'Eventportada'=>array(
			'className'=>'Eventimg',
			'foreignKey'=>'event_id',
			'conditions'=>'Eventportada.portada = 1'
		),
		'Timeline' => array(
			'className' => 'Timeline',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Event'),
			'dependent' => true
		)
	);
}
?>