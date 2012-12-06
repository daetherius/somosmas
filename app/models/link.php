<?php
class Link extends AppModel {
	var $name = 'Link';
	var $labels = array('src'=>'Imagen');
	var $actsAs = array('File' => array('portada'=>false));
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