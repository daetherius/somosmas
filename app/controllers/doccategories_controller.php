<?php
App::import('Controller','_base/Labels');
class DoccategoriesController extends LabelsController {
	var $name = 'Doccategories';
	var $ts = 'Categorías de Archivo';
	var $uses = array('Doccategory');
}
?>