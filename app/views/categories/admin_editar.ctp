<?php
$schema = array('nombre_corto'=>'skip','src'=>array('strict'=>'960 x 115'));
fb($this->data[$_m[0]]);
if($this->data[$_m[0]]['parent_id']){ $schema = array('src'=>'skip'); }

echo
	$this->element('adminhdr',array('links'=>array('back'))),
	$this->element('inputs',compact('schema')),
	$this->element('tinymce',array('advanced'=>1,'size'=>'m'));
?>