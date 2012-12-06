<?php
class Linkcategory extends AppModel {
	var $name = 'Linkcategory';
	var $hasMany = array('Clink');
	var $actsAs = array('Ordenable','Tree');
	var $asTree = false;

}
?>