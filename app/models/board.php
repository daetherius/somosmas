<?php
class Board extends AppModel {
	var $name = 'Board';
	var $actsAs = array('File' => array('portada'=>false));
	var $labels = array('src'=>'Miniatura');
	
	var $validate = array(
		'enlace'=>array('rule'=>'url', 'allowEmpty'=>true, 'message'=>'Ingrese una dirección web válida.')
	);
}
?>