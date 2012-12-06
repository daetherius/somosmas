<?php
App::import('Controller','_base/Labels');
class LinkcategoriesController extends LabelsController {
	var $name = 'Linkcategories';
	var $ts = 'Categorías de Enlaces';
	var $uses = array('Linkcategory');
}
?>