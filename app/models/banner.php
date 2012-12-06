<?php
class Banner extends AppModel {
	var $name = 'Banner';
	var $actsAs = array(
		'Ordenable',
		'File'=>array(
			'portada'=>false,
			'fields'=>array('src'=>array('types'=>'swf|jpg|jpeg|gif|png'))
		)
	);
}
?>