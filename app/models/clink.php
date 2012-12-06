<?php
class Clink extends AppModel {
	var $name = 'Clink';
	var $belongsTo = array(
		'Linkcategory',
		'Category'=>array('className' => 'Category'),
		'Pcategory' => array(
			'className' => 'Category',
			'foreignKey' => false,
			'conditions' => 'Pcategory.id = Category.parent_id'
		)
	);
	var $labels = array(
		'src'=>'Imagen',
		'linkcategory_id'=>'Subcategoría',
		'category_id'=>'Programa'
	);
	var $actsAs = array('File' => array('portada'=>false));
	var $hasOne = array(
		'Timeline' => array(
			'className' => 'Timeline',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Clink'),
			'dependent' => true
		)
	);    
	
	var $validate = array(
		'nombre' => array(
			'rule' => array('between',1,255),
			'allowEmpty'=>false,
			'message' => 'Ingrese un nombre de entre 1 y 255 caracteres.'
		),
		'enlace' => array(
			'rule'=>'url',
			'allowEmpty'=>false,
			'message'=>'Ingrese una dirección web válida'
		)			
	);
}
?>