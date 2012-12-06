<?php
App::import('Controller','_base/My');
class AbcsController extends MyController{
	function admin_index() {
		$this->paginate[$this->uses[0]]['limit'] = 25;
		$find = array();

		//// Buscador
		if($this->data){
			if(isset($this->data['action']) && $this->data['action']=='reset'){
				$this->data['q'] = '';
			} elseif(isset($this->data['q']) && $this->data['q']) {
				$this->redirect(array(
					'q'=>b64($this->data['q'])
				));
			}
			
			if(isset($this->data['todelete']) && $this->data['todelete']){
				$this->m[0]->deleteAll(array($this->uses[0].'.id'=>array_keys(array_filter($this->data['todelete']))),true,true);
			}
			
		} elseif(isset($this->params['named']['q'])) {
			$q = b64($this->params['named']['q'],1);
			
			if(is_numeric($q)){
				$find[$this->uses[0].'.id'] = $q;
			} elseif($this->m[0]->hasField($this->m[0]->displayField)){
				$find[$this->uses[0].'.'.$this->m[0]->displayField.' LIKE'] = '%'.$q.'%';
			}

			$this->data['q'] = $q;
		}
		/////
		
		$this->set('items',$this->paginate($this->uses[0],$find));
		if($this->m[0]->belongsTo){
			$parentModels = array_keys($this->m[0]->belongsTo);
			foreach($parentModels as $parent){
				if(in_array($parent, $this->uses)) # SHOULD be true
					$this->paginate($parent);
			}
		}
		
		$this->data['todelete'] = array();
	}

	function admin_agregar() {
		if(!empty($this->data)){
			if($return = $this->m[0]->saveAll($this->data,array('validate'=>true))){
				$msg = 'oksave'; if(is_array($return)){foreach($return as $ret){ if(in_array(false,$ret)) $msg = 'somesave'; }}
				$this->redirect(array('action'=>'index','admin'=>1,'msg'=>$msg));		
			}
		} else {
			if($this->m[0]->hasField('activo')) $this->data[$this->uses[0]]['activo'] = 1;
			if($this->m[0]->hasField('layout')) $this->data[$this->uses[0]]['layout'] = 'Izquierda';
		}
	}
	
	function admin_editar($id) {
		$id = $this->_checkid($id);
		$this->m[0]->id = $id;

		if(empty($this->data)){
			$this->m[0]->recursive = 0;
			$this->data = $this->m[0]->read();
			$this->m[0]->clean($this->data,true);
		} elseif($return = $this->m[0]->saveAll($this->data,array('validate'=>true))){
			$msg = 'oksave'; if(is_array($return)){ foreach($return as $ret){ if(in_array(false,$ret)) $msg = 'somesave'; }}
			$this->redirect(array('action'=>'index','admin'=>1,'msg'=>$msg));		
		}
	}

	function admin_activar($id,$exclusive = false) {
		$id = $this->_checkid($id);
		$this->m[0]->recursive = -1;
		
		if($data = $this->m[0]->read(array('id','activo'),$id)){
			if($exclusive) $this->m[0]->updateAll(array('activo'=>0));
			$this->m[0]->create();
			$this->m[0]->id = $id;
			$this->m[0]->saveField('activo',!$data[$this->uses[0]]['activo']);
		}
		$this->redirect(array('action'=>'index','admin'=>1));
	}
}
?>