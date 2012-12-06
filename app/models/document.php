<?php
class Document extends AppModel {
	var $name = 'Document';
	var $labels = array(
		'src'=>'Archivo',
		'doccategory_id'=>'Subcategoría',
		'category_id'=>'Programa'
	);
	var $categoryModel = 'Category';
	var $belongsTo = array(
		'Doccategory',
		'Category'=>array('className' => 'Category'),
		'Pcategory' => array(
			'className' => 'Category',
			'foreignKey' => false,
			'conditions' => 'Pcategory.id = Category.parent_id'
		)
	);
	var $actsAs = array(
		'File' => array(
			'portada'=>false,
			'fields'=>array(
				'src'=>array(
					'types'=>'docx|xlsx|ppt|pps|ppsx|pptx|doc|xls|pdf|zip|rar',
					'dir'=>'docs',
					'maxsize'=>5242880 // 5 Mb
				)
			)
		)
	);

	var $hasOne = array(
		'Timeline' => array(
			'className' => 'Timeline',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Document'),
			'dependent' => true
		)
	);
	
	var $validate = array(
		'nombre' => array(
			'rule' => array('between', 1,255),
			'allowEmpty' => false,
			'message' => 'Ingrese un nombre de entre 1 y 255 caracteres'
		),
		'src' => array(
			'rule' => array('between', 1,255),
			'allowEmpty' => true,
			'message' => 'No ha seleccionado el archivo'
		)
	);
}
?>