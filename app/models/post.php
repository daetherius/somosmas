<?php
class Post extends AppModel {
	var $name = 'Post';
	var $labels = array(
		'comment_count'=>'comentarios',
		'postimg_count'=>'Imágenes',
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
			'conditions'=>array('Comment.parent'=>'Post'),
			'dependent'=>true
		),
		'Postimg'=>array(
			'className'=>'Postimg',
			'order'=>'Postimg.id desc',
			'dependent'=>true
		)
	);
	
	var $hasOne = array(
		'Postportada'=>array(
			'className'=>'Postimg',
			'foreignKey'=>'post_id',
			'conditions'=>'Postportada.portada = 1'
		),
		'Timeline' => array(
			'className' => 'Timeline',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Post'),
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