<?php
App::import('Controller','Categorizeditems');
class TimedController extends CategorizeditemsController{
	var $name = 'Timed';
	function admin_agregar(){
		$this->detour('timeline');
		
		if(isset($this->data['Timeline']['created']) && $this->data['Timeline']['created'])
			$this->data[$this->uses[0]]['created'] = $this->data['Timeline']['created'];

		parent::admin_agregar();
	}
	
	function admin_editar($id){
		$this->detour('timeline');
		
		if(isset($this->data['Timeline']['created']) && $this->data['Timeline']['created'])
			$this->data[$this->uses[0]]['created'] = $this->data['Timeline']['created'];

		parent::admin_editar($id);
	}

}
?>