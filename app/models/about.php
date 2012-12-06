<?php
class About extends AppModel {
	var $name = 'About';
	var $useTable = 'about';
	var $actsAs = array('File' => array('portada'=>false));
}
?>