<?php
class Timeline extends AppModel {
	var $name = 'Timeline';
	var $labels = array();
	var $belongsTo = array(
		'Achievement' => array(
			'className' => 'Achievement',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Achievement')
		),
		'Achievementportada' => array(
			'className' => 'Achievementimg',
			'foreignKey'=>false,
			'conditions'=>array(
				'Achievementportada.achievement_id = Achievement.id',
				'Achievementportada.portada'=>1
			)
		),
		'Event' => array(
			'className' => 'Event',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Event')
		),
		'Eventportada' => array(
			'className' => 'Eventimg',
			'foreignKey'=>false,
			'conditions'=>array(
				'Eventportada.event_id = Event.id',
				'Eventportada.portada'=>1
			)
		),
		'Post' => array(
			'className' => 'Post',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Post')
		),
		'Postportada' => array(
			'className' => 'Postimg',
			'foreignKey'=>false,
			'conditions'=>array(
				'Postportada.post_id = Post.id',
				'Postportada.portada'=>1
			)
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Document')
		),
		'Doccategory' => array(
			'className' => 'Doccategory',
			'foreignKey'=>false,
			'conditions'=>'Document.doccategory_id = Doccategory.id'
		),
		'Album' => array(
			'className' => 'Album',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Album')
		),
		'Clink' => array(
			'className' => 'Clink',
			'foreignKey'=>'parent_id',
			'conditions'=>array('Timeline.parent'=>'Clink')
		),
		'Linkcategory' => array(
			'className' => 'Linkcategory',
			'foreignKey'=>false,
			'conditions'=>'Clink.linkcategory_id = Linkcategory.id'
		)
	);
}
?>