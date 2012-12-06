<?php
App::import('Controller','_base/Timed');
class ClinksController extends TimedController{
	var $name = 'Clinks';
	var $ts = 'Ligas';
	var $uses = array('Clink');

	function admin_agregar(){
		parent::admin_agregar();
		$this->set('linkcategories',$this->m[0]->Linkcategory->find_(null,'list'));
	}

	function admin_editar($id = false){
		parent::admin_editar($id);
		$this->set('linkcategories',$this->m[0]->Linkcategory->find_(null,'list'));
	}

}
?>