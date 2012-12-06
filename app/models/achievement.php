<?php
class Achievement extends AppModel {
	var $name = 'Achievement';
	var $labels = array(
		'comment_count'=>'comentarios',
		'achievementimg_count'=>'Imágenes',
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
			'conditions'=>array('Comment.parent'=>'Achievement'),
			'dependent'=>true
		),
		'Achievementimg'=>array(
			'className'=>'Achievementimg',
			'order'=>'Achievementimg.id desc',
			'dependent'=>true
		)
	);
	
	var $hasOne = array(
		'Achievementportada'=>array(
			'className'=>'Achievementimg',
			'foreignKey'=>'achievement_id',
			'conditions'=>'Achievementportada.portada = 1'
		),
		'Timeline' => array(
			'className' => 'Timeline',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Achievement'),
			'dependent' => true
		)
		
	);
	var $validate = array(
		'nombre' => array(
			'rule' => array('between', 1,255),
			'allowEmpty' => false,
			'message' => 'Ingrese un título de entre 1 y 255 caracteres'
		),
		'descripcion' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Ingrese el contenido del artículo'
		)
	);
}
?>