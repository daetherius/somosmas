<?php
class Comment extends AppModel {
	var $name = 'Comment';
	var $displayField = 'email';
	var $belongsTo = array(
		/*
		'Product' => array(
			'className'=>'Product',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Comment.parent'=>'Product'),
			'counterCache' => true
		),
		'Podcast' => array(
			'className'=>'Podcast',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Comment.parent'=>'Podcast'),
			'counterCache' => true
		),
		'Video' => array(
			'className'=>'Video',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Comment.parent'=>'Video'),
			'counterCache' => true
		),
		'Album' => array(
			'className'=>'Album',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Comment.parent'=>'Album'),
			'counterCache' => true
		),
		*/
		'Post' => array(
			'className'=>'Post',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Comment.parent'=>'Post'),
			'counterCache' => true
		)
	);
	var $validate = array(
		'name' => array(
			'rule'=>'blank',
			'allowEmpty'=>true,
			'on'=>'create',
			'required'=>true,
			'message'=>'Non-Human'
		),
		'autor' => array(
			'rule'=>'notEmpty',
			'allowEmpty'=>false,
			'message'=>'Ingrese su nombre por favor'
		),
		'web' => array(
			'rule'=>'url',
			'allowEmpty'=>true,
			'message'=>'Ingrese una dirección web válida'
		),
		'email' => array(
			'format'=>array(
				'rule'=>'email',
				'allowEmpty'=>false,
				'message'=>'Ingrese una dirección de correo válida'
			),
			'vacio' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Este campo no puede quedar vacío'
			)		
		),
		'descripcion' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Ingrese su comentario'
		)			
	);

	function beforeValidate(){ $this->clean($this->data,false,false);return true; }
}
?>