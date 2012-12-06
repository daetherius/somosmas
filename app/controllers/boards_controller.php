<?php
App::import('Controller','_base/Items');
class BoardsController extends ItemsController{
	var $name = 'Boards';
	var $ts = 'Cartelera';
	var $pageTitle = 'Cartelera';
	var $uses = array('Board');

	function admin_export(){ $this->_export(array('nombre','enlace','descripcion')); }
}
?>