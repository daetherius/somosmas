<?php
echo
	$this->element('adminhdr',array('links'=>array('back'))),
	$this->element('inputs',array('schema'=>array(
		'category_id'=>array('empty'=>'— Seleccione —'),
		'category'=>'skip',
		'created'=>'skip',
		'Timeline.id'=>array('type'=>'hidden'),
		'Timeline.parent'=>array('value'=>$_m[0],'type'=>'hidden'),
		'Timeline.created'=>array('label'=>'Fecha de publicación')
	))),
	$this->element('tinymce',array('advanced'=>1,'size'=>'m'));
?>