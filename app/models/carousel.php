<?php
class Carousel extends AppModel {
	var $name = 'Carousel';
	var $labels = array();
	var $actsAs = array(
		'Ordenable',
		'File'=>array(
			'portada'=>false,
			'fields'=>array('src'=>array('maxsize'=>220160))
		)
	);
}
?>