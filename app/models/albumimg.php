<?php
class Albumimg extends AppModel {
	var $name = 'Albumimg';
	var $actsAs = array('Ordenable','File'=>array('portada'=>'album_id'));
	var $belongsTo = array(
		'Album' => array(
			'className'=>'Album',
			'counterCache' => true
		)
	);
}
?>