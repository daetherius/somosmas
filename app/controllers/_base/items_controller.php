<?php
App::import('Controller','_base/Abcs');
class ItemsController extends AbcsController{
	var $name = 'Items';
	
	function index($paginate = true) {
	   $items = $paginate ? $this->paginate($this->uses[0],$this->m[0]->find_(null,'paginate')):$this->m[0]->find_(array('contain'=>false));
	   $this->set(compact('items'));
	}
	
	function ver($id = false) {
		$id = $this->_checkid($id);
		$this->m[0]->recursive = 1;
		if($item = $this->m[0]->read(null,$id)){
			$this->set(compact('item'));
			$this->set('related',$this->m[0]->find_(array('recursive'=>0,'field'=>'id','value'=>$item[$this->uses[0]]['id']),'neighbors'));
			$this->pageTitle = $item[$this->uses[0]][$this->m[0]->displayField];
		}

		if(isset($this->m[0]->hasMany['Comment']) && isset($this->params['named']['reply']) && $this->params['named']['reply']){
			$this->data['Comment'] = array(
				'autor' => Configure::read('Site.name'),
				'email' => Configure::read('Site.email')
			);
		}
	}
	
	///// Admin
	
	function admin_images($id = false){
		$id = $this->_checkid($id);
		$this->paginate[$this->uses[0].'img']['limit'] = 16;

		if($id = (int)$id){
			$this->set('items',$this->paginate($this->uses[0].'img',array($this->uses[0].'img.'.(low($this->uses[0])).'_id'=>$id)));
			$this->set('itemtitle',$this->m[0]->field($this->m[0]->displayField,array('id'=>$id)));
		}
			
		if(!empty($this->data)){
			if($return = $this->m[0]->saveAll($this->data,array('validate'=>true))){
				$msg = 'oksave'; if(is_array($return)){foreach($return as $ret){ if(in_array(false,$ret)) $msg = 'somesave'; }}
				$this->redirect(array_merge($this->passedArgs,array('action'=>'index','admin'=>1,'msg'=>$msg)));
			}
		}
		
		$this->detour('elements/temp');
	}
	
	function admin_orden(){
		if(empty($this->data)){
			$this->set('orderdata',$this->m[0]->find_(array(
				'fields'=>array('id',$this->m[0]->displayField,'orden'),
				'contain'=>false,
			),'all+'));
		} else {
			foreach($this->data[$this->uses[0]] as $it){
				$this->m[0]->create(false);
				$this->m[0]->save($it);
			}
			$this->redirect(array('msg:oksave'));
		}
	}
}
?>