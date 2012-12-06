<?php
App::import('Controller','_base/Items');
class LinksController extends ItemsController{
	var $name = 'Links';
	var $ts = 'Ligas';
	var $uses = array('Link');
	
	function index(){
		$this->paginate[$this->uses[0]]['limit'] = 2;
		parent::index();
	}
}
?>