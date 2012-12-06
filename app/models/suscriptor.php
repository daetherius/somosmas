<?php
class Suscriptor extends AppModel {
	var $name = 'Suscriptor';
	var $displayField = 'email';
	var $validate = array(
		'email' => array(
			'formato'=>array(
				'rule' => 'email',
				'message' => 'Ingrese una dirección de correo válida.'
			),
			'longitud'=>array(
				'rule' => array('between',3,80),
				'message' => 'Ingrese una dirección de correo de entre 3 y 80 caracteres.'
			),
			'vacio'=>array(
				'rule' => 'notEmpty',
				'message' => 'Ingrese una dirección de correo de entre 3 y 80 caracteres.'
			)
		)		
	);
}
?>