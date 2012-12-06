<?php
class Achievementimg extends AppModel {
	var $name = 'Achievementimg';
	var $actsAs = array('File' => array('portada'=>'achievement_id'));
	var $belongsTo = array(
		'Achievement' => array(
			'className'=>'Achievement',
			'counterCache' => true
		)
	);
}
?>