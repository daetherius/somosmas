<?php
echo
	$this->element('adminhdr',array('title'=>'Sección '.$_ts)),
	$this->element('inputs',array('schema'=>array('src'=>array('strict'=>'x')))),
	$this->element('tinymce',array('size'=>'l','advanced'=>1));
?>