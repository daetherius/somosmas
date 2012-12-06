<?php
class Album extends AppModel {
	var $name = 'Album';
	var $actsAs = array('File' => array('portada'=>false));
	var $labels = array(
		'src'=>'Miniatura del Video',
		'url'=>'Enlace del Video',
		'comment_count'=>'Comentarios',
		'albumimg_count'=>'Imágenes',
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
			'conditions'=>array('Comment.parent'=>'Album'),
			'dependent'=>true
		),
		'Albumimg'=>array(
			'className'=>'Albumimg',
			'dependent'=>true
		)
	);
	var $hasOne = array(
		'Albumportada'=>array(
			'className'=>'Albumimg',
			'foreignKey'=>'album_id',
			'conditions'=>'Albumportada.portada = 1'
		),
		'Timeline' => array(
			'className' => 'Timeline',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Album'),
			'dependent' => true
		)
	);
	
	var $validate = array(
		'url'=>array('rule'=>'url', 'allowEmpty'=>true, 'message'=>'Ingrese una dirección web válida.'),
		'src'=>array(
			'rule'=>array('between', 1,255),
			'allowEmpty'=>true,
			'message'=>'Problema al subir el archivo'
		)
	);
	
	function getimgs($id = false){
		return $this->Albumimg->find_(array(
			'conditions'=>array('album_id'=>(int)$id),
			'contain'=>false,
			'limit'=>4
		));
	}
}
?>